<?php
	//페이지별 언어팩 로드
	$this->lang->load('cic_layout_mobile', $this->session->userdata('lang'));
?>
<!DOCTYPE html> <!--mobile layout-->
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo html_escape(element('page_title', $layout)); ?></title>
<meta property="og:image" content="<?php echo element('favicon', $layout); ?>" />
<?php if (element('meta_description', $layout)) { ?><meta name="description" content="<?php echo html_escape(element('meta_description', $layout)); ?>"><?php } ?>
<?php if (element('meta_keywords', $layout)) { ?><meta name="keywords" content="<?php echo html_escape(element('meta_keywords', $layout)); ?>"><?php } ?>
<?php if (element('meta_author', $layout)) { ?><meta name="author" content="<?php echo html_escape(element('meta_author', $layout)); ?>"><?php } ?>
<?php if (element('favicon', $layout)) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo element('favicon', $layout); ?>" /><?php } ?>
<?php if (element('canonical', $view)) { ?><link rel="canonical" href="<?php echo element('canonical', $view); ?>" /><?php } ?>

<!-- 커스텀 CSS 시작 -->
<?php /*
	CSS href 사용방법 : <?php echo element('layout_skin_url', $layout); ?>/css/style.css
	CSS href 실질경로 : /views/_layout/example_main/css/style.css
*/ ?>
<!--RS css-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/m_common.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/reset.css" />
<!--google fonts-->
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,900&display=swap" rel="stylesheet">
<!--fontawesome-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--툴팁-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/tooltip.css'); ?>" />
<!--제이쿼리 레이어 팝업-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/lightlayer.min.css'); ?>" />
<!--프로그레스바-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/progress.css'); ?>" />
<!-- 커스텀 CSS 끝 -->

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
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo base_url('assets/js/html5shiv.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.extension.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/sideview.js?v=1'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/js.cookie.js'); ?>"></script>

<!-- 커스텀 자바스크립트 시작 -->
<?php /*
	JS src 사용방법 : <?php echo base_url('assets/js/common.js'); ?>
	JS 실질 경로 : /assats/js/commons.js
*/ ?>
<!--모바일 right menu-->
<script type="text/javascript" src="<?php echo base_url('assets/js/sidebar-menu.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.contenttoggle.js'); ?>"></script>
<!--숫자 스크롤-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.numscroll.js'); ?>"></script>
<!--한줄 가입뉴스-->
<script type="text/javascript" src="<?php echo base_url('assets/js/acmeticker.js'); ?>"></script>
<!--툴팁-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.tooltip.js'); ?>"></script>
<!--제이쿼리레이어 팝업 (20/09/09 얘 못불러온데용 <-- 그게무슨말이져 )-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.lightlayer.min.js'); ?>"></script>
<!--로딩 프로그레스바-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.progressBarTimer.min.js'); ?>"></script>
<!--제이쿼리카운트다운 타이머-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.simple.timer.js'); ?>"></script>
<!-- 커스텀 자바스크립트 끝 -->

<?php echo $this->managelayout->display_js(); ?>
</head>
<body <?php echo isset($view) ? element('body_script', $view) : ''; ?>>
<!--wrap-->
<div id="wrap">
	<!--Mobile toogle right menu-->
	<div id="rightmenu" class="menu js-contentToggle__content">
			<!--right_menu_top-->
			<div class="right_menu_top">
				<div class="log_area">
					<a href="<?=base_url('mypage')?>" class="top_btn1"><?=$this->lang->line('cic_0')?></a> <!--비로그인시 안보임-->
					<a class="top_btn2" href="<?= $this->member->is_member()? site_url('login/logout?url=' . urlencode(current_full_url())) : site_url('login?url=' . urlencode(current_full_url()))  ?>"><?php echo $this->member->is_member()? $this->lang->line('cic_1') : $this->lang->line('cic_2') ?></a> <!--LOGIN / LOGOUT-->
				</div>
				<!--menu close-->
				<button class="burger js-contentToggle__trigger" type="button" id="menu_off">
					<i class="fa fa-times-circle" aria-hidden="true"></i>
				</button>
				<!--//menu close-->
			</div>
			<!--right_menu_top-->
			<nav>
				<!--메뉴-->
				<ul class="sidebar-menu">
					<li>
						<a href="#">
							<span><?php echo $this->lang->line('cic_29')?></span><i class="fa fa-arrow-down pull-right" aria-hidden="true"></i>
						</a>
						<ul class="sidebar-submenu" style="display: none;">
							<li><a href="<?=base_url('About/provision')?>"><?php echo $this->lang->line('cic_18')?> <i class="fa fa-angle-right pull-right"></i></a></li>
							<!-- <li><a href="<?php //echo base_url('About/status')?>"><?php //echo $this->lang->line('cic_19')?> <i class="fa fa-angle-right pull-right"></i></a></li> -->
							<li><a href="<?=base_url('About/whitepaper')?>"><?php echo $this->lang->line('cic_20')?> <i class="fa fa-angle-right pull-right"></i></a></li>
						</ul>
					</li>
					<li>
						<a href="<?=base_url('Mission')?>">
							<span><?php echo $this->lang->line('cic_14')?></span><i class="fa fa-arrow-down pull-right" aria-hidden="true"></i>
						</a>
					</li>
					<li>
						<a href="<?=base_url('/board/noti')?>">
							<span><?php echo $this->lang->line('cic_3')?></span><i class="fa fa-arrow-down pull-right" aria-hidden="true"></i>
						</a>
					</li>
					<li>
						<a href="#">
							<span><?php echo $this->lang->line('cic_4')?></span><i class="fa fa-arrow-down pull-right" aria-hidden="true"></i>
						</a>
						<ul class="sidebar-submenu" style="display: none;">
							<li><a href="<?=base_url('Inquiry/ad_inquiry')?>"><?php echo $this->lang->line('cic_16')?><i class="fa fa-angle-right pull-right"></i></a></li>
							<li><a href="<?=base_url('Inquiry/ad_consulting_inquiry')?>"><?php echo $this->lang->line('cic_17')?><i class="fa fa-angle-right pull-right"></i></a></li>
						</ul>
					</li>
				</ul>
				<!--//메뉴-->
			</nav>
			<div class="btm_box">
				<div class="lang">
					<a href="?lang=korean" <?=$this->session->userdata('lang') == 'korean' ? 'class="on"' : ''?>> <?=$this->lang->line('cic_8')?>  </a>
					<a href="?lang=english" <?=$this->session->userdata('lang') == 'english' ? 'class="on"' : ''?>> <?=$this->lang->line('cic_9')?></a>
				</div>
				<div class="quick_area">
					<a href="https://pf.kakao.com/_ZExaRK" target="_blank" class="kakao_qa"><img src="<?php echo base_url('assets/images/kakao_icon.png');?>" alt="카카오톡 상담"/></a>
					
				</div>
		</div>
	</div>
	<!--//Mobile toogle right menu-->

	<!--header-->
	<div id="header">
		<h1><a href="<?=base_url()?>"><img src="<?php echo base_url('assets/images/logo.png');?>" alt="슈퍼커뮤니티"></a></h1>
			<!--쪽지 알림벨 로그인시-->
		<div class="hd_right">
<?php if ($this->member->is_member() && $this->cbconfig->item('use_notification')) { ?>
			<div class="note_alram">
				<a href="javascript:;" onClick="note_list();">
					<small style="display:block;"><?php echo $this->Note_model->get_unread_recv_note_num($this->member->is_member())?></small></small> <!--새쪽지 숫자 또는 new-->
					<i class="fas fa-bell"></i>
				</a>	
			</div>
<?php }?>
			<!--쪽지 알림벨 로그인시-->
			<button class="burger js-contentToggle__trigger" type="button" id="menu_on" tabindex="0" aria-controls="leftMenu" aria-expanded="false">
				<i class="fa fa-bars" aria-hidden="true"></i>
			</button>
		</div>
		<nav>
			
		</nav>
	</div>	
	<!--//header-->
<?php 
switch(element('menu',$header)){ 
	case 'mypage' :
?>
	<div id="sub_menu">
		<ul> 
			<li><a href="<?=base_url('mypage')?>" <?php echo (strpos(uri_string(),'mypage') !== false && strpos(uri_string(),'mypage/superpoint') === false ) ? 'class="on"': ''?>><?=$this->lang->line('cic_10')?></a></li>
			<li><a href="<?=base_url('Media/mymedia')?>" <?php echo (strpos(uri_string(),'Media/mymedia') !== false) ? 'class="on"': ''?> ><?=$this->lang->line('cic_11')?></a></li>
			<li><a href="<?=base_url('Mission/myMission')?>" <?php echo (strpos(uri_string(),'Mission/myMission') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_12')?></a></li>
			<li><a href="<?=base_url('mypage/superpoint')?>" <?php echo (strpos(uri_string(),'mypage/superpoint') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_13')?></a></li>
		</ul>
	</div>
<?php 
	break;

	case 'pershouting' : 
?>
	<div id="sub_menu">
		<ul> 
			<li><a href="<?=base_url('/Mission')?>" class="on"><?=$this->lang->line('cic_14')?></a></li> <!--단일메뉴-->
		</ul>
	</div>
<?php 
	break;

	case 'noti' :
?> 
	<div id="sub_menu">
		<ul> 
			<li><a href="<?=base_url('/board/noti')?>" <?php echo (strpos(uri_string(),'/noti') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_15')?></a></li>
			<li><a href="<?=base_url('/board/wallet_noti')?>" <?php echo (strpos(uri_string(),'/wallet_noti') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_30')?></a></li>
		</ul>
	</div>
<?php 
	break;

	case 'inquiry' :
?>
	<div id="sub_menu">
		<ul> 
			<li><a href="<?=base_url('Inquiry/ad_inquiry')?>" <?php echo (strpos(uri_string(),'Inquiry/ad_inquiry') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_16')?></a></li>
			<li><a href="<?=base_url('Inquiry/ad_consulting_inquiry')?>" <?php echo (strpos(uri_string(),'Inquiry/ad_consulting_inquiry') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_17')?></a></li>
		</ul>
	</div>
<?php
	break;
	case 'about' :
?>
	<div id="sub_menu">
		<ul> 
			<li><a href="<?=base_url('About/provision')?>" <?php echo (strpos(uri_string(),'About/provision') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_18')?></a></li>
			<!-- <li><a href="<?php //echo base_url('About/status')?>" <?php //echo (strpos(uri_string(),'About/status') !== false) ? 'class="on"': ''?>><?php //echo $this->lang->line('cic_19')?></a></li> -->
			<li><a href="<?=base_url('About/whitepaper')?>" <?php echo (strpos(uri_string(),'About/whitepaper') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_20')?></a></li>
		</ul>
	</div>
<?php 
	break;
}
?>

	<!-- 본문 시작(Contents) -->
	<div id="content">
		<?php if (isset($yield))echo $yield; ?>
	</div>	
	<!-- 본문 끝(Contents) -->

	<!--footer-->
	<div id="footer">
		<!--footer_wrap-->
			<div class="footer_top">
				<img src="<?php echo base_url('assets/images/perperman.png');?>" alt="<?php echo $this->lang->line('cic_24')?>"/>
				<dl class="bt_all">
					<dt><?php echo $this->lang->line('cic_25')?></dt>
					<dd>
						<a href="void(0);" onclick="alert('<?php echo $this->lang->line('cic_26')?>');return false;" > <img src="<?php echo base_url('assets/images/google.png');?>" alt="<?php echo $this->lang->line('cic_27')?>"/> </a>
					</dd>
					<dd>
						<a href="void(0);" onclick="alert('<?php echo $this->lang->line('cic_26')?>');return false;" ><img src="<?php echo base_url('assets/images/apple.png');?>" alt="<?php echo $this->lang->line('cic_28')?>" /></a>
					</dd>
				</dl>          
			</div>
			<div class="footer_bottom">
				<ul class="left_top">
					<li><a href="<?=base_url('Terms/provision')?>"><?php echo $this->lang->line('cic_21')?></a></li>
					<li><a href="<?=base_url('Terms/privacy')?>"><?php echo $this->lang->line('cic_22')?></a></li>
					<li><a href="void(0);" onclick="window.scrollTo(0,0);return false;">TOP</a></li>
				</ul>
				Copyright © Super Community.  All rights reserved.    
			</div>              
	</div>	
<!--//footer-->
<?php echo element('popup', $layout); ?>
<?php echo $this->cbconfig->item('footer_script'); ?>


</div>	
<!--//wrap-->
</body>
</html>

<script type="text/javascript">
$.sidebarMenu($('.sidebar-menu'))

$( "body" ).contentToggle( {
  defaultState: "close",
  globalClose: true,
  toggleProperties: []
} );

</script>