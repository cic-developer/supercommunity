<!--INDEX-->
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
	<div class="video-background"></div>
	<div class="main_bg">
    </div> 
	<div class="main_text">
		<!--한줄뉴스 단순 텍스트밖에안됨-->
        <?php if(element('mcf_message_setting',$main_config)){ ?>
            <div class="acme-news-ticker-box">
                <ul class="my-news-ticker-3">
                <?php foreach($message_rows AS $mr){?>
                    <li><a><?= html_escape($mr) ?></a></li>
                <?php } ?>
                </ul>
            </div>
        <?php } ?>
		<div class="text_box">
			<!--//한줄뉴스-->
        <?php if(element('mcf_perfriends_setting',$main_config)){?>
                <?='PER FRIENDS.'?> 
                <strong class="num">0</strong>
        <?php } ?>
		</div>	
	</div>
</div>
<!--//main-->




<!--유튜브 background-->
<script type="text/javascript">

	$('.video-background').YTPlayer({
        videoURL :'yu_32CJ1rrU',
        containment : $("#main"),
        autoPlay:true,
        loop:true,
        opacity: 1,
        mute: true,
        showControls: false,
        showYTLogo: false,
        useOnMobile: true,
        anchor: 'center,center',
        showAnnotations: true,
        stopMovieOnBlur: false,
        optimizeDisplay: true,
        abundance: 0.3,
        onError: function(err){
            window.location.reload()
        }
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
                    $(".num").numScroll({
                        number: result,
                        symbol: true
                    });
                }
            }
        })
    }, 10000);

	$(".num").numScroll({
      number:<?=$per_friends ? $per_friends : 0 ?>,
      symbol: true
	});
	
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
    })
</script>