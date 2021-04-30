<?php echo $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div id="research_wrap">
    <div class="research_content">
        <div id="research_page1" class="research_top research_page">
            <h3><?php echo $this->lang->line('h3_1') ?><br /><small><?php echo $this->lang->line('small_1') ?></small>
            </h3>
            <form id="page1">
                <ul class="text_g">
                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_1') ?>
                    </li>
                    <li class="form-group">
                        <p>
                            <input id="res_name" name="res_name" type="text"
                                placeholder="<?php echo $this->lang->line('res_name_placehold') ?>" />
                        </p>
                    </li>

                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_2') ?>
                    </li>
                    <li class="form-group">
                        <label for="ctg_coin">
                            <input name="res_category" id="ctg_coin" type="radio" value="코인" />
                            <p class="tex"><?php echo $this->lang->line('res_category_coin') ?></p>
                        </label>
                        <label for="ctg_exchange">
                            <input name="res_category" id="ctg_exchange" type="radio" value="거래소" />
                            <p class="tex"><?php echo $this->lang->line('res_category_exchange') ?></p>
                        </label>
                        <label for="ctg_etc">
                            <input name="res_category" id="ctg_etc" type="radio" value="기타" />
                            <p class="tex"><?php echo $this->lang->line('res_category_etc') ?></p>
                        </label>
                    </li>

                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_3') ?>
                    </li>
                    <li class="form-group">
                        <p><textarea name="res_contents"></textarea></p>
                        <br><br><br>
                        <p><input type="file" name="res_contents_file" /></p>
                    </li>
                    <li>
                        <div class="bt">
                            <a class="btn1 btn_yellow"
                                onclick="research_next(1)"><?php echo $this->lang->line('next_button') ?></a>
                        </div>
                    </li>
                </ul>
            </form>
        </div>

        <div id="research_page2" class="research_top research_page" style="display:none">
            <h3><?php echo $this->lang->line('h3_2') ?></h3>
            <form id="page2">
                <ul class="text_g">
                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_4') ?>
                    </li>
                    <li class="form-group">
                        <label for="when_now">
                            <input name="res_when" id="when_now" type="radio" value="신속히" />
                            <p class="tex"><?php echo $this->lang->line('res_when_now') ?></p>
                        </label>
                        <label for="when_week">
                            <input name="res_when" id="when_week" type="radio" value="일주일 이내" />
                            <p class="tex"><?php echo $this->lang->line('res_when_week') ?></p>
                        </label>
                        <label for="when_month">
                            <input name="res_when" id="when_month" type="radio" value="1개월 이내" />
                            <p class="tex"><?php echo $this->lang->line('res_when_month') ?></p>
                        </label>
                        <label for="when_want">
                            <input name="res_when" id="when_want" type="radio" value="원하는 날짜" />
                            <p class="tex"><?php echo $this->lang->line('res_when_want') ?></p>
                        </label>
                        <label for="when_argument">
                            <input name="res_when" id="when_argument" type="radio" value="협의필요" />
                            <p class="tex"><?php echo $this->lang->line('res_when_argument') ?></p>
                        </label>
                    </li>

                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_5') ?>
                    </li>
                    <li class="form-group">
                        <label for="term_10">
                            <input name="res_howlong" id="term_10" type="radio" value="10일 미만" />
                            <p class="tex"><?php echo $this->lang->line('res_howlong_10') ?></p>
                        </label>
                        <label for="term_20">
                            <input name="res_howlong" id="term_20" type="radio" value="20일 미만" />
                            <p class="tex"><?php echo $this->lang->line('res_howlong_20') ?></p>
                        </label>
                        <label for="term_30">
                            <input name="res_howlong" id="term_30" type="radio" value="30일 미만" />
                            <p class="tex"><?php echo $this->lang->line('res_howlong_30') ?></p>
                        </label>
                        <label for="term_month">
                            <input name="res_howlong" id="term_month" type="radio" value="30일 이상" />
                            <p class="tex"><?php echo $this->lang->line('res_howlong_month') ?></p>
                        </label>
                        <label for="term_argument">
                            <input name="res_howlong" id="term_argument" type="radio" value="상담 필요" />
                            <p class="tex"><?php echo $this->lang->line('res_howlong_argument') ?></p>
                        </label>
                        <label for="term_spent_all">
                            <input name="res_howlong" id="term_spent_all" type="radio" value="광고비 소진" />
                            <p class="tex"><?php echo $this->lang->line('res_howlong_spent_all') ?></p>
                        </label>
                    </li>
                    <li>
                        <div class="bt">
                            <a class="btn1 btn_black"
                                onClick="research_back(2)"><?php echo $this->lang->line('pre_button') ?></a>
                            <a class="btn1 btn_yellow"
                                onClick="research_next(2)"><?php echo $this->lang->line('next_button') ?></a>
                        </div>
                    </li>
                </ul>
            </form>
        </div>

        <div id="research_page3" class="research_top research_page" style="display:none">
            <h3><?php echo $this->lang->line('h3_3') ?></h3>
            <form id="page3">
                <ul class="text_g">
                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_6') ?>
                    </li>
                    <li class="form-group">
                        <select name="res_price">
                            <option value="200~300"><?php echo $this->lang->line('res_price_option_1') ?></option>
                            <option value="300~500"><?php echo $this->lang->line('res_price_option_2') ?></option>
                            <option value="500~1000"><?php echo $this->lang->line('res_price_option_3') ?></option>
                            <option value="1000이상"><?php echo $this->lang->line('res_price_option_4') ?></option>
                            <option value="미정"><?php echo $this->lang->line('res_price_option_5') ?></option>
                        </select>
                        <?php echo $this->lang->line('res_price_unit') ?>
                    </li>

                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_7') ?>
                    </li>
                    <li class="form-group">
                        <label for="platform_naverblog">
                            <input name="res_platform[]" id="platform_naverblog" type="checkbox" value="네이버 블로그" />
                            <p class="tex"><?php echo $this->lang->line('res_platform_1') ?></p>
                        </label>
                        <label for="platform_cobak">
                            <input name="res_platform[]" id="platform_cobak" type="checkbox" value="코박" />
                            <p class="tex"><?php echo $this->lang->line('res_platform_2') ?></p>
                        </label>
                        <label for="platform_telegram">
                            <input name="res_platform[]" id="platform_telegram" type="checkbox" value="텔레그램" />
                            <p class="tex"><?php echo $this->lang->line('res_platform_3') ?></p>
                        </label>
                        <label for="platform_youtube">
                            <input name="res_platform[]" id="platform_youtube" type="checkbox" value="유튜브" />
                            <p class="tex"><?php echo $this->lang->line('res_platform_4') ?></p>
                        </label>
                        <label for="platform_coinpan">
                            <input name="res_platform[]" id="platform_coinpan" type="checkbox" value="코인판" />
                            <p class="tex"><?php echo $this->lang->line('res_platform_5') ?></p>
                        </label>
                        <label for="platform_moneynet">
                            <input name="res_platform[]" id="platform_moneynet" type="checkbox" value="머니넷" />
                            <p class="tex"><?php echo $this->lang->line('res_platform_6') ?></p>
                        </label>
                        <label for="platform_kakaoopen">
                            <input name="res_platform[]" id="platform_kakaoopen" type="checkbox" value="카카오톡오픈톡" />
                            <p class="tex"><?php echo $this->lang->line('res_platform_7') ?></p>
                        </label>
                        <label for="platform_tstory">
                            <input name="res_platform[]" id="platform_tstory" type="checkbox" value="티스토리" />
                            <p class="tex"><?php echo $this->lang->line('res_platform_8') ?></p>
                        </label>
                        <label for="platform_anything">
                            <input name="res_platform[]" id="platform_anything" type="checkbox" value="협의가 필요해요" />
                            <p class="tex"><?php echo $this->lang->line('res_platform_9') ?></p>
                        </label>
                    </li>

                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_8') ?>
                    </li>
                    <li class="form-group">
                        <label for="pack_per">
                            <input name="res_package" id="pack_per" type="radio" value="PER 패키지" />
                            <p class="tex"><?php echo $this->lang->line('res_package_per') ?></p>
                        </label>
                        <label for="pack_super">
                            <input name="res_package" id="pack_super" type="radio" value="SUPER 패키지" />
                            <p class="tex"><?php echo $this->lang->line('res_package_super') ?></p>
                        </label>
                        <label for="pack_pereprman">
                            <input name="res_package" id="pack_pereprman" type="radio" value="PERPERMAN 패키지" />
                            <p class="tex"><?php echo $this->lang->line('res_package_perperman') ?></p>
                        </label>
                        <label for="pack_supershouting">
                            <input name="res_package" id="pack_supershouting" type="radio" value="SUPER SHOUTING패키지" />
                            <p class="tex"><?php echo $this->lang->line('res_package_supershouting') ?></p>
                        </label>

                        <i class="fas fa-chevron-down"
                            onclick="view_hiddenContent($(this))">&nbsp;<?php echo $this->lang->line('more') ?></i>
                        <div id="hiddenContent" style="display:none;">
                            <img src="<?php echo site_url('assets/images/extra_service.jpg')?>"
                                style="width:100%; height:280" />
                        </div>
                    </li>
                    <li>
                        <div class="bt">
                            <a class="btn1 btn_black"
                                onClick="research_back(3)"><?php echo $this->lang->line('pre_button') ?></a>
                            <a class="btn1 btn_yellow"
                                onClick="research_next(3)"><?php echo $this->lang->line('next_button') ?></a>
                        </div>
                    </li>
            </form>
        </div>

        <div id="research_page4" class="research_top research_page" style="display:none">
            <br>
            <h3><?php echo $this->lang->line('h3_4') ?><br><small><?php echo $this->lang->line('small_2') ?></small>
            </h3><br>
            <form id="page4">
                <ul class="text_g">
                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_9') ?>
                    </li>
                    <li class="form-group">
                        <input name="res_email" id="respon_email" type="text" placeholder="example1234@test.net" />
                    </li>

                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_10') ?>
                    </li>
                    <li class="form-group">
                        <input name="res_tel" id="respon_tel" type="text" placeholder="010-123-4567 OR 0101234567" />
                    </li>
                    
                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_11')?>
                    </li>
                    <li class="form-group">
                        <input id="respon_wallet" type="text" readonly value="0x148c7f3d1f883b4069a734ac83acb926b5bb5226" />
                        <button type="button" class="copyButton" onclick="copy_to_clipboard()">복사</button>
                        <p class="exp"><?php echo $this->lang->line('explain1')?></p>
                    </li>

                    <li class="sub_title">
                        <?php echo $this->lang->line('subtitle_12')?>
                    </li>
                    <li class="form-group">
                        <input name="respon_transaction" id="respon_transaction" type="text" placeholder="ex) 0x647287dfa0ded326f39c00b8bbe795e4fffd7e401bf0b23feac07753c3bae471" />
                        <p class="exp"><?php echo $this->lang->line('explain2')?></p>
                    </li>

                    <li>
                        <div class="bt">
                            <a class="btn1 btn_black"
                                onClick="research_back(4)"><?php echo $this->lang->line('pre_button') ?></a>
                            <a class="btn1 btn_yellow"
                                onClick="research_next(4)"><?php echo $this->lang->line('submit_button') ?></a>
                        </div>
                    </li>

                </ul>
            </form>
        </div>
    </div>
    <?php echo form_open_multipart('',array('id' => 'hiddenForm')) ?>
    <input type="hidden" name="is_submit" value="true" />
    <input type="hidden" name="total_data" />
    <?php echo form_close()?>
</div>



<script>
    var research_Page = 1;
    $(document).ready(function () {
        $("#page1").validate({
            rules: {
                res_name: {
                    required: true,
                    rangelength: [2, 50]
                },
                res_category: {
                    required: true
                },
                res_contents: {
                    required: true,
                    minlength: 2,
                    maxlength: 1000
                }
            },
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    console.log(element.closest('.form-group'))
                    element.closest('.form-group').append(error);
                } else {
                    element.after(error);
                }
            }
        });

        $("#page2").validate({
            rules: {
                res_when: {
                    required: true
                },
                res_howlong: {
                    required: true
                },
            },
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    console.log(element.closest('.form-group'))
                    element.closest('.form-group').append(error);
                } else {
                    element.after(error);
                }
            }
        });

        $("#page3").validate({
            rules: {
                'res_platform[]': {
                    required: true
                }
            },
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    console.log(element.closest('.form-group'))
                    element.closest('.form-group').append(error);
                } else {
                    element.after(error);
                }
            }
        });

        $("#page4").validate({
            rules: {
                res_email: {
                    required: true,
                    email: true,
                    rangelength: [9, 100]
                },
                res_tel: {
                    required: true,
                    minlength: 2,
                    rangelength: [10, 13]
                },
            },
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.form-group').append(error);
                } else {
                    element.after(error);
                }
            }
        });

    });

    function view_hiddenContent(icon) {
        let hiddenContent = $("#hiddenContent");
        if (hiddenContent.css('display') == 'none') {
            hiddenContent.css('display', 'block');
            icon.attr('class', 'fas fa-chevron-up');
        } else {
            hiddenContent.css('display', 'none');
            icon.attr('class', 'fas fa-chevron-down');
        }
    }

    function research_back(pageNum) {
        let backPage = "#research_page" + (pageNum - 1);
        let nowPage = '#research_page' + pageNum;
        $(nowPage).css('display', 'none');
        $(backPage).css('display', 'block');
        research_Page--;
    }

    function research_next(pageNum) {
        let val_result = false;
        switch (pageNum) {
            case 1:
                val_result = $("#page1").valid();
                break;
            case 2:
                val_result = $("#page2").valid();
                break;
            case 3:
                val_result = $("#page3").valid();
                break;
            case 4:
                val_result = $("#page4").valid();
                break;
            default:
                console.log('defualt valid');
        }

        if (val_result && pageNum != 4) {
            let nextPage = "#research_page" + (pageNum + 1);
            let nowPage = "#research_page" + pageNum;
            $(nowPage).css('display', 'none');
            $(nextPage).css('display', 'block');
            research_Page++;
            let val_result = false;
        } else if (val_result && pageNum == 4) {
            let page1 = $("#page1").children();
            let page2 = $("#page2").children();
            let page3 = $("#page3").children();
            let page4 = $("#page4").children();

            $("#hiddenForm").append(page1);
            $("#hiddenForm").append(page2);
            $("#hiddenForm").append(page3);
            $("#hiddenForm").append(page4);

            $("#hiddenForm").submit();
        } else {
            console.log(val_result, pageNum);
        }
    };

    function copy_to_clipboard() {    
        var copyText = document.getElementById('respon_wallet');
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("Copy");
        alert('복사되었습니다.');
        return;
    }
</script>