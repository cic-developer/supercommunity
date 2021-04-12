<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css');

    $this->load->model('Member_extra_vars_model');
    $wallet_addr = element('meta_wallet_address', $this->Member_extra_vars_model->get_all_meta($this->member->is_member()));
    $_is_super = ($this->member->group()[0]['mgr_id'] == 1) ? false : true;
?>
<!--마이페이지-3 :: 미션인증현황-->

        <!--페이지별 변경되는 오른쪽 영역 page_right_box-->
        <div id="my_right_box">
            <h5><?=$this->lang->line(0)?></h5> <!--마이페이지 상세 타이틀-->
            <!--my_cont_area-->
            <div class="my_cont_area">
            <h6><?=$this->lang->line(1)?></h6>
                <?php
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash'  => $this->security->get_csrf_hash()
                    );
                ?>
                <?php echo form_open_multipart(''); ?>
                    <table cellpadding="0" cellspacing="0" width="100" class="list_table">
                        <colgroup>
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                            <th><?=$this->lang->line(2)?></th>
                            <th><?=$this->lang->line(3)?></th>
                            <th><?=$this->lang->line(4)?></th>
                        </thead>
                        <tbody>

                      
                        <?php foreach($view['judList'] AS $data){?>
                            <tr>
                                <td><?=$this->session->userdata('lang') == 'korean' ? $data['mis_title'] : $data['mis_title_en']?></td>
                                <td>
                            <?php echo $_is_super ? '<span class="tooltip tooltip-default" data-content="['.$this->lang->line(5).']">' : '' ?>
                                    <i class="per_p"></i>
                                    <b><?php echo $data['jud_state'] == 5? number_format($data['jud_expected_value'],1) : "0" ?></b>
                            <?php echo $_is_super ? '</span>' : '' ?>
                                </td>
                                <?php 
                                switch($data['jud_state']){ 
                                    case 0 : 
                                        echo    '<td><span class="reject tooltip tooltip-default" data-content="'.$data['judn_reason'].'">
                                                <i class="fa fa-question-circle"></i> '.$data['jud_ko_state'].'</span></td>';
                                    break;
                                    case 1 : 
                                        echo "<td>".$data['jud_ko_state']."</td>";
                                    break;
                                    case 3 : 
                                    case 5 : 
                                        echo  '<td><span class="judge">'.$data['jud_ko_state'].'</span></td>';
                                    break;
                                }
                                ?>
                        <?php }?>

                            </tr>
                        <?php if(!$view['judList']){?>
                            <tr>
                                <td colspan="3"><?=$this->lang->line(6)?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
<?php echo form_close(); ?>
                    <!--추후에 페이지네이션-->
                    <?php echo element('paging', $view); ?>
                     <!--추후에 페이지네이션-->
            </div>
            <!--//my_cont_area-->  
            <div class="wallet_link">
                <p><?=$this->lang->line(7)?></p>
                <!-- <span>PER토큰 지갑주소 등록하기</span> 지갑주소가 없는경우-->
<?php if($wallet_addr){ ?>
                <span><b><?=$this->lang->line(8)?></b> <?=$wallet_addr?></span> <!--지갑주소가 있는경우-->
<?php }else { ?>
                <a href="<?=base_url('/mypage')?>" class="btn1 btn_yellow"><?=$this->lang->line(9)?></a>  <!--주소등록 안됐을경우 '지갑주소 등록'-->
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