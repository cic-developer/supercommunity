<!--INDEX-->
<script src="../../../assets/js/jquery.bpopup-0.1.1.min.js"></script>
<?php
$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash'  => $this->security->get_csrf_hash()
);
if ($this->session->userdata('lang') == 'korean') {
    $message_rows = explode('<br />', element('mcf_messages', $main_config, ''));
} else if ($this->session->userdata('lang') == 'english') {
    $message_rows = explode('<br />', element('mcf_messages_en', $main_config, ''));
} else {
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
        <?php if (element('mcf_message_setting', $main_config)) { ?>
            <div class="acme-news-ticker-box">
                <ul class="my-news-ticker-3">
                    <?php foreach ($message_rows as $mr) { ?>
                        <li><a><?= html_escape($mr) ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <div class="text_box">
            <!--//한줄뉴스-->
            <?php if (element('mcf_perfriends_setting', $main_config)) { ?>
                <?= 'PER FRIENDS.' ?>
                <strong class="num">0</strong>
            <?php } ?>
        </div>
    </div>
</div>
<!--//main-->
<div id="element_to_pop_up" style="padding: 0; padding-bottom: 10px;">
    <a class="b-close">X</a>
    <a href="https://www.ciccommunity.com/sign_up"><img src="../../../assets/images/popup_ver1.png" style="border-radius:30px 30px 0 0;"></a>
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
        min-width: 400px;
        min-height: 180px;
    }

    .b-close {
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 5px;
    }
</style>
<script>
    $(document).ready(function() {
        $('#element_to_pop_up').bPopup({});
    })
</script>

<!--유튜브 background-->
<script type="text/javascript">
    $('.video-background').YTPlayer({
        videoURL: 'yu_32CJ1rrU',
        containment: $("#main"),
        autoPlay: true,
        loop: true,
        opacity: 0.9,
        mute: true,
        showControls: false,
        showYTLogo: false,
        useOnMobile: true,
        anchor: 'center,center',
        showAnnotations: true,
        stopMovieOnBlur: false,
        optimizeDisplay: true,
        abundance: 0.3,
        onError: function(err) {
            window.location.reload()
        }
    });

    setInterval(function() {
        $.ajax({
            url: "<?= base_url('Main/getPerFriendsCount') ?>",
            type: "POST",
            dataType: "json",
            data: {
                <?= $csrf['name'] ?>: "<?= $csrf['hash'] ?>"
            },
            success: function(result) {
                if (result) {
                    $(".num").numScroll({
                        number: result,
                        symbol: true
                    });
                }
            }
        })
    }, 10000);

    $(".num").numScroll({
        number: <?= $per_friends ? $per_friends : 0 ?>,
        symbol: true
    });

    jQuery(document).ready(function($) {
        $('.my-news-ticker-3').AcmeTicker({
            type: 'typewriter',
            /*horizontal/horizontal/Marquee/type*/
            direction: 'right',
            /*up/down/left/right*/
            speed: 50,
            /*true/false/number*/
            /*For vertical/horizontal 600*/
            /*For marquee 0.05*/
            /*For typewriter 50*/
            controls: {
                prev: $('.acme-news-ticker-prev'),
                /*Can be used for horizontal/horizontal/typewriter*/
                /*not work for marquee*/
                toggle: $('.acme-news-ticker-pause'),
                /*Can be used for horizontal/horizontal/typewriter*/
                /*not work for marquee*/
                next: $('.acme-news-ticker-next') /*Can be used for horizontal/horizontal/marquee/typewriter*/
            }
        });
    })
</script>