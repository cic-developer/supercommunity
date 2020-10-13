<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
				<div class="nav nav-pills" role="group">
					<label>시작일 <input type="text" class="form-control input-small datepicker " id="start_date" name="start_date" value="<?php echo $this->input->get('start_date')?>" readonly/></label>
					<label>종료일 <input type="text" class="form-control input-small datepicker " id="end_date" name="end_date" value="<?php echo $this->input->get('end_date')?>" readonly/></label>
					<button type="button" class="btn btn-default btn-sm"  onclick="get_submit()">검색</button>
				</div>
				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
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
							<th>번호</th>
							<th>회원 NickName</th>
							<th>지갑주소</th>
							<th>주소등록일</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td><?php echo element('num', $result)?></td>
							<td><?php echo element('mem_nickname',element('member', $result)); ?></td>
							<td><?php echo element('wallet_address',$result); ?></td>
							<td><?php echo display_datetime(element('wallet_date', $result), 'full'); ?></td>
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
					<!-- <select class="form-control" name="sfield" >
						<?php //echo element('search_option', $view); ?>
					</select> -->
					<div class="input-group">
						<!-- <input type="text" class="form-control" name="skeyword" value="<?php //echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span> -->
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	$(function() {	
		$("#start_date").datepicker({
			fromat:"yy-mm-dd",
			language : "ko"
		});

		$("#end_date").datepicker({
			fromat: "yy-mm-dd",
			language : "ko"
		});
	});

	function get_submit(){
		$("form").attr('method','get');
		$("form").submit();
	}
</script>
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
