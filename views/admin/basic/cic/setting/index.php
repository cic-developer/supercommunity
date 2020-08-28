<div class="box">
	<div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">메인페이지</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/denyreason'); ?>" onclick="return check_form_changed();">반려사유</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/mediatype'); ?>" onclick="return check_form_changed();">미디어 성격</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/whitelist'); ?>" onclick="return check_form_changed();">화이트리스트</a></li>
		</ul>
	</div>
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open(current_full_url(), $attributes);
		?>
			<input type="hidden" name="is_submit" value="1" />
			<div class="form-group">
				<label class="col-sm-2 control-label">메인페이지 글자 노출여부</label>
				<div class="col-sm-10">
					<label for="main_message" class="checkbox-inline">
						<input type="checkbox" name="main_message" id="main_message" value="1" <?php echo set_checkbox('main_message', '1', (element('main_message', element('data', $view)) ? true : false)); ?> checked disabled /> 노출시킵니다.
					</label>
				</div>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
// $(function() {
// 	$('#fadminwrite').validate({
// 		rules: {
// 			use_login_account: {required :true},
// 			password_length: {required :true, number:true, min:4 },
// 			password_uppercase_length: {required :true, number:true, min:0 },
// 			password_numbers_length: {required :true, number:true, min:0 },
// 			password_specialchars_length: {required :true, number:true, min:0 },
// 			register_level: {required :true, number:true, min:1, max:1000 }
// 		}
// 	});
// });

var form_original_data = $('#fadminwrite').serialize();
function check_form_changed() {
	if ($('#fadminwrite').serialize() !== form_original_data) {
		if (confirm('저장하지 않은 정보가 있습니다. 저장하지 않은 상태로 이동하시겠습니까?')) {
			return true;
		} else {
			return false;
		}
	}
	return true;
}
//]]>
</script>
