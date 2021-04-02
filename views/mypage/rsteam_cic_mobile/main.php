<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 

    $meta_data = $this->Member_extra_vars_model->get_all_meta($this->member->is_member());
    $_is_auth = element('meta_auth_eamil_datetime',$meta_data);
    $_wallet_addr = element('meta_wallet_address',$meta_data);
?>
<!--마이페이지-1 :: 내정보-->
    <!--서브메뉴 불러와질영역-->

<!--메일인증 팝업-->
 <div class="popup popup_content popup_basic" id="popup_basic">
    <div class="head">
        <label class="ttl-popup"><?php echo $this->lang->line(0)?></label>
    </div>
    <div class="body">
        <p><?php echo $this->lang->line(1)?></p>
        <div class="mail_box">
            <input type="text" name="" id="recheck_email" placeholder="<?php echo $this->lang->line(2)?>" value="<?php echo element('mem_email', $member_data)?>" style="width:100%"/>
            <input type="submit" class="btn2 btn_black" id="send" value="<?php echo $this->lang->line(3)?>" onclick="sendEmail()"  />
            <div class="mail_code" style="display:none"> 
                <input type="text" name="" id="certyfy_string" placeholder="<?php echo $this->lang->line(4)?>" style="width:60%" />
                <input type="submit" class="btn2 btn_line" value="<?php echo $this->lang->line(5)?>" onclick="authEmail()" /> 
                <input type="text" id="changeWallet" placeholder="<?php echo $this->lang->line(15)?>" style="width:80%;" readonly />
            </div>
       
        </div>
    </div>

    <div class="foot">
        <div class="buttons" style="display:none">
            <input class="btn custom-close" type="button" value="<?php echo $this->lang->line(6)?>" onclick="submit_change()"/>
        </div>
    </div>
</div>  
<!--//메일인증 팝업-->


<?php //E-mail 등록 및 수정 팝업 ?>
<!-- <div class="popup popup_content popup_basic" id="popup_email">
    <div class="head">
        <label class="ttl-popup"><?php //echo $this->lang->line(0)?></label>
    </div>
    <div class="body">
        <p><?php //echo $this->lang->line(1)?></p>
        <div class="mail_box">
            <input type="text" id="cert_email" placeholder="<?php //echo $this->lang->line(2)?>" value="<?php //echo element('mem_email', $member_data)?>" style="width:100%"/>
            <input type="submit" class="btn2 btn_black" id="send2" value="<?php //echo $this->lang->line(3)?>" onclick="certEmail()"  />

            <div class="mail_code" style="display:none" id="mail_code2"> 
                <input type="text" id="certyfy_string2" placeholder="<?php //echo $this->lang->line(4)?>" style="width:60%" />
                <input type="button" class="btn2 btn_line" value="<?php //echo $this->lang->line(5)?>" onclick="authEmail2()" />
            </div>
        </div>
    </div>
    <div class="foot">
        <div class="buttons">
            <input class="btn custom-close" type="button" value="<?php //echo $this->lang->line(6)?>"/>
        </div>
    </div>
</div>  -->
<?php //E-mail 등록 및 수정 팝업 끝 ?>

<!--윗부분에 마이페이지 포인트 영역-->

<!--mypage-->
<div id="mypage">
        <h3><?php echo $this->lang->line(7)?></h3>
		<!--my_top--> 
		<div id="my_top"> 
			<ul class="my_box">
				<li>
					<div class="user_img">
						<img src="<?php echo base_url('assets/images/s_user.png');?>" alt="<?php echo $this->lang->line(8)?>"><!--인플루언서 프사-->
						<!--<img src="<?/*php echo base_url('assets/images/user.png');*/?>" alt="퍼프렌즈" />  //일반유저 프사-->
					</div> 
					<!-- <strong></strong> -->
				</li>
				 <li>
					<h4><?php echo $this->lang->line(9)?></h4>
					<p><?php echo $member_data['mem_nickname']?><?php //echo $this->lang->line(10)?> <span><?php //echo number_format($total_super)?></span></p>
				</li> 
			</ul>
		</div>
		<!--//my_top-->
       <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
       <div id="my_right_box">
            <h5><?php echo $this->lang->line(11)?></h5> <!--마이페이지 상세 타이틀-->
            <!--my_cont_area-->
            <div class="my_cont_area">
        <?php echo form_open('') ?>
                <h6><?php echo $this->lang->line(11)?></h6>
                <input type="hidden" id="auth_id" name="auth_id" />
                <input type="hidden" id="auth_hash" name="auth_hash" />
                <ul class="ul_write">
                    <li>
                        <span><?php echo $this->lang->line(12)?></span>
                        <div class="my_cont">
							<p class="read_fake"><?php echo "***".substr($member_data['mem_userid'], mb_strlen($member_data['mem_userid'])/BLIND_ID_LENG ) ?></p>
                        </div>
					</li>
					<li>
                        <span><?php echo $this->lang->line(13)?></span>
                        <div class="my_cont">
                            <input type="text" value="<?php echo html_escape($member_data['mem_nickname'])?>" name="nick_name" />
                        </div>
                    </li>
                    <li>
                        <span><b><?php echo $this->lang->line(14)?></b> <?php echo $this->lang->line(15)?></span>
                        <div class="my_cont">
							<input type="text" value="<?php echo $_is_auth ? $_wallet_addr : '-'?>" id="wallet_addr" name="wallet_addr" style="width:65%" readonly="readonly" /> <!--이메일 인증 시 readonly 해제-->
							<input type="button" id="basic" class="btn2 btn_black" value="<?php echo $_is_auth? $this->lang->line(16): $this->lang->line(17)?>" />
                        </div>
                    </li>
                    <li>
                        <span>E-mail</span>
                        <div class="my_cont">
                            <input type="text" value="<?php echo element('mem_email', $member_data); ?>" name="email" style="width:65%" readonly />
                            <!-- <input type="button" id="is_email" class="btn2 btn_black" value="<?php // echo element('mem_email', $member_data)? $this->lang->line(31): $this->lang->line(32)?>" /> -->
                        </div>
                    </li>
                    <li>
                        <span><?php echo $this->lang->line(18)?></span>
                        <div class="my_cont">
							<ul class="midea_txt">
                                <?php foreach($media_data AS $md){ ?>
                                    <li>
                                        <b><?php echo html_escape($this->session->userdata('lang') == 'korean' ? $md['wht_title'] : $md['wht_title_en'])?></b>
                                        <p><?php echo html_escape($md['med_url'])?></p>
                                    </li>
                                <?php } ?>
                                <?php if(!$media_data){ echo '<li><p>'.$this->lang->line(19).'</p></li>'; }?>
								<li>
									<p><a href="<?php echo base_url('Media/editMedia')?>" class="btn2 btn_line"><?php echo $this->lang->line(20)?></a></p> <!--추가 링크 항시노출-->
								</li>
							</ul>
                        </div>
                    </li>
                </ul>
            </div>
            <!--//my_cont_area-->
            <div class="btn_box">
				 <input type="submit" value="<?php echo $this->lang->line(21)?>" class="btn1 btn_yellow"/>
				 <!-- <a href="<?php //echo base_url('Mypage/withdraw')?>" class="btn1 btn_line"><?php //echo $this->lang->line(22)?></a> -->
				 <a href="<?php echo base_url('Mypage/signout')?>" class="btn1 btn_line"><?php echo $this->lang->line(23)?></a>  
            </div>
        <?php echo form_close()?>
      </div>
       <!--//페이지별 변경되는 오른쪽 영역 page_right_box-->

  </div>
   <!--//마이페이지 레이아웃 mypage-->



<script>
    var auth_id = 0;
    var auth_id2 = 0;
    var auth_email = '';
    var auth_email2= '';

    $(document).on("change keyup input", "#certyfy_string", function(){
        $(this).val( $(this).val().replace(/[^0-9a-zA-Z]/g,"").substr(0,6) );
    });
    $(document).on("change keyup input", "#changeWallet", function(){
        $(this).val( $(this).val().replace(/[^0-9a-zA-Z]/g,"") );
    });

    <?php //지갑 주소 수정 버튼 클릭시 ?>
    $('#basic').on('click', function(){
        // $('.popup_basic').modal({ keyboard: false, backdrop: 'static' });
        //인증 코드를 받지 않은 경우에만
        if(!$("#auth_hash").val()){
            if(!confirm('<?php echo $this->lang->line(29); ?>')) return false;
            sendEmail();
        }
        $('.popup_basic').lightlayer(
            //{ escape: false }
        );
    });
    <?php //지갑 주소 수정 버튼 클릭시 끝 ?>
    
    <?php //E-mail 수정 버튼 클릭시 ?>
    $("#is_email").on('click', function(){
        $('#popup_email').lightlayer({ escape: false });
        certEmail();
    });
    <?php //E-mail 수정 버튼 클릭시 끝 ?>
    
    //------------------- email 전송 ajax ------------------------------------
    function sendEmail(){
        let _email = $("#recheck_email").val().trim();
        auth_email = _email;
        if(!validateEmail(_email)){alert('<?php echo $this->lang->line(24)?>'); return;}
        $.ajax({
            url: "Mypage/ajax_emailSend", // 클라이언트가 요청을 보낼 서버의 URL 주소
            data: { email: _email, type: '1'},                // HTTP 요청과 함께 서버로 보낼 데이터
            type: "GET",                             // HTTP 요청 방식(GET, POST)
            dataType: "json",
            async: false,
            success: function(result){
                switch(result['state']){
                    case 'not found member':
                        alert('<?php echo $this->lang->line(25)?>');
                        location.href = '<?php echo base_url('login')?>';
                    break;
                    case 'fail':
                        alert('<?php echo $this->lang->line(26)?>');
                    break;
                    case 'success':
                        alert('<?php echo $this->lang->line(27)?>');
                        $(".mail_code").css('display','block');
                        $("#recheck_email").attr('readonly',true);
                        $("#send").attr('disabled',true);
                        auth_id = result['id'];
                    break;
                    case 'overlap' :
                        alert('<?php echo $this->lang->line(28)?>');
                        $(".mail_code").css('display','block');
                        $("#recheck_email").attr('readonly',true);
                        $("#send").attr('disabled',true);
                        auth_id = result['id'];
                    break;
                }
            }
        });
    }


    // function certEmail(){
    //     let _email = $("#cert_email").val().trim();
    //     if(_email){
    //         auth_email2 = _email;
    //     }else{
    //         return;
    //     }
    //     if(!validateEmail(auth_email2)){alert('<?php //echo $this->lang->line(20)?>'); return;}
    //     $.ajax({
    //         url: "Mypage/ajax_emailSend", // 클라이언트가 요청을 보낼 서버의 URL 주소
    //         data: { email: auth_email2, type: '2' },                // HTTP 요청과 함께 서버로 보낼 데이터
    //         type: "GET",                             // HTTP 요청 방식(GET, POST)
    //         dataType: "json",
    //         async: false,
    //         success: function(result){
    //             switch(result['state']){
    //                 case 'not found member':
    //                     alert('<?php //echo $this->lang->line(25)?>');
    //                     location.href = '<?php //echo base_url('login')?>';
    //                 break;
    //                 case 'fail':
    //                     alert('<?php //echo $this->lang->line(26)?>');
    //                 break;
    //                 case 'success':
    //                     alert('<?php //echo $this->lang->line(27)?>');
    //                     $("#mail_code2").css('display','block');
    //                     $("#cert_email").attr('readonly',true);
    //                     $("#send2").attr('disabled',true);
    //                     auth_id2 = result['id'];
    //                 break;
    //                 case 'overlap' :
    //                     alert('<?php //echo $this->lang->line(28)?>');
    //                     $("#mail_code2").css('display','block');
    //                     $("#cert_email").attr('readonly',true);
    //                     $("#send2").attr('disabled',true);
    //                     auth_id2 = result['id'];
    //                 break;
    //             }
    //         }
    //     });
    // }
    //-----------------------------------------------------------------------------

    //-------------------------- 인증 ajax -----------------------------------------
    function authEmail(){
        let auth_code = $("#certyfy_string").val().trim();
        $.ajax({
            url: "Mypage/ajax_emailAuth", // 클라이언트가 요청을 보낼 서버의 URL 주소
            data: { 
                code: auth_code,
                id: auth_id,
                email: auth_email,
                csrf_test_name: cb_csrf_hash 
            },                // HTTP 요청과 함께 서버로 보낼 데이터
            type: "POST",                             // HTTP 요청 방식(GET, POST)
            dataType: "json",
            async: false,
            success: function(result){
                switch(result['result']){
                    case 'fail':
                        alert('<?php echo $this->lang->line(29)?>');
                    break;
                    case 'success':
                        alert('<?php echo $this->lang->line(30)?>');
                        $("#auth_hash").val(result['data']);
                        if(result['type'] == 1){
                            $("input[name=email]").val(auth_email);
                            $("#changeWallet").removeAttr('readonly');
                            $(".buttons").css('display', 'block');
                        }else if(result['type'] == 2){
                            $("input[name=email]").removeAttr("readonly");
                        }
                    break;
                }
            }
        });
    }


    // function authEmail2(){
    //     let auth_code = $("#certyfy_string2").val().trim();
    //     $.ajax({
    //         url: "Mypage/ajax_emailAuth", // 클라이언트가 요청을 보낼 서버의 URL 주소
    //         data: { 
    //             code: auth_code,
    //             id: auth_id2,
    //             email: auth_email2,
    //             csrf_test_name: cb_csrf_hash 
    //         },                // HTTP 요청과 함께 서버로 보낼 데이터
    //         type: "POST",                             // HTTP 요청 방식(GET, POST)
    //         dataType: "json",
    //         async: false,
    //         success: function(result){
    //             switch(result['result']){
    //                 case 'fail':
    //                     alert('<?php //echo $this->lang->line(29)?>');
    //                 break;
    //                 case 'success':
    //                     alert('<?php //echo $this->lang->line(30)?>');
    //                     $("#auth_hash").val(result['data']);
    //                     if(result['type'] == 1){
    //                         $("#wallet_addr").removeAttr("readonly");
    //                         $("input[name=email]").val(auth_email);
    //                     }else if(result['type'] == 2){
    //                         $("input[name=email]").removeAttr("readonly");
    //                     }  
    //                 break;
    //             }
    //         }
    //     });
    // }

    //-------------------------------------------------------------------------------

    $("form").on('submit', function(){
        $("#auth_id").val(auth_id);
        let email_val = $("input[name=email]").val();
        let auth_hash = $("#auth_hash").val();
        if(auth_hash){
            if(!validateEmail(email_val)){alert('<?php echo $this->lang->line(20)?>'); return;}
        }
    });

    function submit_change(){
        let wallet_addr = $("#changeWallet").val();
        if(wallet_addr){
            $("#wallet_addr").val(wallet_addr);     
        }else{
            //지갑 주소 안썼으면 안쓴데로 업데이트 쳐버리자
        }
           
        $("form").submit();
    }

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

</script>