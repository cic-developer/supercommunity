<?php
	//페이지별 언어팩 로드
	$this->lang->load('cic_board_post', $this->session->userdata('lang'));
?>
<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php	$this->managelayout->add_js(base_url('plugin/zeroclipboard/ZeroClipboard.js')); ?>

<?php
if (element('syntax_highlighter', element('board', $view)) OR element('comment_syntax_highlighter', element('board', $view))) {
	$this->managelayout->add_css(base_url('assets/js/syntaxhighlighter/styles/shCore.css'));
	$this->managelayout->add_css(base_url('assets/js/syntaxhighlighter/styles/shThemeMidnight.css'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shCore.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushJScript.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushPhp.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushCss.js'));
	$this->managelayout->add_js(base_url('assets/js/syntaxhighlighter/scripts/shBrushXml.js'));
?>
	<script type="text/javascript">
	SyntaxHighlighter.config.clipboardSwf = '<?php echo base_url('assets/js/syntaxhighlighter/scripts/clipboard.swf'); ?>';
	var is_SyntaxHighlighter = true;
	SyntaxHighlighter.all();
	</script>
<?php } ?>

<?php echo element('headercontent', element('board', $view)); ?>
	<div id="board_wrap">
			<h5><?=$this->lang->line(0)?></h5>
		<div class="board">
			<?php echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>'); ?>
			<h3>
				<?php if (element('category', element('post', $view))) { ?>[<?php echo html_escape(element('bca_value', element('category', element('post', $view)))); ?>] <?php } ?>
				<?php echo html_escape(element('post_title', element('post', $view))); ?>
			</h3>
			<ul class="information mb20">
				<li><?php echo element('display_name', element('post', $view)); ?></li>
				
				
				<?php if (element('use_post_like', element('board', $view))) { ?>
					<li><i class="fa fa-thumbs-up"></i> <span class="post-like"><?php echo number_format(element('post_like', element('post', $view))); ?></span></li>
				<?php } ?>
				<?php	if (element('use_post_dislike', element('board', $view))) { ?>
					<li><i class="fa fa-thumbs-down"></i> <span class="post-dislike"><?php echo number_format(element('post_dislike', element('post', $view))); ?></span></li>
				<?php	} ?>
				<?php if (element('use_print', element('board', $view))) { ?>
					<li><a href="javascript:;" id="btn-print" onClick="post_print('<?php echo element('post_id', element('post', $view)); ?>', 'post-print');" title="이 글을 프린트하기"><i class="fa fa-print"></i> <span class="post-print">Print</span></a></li>
				<?php } ?>
				
				<?php if (element('show_url_qrcode', element('board', $view))) { ?>
					<li class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('short_url', $view)); ?>"><i class="fa fa-qrcode"></i></li>
				<?php } ?>
				<li class="pull-right time"><i class="fa fa-clock-o"></i> <?php echo element('display_datetime', element('post', $view)); ?></li>
				<?php if (element('display_ip', element('post', $view))) { ?>
					<li class="pull-right time"><i class="fa fa-map-marker"></i> <?php echo element('display_ip', element('post', $view)); ?></li>
				<?php } ?>
				<?php if (element('is_mobile', element('post', $view))) { ?>
					<li class="pull-right time"><i class="fa fa-wifi"></i></li>
				<?php } ?>
			</ul>
			<?php if (element('link_count', $view) > 0 OR element('file_download_count', $view) > 0) { ?>
				<div class="table-box">
					<table class="table-body">
						<tbody>
						<?php
						if (element('file_download_count', $view) > 0) {
							foreach (element('file_download', $view) as $key => $value) {
						?>
							<tr>
								<td><i class="fa fa-download"></i> <a href="javascript:file_download('<?php echo element('download_link', $value); ?>')"><?php echo html_escape(element('pfi_originname', $value)); ?>(<?php echo byte_format(element('pfi_filesize', $value)); ?>)</a> <span class="time"><i class="fa fa-clock-o"></i> <?php echo display_datetime(element('pfi_datetime', $value), 'full'); ?></span></td>
							</tr>
						<?php
							}
						}
						if (element('link_count', $view) > 0) {
							foreach (element('link', $view) as $key => $value) {
						?>
							<tr>
								<td><i class="fa fa-link"></i> <a href="<?php echo element('link_link', $value); ?>" target="_blank"><?php echo html_escape(element('pln_url', $value)); ?></a>
									<?php if (element('show_url_qrcode', element('board', $view))) { ?>
										<span class="url-qrcode" data-qrcode-url="<?php echo urlencode(element('pln_url', $value)); ?>"><i class="fa fa-qrcode"></i></span>
									<?php } ?>
								</td>
							</tr>
						<?php
							}
						}
						?>
						</tbody>
					</table>
				</div>
			<?php } ?>

			<script type="text/javascript">
			//<![CDATA[
			function file_download(link) {
				<?php if (element('point_filedownload', element('board', $view)) < 0) { ?>if ( ! confirm("파일을 다운로드 하시면 포인트가 차감(<?php echo number_format(element('point_filedownload', element('board', $view))); ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?")) { return; }<?php }?>
				document.location.href = link;
			}
			//]]>
			</script>

			<?php if (element('extra_content', $view)) { ?>
				<div class="table-box">
					<table class="table-body">
						<tbody>
							<?php foreach (element('extra_content', $view) as $key => $value) { ?>
								<tr>
									<th class="px150"><?php echo html_escape(element('display_name', $value)); ?></th>
									<td><?php echo nl2br(html_escape(element('output', $value))); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			<?php } ?>
			<div class="contents-view">
				<div class="contents-view-img">
					
				<?php
				if (element('file_image', $view)) {
					foreach (element('file_image', $view) as $key => $value) {
				?>
					<img src="<?php echo element('thumb_image_url', $value); ?>" alt="<?php echo html_escape(element('pfi_originname', $value)); ?>" title="<?php echo html_escape(element('pfi_originname', $value)); ?>" class="view_full_image" data-origin-image-url="<?php echo element('origin_image_url', $value); ?>" style="max-width:100%;" />
				<?php
					}
				}
				?>
				</div>

				<!-- 본문 내용 시작 -->
				<div id="post-content"><?php echo element('content', element('post', $view)); ?>
					
				</div>
				<!-- 본문 내용 끝 -->
			</div>

			<?php if ( ! element('post_del', element('post', $view)) && (element('use_post_like', element('board', $view)) OR element('use_post_dislike', element('board', $view)))) { ?>
				<div class="recommand">
					<?php if (element('use_post_like', element('board', $view))) { ?>
						<a class="good" href="javascript:;" id="btn-post-like" onClick="post_like('<?php echo element('post_id', element('post', $view)); ?>', '1', 'post-like');" title="추천하기"><span class="post-like"><?php echo number_format(element('post_like', element('post', $view))); ?></span><br /><i class="fa fa-thumbs-o-up fa-lg"></i></a>
					<?php } ?>
					<?php if (element('use_post_dislike', element('board', $view))) { ?>
						<a class="bad" href="javascript:;" id="btn-post-dislike" onClick="post_like('<?php echo element('post_id', element('post', $view)); ?>', '2', 'post-dislike');" title="비추하기"><span class="post-dislike"><?php echo number_format(element('post_dislike', element('post', $view))); ?></span><br /><i class="fa fa-thumbs-o-down fa-lg"></i></a>
					<?php } ?>
				</div>
			<?php } ?>
		

			<?php
			if (element('use_sns_button', $view)) {
				$this->managelayout->add_js(base_url('assets/js/sns.js'));

				if ($this->cbconfig->item('kakao_apikey')) {
					$this->managelayout->add_js('https://developers.kakao.com/sdk/js/kakao.min.js');
			?>
				<script type="text/javascript">Kakao.init('<?php echo $this->cbconfig->item('kakao_apikey'); ?>');</script>
				<?php } ?>
				<div class="sns_button">
					<a href="javascript:;" onClick="sendSns('facebook', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(element('post_title', element('post', $view)));?>');" title="이 글을 페이스북으로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_facebook.png" width="22" height="22" alt="이 글을 페이스북으로 퍼가기" title="이 글을 페이스북으로 퍼가기" /></a>
					<a href="javascript:;" onClick="sendSns('twitter', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(element('post_title', element('post', $view)));?>');" title="이 글을 트위터로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_twitter.png" width="22" height="22" alt="이 글을 트위터로 퍼가기" title="이 글을 트위터로 퍼가기" /></a>
					<?php if ($this->cbconfig->item('kakao_apikey')) { ?>
						<a href="javascript:;" onClick="kakaolink_send('<?php echo html_escape(element('post_title', element('post', $view)));?>', '<?php echo element('short_url', $view); ?>');" title="이 글을 카카오톡으로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_kakaotalk.png" width="22" height="22" alt="이 글을 카카오톡으로 퍼가기" title="이 글을 카카오톡으로 퍼가기" /></a>
					<?php } ?>
					<a href="javascript:;" onClick="sendSns('kakaostory', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(element('post_title', element('post', $view)));?>');" title="이 글을 카카오스토리로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_kakaostory.png" width="22" height="22" alt="이 글을 카카오스토리로 퍼가기" title="이 글을 카카오스토리로 퍼가기" /></a>
					<a href="javascript:;" onClick="sendSns('band', '<?php echo element('short_url', $view); ?>', '<?php echo html_escape(element('post_title', element('post', $view)));?>');" title="이 글을 밴드로 퍼가기"><img src="<?php echo element('view_skin_url', $layout); ?>/images/social_band.png" width="22" height="22" alt="이 글을 밴드로 퍼가기" title="이 글을 밴드로 퍼가기" /></a>
				</div>
			<?php } ?>

		

			<div class="border_button mt20 mb20">
				<div class="btn-group pull-left" role="group" aria-label="...">
					<?php if (element('modify_url', $view)) { ?>
						<a href="<?php echo element('modify_url', $view); ?>" class="btn btn-default btn-sm">수정</a>
					<?php } ?>
					<?php	if (element('delete_url', $view)) { ?>
						<button type="button" class="btn btn-default btn-sm btn-one-delete" data-one-delete-url="<?php echo element('delete_url', $view); ?>">삭제</button>
					<?php } ?>
					<a href="<?php echo element('list_url', $view); ?>" class="btn btn-default btn-sm"><?=$this->lang->line(1)?></a>
					<?php if (element('search_list_url', $view)) { ?>
						<a href="<?php echo element('search_list_url', $view); ?>" class="btn btn-default btn-sm"><?=$this->lang->line(2)?></a>
					<?php } ?>
					
					<?php if (element('prev_post', $view)) { ?>
						<a href="<?php echo element('url', element('prev_post', $view)); ?>" class="btn btn-default btn-sm"><?=$this->lang->line(3)?></a>
					<?php } ?>
					<?php if (element('next_post', $view)) { ?>
						<a href="<?php echo element('url', element('next_post', $view)); ?>" class="btn btn-default btn-sm"><?=$this->lang->line(4)?></a>
					<?php } ?>
				</div>
				<?php if (element('write_url', $view)) { ?>
					<div class="pull-right">
						<a href="<?php echo element('write_url', $view); ?>" class="btn btn-success btn-sm">글쓰기</a>
					</div>
				<?php } ?>
			</div>
		</div>

		<?php echo element('footercontent', element('board', $view)); ?>

		<?php if (element('target_blank', element('board', $view))) { ?>
		<script type="text/javascript">
		//<![CDATA[
		$(document).ready(function() {
			$("#post-content a[href^='http']").attr('target', '_blank');
		});
		//]]>
		</script>
		<?php } ?>

		<script type="text/javascript">
		//<![CDATA[
		var client = new ZeroClipboard($('.copy_post_url'));
		client.on('ready', function(readyEvent) {
			client.on('aftercopy', function(event) {
				alert('게시글 주소가 복사되었습니다. \'Ctrl+V\'를 눌러 붙여넣기 해주세요.');
			});
		});
		//]]>
		</script>
		<?php
		if (element('highlight_keyword', $view)) {
			$this->managelayout->add_js(base_url('assets/js/jquery.highlight.js'));
		?>
			<script type="text/javascript">
			//<![CDATA[
			$('#post-content').highlight([<?php echo element('highlight_keyword', $view);?>]);
			//]]>
			</script>
		<?php } ?>
	</div>
