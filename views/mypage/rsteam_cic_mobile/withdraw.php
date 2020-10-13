<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 

    $mem_id = $this->member->is_member();
    $_total_point =  $this->Point_model->get_point_sum($mem_id);
?>


<!--advertising 팝업-->
<div class="popup popup_content popup_youtube" id="popup_youtube">
    <div class="head">
        <label class="ttl-popup"><?=$this->lang->line(0)?></label>
    </div>
    <div class="body"> 
        <!--자동재생되는 광고 또는 광고이미지 들어올영역--> <!--이미지ALT = <?=$this->lang->line(1)?>-->
        <div class="frame"> 
            <iframe width="100%" height="90%" src="https://www.youtube.com/embed/<?php echo element('ad_url',$advertise)?>?controls=0&rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
    <div class="foot">
        <!--withdraw_ing 출금 로딩시 보여질것--> 
        <div class="withdraw_ing" style="display:block;">
            <p><?=$this->lang->line(2)?></p>
            <div id="loading"></div> <!--loading 프로그레스 로딩바-->
            <small><?=$this->lang->line(3)?></small>
        </div>
        <!--//withdraw_ing 출금 로딩시 보여질것--> 

        <!--withdraw_done 출금 로딩후 보여질것-->
        <div class="withdraw_done" style="display:none;">
            <p><?=$this->lang->line(4)?></p>
            <input class="btn custom-close" type="button" value="<?=$this->lang->line(5)?>" onclick="close_and_reload()"/>
        </div>
         <!--//withdraw_done 출금 로딩후 보여질것-->
    </div>
</div>
<!--//advertising 팝업-->

<!--mypage-->
<div id="mypage">
  <h3><?=$this->lang->line(6)?></h3>
       <!--my_right_box-->
       <div id="my_right_box">
            <h5><?=$this->lang->line(7)?></h5> <!--마이페이지 상세 타이틀-->
              <h6><?=$this->lang->line(8)?></h6>
                <ul class="ul_write">
                      <li>
                          <span><?=$this->lang->line(9)?></span>
                          <div class="my_cont">
                          <i class="per_p"></i> <strong class="point"><?php echo number_format($_total_point,1)?></strong> <?=$this->lang->line(10)?>
                          </div>
                      </li>
                      <li>
                          <span><?=$this->lang->line(11)?></span>
                          <div class="my_cont">
                              <input type="text" name="withdraw_point" placeholder="<?=$this->lang->line(12)?>" style="width:160px;" /> <?=$this->lang->line(10)?>
                          </div>
                      </li>
                 </ul>

                 <div class="btn_box2">
                    <a href="#" id="adpop" class="btn1 btn_black"><?=$this->lang->line(13)?></a>  <!--클릭시 광고 시청 로딩 팝업뜰것-->
                </div>

                <!--출금요청현황-->
                 <h6><?=$this->lang->line(14)?></h6>
                    <!--mob_list_table 모바일 테이블-->
                    <ul class="mob_list_table">
<?php foreach($withdraw_list AS $l){ ?>
                    <li>
                        <dl>
                            <dt><?=$this->lang->line(15)?></dt>
                            <dd><span><?=$this->lang->line(16)?></span> <?php echo date('Y.m.d H:i', strtotime($l['jud_wdate']))?></dd>
                            <dd><span><?=$this->lang->line(17)?></span> <i class="per_p"></i><b><?php echo $l['jud_point'] ?></b> <?php echo $this->lang->line(10)?></dd>
                        </dl>
                        <div class="table_bottom">
                            <span <?php echo $l['jud_state'] == 0 ? 'class="reject tooltip tooltip-default" data-content="'.html_escape($l['judn_reason']).'"' : 'class="judge"' ?>><?php echo $l['state']?></span>
                        </div>
                    </li>
<?php } ?>
<?php if(!$withdraw_list) {?> 
                    <!--신청 히스토리가 없을때 nothing-->
                    <li class="nothing"> 
                    <?=$this->lang->line(20)?>
                    </li>
<?php } ?>
                </ul>
                <!--//mob_list_table 모바일 테이블--> 
                <!--추후에 리스트 페이지네이션 필요-->
                <?php echo $paging ?>
          </div>
          <!--//my_right_box-->
</div>
<!--//mypage-->




<script>

    $('.tooltip-default').tooltip();
    $('.tooltip-custom').tooltip({
        position: 'right',
        contentBGColor: '#009688',
        labelColor: '#009688'
    });

$("input[name=withdraw_point]").bind("change keyup input",function(){
    $(this).val( $(this).val().replace(/[^0-9.]/g,"") );
});
$(document).ready(function(){
    $('#adpop').on('click', function(){
        let withdraw_point = $("input[name=withdraw_point]").val(); 
        let total_point = <?php echo $_total_point?>;

        if(!$.isNumeric(withdraw_point) || withdraw_point <= 0){
            alert('<?php echo $this->lang->line(21)?>');
            $("input[name=withdraw_point]").focus();
            return false;
        }
        if(withdraw_point > total_point){
            alert('<?php echo $this->lang->line(22)?>');
            $("input[name=withdraw_point]").focus();
            return false;
        }
        $('.popup_youtube').lightlayer( {escape : false} );
        yt_play_start($(".frame"));
        $('.popup_youtube').lightlayer();
        $("#loading").progressBarTimer({ 
            timeLimit: 20,
            warningThreshold: 5,
            autostart: true,
            warningStyle: 'bg-danger',   
            // smooth: true,
            completeStyle: 'bg-success',
            label : { show: true, type: 'seconds' } ,
            onFinish  : function () { 
                Complete_withdraw();
            }
        }).start();
    });
});

function Complete_withdraw(){
    let withdraw_point = $("input[name=withdraw_point]").val(); 
    $.ajax({
        url : "<?php echo base_url('mypage/ajax_withdraw')?>",
        type : "POST",
        dataType: "json",
        data : {
            <?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash()?>',
            withdraw_point : withdraw_point
        },
        success : function(result){
            if(result != 'fail'){
                $('.withdraw_ing').css('display', 'none');
                $('.withdraw_done').css('display', 'block');
            }
        }
    });
}

//썸네일 호버링 끝 작동 함수
function yt_play_start(obj){
    let this_iframe = $(obj).find('iframe');
    if(this_iframe){
        let this_iframe_src = this_iframe.attr('src');
        this_iframe.attr('src',this_iframe_src+'&autoplay=1');
    }
}


function close_and_reload(){
$.lightlayer().exit();
window.location.reload(true);
}
</script>