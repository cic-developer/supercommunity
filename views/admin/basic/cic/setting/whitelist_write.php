<div class="box">
	<div class="box-header">
		<ul class="nav nav-tabs">
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">메인페이지</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/denyreason'); ?>" onclick="return check_form_changed();">반려사유</a></li>
			<li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/mediatype'); ?>" onclick="return check_form_changed();">미디어 성격</a></li>
			<li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/whitelist'); ?>" onclick="return check_form_changed();">화이트리스트</a></li>
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
				<label class="col-sm-2 control-label">제목</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="wht_title" value="<?php echo set_value('wht_title', element('wht_title', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">도메인</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" name="wht_domains"><?php echo set_value('wht_domains', element('wht_domains', element('data', $view))); ?></textarea>
					엔터로 구분 <br/> 
					http:// 또는 https:// 는 적지 않습니다. <br/> 
					예시) <br/>
					facebook.com <br/>
					fb.com
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">관리용 메모</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" name="wht_memo"><?php echo set_value('wht_memo', element('wht_memo', element('data', $view))); ?></textarea>
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
			wht_title: { required: true, minlength:2, maxlength:20 },
			wht_domains: { required: true }
		}
	});
});
//]]>
</script>
