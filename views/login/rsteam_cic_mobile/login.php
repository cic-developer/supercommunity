<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>





<!-- 임시 로그인 삭제예정 -->


<?php
if($this->input->ip_address() == '59.26.134.158'){
echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
$attributes = array('class' => 'form-horizontal', 'name' => 'flogin', 'id' => 'flogin');
echo form_open(current_full_url(), $attributes);
?>
	<!--불가촉천민 로그인-->
	<div class="rs_login" style=" display:block; position:absolute; left:0; top:100px; background:#ccc"> 
	<strong>불가촉 천민 로그인 입구---------</strong> <br/><!--모바일 마이페이지 확인을 위해 잠시 열어놓습니다.-->
	<input type="hidden" name="url" value="<?php echo html_escape($this->input->get_post('url')); ?>" />
	<ol class="loginform">
		<li>
			<span><?php echo element('userid_label_text', $view);?></span>
			<input type="text" name="mem_userid" class="input" value="<?php echo set_value('mem_userid'); ?>" accesskey="L" />
		</li>
		<li>
			<span>비밀번호</span>
			<input type="password" class="input" name="mem_password" />
		</li>
		<li>
			<span></span>
			<button type="submit" class="btn btn-primary btn-sm">로그인</button>
			<label for="autologin">
				<input type="checkbox" name="autologin" id="autologin" value="1" /> 자동로그인
			</label>
		</li>
	</ol>
	<div class="alert alert-dismissible alert-info autologinalert" style="display:none;">
		자동로그인 기능을 사용하시면, 브라우저를 닫더라도 로그인이 계속 유지될 수 있습니다. 자동로그이 기능을 사용할 경우 다음 접속부터는 로그인할 필요가 없습니다. 단, 공공장소에서 이용 시 개인정보가 유출될 수 있으니 꼭 로그아웃을 해주세요.
	</div>
</div>	
<?php 
	echo form_close(); 
} 
?>
<!--//불가촉천민 로그인-->



 <!--login_wrap-->
 <div id="login_wrap">
		<!--left-->
		<div class="left">
			<ul>
				<li>
					<p>SUPER<br>COMMUNITY</p>
				</li>
				<li>
					<b>LOGIN</b>
				</li>
			</ul>
		</div>
		<!--//left-->
		<!--right-->
		<div class="right">
<?php
if ($this->cbconfig->item('use_sociallogin')) {
	$this->managelayout->add_js(base_url('assets/js/social_login.js'));
?>
		<ul>
			<li>
				<?php if ($this->cbconfig->item('use_sociallogin_facebook')) {?>
					<a href="javascript:;" onClick="social_connect_on('facebook');" title="페이스북 로그인" class="facebook_lg">
						<img src="<?php echo base_url('assets/images/sns_face_book.png'); ?>" width="22" height="22" alt="페이스북 로그인" title="페이스북 로그인" />
						<strong>FACEBOOK LOGIN</strong>
					</a>
				<?php } ?>
			</li>
			<!-- <li>
				<a class="twitter_lg">
				<img src="assets/images/twt_logo.png" width="22" height="22" alt="트위터" title="트위터 로그인" />
					<strong>twitter LOGIN</strong>
				</a>
			</li> -->
			<!-- <li>
				<?php if ($this->cbconfig->item('use_sociallogin_twitter')) {?> 없음
					<a href="javascript:;" onClick="social_connect_on('twitter');" title="트위터 로그인"><img src="<?php echo base_url('assets/images/twt_logo.png'); ?>" width="22" height="22" alt="트위터 로그인" title="트위터 로그인" /></a>
				<?php } ?>
			</li> -->
			<li>
				<?php if ($this->cbconfig->item('use_sociallogin_google')) {?>
					<a href="javascript:;" onClick="social_connect_on('google');" title="구글 로그인" class="google_lg">
						<img src="<?php echo base_url('assets/images/glogo.png'); ?>" width="22" height="22" alt="구글 로그인" title="구글 로그인" />
						<strong>GOOGLE LOGIN</strong>
					</a>
				<?php } ?>
			</li>
			<li>
				<?php if ($this->cbconfig->item('use_sociallogin_naver')) {?>
					<a href="javascript:;" onClick="social_connect_on('naver');" title="네이버 로그인" class="naver_lg">
						<img src="<?php echo base_url('assets/images/naver_logo.png'); ?>" width="22" height="22" alt="네이버 로그인" title="네이버 로그인" />
						<strong>NAVER LOGIN</strong>
					</a>
				<?php } ?>
			</li>
			<li>
				<?php if ($this->cbconfig->item('use_sociallogin_kakao')) {?>
					<a href="javascript:;" onClick="social_connect_on('kakao');" title="카카오 로그인" class="kakao_lg">
						<img src="<?php echo base_url('assets/images/kakao_logo.png'); ?>" width="22" height="22" alt="카카오 로그인" title="카카오 로그인" />
						<strong>KAKAO LOGIN</strong>
					</a>
				<?php } ?>
			</li>
		</ul>
<?php } ?>

		</div>
		<!--//right-->
</div>
 <!--//login_wrap-->



 <script>
	function printAlert(alert_message, url_after_login){
		// alert(alert_message);
		// social_close();
		if(url_after_login){
			location.href = url_after_login
		}else{
			location.reload();
		}
	}
 </script>

