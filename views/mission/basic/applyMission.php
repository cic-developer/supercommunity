<?php
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>

<?php echo form_open_multipart(''); ?>
    <table>
        <colgroup>
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
        </colgroup>
        <thead>
            <th>미디어 네임</th>
            <th>관리자명</th>
            <th>입장링크</th>
            <th>게시인증</th>
            <th>Super Point</th>
            <th>예상 지급 Per Point</th>
            <th>신청가능</th>
        </thead>
        <tbody>
<?php 
foreach($medList AS $ml){ 
    $media_check = ($ml['jud_state'] == 1 || $ml['jud_state'] == 3); //해당 미디어가 미션 심사 진행 또는 완료된 미디어인지 체크
    $media_comp_check =  ($ml['jud_state'] == 3);
    $expected_point = rs_cal_expected_point2($missionData['mis_per_token'], $missionData['mis_max_point'], $ml['med_superpoint'], $ml); //예상 지급 토큰값
?>
            <tr>
                <td><?=$ml['med_name']?></td>
                <td><?=$ml['med_admin']?></td>
                <td><?=$ml['med_url']?></td>
                <td>
                    <img class="<?=$media_comp_check ? 'finish_img' : 'attach_img'?>" src="<?php echo thumb_url('judge', element('jud_attach', $ml), 400, 300); ?>" alt='인증 사진' />
                    <input class="jud_attach" name="jud_attach[]" type="file" style="display:none;">
                </td>
                <td><?=$ml['med_superpoint']?></td>
                <td><?= number_format($expected_point, 1) ?></td>
                <td>
                    <input class="applycheck" name="med_id[]" type="checkbox" value="<?=$ml['med_id']?>" <?= ($media_check)? 'checked' : '' ?>  onclick="return false" <?=$media_comp_check ? 'disabled' : ''?>>
                    <input name="all_med_id[]" value="<?=$ml['med_id']?>" style="display:none;"/>
                </td>
            </tr>
<?php } ?>
        </tbody>
    </table>
    <input type="submit" value="미션 신청">
<?php echo form_close(); ?>

<script>
    var fileTypes = ['image/png', 'image/jpg', 'image/jpeg'];

    $(document).ready(function(){
        let validation_err = '<?=isset($validation_err) ? $validation_err : '' ?>';
        if(validation_err){
            alert(validation_err);
        }
    });

    $(".attach_img").on('click', function(){
        let input_img = $(this).parent().find(".jud_attach");
        input_img.click();
    });

    $(".jud_attach").on('change', function(){
        let attach_img = $(this).parent().find(".attach_img");
        let checkbox = $(this).parents('tr').find('.applycheck');
        var file = $(this).get(0).files[0];
        if(file){
            if(file.size > 10000000){
                alert('파일은 최대 10MB까지 업로드 가능합니다.');
                return false;
            }
            if(file.type.indexOf('image') == -1 ){
                alert('이미지 파일만 업로드 가능합니다.');
                return false;
            }
            if(!validFileType(file)){
                alert('지원하지 않는 이미지 파일입니다.');
                return false;
            }
            var reader = new FileReader();
            reader.onload = function(){
                attach_img.attr('src',reader.result);
            };

            reader.readAsDataURL(file);
            checkbox.prop("checked", true);
            // console.log($(this).val());
        }
    });

    function validFileType(file) {
        for (var i = 0; i < fileTypes.length; i++) {
            if (file.type) {
                    if (file.type === fileTypes[i]) { return true; }
            }else if (file.name.toLowerCase().endsWith('jpg') || file.name.toLowerCase().endsWith('jpeg') || file.name.toLowerCase().endsWith('png')) { 
                // Edge file.type 안나오는 것을 위해서.
                return true; 
            } 
        } 
        return false;
    }
</script>