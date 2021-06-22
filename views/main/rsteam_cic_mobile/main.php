<script src="../../../assets/js/jquery.bpopup-0.1.1.min.js"></script>
<?php 
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
    if($this->session->userdata('lang') == 'korean'){
        $message_rows = explode('<br />',element('mcf_messages',$main_config, ''));
    }else if($this->session->userdata('lang') == 'english'){
        $message_rows = explode('<br />',element('mcf_messages_en',$main_config, ''));
    }else{
        $message_rows = array();
    }
    //랜덤순서로 표출
    shuffle($message_rows);
?>

<!--main-->
<div id="main">
	<div class="main_bg"> 
    </div>
	<div class="main_text">
		<div class="text_box">
			<!--//한줄뉴스-->
        <?php if(element('mcf_perfriends_setting',$main_config)){?>
			<?='PER FRIENDS.'?> 
			<strong class="num">0</strong>
        <?php } ?>
		</div>	
		<!--한줄뉴스 단순 텍스트밖에안됨-->
        <?php if(element('mcf_message_setting',$main_config)){ ?>
		<div class="acme-news-ticker-box">
			<ul class="my-news-ticker-3">
            <?php foreach($message_rows AS $mr){ ?>
                <li><a href="#"><?php echo html_escape($mr) ?></a></li>
            <?php } ?>
			</ul>
        </div>
        <?php } ?>
	</div>
</div>
<!--//main-->

<div id="element_to_pop_up">
    <a href="https://www.ciccommunity.com/sign_up" style="width:100%;"><img src="../../../assets/images/popup_ver1.png" style="width:100%;"></a>
    <p style="text-align:center;"><b style="font-size:20px;">[cic 커뮤니티 오픈기념 사전가입 이벤트]</b><br><br>
        안녕하세요 퍼 프렌즈 여러분<br>
        신개념 코인 커뮤니티 cic 커뮤니티에서 사전가입 이벤트를 진행합니다<br>
        지금 사전가입을 하시면 1000vp와 5cp, 그리고 추첨을 통해 특별한 선물을 드립니다<br>
        해당 이벤트는 2021년 6월 30일 12:00 까지 진행됩니다<br><br>
        <span style="font-weight:bold; color:#f40315;">*특별한 선물은 지갑주소에 PER Wallet 또는<br> Kaikas 주소를 입력한 분들에 한정합니다*</span>
    </p>
</div>
<style>
    #element_to_pop_up {
        background-color: #fff;
        border-radius: 15px;
        color: #000;
        display: none;
        padding: 20px;
        min-width: 150px;
        min-height: 180px;
        width:80%;
        padding: 0;
        padding-bottom: 10px;
        margin-top: 50px;
    }
</style>
<script>
    $(document).ready(function() {
        $('#element_to_pop_up').bPopup({});
    })
</script>




<script type="text/javascript">
    var per_friends = '<?=$per_friends?>';
    if(per_friends >= 100000){
        $('.num').css('font-size','45px');
    }else if(per_friends >= 10000000){
        $('.num').css('font-size','25px');
    }

    $('#main').css({
        height : $(window).height()
    }); /* 모바일 배너 높이 기기 height 100% */

	$(".num").numScroll({
        number: per_friends,
        symbol: true
	});

    setInterval(function(){
        $.ajax({
            url : "<?=base_url('Main/getPerFriendsCount')?>",
            type : "POST",
            dataType: "json",
            data : {
                <?=$csrf['name']?> : "<?=$csrf['hash']?>"
            },
            success : function(result){
                if(result){
                    if(result >= 100000){
                        $('.num').css('font-size','45px');
                    }else if(per_friends >= 10000000){
                        $('.num').css('font-size','25px');
                    }
                    $(".num").numScroll({
                        number: result,
                        symbol: true
                    });
                }
            }
        })
    }, 10000);
	
    jQuery(document).ready(function ($) {
        $('.my-news-ticker-3').AcmeTicker({
            type:'typewriter',/*horizontal/horizontal/Marquee/type*/
            direction: 'right',/*up/down/left/right*/
            speed:50,/*true/false/number*/ /*For vertical/horizontal 600*//*For marquee 0.05*//*For typewriter 50*/
            controls: {
                prev: $('.acme-news-ticker-prev'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
                toggle: $('.acme-news-ticker-pause'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
                next: $('.acme-news-ticker-next')/*Can be used for horizontal/horizontal/marquee/typewriter*/
            }
        });
    });
</script>