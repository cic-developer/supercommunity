<div class="box">
	<div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">메인페이지</a></li>
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/denyreason'); ?>" onclick="return check_form_changed();">반려사유</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/mediatype'); ?>" onclick="return check_form_changed();">미디어 성격</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/whitelist'); ?>" onclick="return check_form_changed();">화이트리스트</a></li>
		</ul>
	</div>
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">카테고리</label>
				<div class="col-sm-10">
					<select class="form-control" name="judr_jug_id" >
						<option value="1" <?php echo set_select('judr_jug_id', '1', ( (($this->input->get('judr_jug_id') != 2 && $this->input->get('judr_jug_id') != 3) || element('judr_jug_id', element('data', $view)) === '1') ? true : false)); ?>>미션심사</option>
						<option value="2" <?php echo set_select('judr_jug_id', '2', ( ($this->input->get('judr_jug_id') == 2 || element('judr_jug_id', element('data', $view)) === '2' || element('judr_jug_id', element('data', $view)) === '4') ? true : false)); ?>>미디어심사</option>
						<option value="3" <?php echo set_select('judr_jug_id', '3', ( ($this->input->get('judr_jug_id') == 3 || element('judr_jug_id', element('data', $view)) === '3') ? true : false)); ?>>출금심사</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">제목</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="judr_title" value="<?php echo set_value('judr_title', element('judr_title', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">반려사유</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" name="judr_reason"><?php echo set_value('judr_reason', element('judr_reason', element('data', $view))); ?></textarea>
				</div>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fadminwrite').validate({
		rules: {
			judr_reason: { required: true }
		}
	});
});
//]]>
</script>
