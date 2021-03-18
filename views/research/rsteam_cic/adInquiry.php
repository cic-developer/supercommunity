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
                        <input name="res_category"  id="ctg_coin" type="radio" value="coin"/>
                        코인
                    </label>
                    <label for="ctg_exchange">
                        <input name="res_category"  id="ctg_exchange" type="radio" value="exchange"/>
                        거래소
                    </label>
                    <label for="ctg_etc">
                        <input name="res_category"  id="ctg_etc" type="radio" value="etc"/>
                        코인
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
                        <input name="res_category"  id="ctg_coin" type="radio" value="coin"/>
                        코인
                    </label>
                    <label for="ctg_exchange">
                        <input name="res_category"  id="ctg_exchange" type="radio" value="exchange"/>
                        거래소
                    </label>
                    <label for="ctg_etc">
                        <input name="res_category"  id="ctg_etc" type="radio" value="etc"/>
                        코인
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