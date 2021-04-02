<?php echo $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div id="research_wrap">  
    <div class="research_content">
        <h3><?php echo $this->lang->line('h3_1')?></h3>
        <div class="research_top">
            <ul class="text_g">
                <li class="sub_title">
                    <iframe src="https://www.youtube.com/embed/UeEYxrPFlC0?rel=0?enablejsapi=1&disablekb=1&fs=1" 
                            width="100%" height="570"
                            frameborder="0" 
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </li>
                <li><p>
                    <?php echo $this->lang->line('p_1')?>
                </p></li>
            </ul>
        </div> 

        <h3><?php echo $this->lang->line('h3_2')?></h3>
        <div class="research_top">
            <ul class="text_g">
                <li class="sub_title" style="text-align: center;">
                    <img src="<?php echo base_url('assets/images/ad_platform.png');?>"/>
                </li>
                <li><p>
                    <?php echo $this->lang->line('p_2')?>
                </p></li>
            </ul>
        </div>

        <div class="bt">
            <a href="<?php echo base_url('/Research/adInquiry')?>" class="btn1 btn_yellow"><?php echo $this->lang->line('a_1')?></a>
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