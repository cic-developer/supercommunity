<?php echo $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div id="research_wrap">  
    <div class="research_content">
        <h3>광고 컨설팅 플랫폼 SUPER COMMUNITY입니다.</h3>
        <div class="research_top">
            <ul class="text_g">
                <li class="sub_title">
                    <iframe src="https://www.youtube.com/embed/UeEYxrPFlC0?rel=0?enablejsapi=1&disablekb=1&fs=1" 
                            width="100%" height="280"
                            frameborder="0" 
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </li>
                <li><p>
                    SUPER COMMUNITY는 디지털자산 광고플랫폼으로 종합적인 광고 컨설팅을 통해 여러분의 비즈니스 성장을 극대화시킬 수 있습니다.
                    광고주님께서는 중간비용 없이 플랫폼을 무료로 이용하실 수 있으며 
                    미션의 등록, 심사, 기본 보고서 작성 서비스는 회사에서 무료로 제공합니다. 
                    추가적인 광고 컨설팅을 원하시는 경우 패키지서비스를 이용하실 수 있습니다. 
                    가장 효율적인 광고를 진행해 보세요!
                </p></li>
            </ul>
        </div> 

        <h3>SUPER COMMUNITY가 광고하는 주 플랫폼을 소개합니다.</h3>
        <div class="research_top">
            <ul class="text_g">
                <li class="sub_title">
                    <img src="<?php echo base_url('assets/images/ad_platform.png');?>" style="width:100%; height:280"/>
                </li>
                <li><p>
                    네이버 블로그, 유튜브, 텔레그램, 카카오 오픈채팅, 코박, 티스토리, 코인판이 있습니다.
                </p></li>
            </ul>
        </div>

        <div class="bt">
            <a href="<?php echo base_url('/Research/adInquiry')?>" class="btn1 btn_yellow">문의하기</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        YT_autoPaly();
    });

    
    function YT_autoPaly(){
        let this_iframe = $(document).find('iframe');
        if(this_iframe){
            let this_iframe_src = this_iframe.attr('src');
            let autoplay_index = this_iframe_src.lastIndexOf('&autoplay=1');
            

            if(autoplay_index >= 0){
                this_iframe_src = this_iframe_src.substr(0, autoplay_index);
                this_iframe.attr('src',this_iframe_src);
                console.log('autoplay stop', this_iframe_src);

                setTimeout(async () => {
                    await this_iframe.attr('src',this_iframe_src+'&autoplay=1');
                    console.log('autoplay restart', this_iframe_src);
                }, 3000);
            }else{
                this_iframe.attr('src',this_iframe_src+'&autoplay=1');
                console.log('autoplay run', this_iframe_src);
            }
        }
    }
</script>