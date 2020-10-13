<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>


<!--마이페이지-2 :: 내미디어> 내미디어 추가-->

<!--mypage-->
<div id="mypage">
     <h3><?=$this->lang->line(0)?></h3>
       <!--my_right_box-->
       <div id="my_right_box">
            <h5><?=$this->lang->line(1)?></h5>
                <h6><?=$this->lang->line(2)?></h6>
<?php echo form_open(''); ?>
                <ul class="ul_write">
                    <li>
                        <span><?=$this->lang->line(3)?></span>
                        <div class="my_cont">
                            <select name="wht_list">
<?php for($i = 0; $i < count($white_list); $i++){ ?>
                                <option value="<?=$white_list[$i]['wht_id']?>" <?php echo set_select('wht_list', $white_list[$i]['wht_id']); ?>><?=$this->session->userdata('lang') == 'korean' ? $white_list[$i]['wht_title'] : $white_list[$i]['wht_title_en']?></option>
<?php } ?>
                            </select>
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(4)?></span>
                        <div class="my_cont">
                            <ul class="check_table">
<?php foreach($media_type_list AS $mt){ ?>
                                    <li><label><input type="checkbox" value="<?=$mt['met_id']?>" name="met_type[]" <?php echo set_checkbox('met_type[]', $mt['met_id']); ?> /><?=$this->session->userdata('lang') == 'korean' ? $mt['met_title'] : $mt['met_title_en']?></label></li>
<?php } ?>
<?php if(!$media_type_list){ //미디어 type이 없는 경우?>
                                    <input type="hidden" value="0" name="met_type[]"/>
<?php } ?>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(5)?></span>
                        <div class="my_cont">
                            <input type="text" placeholder="<?=$this->lang->line(6)?>" name="med_name" value="<?php echo set_value('med_name'); ?>" />
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(7)?></span>
                        <div class="my_cont">
                            <input type="text" placeholder="<?=$this->lang->line(8)?>" name="med_admin" value="<?php echo set_value('med_admin'); ?>" />
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(9)?></span>
                        <div class="my_cont">
                            <input type="text" placeholder="<?=$this->lang->line(10)?>" name="med_url" value="<?php echo set_value('med_url'); ?>" />
                        </div>
                    </li>
                </ul>
                <div class="btn_box">
                    <input type="submit" value="<?=$this->lang->line(11)?>" class="btn1 btn_yellow"/>
                </div>
 <?php echo form_close(); ?>
        </div>
        <!--//my_right_box-->
</div>
<!--// mypage-->



<script>
    $(document).ready(function(){
        let validation_err = '<?=isset($validation_err) ? $validation_err : '' ?>';
        if(validation_err){
            alert(validation_err);
        }
    });
</script>