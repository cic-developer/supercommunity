<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>

<!--마이페이지-2 :: 내미디어 LIST-->
<!--mypage-->
<div id="mypage">
<h3><?=$this->lang->line(0)?></h3>
       <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
       <div id="my_right_box">
            <h5><?=$this->lang->line(1)?></h5> <!--마이페이지 상세 타이틀-->
                <h6><?=$this->lang->line(2)?></h6>
                  <ul class="mob_list_table">
                      <?php foreach($media_data AS $md){ ?>
                      <li>
                          <dl>
                            <dt><?=html_escape($md['med_name'])?></dt>
                            <dd><span><?=$this->lang->line(3)?></span> <?=html_escape($md['med_admin'])?></dd>
                            <dd><span><?=$this->lang->line(4)?></span> <?php echo '<a href="'.html_escape($md['med_url']).'" target="_blank">'.html_escape($md['med_url']).'</a>'?></dd>
                          </dl>
                          <div class="table_bottom">
                              <?php if($md['med_state'] == 3) {echo '<a class="s_btn" href="'.base_url('Media/increaseMedia/'.$md['med_id']).'">'.$this->lang->line(5).'</a>';} ?>
                              <?php if($md['med_state'] == 0) {echo '<a class="s_btn" onclick="deleteMedia(\''.base_url('Media/deleteMedia/'.$md['med_id']).'\')">'.$this->lang->line(6).'</a>';}?>
                              <?php
                                  switch($md['med_state']){
                                      case 1 :
                                      case 2 :
                                          echo '<span class="judge"><i class="fa fa-history"></i> '.$this->lang->line(7).'</span>';
                                      break;

                                      case 3 :
                                          //echo '<span><i class="super_p"></i><b>'.html_escape($md['med_superpoint']).'</b></span>';
                                      break;

                                      case 5 :
                                          echo '<span class="reject tooltip tooltip-default" data-content="'.html_escape($md['med_textarea']).'">';
                                          echo '<i class="fa fa-question-circle"></i> '.$this->lang->line(8).'</span>';
                                      break;
                                  } 
                              ?>
                          </div>
                      </li>
                      <?php } ?>
                  </ul>
            <div class="btn_box">
                 <a href="<?=base_url('Media/editMedia')?>" class="btn1 btn_yellow"><?=$this->lang->line(9)?></a>
            </div>
      </div>
       <!--//page_right_box-->

  </div>
   <!--//마이페이지 레이아웃 mypage-->



<!--비승인 사유 툴팁 script-->
<script>
    $('.tooltip-default').tooltip();
    $('.tooltip-custom').tooltip({
        position: 'right',
        contentBGColor: '#009688',
        labelColor: '#009688'
    });
            
    function deleteMedia(deleteUrl){
        if(confirm('<?php echo $this->lang->line('deleteMedia')?>')){
            location.href=deleteUrl;
        }
    }
</script>