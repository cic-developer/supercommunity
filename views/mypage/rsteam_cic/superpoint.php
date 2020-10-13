<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>
<!--마이페이지 > 슈퍼포인트-->

       <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
       <div id="my_right_box">
            <h5><?=$this->lang->line(0)?></h5> <!--마이페이지 상세 타이틀-->
            <!--my_cont_area-->
            <div class="my_cont_area">
                <h6><?=$this->lang->line(1)?></h6>
                <ul class="point_txt">
                   <li> 
                        <img src="<?php echo base_url('assets/images/superp_img.png');?>" alt="<?=$this->lang->line(2)?>" />
                        <p>
                              <?=$this->lang->line(3)?> <br/>
                              <?=$this->lang->line(4)?>  <br/>
                              <?=$this->lang->line(5)?>  <br/>
                        </p>
                   
                   </li>
                   <li> <?=$this->lang->line(6)?> <b><?=number_format($total_super)?></b> </li>
                </ul>
            </div>
             <!--//my_cont_area-->
            <div class="btn_box">
                 <a href="<?=base_url('Media/mymedia')?>" class="btn1 btn_black"><?=$this->lang->line(7)?></a>
            </div>
       </div>
        <!--//페이지별 변경되는 오른쪽 영역 page_right_box-->
  </div>
    <!--//마이페이지 레이아웃 mypage-->     