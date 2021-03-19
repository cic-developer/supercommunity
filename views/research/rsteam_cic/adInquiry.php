<?php echo $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>


<div id="research_wrap">  
    <div class="research_content">
        <?php echo form_open(); //여기서부터 데이터 제출?>
            <div class="research_top research_page1">
                <h3>무엇을 광고하고 싶으신가요?<br/><small>간단히 기입해 주시면 됩니다.</small></h3>
                <ul class="text_g">
                    <li class="sub_title">
                        1. 제품이나 프로젝트 제목이 궁금해요. *
                    </li>
                    <li><p>
                        <input name="res_name" type="text" placeholder="프로젝트 제목"/>
                    </p></li>

                    <li class="sub_title">
                        2. 어떤 분야인가요? *
                    </li>
                    <li><p>
                        <label for="ctg_coin">
                            <input name="res_category"  id="ctg_coin" type="radio" value="코인"/>
                            코인
                        </label>
                        <label for="ctg_exchange">
                            <input name="res_category"  id="ctg_exchange" type="radio" value="거래소"/>
                            거래소
                        </label>
                        <label for="ctg_etc">
                            <input name="res_category"  id="ctg_etc" type="radio" value="기타"/>
                            기타
                        </label>
                    </p></li>

                    <li class="sub_title">
                        3. 광고하고 싶으신 내용을 말씀해 주시겠어요?. *
                    </li>
                    <li>
                        <p><textarea name="res_contents"></textarea></p>
                        <p><input type="file" name="res_contents_file"/></p>
                    </li>
                    <li>
                        <div class="bt">
                            <a class="btn1 btn_yellow" onClick="research_next(1)">다음</a>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="research_top research_page2" style="display:none">
                <h3>기간을 알려주세요</h3>
                <ul class="text_g">
                    <li class="sub_title">
                        1. 언제부터 광고를 하실건가요? *
                    </li>
                    <li><p>
                        <label for="when_now">
                            <input name="res_when"  id="when_now" type="radio" value="신속히"/>
                            신속히 진행하고 싶어요
                        </label>
                        <label for="when_week">
                            <input name="res_when"  id="when_week" type="radio" value="일주일 이내"/>
                            일주일 이내
                        </label>
                        <label for="when_month">
                            <input name="res_when"  id="when_month" type="radio" value="1개월 이내"/>
                            1개월 이내
                        </label>
                        <label for="when_want">
                            <input name="res_when"  id="when_want" type="radio" value="원하는 날짜"/>
                            원하는 날짜가 있어요
                        </label>
                        <label for="when_argument">
                            <input name="res_when"  id="when_argument" type="radio" value="협의필요"/>
                            협의가 필요해요
                        </label>
                    </p></li>

                    <li class="sub_title">
                        2. 얼마동안 광고를 하실건가요? *
                    </li>
                    <li><p>
                        <label for="term_10">
                            <input name="res_howlong"  id="term_10" type="radio" value="10일 미만"/>
                            10일 미만
                        </label>
                        <label for="term_20">
                            <input name="res_howlong"  id="term_20" type="radio" value="20일 미만"/>
                            20일 미만
                        </label>
                        <label for="term_30">
                            <input name="res_howlong"  id="term_30" type="radio" value="30일 미만"/>
                            30일 미만
                        </label>
                        <label for="term_month">
                            <input name="res_howlong"  id="term_month" type="radio" value="30일 이상"/>
                            30일 이상
                        </label>
                        <label for="term_argument">
                            <input name="res_howlong"  id="term_argument" type="radio" value="상담 필요"/>
                            상담이 필요해요
                        </label>
                        <label for="term_spent_all">
                            <input name="res_howlong"  id="term_spent_all" type="radio" value="광고비 소진"/>
                            광고비가 소진될 때까지
                        </label>
                    </p></li>
                    <li>
                        <div class="bt">
                            <a class="btn1 btn_black" onClick="research_back(2)">이전</a>
                            <a class="btn1 btn_yellow" onClick="research_next(2)">다음</a>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="research_top research_page3" style="display:none">
                <h3>어떻게 광고하고 싶으신가요?</h3>
                <ul class="text_g">
                    <li class="sub_title">
                        1. 마케팅 예산을 알려주세요 *
                    </li>
                    <li><p>
                        <select name="res_price">
                            <option value="200~300">200~300</option>
                            <option value="300~500">300~500</option>
                            <option value="500~1000">500~1000</option>
                            <option value="1000이상">1000이상</option>
                            <option value="미정">미정</option>
                        </select>
                        만원
                    </p></li>

                    <li class="sub_title">
                        2. 마케팅을 원하시는 플랫폼을 선택해주세요 *
                    </li>
                    <li><p>
                        <label for="platform_naverblog">
                            <input name="res_platform[]"  id="platform_naverblog" type="checkbox" value="네이버 블로그"/>
                            네이버 블로그
                        </label>
                        <label for="platform_cobak">
                            <input name="res_platform[]"  id="platform_cobak" type="checkbox" value="코박"/>
                            코박
                        </label>
                        <label for="platform_telegram">
                            <input name="res_platform[]"  id="platform_telegram" type="checkbox" value="텔레그램"/>
                            텔레그램
                        </label>
                        <label for="platform_youtube">
                            <input name="res_platform[]"  id="platform_youtube" type="checkbox" value="유튜브"/>
                            유튜브
                        </label>
                        <label for="platform_coinpan">
                            <input name="res_platform[]"  id="platform_coinpan" type="checkbox" value="코인판"/>
                            코인판
                        </label>
                        <label for="platform_moneynet">
                            <input name="res_platform[]"  id="platform_moneynet" type="checkbox" value="머니넷"/>
                            머니넷
                        </label>
                        <label for="platform_kakaoopen">
                            <input name="res_platform[]"  id="platform_kakaoopen" type="checkbox" value="카카오톡 오픈톡"/>
                            카카오톡 오픈톡
                        </label>
                        <label for="platform_tstory">
                            <input name="res_platform[]"  id="platform_tstory" type="checkbox" value="티스토리"/>
                            티스토리
                        </label>
                    </p></li>

                    <li class="sub_title">
                        3. 광고 컨설팅이 필요하신가요?<br><small>(유료, 선택사항)</small>
                    </li>
                    <li><p>
                        <label for="pack_per">
                            <input name="res_package"  id="pack_per" type="radio" value="PER 패키지"/>
                            PER 패키지
                        </label>
                        <label for="pack_super">
                            <input name="res_package"  id="pack_super" type="radio" value="SUPER 패키기"/>
                            SUPER 패키기
                        </label>
                        <label for="pack_pereprman">
                            <input name="res_package"  id="pack_pereprman" type="radio" value="PERPERMAN 패키지"/>
                            PERPERMAN 패키지
                        </label>
                        <label for="pack_supershouting">
                            <input name="res_package"  id="pack_supershouting" type="radio" value="SUPER SHOUTING패키지"/>
                            SUPER SHOUTING패키지
                        </label>
                    </p>
                    <i class="fas fa-chevron-down" onclick="view_hiddenContent($(this))">더보기</i>
                    <div id="hiddenContent" style="display:none;">여기에 패키지 내용 입력</div>            
                    </li>
                    <li>
                        <div class="bt">
                            <a class="btn1 btn_black" onClick="research_back(3)">이전</a>
                            <a class="btn1 btn_yellow" onClick="research_next(3)">다음</a>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="research_top research_page4" style="display:none">
                <h3>감사합니다! 이메일을 통해 회신 드리겠습니다</h3>
                <br>
                <small>업무 시간 중에는 보통 2시간 이내에 회신을 드리고 있습니다.</small>
                <ul class="text_g">
                    <li class="sub_title">
                        1. 이메일을 적어주세요 *
                    </li>
                    <li><p>
                        <input name="res_email"  id="respon_email" type="text" placeholder="example1234@test.net"/>
                    </p></li>

                    <li class="sub_title">
                        2. 연락처를 적어주세요 *
                    </li>
                    <li><p>
                        <input name="res_tel"  id="respon_tel" type="text" placeholder="010-123-4567 OR 0101234567"/>
                    </p></li>
            
                    <li>
                        <div class="bt">
                            <a class="btn1 btn_black" onClick="research_back(4)">이전</a>
                            <a class="btn1 btn_yellow" onClick="research_next(4)">제출</a>
                        </div>
                    </li>
                </ul>
            </div>
        <?php echo form_close();  // 여기까지 데이터 제출?>
    </div> 
</div>

<script>
    var research_Page = 1;
    function research_next(pageNum){
        let nextPage = ".research_page" + (pageNum + 1);
        // let nextNode = $(nextPage);
        let nowPage  = ".research_page" + pageNum;
        $(nowPage).css('display','none');
        $(nextPage).css('display', 'block');
        research_Page++;
        console.log(research_Page);
    }

    function research_back(pageNum){
        let backPage = ".research_page" + (pageNum - 1);
        // let backNode = $(backPage);
        let nowPage = '.research_page'+pageNum;
        $(nowPage).css('display','none');
        $(backPage).css('display', 'block');
        research_Page--;
    }

    function view_hiddenContent(icon){
        let hiddenContent = $("#hiddenContent");
        if(hiddenContent.css('display') == 'none'){
            hiddenContent.css('display', 'block');
            icon.attr('class','fas fa-chevron-up');
        }else{
            hiddenContent.css('display', 'none');
            icon.attr('class','fas fa-chevron-down');
        }
    }
</script>