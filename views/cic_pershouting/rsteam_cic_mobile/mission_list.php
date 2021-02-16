<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php 
    // 마감 시간
    $_now = time();
    $_endTime = strtotime(element('mis_enddate', $mission_data));
    $_timer_time = $_endTime - $_now;
    if($_timer_time < 0){
        $_timer_time = 0;
    }
?> 

<!---Per Shouting List--->
<!--서브메뉴-->
<!-- <div id="sub_menu">
    <ul> 
        <li><a href="#" class="on">PER SHOUTING</a></li> 
    </ul>
</div> -->
<!--//서브메뉴-->
<!--퍼샤우팅 shouting_all-->
<div id="shouting_all">
    <!--sc_top 퍼샤우팅 탭메뉴-->
    <div class="sc_top">
        <?php echo $this->lang->line(0)?>
        <ul>
            <li><a <?php echo !element('state',$this->input->get()) ? 'class="on"' : ''?> onclick="searchShouting('')"><?php echo $this->lang->line(2) ?></a></li>    <!--클릭시 .on 추가해주시면 됩니당 (불들어오는효과)-->
            <li><a <?php echo element('state',$this->input->get()) == 'process' ? 'class="on"' : ''?> onclick="searchShouting('process')"><?php echo $this->lang->line(3) ?></a></li>
            <li><a <?php echo element('state',$this->input->get()) == 'end' ? 'class="on"' : ''?> onclick="searchShouting('end')"><?php echo $this->lang->line(4) ?></a> </li>
            <li><a <?php echo element('state',$this->input->get()) == 'planned' ? 'class="on"' : ''?> onclick="searchShouting('planned')"><?php echo $this->lang->line(5) ?></a></li>
        </ul>
        <div class="search_area"> 
        <?php echo form_open('',array('method' => 'get'));?>
            <input type="text" name="search"  id="search" placeholder="<?php echo $this->lang->line(1) ?>" value="<?php echo element('search',$this->input->get())?>"/>
            <input type="hidden" id="state" name="state" value="<?php echo element('state',$this->input->get());?>">
            <button type="button" onclick="searchShouting()"><i class="fas fa-search"></i></button>
        <?php echo form_close();?>
        </div>
    </div>
    <!--//sc_top 퍼샤우팅 탭메뉴-->

    <!--sc_b 리스트 시작-->
    <div class="sc_b">
        <ul class="list_box" >
            <!--0928 추가 검색어가 없을때, 미션글이 없을때-->
<?php if(!count($view['data']['list'])){ ?><li class="nothing"> <?php echo $this->session->userdata('lang') == 'korean' ? '등록된 미션이 없습니다.' : 'Not Found Mission'?> </li><?php }?>
            <!--검색어가 없을때, 미션글이 없을때-->
<?php foreach($view['data']['list'] AS $d){ // 여기서부터 li 닫는데까지 반복해서 li 만들어줌?>
            <li class="
              <?php 
                switch($d['state']){
                    case $this->lang->line('c_2') :
                        echo 'lock';
                        $state = 'lock';
                        $start_day = time();
                        $end_day = strtotime(element('mis_opendate',$d));
                        $realterm = strtotime(element('mis_enddate',$d)) - strtotime(element('mis_opendate',$d));
                    break;
                    case $this->lang->line('c_1') :
                        $state = false;
                        echo 'endgame';
                        $start_day = 0;
                        $end_day = 0;
                    break;
                    default :
                        $state = true;
                        $start_day = time();
                        $end_day = strtotime(element('mis_enddate',$d));
                }
              ?>
              ">   <!--일단 여기는 일반 미션진행중인 글입니다. 오픈예정: class="lock"  미션마감: class="endgame"-->
    <!--thumnail-->
                <div class="thumnail" onmouseover="thumbnail_enter(this)" onmouseout="thumbnail_out(this)">
                        <?php
                        //시간을 마감에 사용하지 않으면 타이머 표시 X
                        if($d['state'] == $this->lang->line('c_2') || ($d['mis_endtype'] > 0 && $d['mis_endtype'] < 3)){
                        ?>
                        <div class="time_box">
                        <?php
                            $countdown_on = ($d['state'] == $this->lang->line('c_2') || $d['mis_endtype'] == '1' || $d['mis_endtype'] == '2') && $d['state'] != $this->lang->line('c_1');
                                            //오픈예정이거나                            마감형식이 날짜를 활용하는 경우 이고,                    //상태가 마감이 아닌 경우 카운트다운 사용
                            if($d['state'] == $this->lang->line('c_2')){
                                //오픈예정의 경우
                        ?>
                            <h1 class='timer <?php echo $countdown_on ? 'countdown' : ''; ?>' data-state="planned" data-fixTime='{"Seconds": "<?php echo $end_day-$start_day; ?>"}' data-realTerm='{"Seconds": "<?php echo $realterm; ?>"}' data-isend="false" data-processText='<?php echo $this->lang->line('c_3') ?>' data-endText='<?php echo $this->lang->line('c_1') ?>' data-hidden="<?php echo $d['mis_per_token']; ?>" data-page="list">
                                <div class="running">
                                    <timer>
                                        <span class="days">00</span>:<span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span>
                                    </timer>
                                </div>
                            </h1>
                            <section class='actions'></section>
                        <?php
                            } else {
                                //진행중인 경우
                        ?>
                            <h1 class='timer <?php echo $countdown_on ? 'countdown' : ''; ?>' data-state="process" data-fixTime='{"Seconds": "<?php echo $end_day-$start_day; ?>"}' data-isend="false" data-endText='<?php echo $this->lang->line('c_1') ?>' data-page="list">
                                <div class="running">
                                    <timer>
                                        <span class="days">00</span>:<span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span>
                                    </timer>
                                </div>
                            </h1>
                            <section class='actions'></section>
                        <?php
                            }
                        ?>
                        </div>   
                        <?php
                        }
                        ?>
                        <a href="<?php echo base_url('Mission/detailMission/'.$d['mis_id'])?>">
                            <span class="opacity"> </span>
<?php if(element('mis_thumb_type', $d) == 1 &&  $d['state'] != $this->lang->line('c_1')){ ?>
                            <img 
                                src="<?= thumb_url('mission_thumb_img', element('mis_thumb_image', $d), 400, 300)?>" 
                                alt="<?=element('mis_thumb_image', $d)?>"
                                class=""
                            />
<?php }else if(element('mis_thumb_type', $d) == 2 && $d['state'] != $this->lang->line('c_1') ){ ?>
                            <iframe src="https://www.youtube.com/embed/<?=rs_get_YT_id(element('mis_thumb_youtube',$d))?>?mute=1&controls=0&rel=0" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
<?php }else if($d['state'] == $this->lang->line('c_1')){ ?>
                            <img 
                                src="<?php echo thumb_url('tmp', 'closed.png', 400, 300)?>" 
                                alt="<?=element('mis_thumb_image', $d)?>"
                                class=""
                            />
<?php } ?>
                        </a>  
                </div>
    <!--//thumnail-->
                <div class="txt_box">
                    <div class="txt_t">
                        <span class="yet">
                            <?=$d['state']?>
                        </span>
                        <!-- <span class="icon">안녕</span> -->
                        <h3>
                            <img src="<?php echo base_url('assets/images/sub_01_point_logo.png');?>" alt="<?php echo $this->lang->line(6)?>"/>
                            <b><?php echo ($state === true || $state === false) ? number_format($d['mis_per_token']) : 'HIDDEN'?></b> PER POINT
                        </h3>
                    </div>
                    <div class="misson_t">
                        <a href="<?php echo base_url('Mission/detailMission/'.$d['mis_id'])?>">
                            <h2>
                            [MISSION] <?php echo $this->session->userdata('lang') == 'korean' ? $d['mis_title'] : $d['mis_title_en']?>
                            </h2>

                            <?php //echo mb_substr(strip_tags($this->session->userdata('lang') == 'korean' ? $d['mis_content'] : $d['mis_content_en']), 0, 100)?>
                            <?php if(element('wht_attach', $d)){ ?>
                        <img src="<?php echo thumb_url('wht_attach', element('wht_attach', $d)); ?>" class="icon" />
                        <?php } ?>
                        </a>                            
                    </div>                   
                </div>
            </li>
<?php } ?>     
        </ul>
        <div class="page">
            <?php echo element('paging', $view); ?>
        </div>
    </div>
    <!--//sc_b 리스트 끝-->
</div>
<!--//퍼샤우팅 shouting_all-->

<script src="/assets/js/multi-countdown.js?v=2"></script>
<script>
    //미션 검색
    function searchShouting(state = false){
        if(state !== false){
            $("#state").val(state);
        }
        $("form").submit();
    }

    //타이머 설정 함수
    // $(document).ready(function(){
    //     var timers = $(".timer");

    //     $(function(){
    //         $.each(timers, function(index, element){
    //             let start_day = $(element).attr('data-start-day');
    //             let end_day = $(element).attr('data-end-day');
    //             $(element).attr('data-seconds-left', end_day-start_day);
    //         });
    //         timers.startTimer({
    //             onComplete: function(element){
    //                 $('html, body').addClass('bodyTimeoutBackground');
    //             }
    //         })
    //     });
    // });

    //썸네일 호버링시 작동 함수
    function thumbnail_enter(obj){
        let this_iframe = $(obj).find('iframe');
        console.log(this_iframe);
        if(this_iframe){
            let this_iframe_src = this_iframe.attr('src');
            this_iframe.attr('src',this_iframe_src+'&autoplay=1');
        }
    }

    //썸네일 호버링 끝 작동 함수
    function thumbnail_out(obj){
        let this_iframe = $(obj).find('iframe');
        if(this_iframe){
            let this_iframe_src = this_iframe.attr('src');
            let autoplay_index = this_iframe_src.lastIndexOf('&autoplay=1');
            if(autoplay_index >= 0){
                this_iframe_src = this_iframe_src.substr(0, autoplay_index);
                this_iframe.attr('src',this_iframe_src);
            }
        }
    }
</script>
