<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
    $is_en = '';
    if($this->session->userdata('lang') == 'english'){
        $is_en = '_en';
    }
?>
<div id="white_wrap">
    <!--퍼백서 타이틀-->
    <h3>WHITE PAPER</h3>
    <!--퍼백서 타이틀//-->

    <!--퍼백서 내용 시작-->
    <div class="white_content">
        <div class="white_top">
            <?php echo $this->lang->line(0) ?>
        </div> 
        
        <i class="fas fa-chevron-down" onclick="document.getElementById('hiddenContent01').style.display=(document.getElementById('hiddenContent01').style.display=='block') ? 'none' : 'block';">
        <?php echo $this->lang->line(1) ?></i>
        <div class="white_b" id="hiddenContent01" style="display: none;">
            <div class="content_area">
                <?php echo $this->lang->line(2) ?>
            </div>
            <div class="content_area">
                <?php echo $this->lang->line(3) ?>
            </div>
            <div class="content_area">
                <?php echo $this->lang->line(4) ?>
            </div>
            <div class="content_area">
                <?php echo $this->lang->line(5) ?>
            </div>
            <div class="content_area">
                <h4><?php echo $this->lang->line(6) ?></h4>
                <ul class="text_g">
                    <li>
                        <p><?php echo $this->lang->line(7) ?></p>
                    </li>
                    <li class="s_img">
                        <img src="<?php echo base_url('assets/images/white011'.$is_en.'.jpg');?>" alt=" <?php echo $this->lang->line(20) ?>"/>
                    </li>
                    <li>
                    <?php echo $this->lang->line(8) ?>
                    </li>
                    <li class="sub_title">
                    <?php echo $this->lang->line(9) ?>
                    </li>
                    <li>
                        <p><?php echo $this->lang->line(10) ?>
                        </p>
                    </li>
                    <li class="img">
                        <img src="<?php echo base_url('assets/images/white012'.$is_en.'.jpg');?>" alt=" <?php echo $this->lang->line(21) ?>"/>
                    </li>
                    <li class="sub_title">
                        <?php echo $this->lang->line(11) ?>
                    </li>
                    <li>
                        <p> <?php echo $this->lang->line(12) ?></p>
                            <br><br>

                            <!-- <i class="fas fa-chevron-down" onclick="document.getElementById('hiddenContent02').style.display=(document.getElementById('hiddenContent02').style.display=='block') ? 'none' : 'block';">
                            <?//php echo $this->lang->line(13) ?></i> -->
                            <!-- id="hiddenContent02" style="display: none;" -->
                            <p class="long"><?php echo $this->lang->line(14) ?> 
                            </p>
                    </li>
                    <li class="img">
                        <img src="<?php echo base_url('assets/images/white013'.$is_en.'.jpg');?>" alt=" <?php echo $this->lang->line(22) ?>"/>
                    </li>
                    <li>
                        <p><?php echo $this->lang->line(15) ?></p>
                    </li>
                    <li class="img">
                       <img src="<?php echo base_url('assets/images/white014'.$is_en.'.jpg');?>" alt=" <?php echo $this->lang->line(23) ?>"/>
                    </li>
                    <li>
                    <p> <?php echo $this->lang->line(16) ?></p>
                    </li>
                </ul>
            </div>
            <div class="content_area">
                <?php echo $this->lang->line(17) ?>
            </div>
            <div class="content_area">
                <?php echo $this->lang->line(18) ?>
            </div>

        </div>
    </div>


    <script> function fn_spread(id){ var getID = document.getElementById(id); getID.style.display=(getID.style.display=='block') ? 'none' : 'block'; } </script>

        <!--퍼백서 내용끝//-->

        <!--다운로드버튼-->
        <ul class="bt">
            <li>
                <a href="<?php echo base_url('/About/Down_whitepaper/ko')?>" class="btn1 btn_black">KOR DOWNLOAD</a>
            </li>
            <li>
                <a href="<?php echo base_url('/About/Down_whitepaper/en')?>"  class="btn1 btn_yellow">ENG DOWNLOAD</a>
            </li>
        </ul><!--다운로드버튼끝//-->
       

</div>