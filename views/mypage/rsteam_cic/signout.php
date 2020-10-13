<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>




<!--마이페이지> 내정보 >회원탈퇴-->
  
    <!--서브메뉴-->
    <!-- <div id="sub_menu">
        <ul> 
            <li><a href="<?php //echo base_url('mypage')?>" class="on">내정보</a></li>
            <li><a href="<?php //echo base_url('Media/mymedia')?>">내미디어</a></li>
            <li><a href="<?php //echo base_url('Mission/myMission')?>">미션인증현황</a></li>
            <li><a href="<?php //echo base_url('mypage/superpoint')?>">SUPER POINT</a></li>
        </ul>
    </div> -->
    <!--//서브메뉴-->

  <!--마이페이지 레이아웃 mypage-->
       
       <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
       <div id="my_right_box">
            <h5><?php echo $this->lang->line(0)?></h5> <!--마이페이지 상세 타이틀-->
            <!--my_cont_area-->
            <div class="my_cont_area">
              <h6><?php echo $this->lang->line(1)?></h6>
            <?php echo form_open() ?>
                <ul class="ul_write">
                      <li>
                          <span><?php echo $this->lang->line(2)?></span>
                          <div class="my_cont">
                          <p class="read_fake"><?php echo "***".mb_substr(element('mem_userid',$member_data), mb_strlen(element('mem_userid', $member_data))/BLIND_ID_LENG ) ?></p>
                          <input type="hidden" name="member_id" value="<?php echo element('mem_userid',$member_data)?>"/>
                          </div>
                      </li>
                      <!-- <li> 소셜로그인을 사용하기때문에 비밀번호를 받지 않아도 될거같습니다.
                          <span><?php //echo $this->lang->line(3)?></span>
                          <div class="my_cont">
                              <input type="password" value="" name="" placeholder="<?php //echo $this->lang->line(4)?>" />
                          </div>
                      </li> -->
                 </ul>
            <?php echo form_close()?>
            </div>
            <!--//my_cont_area-->
            <div class="btn_box">
                <input type="button" id="submit_button" class="btn1 btn_yellow" value="<?php echo $this->lang->line(5)?>" />  <!--슈퍼커뮤니티를 탈퇴하시겠습니까? 알럿-->
            </div>
        </div>
        <!--//페이지별 변경되는 오른쪽 영역 page_right_box-->
</div>
<!--//마이페이지 레이아웃 mypage-->

<script>
    $("#submit_button").on('click', function(){
        if(confirm('<?php echo $this->lang->line(6)?>')){
            $("form").submit();
        }
    });
</script>