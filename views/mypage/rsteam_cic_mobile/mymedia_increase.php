<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
    
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>

<!--마이페이지-2 :: 내미디어> 증액신청-->
<!--mypage-->
<div id="mypage">
  <h3><?=$this->lang->line(0)?></h3>
   <!--my_right_box-->
   <div id="my_right_box">
            <h5><?=$this->lang->line(1)?></h5> <!--마이페이지 상세 타이틀-->
            <h6><?=$this->lang->line(2)?> 
                <small>
                    <?=$this->lang->line(3)?> <br/> 
                    <?=$this->lang->line(4)?>
                </small>
            </h6>
<?php echo form_open_multipart('');?>
                <ul class="ul_write">
                    <li>
                        <span><?=$this->lang->line(5)?></span>
                        <div class="my_cont">
                             <p class="read_fake"><?=$this->session->userdata('lang') == 'korean' ? $media_data['wht_title'] : $media_data['wht_title_en']?></p>
                             <input type="hidden" name='wht_list' value="<?=$media_data['med_wht_id']?>" />
                           <!-- 기존에있던 셀렉트
                               <select name="wht_list" onFocus='this.initialSelect = this.selectedIndex;' onChange='this.selectedIndex = this.initialSelect;'>
                                <?php /*foreach($white_list AS $wl){ ?>
                                    <option value="<?=$wl['wht_id']?>" <?=$wl['wht_id'] == $media_data['med_wht_id'] ? 'selected' : ''?> >
                                        <?=$wl['wht_title']?>
                                    </option>
                                <?php }*/?>
                            </select>-->
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(6)?></span>
                        <div class="my_cont">
                             <p class="read_fake"><?=$media_data['med_name']?></p>
                             <input type="hidden" name="med_name" value="<?=$media_data['med_name']?>" />
                             <!--<input type="text" name="med_name" value="<?/*=$media_data['med_name']*/?>" readonly/>-->
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(7)?></span>
                        <div class="my_cont">
                            <p class="read_fake"> <?=$media_data['med_admin']?></p>
                            <input type="hidden" name="med_admin" value="<?=$media_data['med_admin']?>" />
                            <!--<input type="text" placeholder="관리자 이름 입력" name="med_admin" />-->
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(8)?></span>
                        <div class="my_cont">
                            <p class="read_fake"> <?=$media_data['med_admin']?></p>
                            <input type="hidden" name="med_url" value="<?=$media_data['med_url']?>" />
                            <!--<input type="text" name="med_admin" value="<?/*=$media_data['med_admin']*/?>" readonly/>-->
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(9)?></span>
                        <div class="my_cont">
                            <textarea placeholder="<?=$this->lang->line(10)?>" name="med_textarea"><?php echo set_value('med_textarea',$media_data['med_textarea']); ?></textarea>
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(11)?></span>
                        <div class="my_cont">
                            <span class="img_file"> <img id="preview_img" src="<?php echo base_url('assets/images/basic_img.gif');?>" alt="<?=$this->lang->line(12)?>"/></span>
                            <div class="right_txt">
                                <small><?=$this->lang->line(13)?> </small>
                                <input id="img_file" type="file" name="jud_attach" style="display:none"/>
                                <input id="file_button" type="button" value="<?=$this->lang->line(14)?>" class="btn2 btn_line"/>
                            </div>    
                        </div>
                    </li>
                </ul> 
              <div class="btn_box">
                 <input type="submit" value="<?=$this->lang->line(15)?>"  class="btn1 btn_yellow"/>
              </div>
<?php echo form_close('');?>
      </div>
       <!--my_right_box-->   
</div>
<!--//mypage-->
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
                alert('<?=$this->lang->line(16)?>');
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


