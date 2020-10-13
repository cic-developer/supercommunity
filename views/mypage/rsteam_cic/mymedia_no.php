<?php 
   $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>



<!--마이페이지-2 :: 내미디어가 없을때-->

       <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
       <div id="my_right_box">
            <h5><?=$this->lang->line(0)?></h5> <!--마이페이지 상세 타이틀-->
            <!--my_cont_area-->
           <div class="my_cont_area">
              <h6><?=$this->lang->line(1)?></h6>
              
              <!--none_list 그냥 이부분만 내미디어 목록페이지에서 none block 해도될듯-->
              <div class="none_media">
                     <i class="fas fa-globe-americas"></i>
                  <p> <?=$this->lang->line(2)?></p>
                  <a href="<?=base_url('Media/editMedia')?>" class="btn1 btn_yellow"><?=$this->lang->line(3)?></a>
              </div>
              <!--//none_list-->

              

           </div>
          <!--my_cont_area-->
      </div>     