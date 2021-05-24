<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php 
    //마감 시간 설정
    $_now = time();
    $_endTime = strtotime(element('mis_enddate', $mission_data));
    $_timer_time = $_endTime - $_now;
    if($_timer_time < 0){
        $_timer_time = 0;
    }
    $end_type = element('mis_endtype', $mission_data);
    $mission_state = element('state',$mission_data);
?>
<!---Per Shouting Detail--->

<!--퍼샤우팅 shouting_all-->
<div id="shouting_all" class="scrollTop">
    <!--sc_top 퍼샤우팅 탭메뉴-->
    <div class="sc_top">
       <?php echo $this->lang->line(0) ?>
        <ul>
            <li><a onclick="searchShouting('')"><?php echo $this->lang->line(2) ?></a></li>
            <li><a onclick="searchShouting('process')"><?php echo $this->lang->line(3) ?></a></li>
            <li><a onclick="searchShouting('end')"><?php echo $this->lang->line(4) ?></a> </li>
            <li><a onclick="searchShouting('planned')"><?php echo $this->lang->line(5) ?></a></li>
            <li><a onclick="searchShouting('urgent')"><?php echo $this->lang->line('urgent')?></a></li>
        </ul>
        <div class="search_area"> 
        <?php echo form_open('/Mission',array('method' => 'get'));?>
            <input type="text" name="search"  id="search" placeholder="<?php echo $this->lang->line(1) ?>" value="<?php echo element('search',$this->input->get())?>"/>
            <input type="hidden" id="state" name="state" value="<?php echo element('state',$this->input->get());?>">
            <button type="button" onclick="searchShouting()"><i class="fas fa-search"></i></button>
        <?php echo form_close();?>
        </div>   
    </div>
    <!--//sc_top 퍼샤우팅 탭메뉴-->
    <div class="sc_b">
        <div class="event_content_all">
            <dl class="event_title">
                <dt>
                    <p>[MISSION] <?php echo $this->session->userdata('lang') == 'korean' ? element('mis_title',$mission_data) : element('mis_title_en',$mission_data)?></p>
                </dt>
                <dd>
 
                    <u id="mis_state"><?php echo $mission_state == 'end' ? $this->lang->line(12) : $this->lang->line(6); ?></u>
                    <?php if(element('wht_attach', $mission_data)){ ?>
                    <img src="<?php echo thumb_url('wht_attach', element('wht_attach', $mission_data)); ?>" class="icon" />
                    <?php }?>
                    <ul class="detail_title">
                        <li>               
                            <strong>
                            <img src="<?php echo base_url('assets/images/sub_01_point_logo2.png');?>" alt="<?php echo $this->lang->line(6)?>"/>
                            <b><?php echo number_format(element('mis_per_token',$mission_data))?></b> PER POINT
                            </strong>
                        </li>
                        <!-- <li>
                            <?php //echo $this->lang->line(7) ?> <b><?php //echo number_format(element('mis_max_point',$mission_data))?></b> SUPER POINT
                        </li> -->
                    </ul>    
                </dd>       
            </dl>
            <div class="write">
            <?php if( element('mis_thumb_youtube',$mission_data)){?>
                <div class="event_main">
                    <iframe width=100% height=100% src="https://www.youtube.com/embed/<?php echo rs_get_YT_id(element('mis_thumb_youtube', $mission_data))?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            <?php }?>
                    <?php echo $this->session->userdata('lang') == 'korean' ? element('mis_content',$mission_data) : element('mis_content_en',$mission_data)?>
            </div>            
        </div>                 
    </div>
</div>
<!--//퍼샤우팅 shouting_all-->

<!--타임 div-->
<div id="time_btn_bar">
    <div class="time_bar_cont">
<?php if($mission_state != 'end'){  ?>
<?php if( $mission_state == 'urgent') {?>
        <!-- 마감 안됐을 때 -->
        <div class='time_box' id="ing_div_tag">
            <div class="time_label">
                <small>Days</small>
                <small>Hours</small>
                <small>Minutes</small>
                <small>Seconds</small>
            </div>
            <h1 class='timer countdown' data-state="process" data-fixTime='{"Seconds": "<?php echo $_timer_time; ?>"}' data-endText='<?php echo $this->lang->line("12"); ?>' data-isend='<?php echo $mission_state != 'end' ? 'false' : 'true'; ?>' data-page="detail">                                
                <div class="running">
                    <timer>
                        <span class="days">00</span>:<span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span>
                    </timer>
                </div>
            </h1>
            <section class='actions'></section>
        </div>
        
        <!-- 마감 됐을 때 -->
        <p class="m_txt" id="end_p_tag" style="display:none;">
            <?php echo $this->lang->line(9)?>
        </p>
<?php }else if($mission_state == 'process'){?>
        <!-- 타임 설정 없을시-->
        <p class="m_txt">
            <?php echo $this->lang->line(8)?>
        </p>
        <!-- //타임 설정 없을시-->
<?php } ?>
        <!-- 마감 안됐을 때 -->
        <a href="<?php echo base_url('Mission/applyMission/'.element('mis_id', $mission_data))?>" id="ing_a_tag" class="btn1 btn_mission" ><?php echo $this->lang->line(10)?></a>
        <!-- 마감 됐을 때 -->
        <a href="<?php echo base_url('Mission')?>" class="btn1 btn_mission" id="end_a_tag" style="display:none;"><?php echo $this->lang->line(11)?></a>
<?php }else{ ?>
        <p class="m_txt">
            <?php echo $this->lang->line(9)?>
        </p>
        <a href="<?php echo base_url('Mission')?>" class="btn1 btn_mission" ><?php echo $this->lang->line(11)?></a>
<?php }?>
    </div>
</div>






<script src="/assets/js/multi-countdown.js"></script>
<script type="text/javascript">
 $("#time_btn_bar").css('display','block');
    var mis_end_type = '<?php echo $end_type; ?>';

    $(window).on("scroll",function(){
        var scrollBottom = parseInt(window.innerHeight)+parseInt($(this).scrollTop());
        var scrollFixed  = parseInt($("#time_btn_bar").offset().top);
        var scrollTop	 = parseInt($(".scrollTop").offset().top);
        var footer		 = parseInt($("#footer").offset().top);

        var num = scrollBottom - footer
        if(scrollBottom >= footer){
            $("#time_btn_bar").css('bottom',num+'px');
        }else{
            $("#time_btn_bar").css('bottom','0px');
        }
        console.log('scrollTop : '+ scrollTop);
        console.log('Now ScrollTop : '+$(this).scrollTop());
    });

    function searchShouting(state = false){
        if(state !== false){
            $("#state").val(state);
        }
        $("form").submit();
    }
</script>
