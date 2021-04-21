<head>

<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css" />
<?php echo $this->managelayout->display_css(); ?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
// 자바스크립트에서 사용하는 전역변수 선언
var cb_url = "<?php echo trim(site_url(), '/'); ?>";
var cb_cookie_domain = "<?php echo config_item('cookie_domain'); ?>";
var cb_charset = "<?php echo config_item('charset'); ?>";
var cb_time_ymd = "<?php echo cdate('Y-m-d'); ?>";
var cb_time_ymdhis = "<?php echo cdate('Y-m-d H:i:s'); ?>";
var layout_skin_path = "<?php echo element('layout_skin_path', $layout); ?>";
var view_skin_path = "<?php echo element('view_skin_path', $layout); ?>";
var is_member = "<?php echo $this->member->is_member() ? '1' : ''; ?>";
var is_admin = "<?php echo $this->member->is_admin(); ?>";
var cb_admin_url = <?php echo $this->member->is_admin() === 'super' ? 'cb_url + "/' . config_item('uri_segment_admin') . '"' : '""'; ?>;
var cb_board = "<?php echo isset($view) ? element('board_key', $view) : ''; ?>";
var cb_board_url = <?php echo ( isset($view) && element('board_key', $view)) ? 'cb_url + "/' . config_item('uri_segment_board') . '/' . element('board_key', $view) . '"' : '""'; ?>;
var cb_device_type = "<?php echo $this->cbconfig->get_device_type() === 'mobile' ? 'mobile' : 'desktop' ?>";
var cb_csrf_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
var cookie_prefix = "<?php echo config_item('cookie_prefix'); ?>";
var rs_lang = "<?php echo $this->session->userdata('lang'); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.extension.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/sideview.js?v=1'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/js.cookie.js'); ?>"></script>

<!-- 팝업레이어 시작 -->
<style type="text/css">
.popup_layer {position:absolute;border:1px solid #e9e9e9;background:#fff}
.popup_layer_footer {padding:10px 0;background:#000;color:#fff;text-align:right}
.popup_layer_footer button {margin-right:10px;padding:5px 10px;border:0;background:#4F4F4F;color:#FFFFFF}
</style>
</head>
<body>
<?php
	$result = $popup;
?>
	
	<div id="popup_layer_<?php echo element('pop_id', $result); ?>" class="popup_layer" style="top:<?php echo element('pop_top', $result); ?>px;left:<?php echo element('pop_left', $result); ?>px">
		<div class="popup_layer_con" style="width:<?php echo element('pop_width', $result); ?>px;height:<?php echo element('pop_height', $result); ?>px">
			<a href="<?php echo base_url('/post/74')?>" target="_blank">
			<?php echo element('pop_content', $result); ?>
			</a>
		</div>
		<div class="popup_layer_footer">
			<?php if (element('pop_disable_hours', $result)) { ?>
				<button class="popup_layer_reject" data-wrapper-id="popup_layer_<?php echo element('pop_id', $result); ?>" data-disable-hours="<?php echo element('pop_disable_hours', $result); ?>"><strong><?php echo element('pop_disable_hours', $result); ?></strong>시간 동안 열지 않기</button>
			<?php } ?>
			<button class="popup_layer_close" data-wrapper-id="popup_layer_<?php echo element('pop_id', $result); ?>">닫기</button>
		</div>
	</div>
		<?php
		if (element('pop_is_center', $result) === '1') {
		?>
		<script type="text/javascript">
		//<![CDATA[
		popup_center_left_<?php echo element('pop_id', $result); ?> = $(window).scrollLeft() + ($(window).width() - <?php echo element('pop_width', $result); ?>) / 2
		$('#popup_layer_<?php echo element('pop_id', $result); ?>').css('left', popup_center_left_<?php echo element('pop_id', $result); ?>);
		//]]>
		</script>
<?php
	}
?> 

<script type="text/javascript">
//<![CDATA[
$(function() {

	$(window).load(function() {
		var strWidth = $('#popup_layer_1').outerWidth() + (window.outerWidth - window.innerWidth);
		var strHeight = $('#popup_layer_1').outerHeight() + (window.outerHeight - window.innerHeight);
		//resize 
		window.resizeTo( strWidth, strHeight );
	});

	$(document).ready(function(){
		if(get_cookie('popup_layer_<?php echo element('pop_id', $result); ?>')){
			window.close();
		}
	});
	$(document).on('click', '.popup_layer_reject', function() {
		var cookie_name = $(this).attr('data-wrapper-id');
		var cookie_expire = $(this).attr('data-disable-hours');
		// $('#' + $(this).attr('data-wrapper-id')).hide();
		set_cookie(cookie_name, 1, cookie_expire, cb_cookie_domain);
		window.close();
	});
	$(document).on('click', '.popup_layer_close', function() {
		// $('#' + $(this).attr('data-wrapper-id')).hide();
		window.close();
	});
});
//]]>
</script>
<!-- 팝업레이어 끝 -->
</body>
