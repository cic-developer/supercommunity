<?php
	//페이지별 언어팩 로드
	$this->lang->load('cic_layout', $this->session->userdata('lang'));
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php // 카카오톡 미리보기 이미지 변경을 위한 설정?>
<meta property="og:url" content="<?php echo $_SERVER["HTTP_HOST"] ?>">
<meta property="og:title" content="<?php echo html_escape(element('page_title', $layout)) ?>">
<meta property="og:type" content="website">
<meta property="og:image" content="https://www.percommunity.com/assets/images/preview.png">
<meta property="og:description" content="<?php echo html_escape(element('meta_description', $layout)); ?>">

<title><?php echo html_escape(element('page_title', $layout)); ?></title>
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/style.css" />
<!--RS 스타일-->
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/reset.css" />
<!-- <link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/rs_style.css" /> -->
<!--google fonts-->
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet" type="text/css">
<!--fontawesome-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--툴팁-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/tooltip.css'); ?>" />
<!--제이쿼리 레이어 팝업-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/lightlayer.min.css'); ?>" />
<!-- //커스텀 CSS 끝 -->

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
<script type="text/javascript" src="<?php echo base_url('assets/js/sideview.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/js.cookie.js'); ?>"></script>

<!-- 커스텀 자바스크립트 시작 -->
<?php /*
	JS src 사용방법 : <?php echo base_url('assets/js/common.js'); ?>
	JS 실질 경로 : /assats/js/commons.js
*/ ?>
<!--파비콘-->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.ico');?>">
<!--유튜브 동영상 백그라운드-->
<script type="text/javascript" src="<?php echo base_url('assets/js/YTPlayer/jquery.mb.YTPlayer.min.js'); ?>"></script>
<link href="/assets/js/YTPlayer/css/jquery.mb.YTPlayer.min.css" rel="stylesheet" />
<!--숫자 스크롤-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.numscroll.js'); ?>"></script>
<!--한줄 가입뉴스-->
<script type="text/javascript" src="<?php echo base_url('assets/js/acmeticker.js'); ?>"></script>
<!--툴팁-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.tooltip.js'); ?>"></script>
<!--제이쿼리레이어 팝업-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.lightlayer.min.js'); ?>"></script>
<!--제이쿼리카운트다운 타이머-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.simple.timer.js'); ?>"></script>
<!-- 커스텀 자바스크립트 끝 -->
<?php echo $this->managelayout->display_js(); ?>
</head>
<body <?php echo isset($view) ? element('body_script', $view) : ''; ?>>
<!--wrap-->
<div id="wrap">
	<div id="quick_area">
		<a href="https://pf.kakao.com/_ZExaRK" target="_blank" class="kakao_qa"><img src="<?php echo base_url('assets/images/kakao_icon.png');?>" alt="카카오톡 상담"/></a>
		<div style="cursor:pointer;" onclick="window.scrollTo(0,0);" class="top"><i class="far fa-arrow-alt-circle-up"></i><br/><?=$this->lang->line('cic_0')?></div>
	</div>
	<!--header-->
	<div id="header">
		<nav>
			<h1><a href="<?=base_url()?>"><img src="<?php echo base_url('assets/images/logo.png');?>" alt="슈퍼커뮤니티"></a></h1>
			<!--menu-->
			<ul id="menu">  
				<li><a href="<?=base_url('About/whitepaper')?>" class="<?=element('menu',$header) == 'about' ? 'on' : '';?>"><?=$this->lang->line('cic_1')?></a></li> <!--해당메뉴 진입시 class="on"-->
				<li><a href="<?=base_url('Mission')?>" class="<?=element('menu',$header) == 'pershouting' ? 'on' : '';?>"><?=$this->lang->line('cic_2')?></a></li>
				<!-- <li><a href="<?php //echo base_url('About/whitepaper')?>" class="<?php //echo element('menu',$header) == 'whitepaper' ? 'on' : '';?>"><?php //echo $this->lang->line('cic_3')?></a></li> -->
				<li><a href="<?=base_url('board/noti')?>" class="<?=element('menu',$header) == 'noti' ? 'on' : '';?>"><?=$this->lang->line('cic_3')?></a></li>
				<li><a href="<?=base_url('Research')?>" class="<?=element('menu',$header) == 'inquiry' ? 'on' : '';?>"><?=$this->lang->line('cic_4')?></a></li>
			</ul>
			<!--//menu-->
			<div class="box">
				<div class="mypage">
					<a href="<?=base_url('mypage')?>"><?=$this->lang->line('cic_5')?></a> <!--비로그인시 안보여야함-->
				</div>
				<div class="logout">
				<a href="<?= $this->member->is_member()? site_url('login/logout?url=' . urlencode(current_full_url())) : site_url('login?url=' . urlencode(current_full_url()))  ?>"><?php echo $this->member->is_member()? $this->lang->line('cic_6') : $this->lang->line('cic_7') ?></a> <!--LOGIN / LOGOUT-->
				</div>
			</div>
			<!--쪽지 알림벨 추가-->
<?php if ($this->member->is_member() && $this->cbconfig->item('use_notification')) { ?>
			<div class="note_alram">
				<a href="javascript:;" onClick="note_list();">
					<small style="display:block;"><?php echo $this->Note_model->get_unread_recv_note_num($this->member->is_member())?></small> <!--새쪽지 숫자 또는 new-->
					<i class="fas fa-bell"></i>
				</a>	
			</div>
<?php }?>
			<!--//쪽지 알림벨 추가-->
			<ul class="lang">
				<li><a href="?lang=korean" <?=$this->session->userdata('lang') == 'korean' ? 'class="on"' : ''?>> <?=$this->lang->line('cic_8')?>  </a></li>
				<li><a href="?lang=english" <?=$this->session->userdata('lang') == 'english' ? 'class="on"' : ''?>> <?=$this->lang->line('cic_9')?></a></li>
			</ul>
		</nav>
		
		<!-- 알림 div 시작 -->
		<?php
			if ($this->member->is_member() && $this->cbconfig->item('use_notification') && (int)element('notification_num', $layout)) {
		?>
			<!-- <div class="notifications">
				쪽지가 도착했습니다!
				div 클릭시 쪽지 새창
			</div> -->
		<?php
			}
		?>
		<!-- 알림 div 끝 -->

	</div>
	<!--//header-->

<!--서브메뉴 분리하기 위해 코드 추가하였습니다 이 아래로 php 본문 시작부분이 시작하는데까지가 서브메뉴 입니다. -->
<?php 
	switch(element('menu',$header)){ 
		case 'mypage' :
?>
			<div id="sub_menu">
				<ul> 
					<li><a href="<?=base_url('mypage')?>" <?php echo (strpos(uri_string(),'mypage') !== false && strpos(uri_string(),'mypage/withdraw') === false ) ? 'class="on"': ''?>><?=$this->lang->line('cic_10')?></a></li>
					<li><a href="<?=base_url('Media/mymedia')?>" <?php echo (strpos(uri_string(),'Media/mymedia') !== false) ? 'class="on"': ''?> ><?=$this->lang->line('cic_11')?></a></li>
					<li><a href="<?=base_url('Mission/myMission')?>" <?php echo (strpos(uri_string(),'Mission/myMission') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_12')?></a></li>
					<li><a href="<?=base_url('mypage/withdraw')?>" <?php echo (strpos(uri_string(),'mypage/withdraw') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_13')?></a></li>
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
					<li><a href="<?=base_url('/board/wallet_noti')?>" <?php echo (strpos(uri_string(),'/wallet_noti') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_29')?></a></li>
				</ul>
			</div>
<?php 
		break;

		case 'inquiry' :
?>
			<div id="sub_menu">
				<ul> 
					<li><a href="<?php echo base_url('Research')?>" class="on"><?php echo $this->lang->line('cic_16')?></a></li>
					<!-- <li><a href="<?php //echo base_url('Inquiry/ad_inquiry')?>" <?php // echo (strpos(uri_string(),'Inquiry/ad_inquiry') !== false) ? 'class="on"': ''?>><?php //echo $this->lang->line('cic_16')?></a></li> -->
					<!-- <li><a href="<?php //echo base_url('Inquiry/ad_consulting_inquiry')?>" <?php //echo (strpos(uri_string(),'Inquiry/ad_consulting_inquiry') !== false) ? 'class="on"': ''?>><?php //echo $this->lang->line('cic_17')?></a></li> -->
				</ul>
			</div>
<?php
		break;
		case 'about' :
?>
			<div id="sub_menu">
				<ul> 
					<!-- <li><a href="<?php //echo base_url('About/provision')?>" <?php //echo (strpos(uri_string(),'About/provision') !== false) ? 'class="on"': ''?>><?php //echo $this->lang->line('cic_18')?></a></li> -->
					<!-- <li><a href="<?php //echo base_url('About/status')?>" <?php //echo (strpos(uri_string(),'About/status') !== false) ? 'class="on"': ''?>><?php // echo $this->lang->line('cic_19')?></a></li> -->
					<li><a href="<?=base_url('About/whitepaper')?>" <?php echo (strpos(uri_string(),'About/whitepaper') !== false) ? 'class="on"': ''?>><?=$this->lang->line('cic_20')?></a></li>
				</ul>
			</div>
<?php 
		break;
	}
?>
<!--서브메뉴 끝!!! 입니다. -->
	<!--content-->
	<div id="content">
		<!-- 본문 시작(Contents) -->
		<?php if (isset($yield))echo $yield; ?>
		<!-- 본문 끝(Contents) -->
	</div>
	<!--//content-->

	<!--footer-->
	<div id="footer">
		<!--footer_wrap-->
		<div id="footer_wrap"> 
				<div class="footer_left">
					<ul class="left_top">
						<li><a href="<?=base_url('Terms/provision')?>"><?=$this->lang->line('cic_21')?></a></li>
						<li><a href="<?=base_url('Terms/privacy')?>"><?=$this->lang->line('cic_22')?></a></li>
					</ul>
					<?=$this->lang->line('cic_23')?>  
				</div>
				<div class="footer_right">
					<img src="<?php echo base_url('assets/images/perperman.png');?>" style="float: left;" alt="<?=$this->lang->line('cic_24')?>"/>
					<dl class="bt_all">
						<dt><?=$this->lang->line('cic_25')?></dt>
						<dd>
							<a href="void(0);" onclick="alert('<?=$this->lang->line('cic_26')?>');return false;" > <img src="<?php echo base_url('assets/images/google.png');?>" alt="<?=$this->lang->line('cic_27')?>"/> </a>
						</dd>
						<dd>
							<a href="void(0);" onclick="alert('<?=$this->lang->line('cic_26')?>');return false;" ><img src="<?php echo base_url('assets/images/apple.png');?>" alt="<?=$this->lang->line('cic_28')?>" /></a>
						</dd>
					</dl>                        
				</div>                   
		</div>
		<!--//footer_wrap-->
	</div>
	<!--//footer-->
	<?php echo element('popup', $layout); ?>
	<?php echo $this->cbconfig->item('footer_script'); ?>
</div>
<!--//wrap-->

</body>
</html>


<script type="text/javascript">
	 // 스크롤시 transform 네비 clsaa 추가
	$(window).scroll(function() {
		var position = $(window).scrollTop();
		if(position >= 85) {
			$('#header').addClass('trans_nav');	
		} else {
			$('#header').removeClass('trans_nav');
		}   
	});
	
	$(window).scroll(function() {
		var position = $(window).scrollTop();
		if(position >= 85) {
			$('#sub_menu').addClass('sub_fixed');
			/*$('#sub_visual').css('height','382px');
			$('#sub_cont').css('padding-top','120px');*/
		} else {
			$('#sub_menu').removeClass('sub_fixed');
			
		} 
	});
</script>