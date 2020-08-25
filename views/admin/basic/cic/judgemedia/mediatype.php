<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<input type="hidden" name="s" value="1" />
			<div class="box-table-header">
				<div class="btn-group btn-group-sm" role="group">
					<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-sm btn-default">전체목록</a>
					<a href="<?php echo element('listall_url', $view); ?>?wait=1" class="btn btn-sm btn-default">대기목록</a>
					<a href="<?php echo element('listall_url', $view); ?>?allowed=1" class="btn btn-sm btn-default">승인목록</a>
					<a href="<?php echo element('listall_url', $view); ?>?denied=1" class="btn btn-sm btn-default">반려목록</a>
				</div>
				<div class="btn-group btn-group-sm" role="group">
					<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-sm btn-default">화이트리스트 전체</a>
					<?php
					foreach (element('list',element('all_whitelist', $view)) as $wkey => $wval) {
					?>
						<a href="<?php echo element('listall_url', $view); ?>?wht_id=<?php echo element('wht_id', $wval); ?>" class="btn btn-sm btn-default"><?php echo element('wht_title', $wval); ?></a>
					<?php
					}
					?>
				</div>
				<div class="btn-group pull-right" role="group" aria-label="...">
					<a href="<?php echo element('denyreason_url', $view); ?>" class="btn btn-outline btn-default btn-sm">반려사유</a>
					<a href="<?php echo element('whitelist_url', $view); ?>" class="btn btn-outline btn-default btn-sm">화이트리스트</a>
					<a href="<?php echo element('mediatype_url', $view); ?>" class="btn btn-outline btn-success btn-sm">미디어성격</a>
					<button type="submit" class="btn btn-outline btn-danger btn-sm">저장하기</button>
				</div>
			</div>
			<div class="row"><?php echo element('total_rows', element('data', $view), 0); ?>개의 미디어성격이 존재합니다</div>
			<div class="list-group">
				<div class="form-group list-group-item">
					<div class="col-sm-1">순서변경</div>
					<div class="col-sm-7">미디어 성격</div>
					<div class="col-sm-2">회원수</div>
					<div class="col-sm-2"><button type="button" class="btn btn-outline btn-primary btn-xs btn-add-rows">추가</button></div>
				</div>
				<div id="sortable">
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<div class="form-group list-group-item">
							<div class="col-sm-1"><div class="fa fa-arrows" style="cursor:pointer;"></div><input type="hidden" name="met_id[<?php echo element('met_id', $result); ?>]" value="<?php echo element('met_id', $result); ?>" /></div>
							<div class="col-sm-7"><input type="text" class="form-control" name="met_title[<?php echo element('met_id', $result); ?>]" value="<?php echo html_escape(element('met_title', $result)); ?>"/></div>
							<div class="col-sm-2"><?php echo element('member_count', $result); ?></div>
							<div class="col-sm-2"><button type="button" class="btn btn-outline btn-default btn-xs btn-delete-row" >삭제</button></div>
						</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).on('click', '.btn-add-rows', function() {
	$('#sortable').append(' <div class="form-group list-group-item"><div class="col-sm-1"><div class="fa fa-arrows" style="cursor:pointer;"></div><input type="hidden" name="met_id[]" /></div><div class="col-sm-7"><input type="text" class="form-control" name="met_title[]"/></div><div class="col-sm-2"></div><div class="col-sm-2"><button type="button" class="btn btn-outline btn-default btn-xs btn-delete-row" >삭제</button></div></div>');
});
$(document).on('click', '.btn-delete-row', function() {
	$(this).parents('div.list-group-item').remove();
});
$(function () {
	$('#sortable').sortable({
		handle:'.fa-arrows'
	});
})
//]]>
</script>
