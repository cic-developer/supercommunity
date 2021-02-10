<?php 
	function display_warn($mem_id){
		$CI =& get_instance();
		$all_extra = $CI->Member_extra_vars_model->get('','', array('mem_id' => $mem_id));
		foreach($all_extra AS $extra){
			if(  $extra['mev_key'] == 'mem_warn_1' ||  $extra['mev_key'] == 'mem_warn_2' ){
				if($extra['mev_value']){
					echo '<span class="label label-danger" style="margin-left:10px;">경고</span>';
					return;
				}
			}
		}
	}
?>
<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">신청자</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo element('display_name', element('data', $view)); ?>
					<?php display_warn( element('mem_id' , element('member', element('data',$view))) )?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">미션제목</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo element('mis_title', element('data', $view)); ?>
          <a href="/Mission/detailMission/<?=element('mis_id', element('data', $view))?>" target="_blank" style="padding-left:10px;" >유저페이지 <span class="glyphicon glyphicon-new-window"></span></a>
          <a href="/admin/cic/missionlist/write/<?=element('mis_id', element('data', $view))?>" target="_blank" style="padding-left:10px;" >관리페이지 <span class="glyphicon glyphicon-new-window"></span></a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">승인여부</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo rs_get_state(element('jud_state', element('data', $view))); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">예상/실제 지급 PER TOKEN</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php 
					switch(element('jud_state', element('data', $view))){
						case '0': 
							echo 0;
						break;
						case '1':
						case '3':
							echo number_format(rs_cal_expected_point2( element('mis_per_token', element('data', $view)), element('mis_max_point', element('data', $view)), element('med_superpoint', element('data', $view)), element('data', $view) ),1);
						break;
							// echo number_format((element('mis_per_token', element('data', $view))*element('med_superpoint', element('data', $view))/(element('mip_tpoint', element('data', $view))===0? 1 : element('mip_tpoint', element('data', $view)) )),1);
						break;
						case '5':
							echo number_format(element('jud_point', element('data', $view)),1);
						break;
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">미션 본문</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo element('mis_content', element('data', $view)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">미디어 플랫폼</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo element('wht_title', element('data', $view)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">미디어 관리자명</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo element('jud_med_admin', element('data', $view)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">미디어 링크</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<a href="<?php echo element('jud_med_url', element('data', $view)); ?>" target="_blank"><?php echo element('jud_med_url', element('data', $view)); ?></a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">게시물 링크</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<a href="<?php echo element('jud_post_link', element('data', $view)); ?>" target="_blank"><?php echo element('jud_post_link', element('data', $view)); ?></a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">첨부 이미지</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
          <img  src="<?php echo thumb_url('judge', element('jud_attach', element('data', $view)), 800, 600); ?>" alt="제출이미지" title="제출이미지"/>
				</div>
			</div>
			<?php if(element('judn_reason',element('this_denied_reason',$view))) { ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">반려사유</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('judn_reason',element('this_denied_reason',$view))); ?>
				</div>
			</div>
			<?php } ?>
			<div class="btn-group pull-right" role="group" aria-label="...">
			<?php if(element('jud_state', element('data', $view)) == 3 && element('state', element('data', $view)) == 'end'){ ?>
				<button type="button" class="btn btn-outline btn-default btn-sm give_point" 
					data-judid="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" 
					data-userid="<?php echo element('mem_userid',element('member', element('data', $view))); ?>" 
					data-nickname="<?php echo element('jud_mem_nickname', element('data', $view)); ?>" 
					data-superfriend="<?php echo element('is_superfriend',element('data', $view)); ?>"
					data-point="<?php echo rs_cal_expected_point2(
						element('mis_per_token', element('data', $view)),
						element('mis_max_point', element('data', $view)),
						element('med_superpoint', element('data', $view)),
						element('data', $view)
					)?>"
					data-superpoint="<?php echo element('med_superpoint',element('data',$view))?>"
				>
					포인트 지급
				</button>
			<?php } ?>
				<button type="button" class="btn btn-success btn-sm set_state" data-value="confirm" data-state="3" data-text="승인" <?=element('jud_state', element('data', $view)) != 1 ? 'disabled' : ''?>>승인하기</button>
        <button type="button" id="denyBtn" class="btn btn-danger btn-sm" <?=element('jud_state', element('data', $view)) != 1 ? 'disabled' : ''?>>반려하기</button>
				<button type="button" class="btn btn-default btn-sm btn-history-back" >목록으로</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>


<!-- 포인트 지급 Modal -->
<div class="modal fade" id="pointModal" role="dialog">
	<div class="modal-dialog modal-lg">
	
		<!-- Modal content-->
		<div class="modal-content" style="position:absolute; z-index:2000; width:100%;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">포인트 지급</h4>
			</div>
			<div class="modal-body" style="text-align:center;">
				<div id='div_superfriend' style="margin-bottom:15px;">
					<span style="text-align:center; font-size:24px; font-weight:bold;">SUPERFRIEND</span>
				</div>
				<form class="form-horizontal" id="gp_form">
					<input name="<?php echo $this->security->get_csrf_token_name(); ?>" type="hidden" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					<input name="gp_jud_id" type="hidden" />
					<input name="gp_point" type="hidden" />
					<fieldset>
					
						<!-- Text input-->
						
						<div class="form-group">
							<label class="col-md-4 control-label">유저 닉네임</label>  
							<div class="col-md-4 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input  name="gp_nickname" placeholder="로딩중" class="form-control"  type="text" readonly style="background-color:#ffffff;">
								</div>
							</div>
						</div>
						
						<!-- Text input-->
						
						<div class="form-group">
							<label class="col-md-4 control-label" >유저 아이디</label> 
							<div class="col-md-4 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input name="gp_userid" placeholder="로딩중" class="form-control"  type="text" readonly style="background-color:#ffffff;">
								</div>
							</div>
						</div>

						<!-- Text input-->
						
						<div class="form-group">
							<label class="col-md-4 control-label" >신청 미디어 super point</label> 
							<div class="col-md-4 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
									<input name="gp_mediasuper" placeholder="로딩중" class="form-control"  type="text" readonly style="background-color:#ffffff;">
								</div>
							</div>
						</div>
						
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label">예상 지급 퍼포인트</label>  
							<div class="col-md-4 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
									<input name="gp_expectpoint" placeholder="로딩중" class="form-control"  type="text" readonly style="background-color:#ffffff;">
								</div>
							</div>
						</div>
						
						<!-- Select Basic -->
						<div class="form-group"> 
							<label class="col-md-4 control-label">실제지급퍼센티지</label>
							<div class="col-md-4 selectContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
									<select name="gp_giveperc" class="form-control selectpicker" >
										<option value="100" >100%</option>
										<option value="90" >90%</option>
										<option value="80" >80%</option>
										<option value="70" >70%</option>
										<option value="60" >60%</option>
										<option value="50" >50%</option>
										<option value="40" >40%</option>
										<option value="35" >35%</option>
										<option value="30" >30%</option>
										<option value="28" >28%</option>
										<option value="26" >26%</option>
										<option value="24" >24%</option>
										<option value="22" >22%</option>
										<option value="20" >20%</option>
										<option value="18" >18%</option>
										<option value="16" >16%</option>
										<option value="14" >14%</option>
										<option value="12" >12%</option>
										<option value="10" >10%</option>
										<option value="9" >9%</option>
										<option value="8" >8%</option>
										<option value="7" >7%</option>
										<option value="6" >6%</option>
										<option value="5" >5%</option>
										<option value="4" >4%</option>
										<option value="3" >3%</option>
										<option value="2" >2%</option>
										<option value="1" >1%</option>
										<option value="0" >0%</option>
									</select>
								</div>
							</div>
						</div>
						
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label">실제 지급 퍼포인트</label>  
							<div class="col-md-4 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-gift"></i></span>
									<input name="gp_givepoint" class="form-control"  type="text" value="0" readonly style="background-color:#ffffff;">
								</div>
							</div>
						</div>

					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success send_point" >지급</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
		
	</div>
</div>
<!-- Modal End -->

<style>
  @media (min-width: 780px){ 
    .modal-dialog{
      margin: 150px auto;
    }
  }
</style>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">반려사유입력</h4>
			</div>
			<div class="modal-body">
        <select class="form-control" name="deny_reason_select" id="deny_reason_select" style="margin-bottom:7px;">
          <option value="_self_type">직접입력</option>
          <?php foreach(element('list', element('all_denyreason', $view)) as $r){ ?>
            <option value="<?=html_escape(element('judr_reason',$r))?>"><?php echo html_escape(element('judr_title', $r)); ?></option>
          <?php } ?>
        </select>
        <div style="text-align:right; padding-right:12px; margin-bottom:7px;"><a href="/admin/cic/setting/denyreason?judr_jug_id=1" target="_black">사유 등록</a></div>
        <div style="padding-bottom:4px;"> - 반려사유 - </div>
        <textarea name="deny_reason_text" id="deny_reason_text" class="form-control" rows=7 ></textarea>
        <div style="padding-bottom:4px; padding-top:8px;"> - 경고 - </div>
        <input name="deny_warning_text" id="deny_warning_text" class="form-control" />
			</div>
			<div class="modal-footer">
        <div class="btn-group">
          <button type="button" class="btn btn-danger set_state" data-value="warn" data-state="0" data-text="경고및 반려" <?=element('jud_state', element('data', $view)) != 1 ? 'disabled' : ''?>>경고+반려</button>
          <button type="button" class="btn btn-warning set_state" data-value="deny" data-state="0" data-text="반려" <?=element('jud_state', element('data', $view)) != 1 ? 'disabled' : ''?>>반려</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
        </div>
			</div>
		</div>
		
	</div>
</div>
<!-- Modal End -->


<script type="text/javascript">
//<![CDATA[
$(document).on('click', '#denyBtn', function(){
	$("#myModal").modal({
		backdrop:false
	});
});
var previous = null;
$("#deny_reason_select").on('focus', function () {
  // Store the current value on focus and on change
  previous = this.value;
}).on('change',function(){
  
  if($('#deny_reason_text').val()){
    if(!confirm('입력된 내용들이 삭제됩니다.')) {
      $("#deny_reason_select").val(previous).prop("selected",true);
      return false;
    }
  }
  if($(this).val() == '_self_type'){
    $('#deny_reason_text').val('');
    
    // $('#deny_reason_text').css('display','inline-block');
  } else {
    $('#deny_reason_text').val($(this).val());
  }
});

$(document).on('click','.set_state',function(){
  if(!confirm('정말 '+$(this).attr('data-text')+'처리 하시겠습니까?')) return false;
	let csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  let csrfHash  = '<?php echo $this->security->get_csrf_hash(); ?>';
  let _jul_id   = '<?php echo element(element('primary_key', $view), element('data', $view)); ?>';
  let _value    = $(this).attr('data-value');
  let _state    = $(this).attr('data-state');
  let _deny     = $("#deny_reason_text").val();
  let _warn     = $("#deny_warning_text").val();
  let _is_block = '<?=$this->Member_extra_vars_model->get_one('','mev_value',array('mem_id' => element('jud_mem_id',$getdata), 'mev_key' => 'mem_warn_1')) && !$this->Member_model->get_by_memid(element('jud_mem_id', element('data', $view)),'mem_denied')?>'
	if(_value == 'warn' && _is_block) {
    if(!confirm('해당유저는 현재 경고 1회로 차단됩니다.')) return false;
  }
  $.ajax({
		type: 'post',
		dataType: "json",
		url:'/admin/cic/judgemission/ajax_set_state',
		data:{
			[csrfName]: csrfHash,
			jud_id:_jul_id,
      value:_value,
      state:_state,
      deny:_deny,
      warn:_warn
		},
		success(result){
			if(result.type == 'success'){
        if(_value == 'confirm') alert('승인되었습니다.');
        if(_value == 'deny') alert('반려되었습니다.');
        if(_value == 'warn'){
          if(result.warn_count == 1) alert('경고 1회 및 반려처리 되었습니다.');
          if(result.warn_count == 2) alert('경고 2회로 해당 유저 차단 및 반려처리 되었습니다.');
        }
				location.reload();
				return;
			} else if (result.type == 'error'){
				alert(result.data);
				return;
			} else {
				throw new error('unhandled error occur');
			}
			
		}
	});
});


$(document).on('click', '.give_point', function(){
	document.getElementById("gp_form").reset();
	$('.send_point').attr('disabled', false);
	if($(this).attr('data-superfriend')){
		$('#div_superfriend').css('display','');
	} else {
		$('#div_superfriend').css('display','none');
	}
	$("#pointModal .modal-body input[name=gp_jud_id]").val($(this).attr('data-judid'));
	$("#pointModal .modal-body input[name=gp_point]").val($(this).attr('data-point'));
	$("#pointModal .modal-body input[name=gp_nickname]").val($(this).attr('data-nickname'));
	$("#pointModal .modal-body input[name=gp_userid]").val($(this).attr('data-userid'));
	$("#pointModal .modal-body input[name=gp_expectpoint]").val(Number($(this).attr('data-point')).toLocaleString('en', {maximumFractionDigits: 1}));
	$("#pointModal .modal-body input[name=gp_givepoint]").val(Number($(this).attr('data-point')).toLocaleString('en', {maximumFractionDigits: 1}));
	$("#pointModal .modal-body input[name=gp_mediasuper]").val(Number($(this).attr('data-superpoint')).toLocaleString('en', {maximumFractionDigits: 1}));
	$("#pointModal").modal({
		backdrop:false
	});
});


$(document).on('change', '#pointModal .modal-body select[name=gp_giveperc]', function(){
	console.log('onchange')
	let _perc = $(this).val();
	let _point = $("#pointModal .modal-body input[name=gp_point]").val();
	let _calculate = _point / 100 * _perc;
	$("#pointModal .modal-body input[name=gp_givepoint]").val(_calculate.toLocaleString('en', {maximumFractionDigits: 1}));
});


$(document).on('click','.send_point',function(){
	if(typeof($(this).attr('disabled')) !== 'undefined') {
		return false;
	} else {
  	if(!confirm('정말 지급처리 하시겠습니까?')) return false;
		$(this).attr('disabled', true);
	}
	let _data = $('#gp_form').serialize();
  $.ajax({
		type: 'post',
		dataType: "json",
		url:'/admin/cic/judgemission/ajax_givepoint',
		data: _data,
		success(result){
			if(result.type == 'success'){
        alert('승인되었습니다.');
				location.reload();
			} else if (result.type == 'error'){
				$('.send_point').attr('disabled', false);
				alert(result.data);
				return;
			} else {
				$('.send_point').attr('disabled', false);
				throw new error('unhandled error occur');
			}
			
		}
	});
});
//]]>
</script>
