<?php 
$this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css');
?>
<?php
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>

<!-- 구글 reCAPTCHA 적용하기 위한 JS INSERT -->
<?php $_lang = ($this->session->userdata('lang') == 'english') ? 'en' : 'ko'?>
<script src='https://www.google.com/recaptcha/api.js?hl=<?php echo $_lang?>'></script> 
<!-- 구글 reCAPTCHA 적용하기 위한 JS INSERT -->



<div id="ask_wrap">
    <!--fix 왼쪽 --->
        <?php echo $this->lang->line(0) ?><!-- <h3>SUPER COMMUNITY<br>광고 문의</h3> -->
    <!--오른쪽 TOP 시작-->
    <div class="right">
        <ul>
            <li>
                <?php echo $this->lang->line(1);?>
            </li>      
            <li>
                <h4><?php echo $this->lang->line(2);?></h4>
                <div class="bt">
                    <a href="<?php echo base_url('/Inquiry/ad_consulting_inquiry')?>" class="btn1 btn_black"><?php echo $this->lang->line(3);?></a>
                </div>
            </li>
    <!--오른쪽 TOP//--> 

    <!--form 내용시작-->        
            <li class="form">
                <!--form top-->
                <b><?php echo $this->lang->line(4);?></b>
                <?php echo form_open(''); ?>

               
                    <input name="inq_name" placeholder="<?php echo $this->lang->line(5);?>" value="<?php echo set_value('inq_name'); ?>" />
                    <input name="inq_group" placeholder="<?php echo $this->lang->line(6);?>" value="<?php echo set_value('inq_group'); ?>" />
                    <input name="inq_email" placeholder="<?php echo $this->lang->line(7);?>" value="<?php echo set_value('inq_email'); ?>" />  
                    <span class=number>
                        <input id="tel1" type="text" placeholder="<?php echo $this->lang->line(8);?>"/><strong>-</strong>
                        <input id="tel2" type="text"/><strong>-</strong>
                        <input id="tel3" type="text"/>
                    </span>
                <!--form top//-->

                <!--form bottom-->
                <b><?php echo $this->lang->line(9);?></b>
                    <span class="inquiry">
                        <input id="inq_tel" name="inq_tel" style="display:none;"/>
                        <textarea name="inq_contents" placeholder="<?php echo $this->lang->line(10);?>"><?php echo set_value('inq_contents'); ?></textarea>
                    </span>
                    <label>
                        <input type="checkbox" name="inq_agree" />
                        <h5><?php echo $this->lang->line(11);?></h5>
                    </label>
                    <div class="something">
                        <div class="g-recaptcha" data-sitekey="6Le3GsYZAAAAAEC8gNAMH99a6biCw4z8N3yZBT1v"></div>
                    </div>
                    <div class="bt"><input id="is_submit" type="submit" value="<?php echo $this->lang->line(12);?>"  class="btn1 btn_yellow"/></div>
                    </form>
                <!--form//-->
                   
                <?php echo form_close('');?>
            </li>
        </ul>
        <!--form내용끝//-->
    </div>
    <!--right끝//-->  
</div>
<!--전체내용끝//-->  

<script>
    $("#tel1").bind("change keyup input",function(){$(this).val( $(this).val().replace(/[^0-9]/g,"").substr(0,3) );});
    $("#tel2, #tel3").bind("change keyup input",function(){$(this).val( $(this).val().replace(/[^0-9]/g,"").substr(0,4) );});

    $("#is_submit").click(function(){
        //이름 필수
        if($('input[name=inq_name]').val() === ''){
            alert('<?php echo $this->lang->line(23); ?>');
            $('input[name=inq_name]').focus();
            return false;
        }

        //직장/단체명 필수
        if($('input[name=inq_group]').val() === ''){
            alert('<?php echo $this->lang->line(24); ?>');
            $('input[name=inq_group]').focus();
            return false;
        }

        //이메일 필수
        if($('input[name=inq_email]').val() === '' || !validateEmail($('input[name=inq_email]').val())){
            alert('<?php echo $this->lang->line(25); ?>');
            $('input[name=inq_email]').focus();
            return false;
        }

        let tel1 = trim($("#tel1").val());
        let tel2 = trim($("#tel2").val());
        let tel3 = trim($("#tel3").val());
        $("#inq_tel").val(tel1+'-'+tel2+'-'+tel3);
        //전화번호 입력 필수
        // if($('#inq_tel').val() === '' || $('#inq_tel').val().length <3){
        //     alert('"전화번호 항목은 3자 이상 입력하셔야합니다.');
        //     $('#tel2').focus();
        //     return false;
        // }

        //문의내용 항목 필수
        if($('textarea[name=inq_contents]').val() === '' || $('textarea[name=inq_contents]').val().length < 10){
            alert('<?php echo $this->lang->line(26); ?>');
            $('textarea[name=inq_contents]').focus();
            return false;
        }

        //개인정보처리방침 필수
        if(!$('input[name=inq_agree]').is(":checked")){
            alert('<?php echo $this->lang->line(27); ?>');
            $('input[name=inq_agree]').focus();
            return false;
        }
        
        if(grecaptcha.getResponse() == ""){
            alert("<?php echo $this->lang->line(13);?>");
            return false;
        }

        $('form').submit();
    });

    $(document).ready(function(){
        let validation_err = '<?=isset($validation_err) ? $validation_err : '' ?>';
        if(validation_err){
            alert(validation_err);
        }
    });
    
    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

</script>
