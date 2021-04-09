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
				<label class="col-sm-2 control-label">사용자지정 미디어 이름</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="jud_med_name" value="<?php echo set_value('jud_med_name', element('jud_med_name', element('data', $view))); ?>" <?=element('jud_state', element('data', $view)) != 1 ? 'disabled' : ''?> />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">미디어플랫폼</label>
				<div class="col-sm-10">
					<select name="jud_med_wht_id" class="form-control" <?=element('jud_state', element('data', $view)) != 1 ? 'disabled' : ''?>>
						<?php foreach(element('list',element('all_whitelist', $view)) as $l){ ?>
							<option value="<?=element('wht_id',$l)?>" <?php echo set_select('jud_med_wht_id', element('wht_id',$l), ( element('jud_med_wht_id', element('data', $view)) == element('wht_id',$l) )); ?>><?=element('wht_title',$l)?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">링크</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="jud_med_url" value="<?php echo set_value('jud_med_url', element('jud_med_url', element('data', $view))); ?>" <?=element('jud_state', element('data', $view)) != 1 ? 'disabled' : ''?> />
					<a href="<?php echo set_value('jud_med_url', element('jud_med_url', element('data', $view))); ?>" target="_blank"><?php echo set_value('jud_med_url', element('jud_med_url', element('data', $view))); ?></a>
					<?php if(element('med_duplicate', $view)){ ?>
						<a href="/admin/cic/judgemedia?sfield=jud_med_url&skeyword=<?php echo urlencode(element('jud_med_url', element('data', $view))); ?>&search_submit=">
							<span class="label label-danger" style="margin-left:10px;">중복된 미디어입니다.</span>
						</a>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">미디어 성격</label>
				<div class="col-sm-10">
				<?php 
					foreach(element('list',element('all_mediatype', $view)) as $l){ 
					$chkvalue = in_array(element('met_id', $l), element('all_mediatype_map', $view)) ? element('met_id', $l) : '';
				?>
					<label class="checkbox-inline">
						<input type="checkbox" name="met_id[]" value="<?php echo set_value('met_id[]', element('met_id', $l)); ?>" <?=(element('met_deletion',$l) == 'Y' or element('jud_state', element('data', $view)) != 1) ? 'disabled' : ''?> <?php echo set_checkbox('met_id[]', element('met_id', $l), ($chkvalue ? true : false)); ?> />
						<?=element('met_title',$l)?><?=element('met_deletion',$l) == 'Y' ? '(삭제)' : ''?>
					</label>
				<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">관리자명</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="jud_med_admin" value="<?php echo set_value('jud_med_admin', element('jud_med_admin', element('data', $view))); ?>" <?=element('jud_state', element('data', $view)) != 1 ? 'disabled' : ''?> />
				</div>
			</div>
			<?php if(element('jud_state',element('data',$view)) == 1) { ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">SUPERPOINT</label>
				<div class="col-sm-10">
					<?php if(element('jud_state', element('data', $view)) == 1) { ?>
						<input type="text" class="form-control" name="med_superpoint" value="<?php echo set_value('med_superpoint', element('jud_jug_id', element('data', $view)) == 2 ? 0 : element('med_superpoint', element('med_data', $view))); ?>" />
					<?php } else { ?>
						<input type="text" style="all:unset; height:30px; display:inline-block; vertical-align:middle;" disabled value="0" />
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">PERFRIEND</label>
				<div class="col-sm-10">
					<?php if(element('jud_state', element('data', $view)) == 1) { ?>
					<input type="text" class="form-control" name="med_member" value="<?php echo set_value('med_member', element('jud_jug_id', element('data', $view)) == 2 ? 0 : element('med_member', element('med_data', $view))); ?>" />
					<?php } else { ?>
					<input type="text" style="all:unset; height:30px; display:inline-block; vertical-align:middle;" disabled value="0" />
					<?php } ?>
				</div>
			</div>
			<?php } ?>
			<?php if(element('jud_jug_id',element('data',$view)) == 4) { ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">신청 사유</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
					<?php echo nl2br(html_escape(element('med_textarea',element('med_data',$view)))); ?>
				</div>
			</div>
			<?php } ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">상태</label>
				<div class="col-sm-10 form-inline">
					<input type="text" style="all:unset; height:30px; display:inline-block; vertical-align:middle;" disabled value="<?=rs_get_state(element('jud_state', element('data', $view)))?>" />
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
			<div class="form-group">
				<label class="col-sm-2 control-label">회원정보</label>
				<div class="col-sm-10">
					<span class="form-control" style="border:0;box-shadow:none;padding:6px 0;"><?php echo element('display_name',$view); ?> <?php display_warn(element('mem_id', element('member',$view)));?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">등록유저IP</label>
				<div class="col-sm-10">
					<input type="text" style="all:unset; height:30px; width:150px; display:inline-block; vertical-align:middle;" disabled value="<?=element('jud_register_ip', element('data', $view))?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">등록일</label>
				<div class="col-sm-10 form-inline">
					<input type="text" style="all:unset; height:30px; width:150px; display:inline-block; vertical-align:middle;" disabled value="<?=display_datetime(element('jud_wdate', element('data', $view)),'user','Y-m-d H:i:s')?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">첨부 이미지</label>
				<div class="col-sm-10" style="min-height:30px; padding-top:7px;">
          			<img  src="<?php echo thumb_url('judge', element('jud_attach', element('data', $view)), 800, 600); ?>" alt="제출이미지" title="제출이미지"/>
				</div>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-success btn-sm" id="confirm" <?=element('jud_state', element('data', $view)) != 1 ? 'disabled' : ''?>>승인하기</button>
				<button type="button" class="btn btn-danger btn-sm" id="denyBtn" <?=element('jud_state', element('data', $view)) == 0 ? 'disabled' : ''?>>반려하기</button>
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
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
        <div style="text-align:right; padding-right:12px; margin-bottom:7px;"><a href="/admin/cic/setting/denyreason?judr_jug_id=2" target="_black">사유 등록</a></div>
        <div style="padding-bottom:4px;"> - 반려사유 - </div>
        <textarea name="deny_reason_text" id="deny_reason_text" class="form-control" rows=7 ></textarea>
        <div style="padding-bottom:4px; padding-top:8px;"> - 경고 - </div>
        <input name="deny_warning_text" id="deny_warning_text" class="form-control" />
			</div>
			<div class="modal-footer">
        <div class="btn-group">
          <button type="button" class="btn btn-danger set_state" data-value="warn" data-state="0" data-text="경고및 반려" <?=element('jud_state', element('data', $view)) == 0 ? 'disabled' : ''?>>경고+반려</button>
          <button type="button" class="btn btn-warning set_state" data-value="deny" data-state="0" data-text="반려" <?=element('jud_state', element('data', $view)) == 0 ? 'disabled' : ''?>>반려</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
        </div>
			</div>
		</div>
		
	</div>
</div>
<!-- Modal End -->

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fadminwrite').validate({
		rules: {
			jud_med_name: { required: true, minlength:2, maxlength :255 },
			jud_wht_id: { required: true, digits:true, min:1, maxlength :11 },
			jud_url: { required: true, url:true, minlength:5, maxlength :255 },
			<?php if(element('jud_state', element('data', $view)) == 1) { ?>
				med_superpoint:{ required: true, digits:true, min:1, maxlength :11 },
				med_member:{ required: true, digits:true, min:1, maxlength :11 },
			<?php } ?>
			jud_med_admin: { required: true}
		}
	});
});


$("#confirm").on('click', function(){
	if(!confirm('정말 승인처리 하시겠습니까?')){
		return false;
	}
	$("#fadminwrite").submit();
});

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
		url:'/admin/cic/judgemedia/ajax_set_state',
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
