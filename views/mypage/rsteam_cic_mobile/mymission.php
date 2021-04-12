<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
    
    $this->load->model('Member_extra_vars_model');
    $wallet_addr = element('meta_wallet_address', $this->Member_extra_vars_model->get_all_meta($this->member->is_member()));
?>

<!--마이페이지-3 :: 미션인증현황-->
<!--mypage-->
<div id="mypage">
  <h3><?=$this->lang->line(0)?></h3>
        <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
        <div id="my_right_box">
            <h5><?=$this->lang->line(1)?></h5> <!--마이페이지 상세 타이틀-->
            <h6><?=$this->lang->line(2)?></h6>
                <?php
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash'  => $this->security->get_csrf_hash()
                    );
                ?>
                <?php echo form_open_multipart(''); ?>
                <!--mob_list_table-->  <!--최대한 유지하면서 변경했으나 레이아웃 깨짐없이 잘 나오는지 경우의수 전부 테스트 해봐야함-->
                 <ul class="mob_list_table"> 
                    <?php foreach($view['judList'] AS $data){?>
                    <li>
                        <dl>
                            <dt><?=$this->lang->line(3)?>: <?=$this->session->userdata('lang') == 'korean' ? $data['mis_title'] : $data['mis_title_en']?></dt>
                            <dd><span><?=$this->lang->line(4)?></span> <i class="per_p"></i><b><?php echo $data['jud_state'] == 5? number_format($data['jud_expected_value'],1) : "0" ?></b></dd>
                        </dl>
                        <div class="table_bottom">
                            <?php 
                            switch($data['jud_state']){ 
                                case 0 : 
                                    echo    '<span class="reject tooltip tooltip-default" data-content="'.$data['judn_reason'].'">
                                            <i class="fa fa-question-circle"></i> '.$data['jud_ko_state'].'</span>';
                                break;
                                case 1 : 
                                    echo "<span>".$data['jud_ko_state']."</span>";
                                break;
                                case 3 : 
                                case 5 : 
                                    echo  '<span class="judge">'.$data['jud_ko_state'].'</span>';
                                break;
                            }
                            ?>
                        </div>
                    <?php }?>
                    </li>
                    <?php if(!$view['judList']){?>
                        <li class="nothing">
                        <?=$this->lang->line(5)?>
                            </li>
                    <?php } ?>
                </ul>
                <!--//mob_list_table--> 
                
                <!--모바일 mob_list_table 원본
                <ul class="mob_list_table">
                    <li>
                        <dl>
                            <dt>참여미션: 테스트미션어쭈구하자</dt>
                            <dd><span>지급예정 토큰</span> <i class="per_p"></i><b>123456</b></dd>
                        </dl>
                        <div class="table_bottom">
                            <span class="reject tooltip tooltip-default" data-content="절대 안됩니다 승인불강쇼">
                            <i class="fa fa-question-circle"></i>비승인</span>
                        </div>
                    </li>
                    <li>
                        <dl>
                            <dt>참여미션: 테스트미션어쭈구하자</dt>
                            <dd><span>지급예정 토큰</span> <i class="per_p"></i><b>123456</b></dd>
                        </dl>
                        <div class="table_bottom">
                            <span>승인</span>
                        </div>
                    </li>
                    <li>
                        <dl>
                            <dt>참여미션: 테스트미션어쭈구하자</dt>
                            <dd><span>지급예정 토큰</span> <i class="per_p"></i><b>123456</b></dd>
                        </dl>
                        <div class="table_bottom">
                            <span class="judge">심사중</span>
                        </div>
                    </li>
                    <li class="nothing">
                        미션인증현황이 없숨다
                    </li>
                </ul>       
                //모바일 mob_list_table 원본-->

<?php echo form_close(); ?>
                    <!--추후에 페이지네이션-->
                    <?php echo element('paging', $view); ?>
                     <!--추후에 페이지네이션-->
                <div class="wallet_link">
                <p><?=$this->lang->line(6)?></p>
                <!-- <span>PER토큰 지갑주소 등록하기</span> 지갑주소가 없는경우-->
<?php if($wallet_addr){ ?>
                <span><b><?=$this->lang->line(7)?></b> <?=$wallet_addr?></span> <!--지갑주소가 있는경우-->
<?php }else { ?>
               <div> <a href="<?=base_url('/mypage')?>" class="btn1 btn_yellow"><?=$this->lang->line(8)?></a> </div><!--주소등록 안됐을경우 '지갑주소 등록'<?=$this->lang->line(9)?>-->
<?php } ?>
            </div>
        </div>
        <!--//my_right_box-->
    </div>
    <!--//마이페이지 레이아웃 mypage-->

<script>
    $(document).ready(function(){
        let validation_err = '<?=isset($validation_err) ? $validation_err : '' ?>';
        if(validation_err){
            alert(validation_err);
        }
    });

    $('.tooltip-default').tooltip();
    $('.tooltip-custom').tooltip({
				position: 'right',
				contentBGColor: '#009688',
				labelColor: '#009688'
	});
</script>