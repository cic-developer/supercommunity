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
        // $('.my-news-ticker-1').AcmeTicker({
        //     type:'horizontal',/*horizontal/horizontal/Marquee/type*/
        //     direction: 'right',/*up/down/left/right*/
        //     controls: {
        //         prev: $('.acme-news-ticker-prev'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
        //         toggle: $('.acme-news-ticker-pause'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
        //         next: $('.acme-news-ticker-next')/*Can be used for horizontal/horizontal/marquee/typewriter*/
        //     }
        // });
        // $('.my-news-ticker-2').AcmeTicker({
        //     type:'marquee',/*horizontal/horizontal/Marquee/type*/
        //     direction: 'left',/*up/down/left/right*/
        //     speed: 0.05,/*true/false/number*/ /*For vertical/horizontal 600*//*For marquee 0.05*//*For typewriter 50*/
        //     controls: {
        //         toggle: $('.acme-news-ticker-pause'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
        //     }
        // });
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
        // $('.my-news-ticker-4').AcmeTicker({
        //     type:'vertical',/*vertical/horizontal/Marquee/type*/
        //     direction: 'right',/*up/down/left/right*/
        //     controls: {
        //         prev: $('.acme-news-ticker-prev'),/*Can be used for vertical/horizontal/typewriter*//*not work for marquee*/
        //         next: $('.acme-news-ticker-next'),/*Can be used for vertical/horizontal/typewriter*//*not work for marquee*/
        //         toggle: $('.acme-news-ticker-pause')/*Can be used for vertical/horizontal/marquee/typewriter*/
        //     }
        // });
    });
</script>