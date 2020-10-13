<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>


<!--마이페이지-2 :: 내미디어> 증액신청-->
    <!--서브메뉴-->
    <!-- <div id="sub_menu">
        <ul> 
            <li><a href="<?php //echo base_url('mypage')?>">내정보</a></li>
            <li><a href="<?php //echo base_url('Media/mymedia')?>" class="on">내미디어</a></li>
            <li><a href="<?php //echo base_url('Mission/myMission')?>">미션인증현황</a></li>
            <li><a href="<?php //echo base_url('mypage/superpoint')?>">SUPER POINT</a></li>
        </ul>
    </div> -->
    <!--//서브메뉴-->


  <!--마이페이지 레이아웃 mypage-->
  <div id="mypage">
      <!--마이페이지 고정 내 포인트정보 박스 my_box-->
      <div id="my_left_box">
          <h3><?=$this->lang->line(0)?></h3>
          <div class="my_box">
              <h4><?=$this->lang->line(1)?></h4>
              <div class="user_img">
                <!-- <img src="<?php /* echo base_url('assets/images/user.png');*/?>" alt="슈퍼프렌즈" />  //일반유저 프사-->
                <img src="<?php echo base_url('assets/images/s_user.png');?>" alt="<?=$this->lang->line(2)?>" /><!--인플루언서 프사-->
              </div> 
              <strong><?=$member_data['mem_nickname']?></strong>
              <p>
                  <?=$this->lang->line(3)?>
                  <span><?=number_format($total_super)?></span>
              </p>
          </div>
      </div>
       <!--//마이페이지 고정 내 포인트정보 박스 my_box-->



       <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
       <div id="my_right_box">
            <h5><?=$this->lang->line(4)?></h5> <!--마이페이지 상세 타이틀-->
            <!--my_cont_area-->
           <div class="my_cont_area">
              <h6><?=$this->lang->line(5)?>
                  <small>
                    <?=$this->lang->line(6)?> <br/> 
                    <?=$this->lang->line(7)?>
                </small>
            </h6>
<?php echo form_open_multipart('');?>
                <ul class="ul_write">
                    <li>
                        <span><?=$this->lang->line(8)?></span>
                        <div class="my_cont">
                             <p class="read_fake"><?=$this->session->userdata('lang') == 'korean' ? $media_data['wht_title'] : $media_data['wht_title_en']?></p>  <!--저장된 값만 받아오면 되욧!-->
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
                        <span><?=$this->lang->line(9)?></span>
                        <div class="my_cont">
                             <p class="read_fake"><?=$media_data['med_name']?></p>
                             <input type="hidden" name="med_name" value="<?=$media_data['med_name']?>" />
                             <!--<input type="text" name="med_name" value="<?/*=$media_data['med_name']*/?>" readonly/>-->
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(10)?></span>
                        <div class="my_cont">
                            <p class="read_fake"><?=$media_data['med_admin']?></p>
                            <input type="hidden" name="med_admin" value="<?=$media_data['med_admin']?>" />
                            <!--<input type="text" placeholder="관리자 이름 입력" name="med_admin" />-->
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(11)?></span>
                        <div class="my_cont">
                            <p style="width:80%" class="read_fake"> <?=$media_data['med_url']?></p>
                            <input type="hidden" name="med_url" value="<?=$media_data['med_url']?>" />
                            <!--<input type="text" name="med_admin" value="<?/*=$media_data['med_admin']*/?>" readonly/>-->
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(12)?></span>
                        <div class="my_cont">
                            <textarea placeholder="<?=$this->lang->line(13)?>" name="med_textarea"><?php echo set_value('med_textarea',$media_data['med_textarea']); ?></textarea>
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(14)?></span>
                        <div class="my_cont">
                            <span class="img_file"> <img id="preview_img" src="<?php echo base_url('assets/images/basic_img.gif');?>" alt="<?=$this->lang->line(15)?>"/></span>
                            <div class="right_txt">
                                <small><?=$this->lang->line(16)?> </small>
                                <input id="img_file" type="file" name="jud_attach" style="display:none"/>
                                <input id="file_button" type="button" value="<?=$this->lang->line(17)?>" class="btn2 btn_line"/>
                            </div>    
                        </div>
                    </li>
                </ul> 
           </div>
          <!--my_cont_area-->
          <div class="btn_box">
            <input type="submit" value="<?=$this->lang->line(18)?>"  class="btn1 btn_yellow"/>
          </div>
<?php echo form_close('');?>
      </div>     


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
                alert('<?=$this->lang->line(19)?>');
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


