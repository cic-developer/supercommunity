<?php 
	//페이지별 언어팩 로드
	$this->lang->load('cic_note_lists', $this->session->userdata('lang'));
	
	$this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>

<div class="modal-header">
	<h4 class="modal-title"><?=$this->lang->line(0)?></h4>
</div>
<div class="modal-body">

	<?php echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>'); ?>

	<ul class="note_menu">
		<li><a href="<?php echo site_url('note/lists/recv'); ?>" class="btn btn-default <?php echo element('type', $view) === 'recv' ? 'active' : ''; ?>"><?=$this->lang->line(1)?></a></li>
		<li><a href="<?php echo site_url('note/lists/send'); ?>" class="btn btn-default <?php echo element('type', $view) === 'send' ? 'active' : ''; ?>"><?=$this->lang->line(2)?></a></li>
		<!-- <?php if($this->member->is_admin()){ ?><li><a href="<?php echo site_url('note/write'); ?>" class="btn btn-default"><?=$this->lang->line(3)?></a></li><?php }?> -->
	</ul>

	<table class="table mt20">
		<thead>
			<tr>
				<th><?php echo element('type', $view) === 'recv' ? $this->lang->line(4):$this->lang->line(5); ?></th>
				<th><?=$this->lang->line(6)?></th>
				<th><?=$this->lang->line(7)?></th>
				<th><?=$this->lang->line(8)?></th>
				<th><?=$this->lang->line(9)?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		if (element('list', element('data', $view))) {
			foreach (element('list', element('data', $view)) as $result) {
		?>
			<tr>
				<td><?php echo element('display_name', $result); ?></td>
				<td><a href="<?php echo site_url('note/view/' . element('type', $view) . '/' . element('nte_id', $result)); ?>"><?php echo html_escape(element('nte_title', $result)); ?></a></td>
				<td><a href="<?php echo site_url('note/view/' . element('type', $view) . '/' . element('nte_id', $result)); ?>"><?php echo display_datetime(element('nte_datetime', $result), 'full'); ?></a></td>
				<td><a href="<?php echo site_url('note/view/' . element('type', $view) . '/' . element('nte_id', $result)); ?>"><?php echo element('nte_read_datetime', $result) > '0000-00-00 00:00:00' ? display_datetime(element('nte_read_datetime', $result), 'full') : '<span style="color:#a94442;">'.$this->lang->line(10).'</span>'; ?></a></td>
				<td><button class="btn-link btn-one-delete" data-one-delete-url = "<?php echo element('delete_url', $result); ?>"><?=$this->lang->line(11)?></button></td>
			</tr>
		<?php
			}
		}
		if ( ! element('list', element('data', $view))) {
		?>
			<tr>
				<td colspan="5" class="nopost"><?=$this->lang->line(12)?></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<div class="pull-left">
		<nav><?php echo element('paging', $view); ?></nav>
	</div>
	<div class="pull-right"><button class="btn btn-default" onClick="window.close();"><?=$this->lang->line(13)?></button></div>
</div>
