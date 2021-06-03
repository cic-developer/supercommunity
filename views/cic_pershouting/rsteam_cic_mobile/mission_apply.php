<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<?php
$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash'  => $this->security->get_csrf_hash()
);
?>

<!--퍼샤우팅:: 마이페이지 > 미션신청-->
<!--mypage-->
<div id="mypage">
    <h3>MY PAGE</h3>
    <!--my_right_box-->
    <div id="my_right_box">
        <h5><?php echo $this->lang->line(0) ?></h5>
        <h6 class="apply_head">
            <?php echo $this->lang->line(1) ?>
            <small>
                <b><?php echo $this->lang->line(19) ?></b>
                <?php echo $this->lang->line(13) ?><br />
                <?php echo $this->lang->line(14) ?> <br />
                <?php echo $this->lang->line(20) ?>
                <!-- <b><?php //echo $this->lang->line(21)
                        ?></b>
                        <?php //echo $this->lang->line(22)
                        ?><br/>
                        <?php //echo $this->lang->line(23)
                        ?> -->
            </small>
        </h6>
        <?php echo form_open_multipart(''); ?>
        <input type="hidden" name="dummy" value="1" />

        <ul class="mob_list_table">
            <?php
            foreach ($medList as $ml) {
                $media_check = ($ml['jud_state'] == 1 || $ml['jud_state'] == 3); //해당 미디어가 미션 심사 진행 또는 완료된 미디어인지 체크
                $media_comp_check =  ($ml['jud_state'] == 3);
                $expected_point = rs_cal_expected_point2($missionData['mis_per_token'], $missionData['mis_max_point'], $ml['med_superpoint'], $ml); //예상 지급 토큰값
                switch ($ml['jud_state']) {   //심사 상태 표시
                    case 0:    //반려
                        if ($ml['jud_state'] === 0) {
                            $_state = $this->lang->line(16);
                        } else if ($ml['jud_state'] === NULL) {
                            $_state = $this->lang->line(25);
                        }
                        break;
                    case 1:    //심사중
                        $_state = $this->lang->line(17);
                        break;
                    case 3:    //승인
                        $_state = $this->lang->line(15);
                        break;
                    case 5:    //지급완료(사실 이건 나오면 안됨)
                        $_state = $this->lang->line(18);
                        break;
                }
            ?>
                <li>
                    <!---20.10.15 미션신청 상태 버튼(신청가능, 심사중, 승인완료)-->
                    <?php if ($_state) { ?><u class="state"><?php echo $_state ?></u><?php } // 미션 신청 상태가 있는 경우에만 
                                                                                        ?>
                    <dl>
                        <dt><?php echo $this->session->userdata('lang') == 'korean' ? element('mis_title', $missionData) : element('mis_title_en', $missionData); ?></dt>
                        <!--미션명 :: 모바일에서는 환경고려상 물고온 미션이름만 노출함-->
                        <dd><span><?php echo $this->lang->line(2) ?></span> <?= $ml['med_name'] ?></dd>
                        <dd><span><?php echo $this->lang->line(3) ?></span> <?= $ml['med_admin'] ?></dd>
                        <dd><span><?php echo $this->lang->line(4) ?></span> <a target="_blank" href="<?= $ml['med_url'] ?>"><?= $ml['med_url'] ?></a></dd>
                        <!--20.10.14추가수정 포스팅url-->
                        <dd><span><?php echo $this->lang->line(24) ?></span><input class="site_url" type="text" name="post_link[]" value="<?php echo element('jud_post_link', $ml) ?>" <?php echo $media_comp_check ? 'readonly' : '' ?> /></dd>
                        <!-- <dd><span><?php //echo $this->lang->line(5)
                                        ?></span> <i class="super_p"></i><b><?php //echo $ml['med_superpoint']
                                                                            ?></b></dd> -->
                        <dd><span><?php echo $this->lang->line(6) ?></span> </i><b onclick="popup('<?php echo site_url('/Popup/paymentPolicy/' . element('mis_id', $missionData)) ?>')"><?php echo $this->lang->line('paymentPolicy_popup') ?></b></dd>
                    </dl>
                    <div class="table_bottom">
                        <div class="img_area">
                            <small><?php echo $this->lang->line(7) ?></small>
                            <div class="img_check">
                                <img class="<?= $media_comp_check ? 'finish_img' : 'attach_img' ?>" src="<?php echo thumb_url('judge', element('jud_attach', $ml), 400, 300); ?>" alt='<?php echo $this->lang->line(8) ?>' />
                                <input class="jud_attach" accept="image/*" name="jud_attach[]" type="file" style="display:none;">
                            </div>
                        </div>
                        <span>
                            <small><?php echo $this->lang->line(9) ?></small> <br />
                            <input class="applycheck" name="med_id[]" type="checkbox" value="<?= $ml['med_id'] ?>" <?= ($media_check) ? 'checked' : '' ?> onclick="return false" <?= $media_comp_check ? 'disabled' : '' ?>>
                            <input name="all_med_id[]" value="<?= $ml['med_id'] ?>" style="display:none;" />
                        </span>
                    </div>
                </li>

            <?php } ?>
        </ul>
        <div class="btn_box">
            <input type="submit" value="<?php echo $this->lang->line(1) ?>" class="btn1 btn_black" style="White-space: normal;" />
        </div>
        <?php echo form_close(); ?>
    </div>
    <!--//my_right_box-->
</div>
<!--//mypage-->

<!--안내 Modal Start-->
<div class="modal fade" id="infoModal" role="dialog" style="display:table;">
    <div class="modal-dialog modal-lg">
        <?php echo $this->lang->line('modalContent') ?>
    </div>
</div>
<!--안내 Modal End -->

<!--주의 Modal Start-->
<div class="modal fade" id="warningModal" role="dialog" style="z-index:1045; display:table;">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <?php echo $this->lang->line('modalContentWarning') ?>

    </div>
</div>
<!--주의 Modal End -->

<!-- Modal Script -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script>
    // 쿠키 설정 함수(modalWarning)
    var setCookie = function(name, value, exp) {
        var date = new Date();
        date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
        document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
    };
    // 쿠키 가져오기 함수(modalWarning)
    var getCookie = function(name) {
        var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return value ? value[2] : null;
    };


    var fileTypes = ['image/png', 'image/jpg', 'image/jpeg'];
    var domains = `<?php echo $domains['wht_domains'] ?>`.split("\n");

    $(document).ready(function() {
        let validation_err = '<?= isset($validation_err) ? $validation_err : '' ?>';
        if (validation_err) {
            alert(validation_err);
        }
        $("#infoModal").modal({
            backdrop: 'static'
        });
    });

    $('#infoModalBtn').on('click', function() {
        $('#infoModal').modal('hide');
        let checkCookie = getCookie("ModalWarning");
        if (checkCookie != 'check') {
            $("#warningModal").modal({
                backdrop: 'static'
            });
            return;
        }
    });
    $('#warningModalBtn').on('click', function() {
        $('#warningModal').modal('hide');
        setCookie("ModalWarning", "check", "7");
    });
    $('#warningModalXBtn').on('click', function() {
        $('#warningModal').modal('hide');
    });


    $(".attach_img").on('click', function() {
        let input_img = $(this).parent().find(".jud_attach");
        input_img.click();
    });

    $(".site_url").on('change', async function() {
        let thisvalue = $(this).val();
        let flag = true;
        let checkbox = $(this).parents('li').find('.applycheck');
        await domains.forEach(element => {
            if (thisvalue.indexOf(element) != -1) {
                flag = false;
            }
        });

        if (flag) {
            alert('<?php echo $this->lang->line('c_11') ?>');
            checkbox.prop("checked", false);
            $(this).val('');
            $(this).focus();
        } else {
            if ($(this).parents('li').find('img').attr('src') != 'https://www.percommunity.com/uploads/cache/thumb-noimage_400x300.png') {
                checkbox.prop("checked", true);
            }
        }
    });

    $(".jud_attach").on('change', function() {
        let attach_img = $(this).parent().find(".attach_img");
        let checkbox = $(this).parents('.table_bottom').find('.applycheck');
        var file = $(this).get(0).files[0];
        if (file) {
            if (file.size > 10000000) {
                alert('<?php echo $this->lang->line(10) ?>');
                return false;
            }
            if (file.type.indexOf('image') == -1) {
                alert('<?php echo $this->lang->line(11) ?>');
                return false;
            }
            if (!validFileType(file)) {
                alert('<?php echo $this->lang->line(12) ?>');
                return false;
            }
            var reader = new FileReader();
            reader.onload = function() {
                attach_img.attr('src', reader.result);
            };

            reader.readAsDataURL(file);
            if ($(this).parents('li').find('.site_url').val()) {
                checkbox.prop("checked", true);
            } else {
                checkbox.prop("checked", false);
            }
        }
    });

    $('form').on('submit', function(event) {
        if ($('.applycheck:checked').length < 1) {
            event.preventDefault();
            alert('<?php echo $this->lang->line('alert_1') ?>');
        }
        let url_leng = $('.site_url').length;
        let flag = false;
        for (index = 0; url_leng >= index; index++) {
            let this_siteurl = $('.site_url').eq(index);
            if (this_siteurl.val()) {
                if (this_siteurl.parents('li').find('img').attr('src') == 'https://www.percommunity.com/uploads/cache/thumb-noimage_400x300.png') {
                    flag = true;
                    break;
                }
            }
        }
        if (flag) {
            event.preventDefault();
            alert('<?php echo $this->lang->line('confirm_1') ?>');
        }
    });

    function validFileType(file) {
        for (var i = 0; i < fileTypes.length; i++) {
            if (file.type) {
                if (file.type === fileTypes[i]) {
                    return true;
                }
            } else if (file.name.toLowerCase().endsWith('jpg') || file.name.toLowerCase().endsWith('jpeg') || file.name.toLowerCase().endsWith('png')) {
                // Edge file.type 안나오는 것을 위해서.
                return true;
            }
        }
        return false;
    }

    function popup(url) {
        let name = '<?php echo $this->session->userdata('lang') == 'korean' ? element('mis_title', $missionData) : element('mis_title_en', $missionData); ?>';
        let options = 'location = no'
        var win = window.open(url, name, options);
        win.focus();
        return win;
    }
</script>