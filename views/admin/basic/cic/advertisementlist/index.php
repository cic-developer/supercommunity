<div class="box">
	<!-- <div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="<?php// echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">광고목록</a></li>
			<li role="presentation"><a href="<?php// echo admin_url($this->pagedir . '/askadvertise'); ?>" onclick="return check_form_changed();">광고 요청</a></li>
			<li role="presentation"><a href="<?php// echo admin_url($this->pagedir . '/adconsulting'); ?>" onclick="return check_form_changed();">광고 컨설팅 요청</a></li>
		</ul>
	</div> -->
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
				<div class="btn-group btn-group-sm" role="group">
					<a href="?" class="btn btn-sm <?php echo ( ! $this->input->get('ad_type')) ? 'btn-success' : 'btn-default'; ?>">전체</a>
					<a href="?ad_type=1" class="btn btn-sm <?php echo ($this->input->get('ad_type') == 1) ? 'btn-success' : 'btn-default'; ?>">이미지</a>
					<a href="?ad_type=2" class="btn btn-sm <?php echo ($this->input->get('ad_type') == 2) ? 'btn-success' : 'btn-default'; ?>">유튜브</a>
				</div>
				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<!-- <button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button> -->
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
						<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
						<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">광고추가</a>
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
							<th>작성자</th>
							<th>광고 분류</th>
							<th><a href="<?php echo element('ad_wdate', element('sort', $view)); ?>">작성일</a></th>
							<th><a href="<?php echo element('ad_state', element('sort', $view)); ?>">상태</a></th>
							<th>메모</th>
							<th>수정</th>
							<th><input type="checkbox" name="chkall" id="chkall" /></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td><?php echo element('display_name', $result); ?></td>
							<td><?php echo (element('ad_type', $result) == 1) ? '이미지':'유튜브'?></td>
							<td><?php echo display_datetime(element('ad_wdate', $result), 'full'); ?></td>
							<td><?php echo (element('ad_state', $result) == 0) ? '비공개' : '공개'?></td>
							<td><?php echo mb_substr(element('ad_memo', $result), 0, 21)?></td>
							<td><a href="<?php echo admin_url($this->pagedir); ?>/write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
							<td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td>
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
