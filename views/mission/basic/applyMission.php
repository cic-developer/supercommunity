<?php
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>

<!doctype html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,height=device-height">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php //print_r($missionData); ?>

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
<?php foreach($medList AS $ml){ ?>
                <tr>
                    <td><?=$ml['med_name']?></td>
                    <td><?=$ml['med_admin']?></td>
                    <td><?=$ml['med_url']?></td>
                    <td><img class="attach_img" src="<?=$ml['jud_attach']?>" alt="인증 사진"/><input class="jud_attach" name="jud_attach[]" type="file" style="display:none;"></td>
                    <td><?=$ml['med_superpoint']?></td>
                    <td><?= rs_cal_expected_point($missionData['mis_per_token'], $ml['med_superpoint'], $total_super) ?></td>
                    <td><input class="applycheck" name="med_id[]" type="checkbox" value="<?=$ml['med_id']?>" <?= ($ml['jud_state'] == 1 || $ml['jud_state'] == 3 )? 'checked' : '' ?>  onclick="return false"></td>
                </tr>
<?php } ?>
            </tbody>
        </table>
        <input type="submit" value="미션 신청">
    </form>

    <pre><?php //print_r($medList);?></pre>
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
</body>
</html>