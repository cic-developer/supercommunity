<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $wallet_text = html_escape($this->member->item('mem_email'))? '지갑주소 수정' : '지갑주소 입력' ?>

<div class="mypage">
	<ul class="nav nav-tabs">
		<li class="active"><a href="<?php echo site_url('mypage'); ?>" title="마이페이지">마이페이지</a></li>
		<li><a href="<?php echo site_url('mypage/post'); ?>" title="나의 작성글">나의 작성글</a></li>
		<?php if ($this->cbconfig->item('use_point')) { ?>
			<li><a href="<?php echo site_url('mypage/point'); ?>" title="포인트">포인트</a></li>
		<?php } ?>
		<li><a href="<?php echo site_url('mypage/followinglist'); ?>" title="팔로우">팔로우</a></li>
		<li><a href="<?php echo site_url('mypage/like_post'); ?>" title="내가 추천한 글">추천</a></li>
		<li><a href="<?php echo site_url('mypage/scrap'); ?>" title="나의 스크랩">스크랩</a></li>
		<li><a href="<?php echo site_url('mypage/loginlog'); ?>" title="나의 로그인기록">로그인기록</a></li>
		<li><a href="<?php echo site_url('membermodify'); ?>" title="정보수정">정보수정</a></li>
		<li><a href="<?php echo site_url('membermodify/memberleave'); ?>" title="탈퇴하기">탈퇴하기</a></li>
	</ul>

	<h3>마이페이지</h3>
	<ol class="mypagemain">
		<li>
			<span>아이디</span>
			<div class="form-text"><?php echo html_escape($this->member->item('mem_userid')); ?></div>
		</li>
		<li>
			<span>이메일 주소</span>
			<div class="form-text"><?php echo html_escape($this->member->item('mem_email')); ?></div>
		</li>
		<?php if (element('use', element('mem_username', element('memberform', $view)))) { ?>
			<li>
				<span>이름</span>
				<div class="form-text"><?php echo html_escape($this->member->item('mem_username')); ?></div>
			</li>
		<?php } ?>
		<li>
			<span>닉네임</span>
			<div class="form-text"><?php echo html_escape($this->member->item('mem_nickname')); ?></div>
		</li>
		<?php if (element('use', element('mem_homepage', element('memberform', $view)))) { ?>
			<li>
				<span>홈페이지</span>
				<div class="form-text"><?php echo $this->member->item('mem_homepage') ? html_escape($this->member->item('mem_homepage')) : '미등록'; ?></div>
			</li>
		<?php } ?>
		<?php if (element('use', element('mem_birthday', element('memberform', $view)))) { ?>
			<li>
				<span>생일</span>
				<div class="form-text"><?php echo html_escape($this->member->item('mem_birthday')); ?></div>
			</li>
		<?php } ?>
		<li>
			<span>포인트</span>
			<div class="form-text"><?php echo number_format($this->member->item('mem_point'),1); ?></div>
		</li>
		<li>
			<span>Per Point <br> 지갑주소</span>
			<div>
				<input value="<?php echo html_escape($this->member->item('mem_email')); ?>" name="wallet"/>
				<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal"><?=$wallet_text?></button>
			</div>
		</li>
		<?php
		/* if (element('member_group_name', $view)) {
		// 회원에게 자신이 어떤 그룹에 속해있는지 보여주고 싶으면 여기 주석을 해제해주세요
		// 웹사이트 운영 정책에 따라 결정해주시면 됩니다
		?>
				<li>
					<span>회원그룹</span>
					<div class="form-text"><?php echo element('member_group_name', $view); ?></div>
				</li>
		<?php } */ ?>
		<li>
			<span>가입일</span>
			<div class="form-text"><?php echo display_datetime($this->member->item('mem_register_datetime'), 'full'); ?></div>
		</li>
		<li>
			<span>최근 로그인</span>
			<div class="form-text"><?php echo display_datetime($this->member->item('mem_lastlogin_datetime'), 'full'); ?></div>
		</li>
		<li class="mt20">
			<span></span>
			<div class="group">
				<a href="<?php echo site_url('membermodify'); ?>" class="btn btn-default btn-sm" title="회원정보 변경">회원정보 변경</a>
			</div>
		</li>
	</ol>
</div>
<style>
	/* .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
	} */
	.modal {
		top : -300px
	}
</style>
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>이메일 인증</h4>
				본인 인증을 위해 이메일 주소를 입력하여 주세요
			</div>
			<div class="modal-body">
				<div class="email_div">
					<input id="email_id">@<input id="email_addr"/>
					<select id="email_category">
						<option value="">직접 입력</option>
						<option value="naver.com">네이버</option>
						<option value="daum.net">다음</option>
					</select>
				</div>
				<div>
					<button id="email_send" onclick="sendCertifiEmail()">이메일 인증</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	let email_addr = $("#email_addr");
	let email_id = $("#email_id");

	$("#email_category").on('change',function(){
		let _value = $(this).val();
		if(_value){
			email_addr.attr('readonly',true);
			email_addr.val(_value);
		}else{
			email_addr.attr('readonly',false);
			email_addr.val('');
		}
	});

	function sendCertifiEmail(){
		if(!email_id.val()){
			alert('이메일 아이디를 입력해주세요');
			email_id.focus();
			return;
		}
		if(!email_addr.val()){
			alert('이메일 주소를 입력해주세요');
			email_addr.focus();
			return;
		}
		$.ajax({
			url: "",
			type: "POST",
			dataType: "json",
			data: {
				id : email_id.val(),
				addr : email_addr.val()
			},
			success: function(data){

			},
			error: function (request, status, error){        

			}
		});
	}
</script>