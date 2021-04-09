<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php
  $csrf = array(
      'name' => $this->security->get_csrf_token_name(),
      'hash'  => $this->security->get_csrf_hash()
  );
//   print_r($mis_total_super);
//   exit;
?>

<!--my_right_box-->
<div id="my_right_box">
    <h5><?php echo $this->lang->line(0)?></h5> <!--마이페이지 상세 타이틀-->
    <!--my_cont_area-->
    <div class="my_cont_area">
<?php echo form_open_multipart(''); ?>
        <input type="hidden" name="dummy" value="1" />
        <h6 class="apply_head"><?php echo $this->lang->line(1)?>
            <!--새 알림 추가-->
            <small class="noti_type1">
                <b><?php echo $this->lang->line(15)?></b>
                <?php echo $this->lang->line(8)?><br/>
                <?php echo $this->lang->line(9)?> <br/>
                <?php echo $this->lang->line(16)?>
            </small>
 
        </h6>
        <table cellpadding="0" class="list_table" cellspacing="0" width="100%">
            <colgroup> <!--칸의 width조절을 여기서해-->
                <col width="8%">
                <col width="10%">
                <col width="*">
<!--20.10.14추가사항 게시링크 타이틀-->    
                <col width="20%">
<!--20.10.14추가사항 게시링크 타이틀-//-->       
                <col width="11%">
                <col width="15%">
                <col width="10%">
            </colgroup>
            <?php echo $this->lang->line(2)?>
<?php 

foreach($medList AS $ml){ 
    $media_check = ($ml['jud_state'] == 1 || $ml['jud_state'] == 3); //해당 미디어가 미션 심사 진행 또는 완료된 미디어인지 체크
    $media_comp_check =  ($ml['jud_state'] == 3 || $ml['jud_state'] == 5);
    $expected_point = rs_cal_expected_point2($missionData['mis_per_token'], $missionData['mis_max_point'], $ml['med_superpoint'], $ml); //예상 지급 토큰값
    switch($ml['jud_state']){   //심사 상태 표시
        case 0 :    //반려
            if($ml['jud_state'] === 0){
                $_state = $this->lang->line(12);    
            }else{
                $_state = $this->lang->line(20);
            }
        break;
        case 1 :    //심사중
            $_state = $this->lang->line(13);    
        break;
        case 3 :    //승인
            $_state = $this->lang->line(11);    
        break;
        case 5 :    //지급완료(사실 이건 나오면 안됨)
            $_state = $this->lang->line(14);    
        break;
    }
?>
                    <tr>
                        <td><?=$ml['med_name']?></td>
                        <td><?=$ml['med_admin']?></td>
                        <td><?=$ml['med_url']?></td>
<!---20.10.14추가사항 게시링크 url 입력-->
                        <td>
                            <small><?php echo $this->lang->line(10)?></small>
                            <input class="site_url" type="text" name="post_link[]" value="<?php echo element('jud_post_link', $ml)?>" <?php echo $media_comp_check? 'readonly' : '' ?>/>
                        </td>
<!---20.10.14추가사항 게시링크 url 입력//-->
                        <td> 
                            <span class="img_check">
                                <img 
                                    class="<?=$media_comp_check ? 'finish_img' : 'attach_img'?>" 
                                    src="<?php echo thumb_url('judge', element('jud_attach', $ml), 400, 300); ?>" 
                                    alt='인증 사진'
                                />
                                <input class="jud_attach" name="jud_attach[]" type="file" style="display:none;">
                            </span> 
                        </td>
                        <!-- <td>
                            <i class="super_p"></i><b><?php //echo $ml['med_superpoint']?></b> 
                        </td> -->
                        <td>
                            <p class="state" onclick="popup('<?php echo site_url('/Popup/paymentPolicy/'.element('mis_id',$missionData))?>')">
                                <?php echo $this->lang->line('paymentPolicy_popup')?>
                            </p>
                            <!-- <i class="per_p"></i><b><?php //echo number_format($expected_point, 1) ?></b>  -->
                        </td>
                        <td>
                            <?php if($_state){ ?><p class="state"><?php echo $_state?></p><?php } // 미션 신청 상태가 있는 경우에만 ?>
                            <input class="applycheck" name="med_id[]" type="checkbox" value="<?=$ml['med_id']?>" <?= ($media_check)? 'checked' : '' ?>  onclick="return false" <?=$media_comp_check ? 'disabled' : ''?>>
                             <input name="all_med_id[]" value="<?=$ml['med_id']?>" style="display:none;"/>   
                        </td>
                    </tr>
<?php } ?>
                </table>
                <!--mission_check 유저가 물고온 미션 노출-->
                <div class="mission_check">
                    <a href="<?php echo base_url('Mission/detailMission/'.element('mis_id',$missionData))?>" target="_blank"> <?php echo $this->lang->line(3) ?> <i class="fas fa-plus"></i></a> <!--게시글 링크로 이동-->
                    <div class="mission_check_thumb">
                        <img src="<?php echo thumb_url('mission_thumb_img', element('mis_thumb_image', $missionData), 400, 300);?>" alt="<?php echo $this->lang->line(4)?>" />
                    </div>
                    <div class="mission_check_txt">
                        <small><i class="per_p"></i> <?php echo element('mis_per_token', $missionData);?> PER POINT</small>
                        <strong>[MISSION] <?php echo $this->session->userdata('lang') == 'korean' ? element('mis_title', $missionData) : element('mis_title_en', $missionData);?></strong>
                        <p>
                            <?php echo strip_tags(mb_substr($this->session->userdata('lang') == 'korean' ? element('mis_content',$missionData) : element('mis_content_en',$missionData), 0, 100))."..."?>
                        </p>
                    </div>
                </div>
                <!--//mission_check 유저가 물고온 미션 노출-->
            </div>
             <!--//my_cont_area-->
             <div class="btn_box">
                <input type="submit" value="<?php echo $this->lang->line(1)?>" class="btn1 btn_black" />
             </div>
        </div>
        <!--my_right_box-->
<?php echo form_close(); ?>
</div>
<!--//mypage-->

<!--안내 Modal Start-->
<div class="modal fade" id="infoModal" role="dialog" style="display:table;">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<?php echo $this->lang->line('modalContent')?>
		
	</div>
</div>
<!--안내 Modal End -->


<!-- Modal Script -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script>
    var fileTypes = ['image/png', 'image/jpg', 'image/jpeg'];
    var domains = `<?php echo $domains['wht_domains']?>`.split("\n");
    $(document).ready(function(){
        let validation_err = '<?=isset($validation_err) ? $validation_err : '' ?>';
        if(validation_err){
            alert(validation_err);
        }
        $("#infoModal").modal({
            backdrop: 'static'
        });
    });

    $(".attach_img").on('click', function(){
        let input_img = $(this).parent().find(".jud_attach");
        input_img.click();
    });

    $(".jud_attach").on('change', function(){
        let attach_img = $(this).parent().find(".attach_img");
        let checkbox = $(this).parents('tr').find('.applycheck');
        var file = $(this).get(0).files[0];
        if(file){
            if(file.size > 10000000){
                alert('<?php echo $this->lang->line(5)?>');
                return false;
            }
            if(file.type.indexOf('image') == -1 ){
                alert('<?php echo $this->lang->line(6)?>');
                return false;
            }
            if(!validFileType(file)){
                alert('<?php echo $this->lang->line(7)?>');
                return false;
            }
            var reader = new FileReader();
            reader.onload = function(){
                attach_img.attr('src',reader.result);
            };

            reader.readAsDataURL(file);

            if($(this).parents('tr').find('.site_url').val()){
                checkbox.prop("checked", true);
            }else{
                checkbox.prop("checked", false);
            }
        }
    });

    $(".site_url").on('change',async function(){
        let thisvalue = $(this).val();
        let flag = true;
        let checkbox = $(this).parents('tr').find('.applycheck');
        await domains.forEach(element => {
            if(thisvalue.indexOf(element) != -1){
                flag = false;
            }
        });

        if(flag){
            alert('<?php echo $this->lang->line('c_11')?>');
            checkbox.prop("checked", false);
            $(this).val('');
            $(this).focus();
        }else{
            if( $(this).parents('tr').find('img').attr("src") != 'https://www.percommunity.com/uploads/cache/thumb-noimage_400x300.png'){
                checkbox.prop("checked", true);
            }
        }
    });

    $('form').on('submit', function(event){
        if($('.applycheck:checked').length < 1){
            event.preventDefault();
            alert('<?php echo $this->lang->line('alert_1')?>');
        }
        let url_leng = $('.site_url').length;
        let flag = false;
        for(index = 0; url_leng >= index; index ++){
            let this_siteurl = $('.site_url').eq(index);
            if(this_siteurl.val()){ 
                if(this_siteurl.parents('tr').find('img').attr("src") == 'https://www.percommunity.com/uploads/cache/thumb-noimage_400x300.png'){
                    flag = true;
                    break;
                }
            }
        }
        if(flag){
            event.preventDefault();
            alert('<?php echo $this->lang->line('confirm_1')?>');
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

    function popup(url){
        let name = '<?php echo $this->session->userdata('lang') == 'korean' ? element('mis_title', $missionData) : element('mis_title_en', $missionData);?>';
        let options = 'location = no'
        var win = window.open(url, name, options);
        win.focus();
        return win;
    }
</script>