<?php 
	//페이지별 언어팩 로드
	$this->lang->load('cic_note_mobile_write', $this->session->userdata('lang'));
	
	$this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css?=v3'); 
?>

<div class="modal-header">
	<h4 class="modal-title"><?=$this->lang->line(0)?></h4>
</div>

<div class="modal-body">
	<ul class="note_menu">
		<li><a href="<?php echo site_url('note/lists/recv'); ?>" class="btn btn-default"><?=$this->lang->line(1)?></a></li>
		<li><a href="<?php echo site_url('note/lists/send'); ?>" class="btn btn-default "><?=$this->lang->line(2)?></a></li>
		<!-- <li><a href="<?php echo site_url('note/write'); ?>" class="btn btn-default active"><?=$this->lang->line(3)?></a></li> -->
	</ul>

	<?php
	echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
	echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
	$attributes = array('class' => 'mt20', 'name' => 'fnote', 'id' => 'fnote');
	echo form_open_multipart(current_full_url(), $attributes);
	?>
		<input type="hidden" class="input px300" name="userid" id="userid" value="<?php echo set_value('userid', element('userid', $view)); ?>"/>
		<ol>
			<li><span><?=$this->lang->line(4)?></span> <?=$this->lang->line(5)?>
				<!--<input type="text" class="input px300" name="userid" id="userid" value="<?/*php echo set_value('userid', element('userid', $view)); */?>" placeholder="회원아이디를 입력, 여러명에게 보낼 때는 쉼표로 구분" />-->
			</li>
			<li><span><?=$this->lang->line(6)?></span>
				<input type="text" class="input px300" name="title" id="title" value="<?php echo set_value('title'); ?>" placeholder="<?=$this->lang->line(7)?>" />
			</li>
			<li>
				<?php //echo display_dhtml_editor('content', set_value('content'), $classname = 'dhtmleditor', $is_dhtml_editor = element('use_dhtml', $view), $editor_type = $this->cbconfig->item('note_editor_type')); ?>
				<textarea id="content" name="content" class="smarteditor dhtmleditor" style="width: 98%;"></textarea>
			</li>
			<?php if ($this->cbconfig->item('use_note_file')) { ?>
				<li><span><?=$this->lang->line(8)?></span>
					<input type="file" class="form-control" name="note_file" />
				</li>
			<?php } ?>
		</ol>
		<div class="pull-right">
			<button type="submit" class="btn btn-success"><?=$this->lang->line(9)?></button>
		</div>
	<?php echo form_close(); ?>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fnote').validate({
		rules: {
			userid: {required :true, minlength:3 },
			title: {required :true},
			content : {<?php echo (element('use_dhtml', $view)) ? 'required_' . $this->cbconfig->item('note_editor_type') : 'required'; ?> : true }
		}
	});
});
//]]>
</script>
