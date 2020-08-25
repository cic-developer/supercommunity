<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
				<div class="btn-group btn-group-sm" role="group">
					<a href="?" class="btn btn-sm <?php echo ( $this->input->get('jud_state') !== '0' && $this->input->get('jud_state') !== '1' && $this->input->get('jud_state') !== '3' && $this->input->get('jud_state') !== '5' ) ? 'btn-success' : 'btn-default'; ?>">전체목록</a>
					<a href="?jud_state=1" class="btn btn-sm <?php echo ($this->input->get('jud_state') === '1') ? 'btn-success' : 'btn-default'; ?>">대기목록</a>
					<a href="?jud_state=3" class="btn btn-sm <?php echo ($this->input->get('jud_state') === '3') ? 'btn-success' : 'btn-default'; ?>">승인 - 지급대기</a>
					<a href="?jud_state=5" class="btn btn-sm <?php echo ($this->input->get('jud_state') === '5') ? 'btn-success' : 'btn-default'; ?>">지급완료</a>
					<a href="?jud_state=0" class="btn btn-sm <?php echo ($this->input->get('jud_state') === '0') ? 'btn-success' : 'btn-default'; ?>">반려목록</a>
				</div>
				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
						<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택 지급처리</button>
					</div>
				<?php
				$buttons = ob_get_contents();
				ob_end_flush();
				?>
			</div>
			<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th><a href="<?php echo element('jud_id', element('sort', $view)); ?>">번호</a></th>
							<th>지갑주소</th>
							<th><a href="<?php echo element('jud_withdraw', element('sort', $view)); ?>">수량</a></th>
							<th><a href="<?php echo element('jud_state', element('sort', $view)); ?>">상태</a></th>
							<th><a href="<?php echo element('jud_mem_nickname', element('sort', $view)); ?>">신청자</a></th>
							<th><a href="<?php echo element('jud_wdate', element('sort', $view)); ?>">신청일</a></th>
							<th>버튼</th>
							<th><input type="checkbox" name="chkall" id="chkall" /></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td><?php echo number_format(element('num', $result)); ?></td>
							<td><?php echo html_escape(element('jud_wallet', $result)); ?></td>
							<td class="text-right"><?php echo number_format(element('jud_withdraw', $result)); ?></td>
							<td><?php echo rs_get_state(element('jud_state', $result)); ?></td>
							<td><?php echo element('display_name', $result); ?></td>
							<td><?php echo display_datetime(element('jud_wdate', $result), 'user', 'Y-m-d H:i:s'); ?></td>
							<td>
								<div class="btn-group">
									<?php if(element('jud_state', $result) == 1) { ?>
										<button type="button" class="btn btn-outline btn-success btn-xs set_state" data-text="승인" data-judid="<?php echo element(element('primary_key', $view), $result); ?>" data-value="confirm" data-state="3" >승인</button>
										<button type="button" class="btn btn-outline btn-danger btn-xs" id="denyBtn" data-judid="<?php echo element(element('primary_key', $view), $result); ?>">반려</button>
									<?php } else if (element('jud_state', $result) == 3) { ?>
										<button type="button" class="btn btn-outline btn-success btn-xs set_state" data-text="지급" data-judid="<?php echo element(element('primary_key', $view), $result); ?>" data-value="withdraw" data-state="5" >지급</button>
									<?php } else if (element('jud_state', $result) == 5) { ?>
										<button type="button" class="btn btn-outline btn-success btn-xs" disabled >지급완료</button>
									<?php } else { ?>
										<button type="button" class="btn btn-outline btn-danger btn-xs" disabled >반려</button>
									<?php } ?>
								</div>
							</td>
						<td><?php if(element('jud_state',$result) == 3){ ?><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /><?php } ?></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="17" class="nopost">자료가 없습니다</td>
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
			<div class="box-info">
				<?php echo element('paging', $view); ?>
				<div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
				<?php echo $buttons; ?>
			</div>
		<?php echo form_close(); ?>
	</div>
	<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		<div class="box-search">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<select class="form-control" name="sfield" >
						<?php echo element('search_option', $view); ?>
					</select>
					<div class="input-group">
						<input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
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
        <div style="text-align:right; padding-right:12px; margin-bottom:7px;"><a href="/admin/cic/judgemission/denyreason" target="_black">사유 등록</a></div>
        <div style="padding-bottom:4px;"> - 반려사유 - </div>
        <textarea name="deny_reason_text" id="deny_reason_text" class="form-control" rows=7 ></textarea>
        <div style="padding-bottom:4px; padding-top:8px;"> - 경고 - </div>
        <input name="deny_warning_text" id="deny_warning_text" class="form-control" />
			</div>
			<div class="modal-footer">
        <div class="btn-group">
          <button type="button" id="modal_warn" class="btn btn-danger set_state" data-judid="0" data-value="warn" data-state="0" data-text="경고및 반려">경고+반려</button>
          <button type="button" id="modal_deny" class="btn btn-warning set_state" data-judid="0" data-value="deny" data-state="0" data-text="반려">반려</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
        </div>
			</div>
		</div>
		
	</div>
</div>
<!-- Modal End -->

<script type="text/javascript">
//<![CDATA[

$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
})


$(document).on('click', '#denyBtn', function(){
	let judid = $(this).attr('data-judid');
	$("#deny_reason_select").val('_self_type').prop("selected",true);
	$("#deny_reason_text").val('');
	$("#deny_warning_text").val('');
	$('#modal_warn').attr('data-judid',judid);
	$('#modal_deny').attr('data-judid',judid);
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
  let _jul_id   = $(this).attr('data-judid');
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
		url:'/admin/cic/judgewithdraw/ajax_set_state',
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
        if(_value == 'withdraw') alert('지급되었습니다.');
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
