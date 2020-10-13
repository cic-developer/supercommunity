<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 

    $mem_id = $this->member->is_member();
    $_total_point =  $this->Point_model->get_point_sum($mem_id);
?>

<!--마이페이지> 내정보 >출금요청-->
<!--서브메뉴 헤더에서받아옴-->

<!--advertising 팝업-->
<div class="popup popup_content popup_youtube" id="popup_youtube">
    <div class="head">
        <label class="ttl-popup"><?php echo $this->lang->line(0)?></label>
    </div>
    <div class="body"> 
        <!--자동재생되는 광고 또는 광고이미지 들어올영역-->
        <div class="frame"> 
        <?php if(element('ad_type',$advertise) == 1){ ?>
            <img id='ad_img' src="<?php echo thumb_url('advertise', element('ad_url', $advertise))?>" alt="<?php echo $this->lang->line(1)?>" title="<?php echo $this->lang->line(1)?>"/>
        <?php }else if(element('ad_type',$advertise) == 2){ ?>
            <iframe width="800" height="400" src="https://www.youtube.com/embed/<?php echo element('ad_url',$advertise)?>?controls=0&rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <?php }?>
        </div>
    </div>
    <div class="foot">
        <!--withdraw_ing 출금 로딩시 보여질것--> 
        <div class="withdraw_ing">
            <p><?php echo $this->lang->line(2)?></p>
            <div id="loading"></div> <!--loading 프로그레스 로딩바-->
            <small><?php echo $this->lang->line(3)?></small>
        </div>
        <!--//withdraw_ing 출금 로딩시 보여질것--> 

        <!--withdraw_done 출금 로딩후 보여질것-->
        <div class="withdraw_done" style="display:none;">
            <p><?php echo $this->lang->line(4)?></p>
            <input id="custom_close" class="btn custom-close" type="button" value="<?php echo $this->lang->line(5)?>" onclick="close_and_reload()"/>
        </div>
         <!--//withdraw_done 출금 로딩후 보여질것-->
    </div>
</div>
<!--//advertising 팝업-->
       
       <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
       <div id="my_right_box">
            <h5><?php echo $this->lang->line(6)?></h5> <!--마이페이지 상세 타이틀-->
            <!--my_cont_area-->
            <div class="my_cont_area">
              <h6><?php echo $this->lang->line(7)?></h6>
                <ul class="ul_write">
                      <li>
                          <span><?php echo $this->lang->line(8)?></span>
                          <div class="my_cont">
                          <i class="per_p"></i> <strong class="point"><?php echo number_format($_total_point,1)?></strong> <?php echo $this->lang->line(9)?>
                          </div>
                      </li>
                      <li>
                          <span><?php echo $this->lang->line(10)?></span>
                          <div class="my_cont">
                              <input type="text" name="withdraw_point" placeholder="<?php echo $this->lang->line(11)?>" /> <?php echo $this->lang->line(9)?>
                          </div>
                      </li>
                 </ul>

                 <div class="btn_box2">
                    <a href="#" id="adpop" class="btn1 btn_black"><?php echo $this->lang->line(12)?></a>  <!--클릭시 광고 시청 로딩 팝업뜰것-->
                </div>

                <h6><?php echo $this->lang->line(13)?></h6>
                <table cellpadding="0" cellspacing="0" width="100" class="list_table">
                        <colgroup>
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                            <th><?php echo $this->lang->line(14)?></th>
                            <th><?php echo $this->lang->line(15)?></th>
                            <th><?php echo $this->lang->line(16)?></th>
                        </thead>
                        <tbody>
<?php foreach($withdraw_list AS $l){ ?>
                        <tr>
                            <td><?php echo date('Y.m.d H:i', strtotime($l['jud_wdate']))?></td>
                            <td><i class="per_p"></i><b><?php echo $l['jud_point'] ?></b> <?php echo $this->lang->line(9)?></td> <!--퍼포인트 아이콘-->
                            <td><span <?php echo $l['jud_state'] == 0 ? 'class="reject tooltip tooltip-default" data-content="'.html_escape($l['judn_reason']).'"' : 'class="judge"' ?>><?php echo $l['state']?></span></td>
                        </tr>        
<?php } ?>
<?php if(!$withdraw_list) {?> 
                        <tr>
                            <td colspan="3"><?php echo $this->lang->line(17)?></td>
                        </tr>
<?php } ?>
                </table>     
                    <!--추후에 페이지네이션-->
                    <?php echo $paging ?>
              </div>     
              <!--my_cont_area-->
          </div>
          <!--//페이지별 변경되는 오른쪽 영역 page_right_box-->
</div>
<!--//마이페이지 레이아웃 mypage-->




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
            let total_point = <?php echo $_total_point ? $_total_point : 0?>;

            if(!$.isNumeric(withdraw_point) || withdraw_point <= 0){
                alert('<?php echo $this->lang->line(18)?>');
                $("input[name=withdraw_point]").focus();
                return false;
            }
            if(withdraw_point > total_point){
                alert('<?php echo $this->lang->line(19)?>');
                $("input[name=withdraw_point]").focus();
                return false;
            }
            $('.popup_youtube').lightlayer( {escape : false} );
            yt_play_start($(".frame"));
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

    });

    function close_and_reload(){
        $.lightlayer().exit();
        window.location.reload(true);
    }
</script>