<?php 
	//페이지별 언어팩 로드
	$this->lang->load('cic_note_mobile_view', $this->session->userdata('lang'));
	
	$this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css?=v3'); 
?>

<div class="modal-header">
	<h4 class="modal-title"><?=$this->lang->line(0)?></h4>
</div>

<div class="modal-body">
	<ul class="note_menu">
		<li><a href="<?php echo site_url('note/lists/recv'); ?>" class="btn btn-default <?php echo element('type', $view) === 'recv' ? 'active' : ''; ?>"><?=$this->lang->line(1)?></a></li>
		<li><a href="<?php echo site_url('note/lists/send'); ?>" class="btn btn-default <?php echo element('type', $view) === 'send' ? 'active' : ''; ?>"><?=$this->lang->line(2)?></a></li>
		<!-- <li><a href="<?php echo site_url('note/write'); ?>" class="btn btn-default"><?=$this->lang->line(3)?></a></li> -->
	</ul>

	<div class="note-view mt20">
		<div class="note-view-title">
			<?php echo html_escape(element('nte_title', element('data', $view))); ?> <small><?php echo element('display_name', element('data', $view)); ?>, <?php echo display_datetime(element('nte_datetime', element('data', $view)), 'full'); ?> </small>
		</div>
		<?php if (element('nte_originname', element('data', $view))) { ?>
			<div class="table-box">
				<table class="table-body">
					<tbody>
						<tr>
							<td><i class="fa fa-download"></i> <a href="<?php echo element('download_link', element('data', $view)); ?>"><?php echo html_escape(element('nte_originname', element('data', $view))); ?></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php } ?>
		<div class="note-contents">
			<?php echo element('content', element('data', $view)); ?>
		</div>
	</div>
	<div class="pull-right" aria-label="...">
		<button type="button" class="btn btn-success btn-sm" onClick="history.back();"><?=$this->lang->line(4)?></button>
		<?php if (element('userid', element('data', $view))) { ?><a href="<?php echo site_url('note/write/' . html_escape(element('userid', element('data', $view)))); ?>" class="btn btn-danger btn-sm"><?php echo element('type', $view) === 'send' ? $this->lang->line(5):$this->lang->line(6); ?></a><?php } ?>
		<button class="btn btn-default btn-sm" onClick="window.close();"><?=$this->lang->line(7)?></button>
	</div>
</div>
