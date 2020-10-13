<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>


<!--마이페이지> 내정보 >회원탈퇴-->

<!--mypage-->
<div id="mypage">
  <h3><?=$this->lang->line(0)?></h3>
       <!--my_right_box-->
       <div id="my_right_box">
            <h5><?=$this->lang->line(1)?></h5>
              <h6><?=$this->lang->line(2)?></h6>
              <?php echo form_open() ?>
                <ul class="ul_write">
                      <li>
                          <span><?=$this->lang->line(3)?></span>
                          <div class="my_cont">
                          <p class="read_fake"><?php echo "***".mb_substr(element('mem_userid',$member_data), mb_strlen(element('mem_userid', $member_data))/BLIND_ID_LEN ) ?></p>
                          <input type="hidden" name="member_id" value="<?php echo element('mem_userid',$member_data)?>"/>
                          </div>
                      </li>
                      <!-- <li>
                          <span><?=$this->lang->line(4)?></span>
                          <div class="my_cont">
                              <input type="password" value="" name="" placeholder="<?=$this->lang->line(5)?>" />
                          </div>
                      </li> -->
                 </ul>
                <?php echo form_close()?>
            <div class="btn_box">
                <input type="button" id="submit_button" class="btn1 btn_yellow" value="<?=$this->lang->line(6)?>" />  <!--슈퍼커뮤니티를 탈퇴하시겠습니까?<?=$this->lang->line(7)?> 알럿-->
            </div>
        </div>
        <!--//my_right_box-->
</div>
<!--//mypage-->

<script>
    $("#submit_button").on('click', function(){
        if(confirm('<?php echo $this->lang->line(6)?>')){
            $("form").submit();
        }
    });
</script>