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
				<label class="col-sm-2 control-label">Per Friends 노출여부</label>
				<div class="col-sm-10">
					<label for="mcf_perfriends_setting" class="checkbox-inline">
						<input type="checkbox" name="mcf_perfriends_setting" id="mcf_perfriends_setting" value="1" <?php echo element('mcf_perfriends_setting', element('data',$view)) ? 'checked':'' ?>/> 노출시킵니다.
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">메인 메세지 노출여부</label>
				<div class="col-sm-10">
					<label for="mcf_message_setting" class="checkbox-inline">
						<input type="checkbox" name="mcf_message_setting" id="mcf_message_setting" value="1" <?php echo element('mcf_message_setting', element('data',$view)) ? 'checked':'' ?>/> 노출시킵니다.
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">메인 메세지</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" name="mcf_messages"><?php echo str_replace('<br />', '',element('mcf_messages', element('data', $view))); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">영문 메인 메세지</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" name="mcf_messages_en"><?php echo str_replace('<br />', '',element('mcf_messages_en', element('data', $view))); ?></textarea>
					엔터로 구분 <br/>  
					예시) <br/>
					코뿔소 Youtube 님이 회원가입 하였습니다. <br/>
					코리아 Coin Master 코코마님이 회원가입 하였습니다.
				</div>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">

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
