<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>
<!--마이페이지-2 :: 내미디어 LIST-->

       <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
       <div id="my_right_box">
            <h5><?=$this->lang->line(0)?></h5> <!--마이페이지 상세 타이틀-->
            <!--my_cont_area-->
            <div class="my_cont_area">
                <h6><?=$this->lang->line(1)?></h6>
                <table cellpadding="0" class="list_table" cellspacing="0" width="100%">
                    <colgroup> <!--칸의 width조절을 여기서해-->
                      <col width="15%">
                      <col width="15%">
                      <col width="*">
                      <col width="18%">
                      <col width="15%">
                    </colgroup>
                    <tr>
                        <th><?=$this->lang->line(2)?></th>
                        <th><?=$this->lang->line(3)?></th>
                        <th><?=$this->lang->line(4)?></th>
                        <th><?=$this->lang->line(5)?></th>
                        <th><?=$this->lang->line(6)?></th>
                    </tr>
<?php foreach($media_data AS $md){ ?>
                    <tr>
                        <td><?=html_escape($md['med_name'])?></td>
                        <td><?=html_escape($md['med_admin'])?></td>
                        <td class="link"><?php echo '<a href="'.html_escape($md['med_url']).'" target="_blank">'.html_escape($md['med_url']).'</a>'?></td>
                        <td>
                            <?php
                                switch($md['med_state']){
                                    case 1 :
                                    case 2 :
                                        echo '<span class="judge"><i class="fa fa-history"></i> '.$this->lang->line(7).'</span>';
                                    break;

                                    case 3 :
                                        echo '<i class="super_p"></i><b>'.html_escape($md['med_superpoint']).'</b>';
                                    break;

                                    case 0 :
                                        echo '<span class="reject tooltip tooltip-default" data-content="'.html_escape($md['med_textarea']).'">';
                                        echo '<i class="fa fa-question-circle"></i> '.$this->lang->line(8).'</span>';
                                    break;
                                } 
                            ?>
                        </td>
                        <td>
                            <?php if($md['med_state'] == 3) {echo '<a class="s_btn" href="'.base_url('Media/increaseMedia/'.$md['med_id']).'">'.$this->lang->line(9).'</a>';} ?>
                            <?php if($md['med_state'] == 0) {echo '<a class="s_btn delete" onclick="deleteMedia(\''.base_url('Media/deleteMedia/'.$md['med_id']).'\')"> '.$this->lang->line(10).'</a>';}?>
                        </td>
                    </tr>
<?php } ?>
                </table>
            </div>
            <!--my_cont_area-->
            <div class="btn_box">
                 <a href="<?=base_url('Media/editMedia')?>" class="btn1 btn_yellow"><?=$this->lang->line(11)?></a>
            </div>
      </div>
       <!--//페이지별 변경되는 오른쪽 영역 page_right_box-->

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