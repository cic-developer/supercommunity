<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>


<!--마이페이지-2 :: 내미디어가 없을때-->

<!--mypage-->
<div id="mypage">
  <h3><?=$this->lang->line(0)?></h3>
       <!--my_right_box-->
       <div id="my_right_box">
          <h5><?=$this->lang->line(1)?></h5> <!--마이페이지 상세 타이틀-->
            <h6><?=$this->lang->line(2)?></h6>
            <!--none_list 그냥 이부분만 내미디어 목록페이지에서 none block 해도될듯-->
            <div class="none_media">
                    <i class="fas fa-globe-americas"></i>
                <p> <?=$this->lang->line(3)?></p>
                <a href="<?=base_url('Media/editMedia')?>" class="btn1 btn_yellow"><?=$this->lang->line(4)?></a>
            </div>
            <!--//none_list-->
      </div> 
      <!--//my_right_box-->
</div>
<!--//mypage-->