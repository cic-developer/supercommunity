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
/* html {
	overflow: hidden; 
	
}  */
.popup_layer {position:absolute; right:-10px; width: 580px; height:980px; margin-left:50px; background-image:url("/assets/images/popupbackground.png"); background-repeat : no-repeat;
        background-size : cover;  display: block; margin: 0px auto;}
.popup_layer_footer {padding:10px 0;background:#000;color:#fff;text-align:right}
.popup_layer_footer button {margin-right:10px;padding:5px 10px;border:0;background:#4F4F4F;color:#FFFFFF}
/* .popup_contents {width: 500px; height: 300px;} */
</style>
</head>
<body>

	<div id="popup_layer" class="popup_layer">
	<div class="popup_contents">
		<?php echo $mis_payment_policy ?>
	</div>
	</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$(window).load(function() {
		var strWidth = $('#popup_layer').outerWidth() + (window.outerWidth - window.innerWidth);
		var strHeight = $('#popup_layer').outerHeight() + (window.outerHeight - window.innerHeight);
		//resize 
		window.resizeTo( strWidth, strHeight );
	});
});
//]]>
</script>
<!-- 팝업레이어 끝 -->
</body>