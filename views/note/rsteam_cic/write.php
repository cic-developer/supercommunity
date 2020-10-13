<?php 
	//페이지별 언어팩 로드
	$this->lang->load('cic_note_write', $this->session->userdata('lang'));
	
	$this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>

<div class="modal-header">
	<h4 class="modal-title"><?=$this->lang->line(0)?></h4>
</div>

<div class="modal-body">
	<ul class="note_menu">
		<li><a href="<?php echo site_url('note/lists/recv'); ?>" class="btn btn-default"><?=$this->lang->line(1)?></a></li>
		<li><a href="<?php echo site_url('note/lists/send'); ?>" class="btn btn-default "><?=$this->lang->line(2)?></a></li>
		<!-- <?php if($this->member->is_admin()){ ?><li><a href="<?php echo site_url('note/write'); ?>" class="btn btn-default active"><?=$this->lang->line(3)?></a></li><?php } ?> -->
	</ul>

	<?php
	echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
	echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
	$attributes = array('class' => 'mt20', 'name' => 'fnote', 'id' => 'fnote');
	echo form_open_multipart(current_full_url(), $attributes);
	?>
		<ol>
			<!-- <li><span>받은 회원</span> -->
				<input type="hidden" class="input px300" name="userid" id="userid" value="<?php echo set_value('userid', element('userid', $view)); ?>"/>
			<!-- </li> 관리자만 받을거라서 삭제처리-->
			<li><span><?=$this->lang->line(4)?></span>
				<p class=""><?php echo $this->member->is_admin() ? element('userid', $view) : $this->lang->line(5)?></p>
			</li>
			<li><span><?=$this->lang->line(6)?></span>
				<input type="text" class="input px300" name="title" id="title" value="<?php echo set_value('title'); ?>" placeholder="<?=$this->lang->line(7)?>" />
			</li>
			<li>
				<?php echo display_dhtml_editor('content', set_value('content'), $classname = 'dhtmleditor', $is_dhtml_editor = element('use_dhtml', $view), $editor_type = $this->cbconfig->item('note_editor_type')); ?>
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
