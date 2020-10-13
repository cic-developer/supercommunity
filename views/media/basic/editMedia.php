<?php
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>

<?php echo form_open(''); ?>
    <select name="wht_list">
        <?php for($i = 0; $i < count($white_list); $i++){ ?>
            <option value="<?=$white_list[$i]['wht_id']?>"><?=$this->session->userdata('lang') == 'korean' ? $white_list[$i]['wht_title'] : $white_list[$i]['wht_title_en']?></option>
        <?php } ?>
    </select>
    <?php foreach($media_type_list AS $mt){ ?>
        <label><input type="checkbox" value="<?=$mt['met_id']?>" name="met_type[]"/><?=$this->session->userdata('lang') == 'korean' ? $mt['met_title'] : $mt['met_title_en']?></label>
    <?php } ?>
    <?php if(!$media_type_list){ //미디어 type이 없는 경우?>
        <input type="hidden" value="0" name="met_type[]"/>
    <?php } ?>
    <input type="text" placeholder="내 미디어의 이름 입력" name="med_name" />
    <input type="text" placeholder="관리자 이름 입력" name="med_admin" />
    <input type="text" placeholder="내 미디어의 주소 입력" name="med_url" />
    <input type="submit" value="미디어 저장"/>
<?php echo form_close(); ?>

<script>
    $(document).ready(function(){
        let validation_err = <?=isset($validation_err) ? $validation_err : '' ?>;
        if(validation_err){
            alert(validation_err);
        }
    });
</script>
