<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 

    $meta_data = $this->Member_extra_vars_model->get_all_meta($this->member->is_member());
    $_is_auth = element('meta_auth_eamil_datetime',$meta_data);
    $_wallet_addr = element('meta_wallet_address',$meta_data);
?>
<!--마이페이지-1 :: 내정보-->
<?php //if(!$_is_auth) { ?>
<!--메일인증 팝업-->
<div class="popup popup_content popup_basic" id="popup_basic">
        <div class="head">
            <label class="ttl-popup"><?php echo $this->lang->line(0)?></label>
        </div>
         <!--body-->
        <div class="body">
            <p><?php echo $this->lang->line(1)?></p>
            <div class="mail_box">
                <input type="text" id="recheck_email" placeholder="<?php echo $this->lang->line(2)?>" value="<?php echo element('mem_email', $member_data)?>" style="width:280px"/>
                <input type="submit" class="btn2 btn_black" id="send" value="<?php echo $this->lang->line(3)?>" onclick="sendEmail()" />
                <!--mail_code-->
                <div class="mail_code" style="display:none;"> <!--인증 메일 전송후 뜰것 일단 안보이게해놨어여-->
                    <input type="text" id="certyfy_string" placeholder="<?php echo $this->lang->line(4)?>" style="width:180px" />
                    <input type="button" class="btn2 btn_line" value="<?php echo $this->lang->line(5)?>" onclick="authEmail()"/> <!--인증완료시 완료안내 필요-->
                    <input type="text" id="changeWallet" placeholder="<?php echo $this->lang->line(11)?>" style="width:90%; display:none" />
                </div>
                <!--//mail_code-->
            </div>
        </div>
        <!--//body-->
        <!--foot-->
        <div class="foot"> <!--인증완료시 떠도될듯-->
            <div class="buttons" style="display:none">
                <input class="btn" type="button" value="<?php echo $this->lang->line(6)?>" onclick="submit_change()"/>  
            </div>
        </div>
        <!--//foot-->
</div>
<!--//메일인증 팝업-->

       <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
       <div id="my_right_box">
            <h5><?php echo $this->lang->line(7)?></h5> <!--마이페이지 상세 타이틀-->
            <!--my_cont_area-->
            <div class="my_cont_area">
<?php echo form_open('') ?>
                <input type="hidden" id="auth_id" name="auth_id" />
                <input type="hidden" id="auth_hash" name="auth_hash" />
                
                <h6><?php echo $this->lang->line(7)?></h6>
                <ul class="ul_write">
                    <li>
                        <span><?php echo $this->lang->line(8)?></span>
                        <div class="my_cont">
							<p class="read_fake"><?php echo "***".mb_substr($member_data['mem_userid'], mb_strlen($member_data['mem_userid'])/BLIND_ID_LENG ) ?></p>
                        </div>
					</li>
					<li>
                        <span><?php echo $this->lang->line(9)?></span>
                        <div class="my_cont">
                            <input type="text" value="<?php echo html_escape($member_data['mem_nickname'])?>" name="nick_name" />
                        </div>
                    </li>
                    <li>
                        <span><b><?php echo $this->lang->line(10)?></b> <?php echo $this->lang->line(11)?></span>
                        <div class="my_cont">
							<input type="text" value="<?php echo $_is_auth ? $_wallet_addr : '-'?>" id="wallet_addr" name="wallet_addr" style="width:400px" readonly="readonly"/>
							<input type="button" id="basic" class="btn2 btn_black" value="<?php echo $_is_auth? $this->lang->line(12): $this->lang->line(13)?>" /> <!--지갑주소가 입력되면 '지갑주소수정'으로 문구 변경-->
                        </div>
                    </li>
                    <li>
                        <span>E-mail</span>
                        <div class="my_cont">
                            <input type="text" value="<?php echo element('mem_email', $member_data); ?>" name="email" style="width:400px" readonly />
                        </div>
                    </li>
                    <li>
                        <span><?php echo $this->lang->line(14)?></span>
                        <div class="my_cont">
							<ul class="midea_txt">
                                <?php foreach($media_data AS $md){ ?>
                                    <li>
                                        <b><?php echo html_escape($this->session->userdata('lang') == 'korean' ? $md['wht_title'] : $md['wht_title_en'])?></b>
                                        <p><?php echo html_escape($md['med_url'])?></p>
                                    </li>
                                <?php } ?>
                                <?php if(!$media_data){ echo '<li><p>'.$this->lang->line(15).'</p></li>'; }?>
								<li>
									<p><a href="<?php echo base_url('Media/editMedia')?>" class="btn2 btn_line"><?php echo $this->lang->line(16)?></a></p> <!--추가 링크 항시노출-->
								</li>
							</ul>
                        </div>
                    </li>
                </ul>
            </div>
            <!--//my_cont_area-->
            <div class="btn_box">
				 <input type="submit" value="<?php echo $this->lang->line(17)?>" class="btn1 btn_yellow"/>
				 <!-- <a href="<?php //echo base_url('mypage/withdraw')?>" class="btn1 btn_line"><?php //echo $this->lang->line(18)?></a> -->
				 <a href="<?php echo base_url('mypage/signout')?>" class="btn1 btn_line"><?php echo $this->lang->line(19)?></a>  
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

    $(document).ready(function(){
        $("form").validate({
            rules: {
                nick_name : { required: true, rangelength: [2 , 15]}
            },
            errorPlacement:function(error, element){
                element.after(error);
            }
        });
    });

    $(document).on("change keyup input", "#certyfy_string", function(){
        $(this).val( $(this).val().replace(/[^0-9a-zA-Z]/g,"").substr(0,6) );
    });
    $(document).on("change keyup input", "#changeWallet", function(){
        $(this).val( $(this).val().replace(/[^0-9a-zA-Z]/g,"") );
    });
    <?php //지갑 주소 수정 버튼 클릭시 ?>
    $('#basic').on('click', function(){
        //인증 코드를 받지 않은 경우에만
        if(!$("#auth_hash").val()){
            if(!confirm('<?php echo $this->lang->line(29); ?>')) return false;
            sendEmail();
        }
        // $('.popup_basic').modal({ keyboard: false, backdrop: 'static' });
        $('.popup_basic').lightlayer(
            // { escape: false }
        );
        
    });
    <?php //지갑 주소 수정 버튼 클릭시 끝 ?>
    

    //------------------- email 전송 ajax ------------------------------------
    function sendEmail(){
        let _email = $("#recheck_email").val().trim();
        if(_email){
            auth_email = _email;
        }else{
            return;
        }
        if(!validateEmail(auth_email)){alert('<?php echo $this->lang->line(20)?>'); return;}
        $.ajax({
            url: "Mypage/ajax_emailSend", // 클라이언트가 요청을 보낼 서버의 URL 주소
            data: { email: auth_email, type: '1' },                // HTTP 요청과 함께 서버로 보낼 데이터
            type: "GET",                             // HTTP 요청 방식(GET, POST)
            dataType: "json",
            async: false,
            success: function(result){
                switch(result['state']){
                    case 'not found member':
                        alert('<?php echo $this->lang->line(21)?>');
                        location.href = '<?php echo base_url('login')?>';
                    break;
                    case 'fail':
                        alert('<?php echo $this->lang->line(22)?>');
                    break;
                    case 'success':
                        alert('<?php echo $this->lang->line(23)?>');
                        $(".mail_code").css('display','block');
                        $("#recheck_email").attr('readonly',true);
                        $("#send").attr('disabled',true);
                        auth_id = result['id'];
                    break;
                    case 'overlap' :
                        alert('<?php echo $this->lang->line(24)?>');
                        $(".mail_code").css('display','block');
                        $("#recheck_email").attr('readonly',true);
                        $("#send").attr('disabled',true);
                        auth_id = result['id'];
                    break;
                }
            }
        });
    }

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
                        alert('<?php echo $this->lang->line(25)?>');
                    break;
                    case 'success':
                        alert('<?php echo $this->lang->line(26)?>');
                        $("#auth_hash").val(result['data']);
                        if(result['type'] == 1){
                            // $("#wallet_addr").removeAttr("readonly");
                            $("input[name=email]").val(auth_email);
                            $("#changeWallet").css('display','block');
                            $(".buttons").css('display', 'block');
                        }else if(result['type'] == 2){
                            $("input[name=email]").removeAttr("readonly");
                        }  
                    break;
                }
            }
        });
    }

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
        console.log(wallet_addr);
        if(wallet_addr){
            $("#wallet_addr").val(wallet_addr);     
        }
           
        $("form").submit();
    }

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

</script>