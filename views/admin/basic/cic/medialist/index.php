<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
				<div class="btn-group btn-group-sm" role="group">
					<a href="?" class="btn btn-sm <?php echo ( ! $this->input->get('med_state') && $this->input->get('med_state')!=='0') ? 'btn-success' : 'btn-default'; ?>">전체미션</a>
					<a href="?med_state=1" class="btn btn-sm <?php echo ($this->input->get('med_state') === '1') ? 'btn-success' : 'btn-default'; ?>">승인대기중</a>
					<a href="?med_state=3" class="btn btn-sm <?php echo ($this->input->get('med_state') === '3') ? 'btn-success' : 'btn-default'; ?>">승인</a>
					<a href="?med_state=0" class="btn btn-sm <?php echo ($this->input->get('med_state') === '0') ? 'btn-success' : 'btn-default'; ?>">반려</a>
				</div>
				<div class="btn-group btn-group-sm" role="group">
					<a href="<?=$this->input->get('med_state')||$this->input->get('med_state')==='0' ? '?med_state='.$this->input->get('med_state') : '?'?>" class="btn btn-sm <?php echo ( ! $this->input->get('wht_id')) ? 'btn-success' : 'btn-default'; ?>">화이트리스트 전체</a>
					<?php
					foreach (element('list',element('all_whitelist', $view)) as $wkey => $wval) {
					?>
						<a href="?wht_id=<?php echo element('wht_id', $wval); ?><?=$this->input->get('med_state')||$this->input->get('med_state')==='0' ? '&med_state='.$this->input->get('med_state') : ''?>" class="btn btn-sm <?php echo (element('wht_id', $wval) === $this->input->get('wht_id')) ? 'btn-success' : 'btn-default'; ?>"><?php echo element('wht_title', $wval); ?></a>
					<?php
					}
					?>
				</div>
				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
						<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
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
							<th><a href="<?php echo element('mis_id', element('sort', $view)); ?>">번호</a></th>
							<th>미디어플랫폼</th>
							<th>관리자명</th>
							<th>링크</th>
							<th>상태</th>
							<th>닉네임</th>
							<th>자세히</th>
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
							<td><?php echo html_escape(element('wht_title', $result)); ?></td>
							<td><?php echo html_escape(element('med_admin', $result)); ?></td>
							<td><a href="<?php echo element('med_url', $result); ?>"><?php echo element('med_url', $result); ?></a></td>
							<td><?php echo element('state', $result); ?></td>
							<td><?php echo element('display_name', $result); ?></td>
							<td><a href="<?php echo admin_url($this->pagedir); ?>/detail/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">자세히</a></td>
							<td><?php if(element('med_state', $result) != 1){ ?><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>"  /> <?php } ?></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="11" class="nopost">자료가 없습니다</td>
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

<script type="text/javascript">
//<![CDATA[
function social_open(stype, mem_id) {
	var pop_url = cb_admin_url + '/member/members/socialinfo/' + stype + '/' + mem_id;
	window.open(pop_url, 'win_socialinfo', 'left=100,top=100,width=730,height=500,scrollbars=1');
	return false;
}

$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
})

//]]>
</script>
