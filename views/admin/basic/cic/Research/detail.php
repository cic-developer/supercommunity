<?php $datas = (array)json_decode(element('res_input', element('data',$view)))?>


<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">이메일</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_email', $datas)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">전화번호</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_tel', $datas)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">문의자</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo element('display_name', $view); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">제품 또는 프로젝트 이름</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_name', $datas)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">분야</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_category', $datas)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">광고 내용</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_contents', $datas)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">문의 접수일</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_wdate', element('data',$view))); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">광고 내용 첨부 파일</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php if(element('res_file', element('data',$view))) {?>
					<a href="<?php echo admin_url('/cic/Research/download/'.element('res_id', element('data',$view)))?>">
						<?php echo element('res_file', element('data',$view))?>	다운로드
					</a>
					<?php }else {?>
						파일 첨부 없음
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">언제부터 광고할지</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_when', $datas)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">얼마동안 광고할지</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_howlong', $datas)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">예산</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_price', $datas)); ?> 만원
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">마케팅 플랫폼</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php 
						foreach((array)element('res_platform', $datas) AS $res_platform){
							echo $res_platform.",";
						}
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">광고 컨설팅 필요 여부</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo html_escape(element('res_package', $datas)); ?>
				</div>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >목록으로</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

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
//]]>
</script>
