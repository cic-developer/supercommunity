<?php echo $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div id="white_wrap">
    <!--퍼백서 타이틀-->
    <h3>WHITE PAPER</h3>
    <!--퍼백서 타이틀//-->

    <!--퍼백서 내용 시작-->
    <div class="white_content">
        <div class="white_top">
            <?php echo $this->lang->line(0) ?>
        </div> 
        
        <!-- <i class="fas fa-chevron-down" onclick="document.getElementById('hiddenContent01').style.display=(document.getElementById('hiddenContent01').style.display=='block') ? 'none' : 'block';">
        <?php //echo $this->lang->line(1) ?></i>
        <div class="white_b" id="hiddenContent01" style="display: none;">
            <div class="content_area">
                <?php //echo $this->lang->line(2) ?>
            </div>

            <div class="content_area">
                <?php //echo $this->lang->line(3) ?>
            </div>

            <div class="content_area">
                <?php //echo $this->lang->line(4) ?>   
            </div>

            <div class="content_area">
                <?php //echo $this->lang->line(5) ?>   
            </div>

            <div class="content_area">
                <?php //echo $this->lang->line(6) ?>
            </div>

            <div class="content_area">
                <?php //echo $this->lang->line(7) ?>   
            </div>
            <div class="content_area">
                <?php //echo $this->lang->line(8) ?>       
            </div>

        </div> -->
    </div>


    <script> function fn_spread(id){ var getID = document.getElementById(id); getID.style.display=(getID.style.display=='block') ? 'none' : 'block'; } </script>

        <!--퍼백서 내용끝//-->

        <!--다운로드버튼-->
        <ul class="bt">
            <li>
                <a href="<?php echo base_url('/About/Down_whitepaper/ko')?>" class="btn1 btn_black">KOR DOWNLOAD</a>
            </li>
            <li>
                <a href="<?php //echo base_url('/About/Down_whitepaper/en')?>" class="btn1 btn_black" onclick="alert('준비중입니다.')">ENG DOWNLOAD</a>
            </li>
        </ul><!--다운로드버튼끝//-->
       

</div>