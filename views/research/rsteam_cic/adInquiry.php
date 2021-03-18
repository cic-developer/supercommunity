<?php echo $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>


<div id="research_wrap">  
    <div class="research_content">
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
                        <input name="res_term"  id="term_10" type="radio" value="10일 미만"/>
                        10일 미만
                    </label>
                    <label for="term_20">
                        <input name="res_term"  id="term_20" type="radio" value="20일 미만"/>
                        20일 미만
                    </label>
                    <label for="term_30">
                        <input name="res_term"  id="term_30" type="radio" value="30일 미만"/>
                        30일 미만
                    </label>
                    <label for="term_month">
                        <input name="res_term"  id="term_month" type="radio" value="30일 이상"/>
                        30일 이상
                    </label>
                    <label for="term_argument">
                        <input name="res_term"  id="term_argument" type="radio" value="상담 필요"/>
                        상담이 필요해요
                    </label>
                    <label for="term_spent_all">
                        <input name="res_term"  id="term_spent_all" type="radio" value="광고비 소진"/>
                        광고비가 소진될 때까지
                    </label>
                </p></li>
                <li>
                    <div class="bt">
                        <a class="btn1 btn_yellow" onClick="research_back(2)">이전</a>
                        <a class="btn1 btn_yellow" onClick="research_next(2)">다음</a>
                    </div>
                </li>
            </ul>
        </div>
    </div> 
</div>

<script>
    var research_Page = 1;
    function research_next(pageNum){
        let nextPage = ".research_page" + (pageNum + 1);
        // let nextNode = $(nextPage);
        let nowPage  = ".research_page" + pageNum;
        console.log(nextPage, nowPage);
        $(nowPage).css('display','none');
        $(nextPage).css('display', 'block');
        research_Page++;
        console.log(research_Page);
    }

    function research_back(pageNum){
        let backPage = ".research_page" + (pageNum - 1);
        // let backNode = $(backPage);
        let nowPage = '.research_page'+pageNum;
        console.log(backPage, nowPage);
        $(nowPage).css('display','none');
        $(backPage).css('display', 'block');
        research_Page--;
    }
</script>