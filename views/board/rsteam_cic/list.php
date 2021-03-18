<?php
	//페이지별 언어팩 로드
	$this->lang->load('cic_board_list', $this->session->userdata('lang'));
?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php echo element('headercontent', element('board', element('list', $view))); ?>

<div id="white_wrap" class="board">
	<h3><?php echo html_escape(element('board_name', element('board', element('list', $view)))); ?></h3>
	<div class="table-top">
		<div class="col-md-6">
			<div class=" searchbox">
				<form class="navbar-form navbar-right pull-right" action="<?php echo board_url(element('brd_key', element('board', element('list', $view)))); ?>" onSubmit="return postSearch(this);">
					<input type="hidden" name="findex" value="<?php echo html_escape($this->input->get('findex')); ?>" />
					<input type="hidden" name="category_id" value="<?php echo html_escape($this->input->get('category_id')); ?>" />
					<div class="form-group">
						<select class="input pull-left px100" name="sfield">
							<option value="post_both" <?php echo ($this->input->get('sfield') === 'post_both') ? ' selected="selected" ' : ''; ?>><?=$this->lang->line(0)?></option>
							<option value="post_title" <?php echo ($this->input->get('sfield') === 'post_title') ? ' selected="selected" ' : ''; ?>><?=$this->lang->line(1)?></option>
							<option value="post_content" <?php echo ($this->input->get('sfield') === 'post_content') ? ' selected="selected" ' : ''; ?>><?=$this->lang->line(2)?></option>
						</select>
						<input type="text" class="input px150" placeholder="Search" name="skeyword" value="<?php echo html_escape($this->input->get('skeyword')); ?>" />
						<button class="btn-primary btn-sm" type="submit"><i class="fa fa-search"></i></button>
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript">
		//<![CDATA[
		function postSearch(f) {
			var skeyword = f.skeyword.value.replace(/(^\s*)|(\s*$)/g,'');
			if (skeyword.length < 2) {
				alert('<?=$this->lang->line(3)?>');
				f.skeyword.focus();
				return false;
			}
			return true;
		}
		function toggleSearchbox() {
			$('.searchbox').show();
			$('.searchbuttonbox').hide();
		}
		<?php
		if ($this->input->get('skeyword')) {
			echo 'toggleSearchbox();';
		}
		?>
		//]]>
		</script>
	</div>

	<?php
	$attributes = array('name' => 'fboardlist', 'id' => 'fboardlist');
	echo form_open('', $attributes);
	?>
		<table class="table"  cellpadding="0" cellspaceing="0">
			<colgroup>
			<?php if (element('is_admin', $view)) { ?> <col width="5%"/> <?php } ?>
				<col width="10%"/>
				<col width="*"/>
				<col width="12%"/>
				<col width="15%"/>
				<col width="5%"/>
			</colgorup>
			<thead>
				<tr>
					<?php if (element('is_admin', $view)) { ?><th><input onclick="if (this.checked) all_boardlist_checked(true); else all_boardlist_checked(false);" type="checkbox" /></th><?php } ?>
					<th><?=$this->lang->line(4)?></th>
					<th><?=$this->lang->line(5)?></th>
					<th><?=$this->lang->line(6)?></th>
					<th><?=$this->lang->line(7)?></th>
					<th><?=$this->lang->line(8)?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			if (element('notice_list', element('list', $view))) {
				foreach (element('notice_list', element('list', $view)) as $result) {
			?>
				<tr>
					<?php if (element('is_admin', $view)) { ?><th scope="row"><input type="checkbox" name="chk_post_id[]" value="<?php echo element('post_id', $result); ?>" /></th><?php } ?>
					<td><span class="label label-primary"><?=$this->lang->line(9)?></span></td>
					<td class="title_td">
						<?php if (element('post_reply', $result)) { ?><span class="label label-primary" style="margin-left:<?php echo strlen(element('post_reply', $result)) * 10; ?>px">Re</span><?php } ?>
						<a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?></a>
						<?php if (element('post_file', $result)) { ?><span class="fa fa-download"></span><?php } ?>
					<td><?php echo element('display_name', $result); ?></td>
					<td><?php echo element('display_datetime', $result); ?></td>
					<td><?php echo number_format(element('post_hit', $result)); ?></td>
				</tr>
			<?php
				}
			}
			if (element('list', element('data', element('list', $view)))) {
				foreach (element('list', element('data', element('list', $view))) as $result) {
			?>
				<tr>
					<?php if (element('is_admin', $view)) { ?><th scope="row"><input type="checkbox" name="chk_post_id[]" value="<?php echo element('post_id', $result); ?>" /></th><?php } ?>
					<td><?php echo element('num', $result); ?></td>
					<td class="title_td">
						<?php if (element('post_reply', $result)) { ?><span class="label label-primary" style="margin-left:<?php echo strlen(element('post_reply', $result)) * 10; ?>px">Re</span><?php } ?>
						<a href="<?php echo element('post_url', $result); ?>" title="<?php echo html_escape(element('title', $result)); ?>"><?php echo html_escape(element('title', $result)); ?></a>
						<?php if (element('post_file', $result)) { ?><span class="fa fa-download"></span><?php } ?>
						<?php if (element('is_hot', $result)) { ?><span class="label label-danger">Hot</span><?php } ?>
						<?php if (element('is_new', $result)) { ?><span class="label label-warning">New</span><?php } ?>
						<?php if (element('post_blind', $result)){ ?><span class="label label-blind">Blind</span><?php }?>
					<td><?php echo element('display_name', $result); ?></td>
					<td><?php echo element('display_datetime', $result); ?></td>
					<td><?php echo number_format(element('post_hit', $result)); ?></td>
				</tr>
			<?php
				}
			}
			if ( ! element('notice_list', element('list', $view)) && ! element('list', element('data', element('list', $view)))) {
			?>
				<tr>
					<td colspan="6" class="nopost"><?=$this->lang->line(10)?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>

	<div class="table-bottom mt20">
		<?php if (element('is_admin', $view)) { ?>
			
			
			
			<div class="pull-left">
				<div class="btn-admin-manage-layer admin-manage-layer-list">
					<?php if (element('is_admin', $view) === 'super') { ?>	
					<?php } ?>
				</div>
				<div class="item" onClick="post_multi_action('multi_delete', '0', '선택하신 글들을 완전삭제하시겠습니까?');"> 선택 삭제</div>
			</div>
		<?php } ?>
		<?php if (element('write_url', element('list', $view))) { ?>
			<div class="pull-right-write">
				<a href="<?php echo element('write_url', element('list', $view)); ?>" class="btn btn-success btn-sm">글쓰기</a>
			</div>
		<?php } ?>
	</div>
	<h3></h3>
	<nav><?php echo element('paging', element('list', $view)); ?></nav>
</div>

<?php echo element('footercontent', element('board', element('list', $view))); ?>

<?php
if (element('highlight_keyword', element('list', $view))) {
	$this->managelayout->add_js(base_url('assets/js/jquery.highlight.js')); ?>
<script type="text/javascript">
//<![CDATA[
$('#fboardlist').highlight([<?php echo element('highlight_keyword', element('list', $view));?>]);
//]]>
</script>
<?php } ?>
