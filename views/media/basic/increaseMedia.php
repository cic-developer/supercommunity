<?php
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>

<?php echo form_open_multipart(''); ?>
<select name="wht_list" onFocus='this.initialSelect = this.selectedIndex;' onChange='this.selectedIndex = this.initialSelect;'>
        <?php foreach($white_list AS $wl){ ?>
            <option value="<?=$wl['wht_id']?>" <?=$wl['wht_id'] == $media_data['med_wht_id'] ? 'selected' : ''?> >
                <?=$this->session->userdata('lang') == 'korean' ? $wl['wht_title'] : $wl['wht_title_en']?>
            </option>
        <?php } ?>
    </select>
    <input type="text" name="med_name" value="<?=$media_data['med_name']?>" readonly/>
    <input type="text" name="med_admin" value="<?=$media_data['med_admin']?>" readonly/>
    <input type="text" name="med_url" value="<?=$media_data['med_url']?>" readonly/>
    <textarea placeholder="신청 사유를 입력해주세요." name="med_textarea"><?=$media_data['med_textarea']?></textarea>
    <img id="preview_img" src="" alt="첨부파일"/>
    <input id="img_file" type="file" name="jud_attach" style="display:none"/>
    <input id="file_button" type="button" value="파일첨부" />
    <input type="submit" value="미디어 저장"/>
<?php echo form_close('');?>
<script>
    $(document).ready(function(){
        let validation_err = <?=isset($validation_err) ? $validation_err : 'false' ?>;
        if(validation_err){
            alert(validation_err);
        }
    });

    $("#file_button").on('click', function(){
        $("#img_file").click();
    });

    $("#img_file").on('change', function(){
        var file = $(this).get(0).files[0];
        console.log(file);
        if(file){
            if(file.size > 10000000){
                alert('파일은 최대 10MB까지 업로드 가능합니다.');
                return false;
            }
            var reader = new FileReader();
            reader.onload = function(){
                $("#preview_img").attr('src',reader.result);
            };

            reader.readAsDataURL(file);
            // console.log($(this).val());
        }
    });
</script>