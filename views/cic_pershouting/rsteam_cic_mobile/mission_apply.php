<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<?php
  $csrf = array(
      'name' => $this->security->get_csrf_token_name(),
      'hash'  => $this->security->get_csrf_hash()
  );
?>

<!--퍼샤우팅:: 마이페이지 > 미션신청-->
<!--mypage-->
<div id="mypage">
  <h3>MY PAGE</h3>
   <!--my_right_box-->
   <div id="my_right_box">
            <h5><?php echo $this->lang->line(0)?></h5>
                <h6>
                    <?php echo $this->lang->line(1)?>
                    <small><?php echo $this->lang->line(13)?><br/>
                        <?php echo $this->lang->line(14)?>
                     </small>
                </h6>
                <?php echo form_open_multipart(''); ?>
                <input type="hidden" name="dummy" value="1" />
<?php 
foreach($medList AS $ml){ 
    $media_check = ($ml['jud_state'] == 1 || $ml['jud_state'] == 3); //해당 미디어가 미션 심사 진행 또는 완료된 미디어인지 체크
    $media_comp_check =  ($ml['jud_state'] == 3);
    $expected_point = rs_cal_expected_point($missionData['mis_per_token'], $ml['med_superpoint'], $total_super); //예상 지급 토큰값
?>
                  <ul class="mob_list_table">
                      <li>
                          <dl>
                              <dt><?php echo $this->session->userdata('lang') == 'korean' ? element('mis_title', $missionData) : element('mis_title_en',$missionData);?></dt> <!--미션명 :: 모바일에서는 환경고려상 물고온 미션이름만 노출함-->
                              <dd><span><?php echo $this->lang->line(2)?></span> <?=$ml['med_name']?></dd>
                              <dd><span><?php echo $this->lang->line(3)?></span> <?=$ml['med_admin']?></dd>
                              <dd><span><?php echo $this->lang->line(4)?></span> <a target="_blank" href="<?=$ml['med_url']?>"><?=$ml['med_url']?></a></dd>
                              <dd><span><?php echo $this->lang->line(5)?></span> <i class="super_p"></i><b><?=$ml['med_superpoint']?></b></dd>
                              <dd><span><?php echo $this->lang->line(6)?></span> <i class="per_p"></i><b><?= number_format($expected_point, 1) ?></b></dd>
                            </dl>
                            <div class="table_bottom">
                                <div class="img_area">
                                    <small><?php echo $this->lang->line(7)?></small>
                                    <div class="img_check">
                                        <img class="<?=$media_comp_check ? 'finish_img' : 'attach_img'?>" src="<?php echo thumb_url('judge', element('jud_attach', $ml), 400, 300); ?>" alt='<?php echo $this->lang->line(8)?>' />
                                        <input class="jud_attach" accept="image/*" name="jud_attach[]" type="file" style="display:none;">
                                    </div>
                                </div>
                                <span>
                                     <small><?php echo $this->lang->line(9)?></small> <br/>
                                    <input class="applycheck" name="med_id[]" type="checkbox" value="<?=$ml['med_id']?>" <?= ($media_check)? 'checked' : '' ?>  onclick="return false" <?=$media_comp_check ? 'disabled' : ''?>>
                                    <input name="all_med_id[]" value="<?=$ml['med_id']?>" style="display:none;"/>   
                                </span>
                          </div>
                        </li>
                  </ul>
<?php } ?>

                  <div class="btn_box">
                    <input type="submit" value="<?php echo $this->lang->line(1)?>" class="btn1 btn_black" style="White-space: normal;"/>
                  </div>
<?php echo form_close(); ?>
            </div>
            <!--//my_right_box-->      
</div>
<!--//mypage-->



<script>
    var fileTypes = ['image/png', 'image/jpg', 'image/jpeg'];

    $(document).ready(function(){
        let validation_err = '<?=isset($validation_err) ? $validation_err : '' ?>';
        if(validation_err){
            alert(validation_err);
        }
    });

    $(".attach_img").on('click', function(){
        let input_img = $(this).parent().find(".jud_attach");
        input_img.click();
    });

    $(".jud_attach").on('change', function(){
        let attach_img = $(this).parent().find(".attach_img");
        let checkbox = $(this).parents('.table_bottom').find('.applycheck');
        var file = $(this).get(0).files[0];
        if(file){
            if(file.size > 10000000){
                alert('<?php echo $this->lang->line(10)?>');
                return false;
            }
            if(file.type.indexOf('image') == -1 ){
                alert('<?php echo $this->lang->line(11)?>');
                return false;
            }
            if(!validFileType(file)){
                alert('<?php echo $this->lang->line(12)?>');
                return false;
            }
            var reader = new FileReader();
            reader.onload = function(){
                attach_img.attr('src',reader.result);
            };

            reader.readAsDataURL(file);
            checkbox.prop("checked", true);
            // console.log($(this).val());
        }
    });

    function validFileType(file) {
        for (var i = 0; i < fileTypes.length; i++) {
            if (file.type) {
                    if (file.type === fileTypes[i]) { return true; }
            }else if (file.name.toLowerCase().endsWith('jpg') || file.name.toLowerCase().endsWith('jpeg') || file.name.toLowerCase().endsWith('png')) { 
                // Edge file.type 안나오는 것을 위해서.
                return true; 
            } 
        } 
        return false;
    }
</script>