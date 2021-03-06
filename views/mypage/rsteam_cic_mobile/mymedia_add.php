<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>


<!--마이페이지-2 :: 내미디어> 내미디어 추가-->

<!--mypage-->
<div id="mypage">
     <h3><?=$this->lang->line(0)?></h3>
       <!--my_right_box-->
       <div id="my_right_box">
            <h5><?=$this->lang->line(1)?></h5>
                <h6><?=$this->lang->line(2)?>
<!--20.10.14추가요청 가이드 문구 영역-->
                <small id="guide">
                </small>
<!--20.10.14추가요청 가이드 문구 영역//-->
                </h6>
<?php echo form_open_multipart(''); ?>
                <ul class="ul_write">
                    <li>
                        <span><?=$this->lang->line(3)?></span>
                        <div class="my_cont">
                            <select name="wht_list">
<?php for($i = 0; $i < count($white_list); $i++){ ?>
                                <option value="<?=$white_list[$i]['wht_id']?>" 
                                    <?php echo set_select('wht_list', $white_list[$i]['wht_id']); ?>
                                    data-guide="<?php echo $this->session->userdata('lang') == 'korean' ? $white_list[$i]['wht_memo']: $white_list[$i]['wht_memo_en']?>">
                                    <?=$this->session->userdata('lang') == 'korean' ? $white_list[$i]['wht_title'] : $white_list[$i]['wht_title_en']?>
                                </option>
<?php } ?>
                            </select>
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(4)?></span>
                        <div class="my_cont">
                            <ul class="check_table">
<?php foreach($media_type_list AS $mt){ ?>
                                    <li><label><input type="checkbox" value="<?=$mt['met_id']?>" name="met_type[]" <?php echo set_checkbox('met_type[]', $mt['met_id']); ?> /><?=$this->session->userdata('lang') == 'korean' ? $mt['met_title'] : $mt['met_title_en']?></label></li>
<?php } ?>
<?php if(!$media_type_list){ //미디어 type이 없는 경우?>
                                    <input type="hidden" value="0" name="met_type[]"/>
<?php } ?>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(5)?></span>
                        <div class="my_cont">
                            <input type="text" placeholder="<?=$this->lang->line(6)?>" name="med_name" value="<?php echo set_value('med_name'); ?>" />
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(7)?></span>
                        <div class="my_cont">
                            <input type="text" placeholder="<?=$this->lang->line(8)?>" name="med_admin" value="<?php echo set_value('med_admin'); ?>" />
                        </div>
                    </li>
                    <li>
                        <span><?=$this->lang->line(9)?></span>
                        <div class="my_cont">
                            <input type="text" placeholder="<?=$this->lang->line(10)?>" name="med_url" value="<?php echo set_value('med_url'); ?>" />
                        </div>
                    </li>
 <!--20.10.14추가요청 스크린샷 첨부 영역-->                    
                    <li>
                        <span><?php echo $this->lang->line(15)?></span>
                    <div class="my_cont">
                            <span class="img_file"> <img id="preview_img" src="<?php echo base_url('assets/images/basic_img.gif');?>" alt="<?php echo $this->lang->line(16)?>"/></span>
                            <div class="right_txt">
                                <small><?php echo $this->lang->line(17)?></small>
                                <input id="img_file" type="file" name="jud_attach" style="display:none"/>
                                <input id="file_button" type="button" value="<?php echo $this->lang->line(18)?>" class="btn2 btn_line"/>
                            </div>    
                        </div>
                    </li>
 <!--20.10.14추가요청 스크린샷 첨부 영역//-->
                </ul>
                <div class="btn_box">
                    <input type="submit" value="<?=$this->lang->line(11)?>" class="btn1 btn_yellow"/>
                </div>
 <?php echo form_close(); ?>
        </div>
        <!--//my_right_box-->
</div>
<!--// mypage-->



<script>
    var fileTypes = ['image/png', 'image/jpg', 'image/jpeg'];

    $(document).ready(function(){
        let validation_err = '<?=isset($validation_err) ? $validation_err : '' ?>';
        if(validation_err){
            alert(validation_err);
        }
        
        let guide = $("select[name=wht_list] option:selected").attr('data-guide');
        if(guide){
            $("#guide").text(guide);
        }
    });

    $('select[name=wht_list]').on('change', function(){
        let guide = $("select[name=wht_list] option:selected").attr('data-guide');
        $("#guide").text(guide);
    });

    $("#file_button").on('click', function(){
        let input_img = $("#img_file");
        input_img.click();
    });

    $("#img_file").on('change', function(){
        let attach_img = $("#preview_img");
        var file = $(this).get(0).files[0];
        if(file){
            if(file.size > 10000000){
                alert('<?php echo $this->lang->line(11)?>');
                return false;
            }
            if(file.type.indexOf('image') == -1 ){
                alert('<?php echo $this->lang->line(12)?>');
                return false;
            }
            if(!validFileType(file)){
                alert('<?php echo $this->lang->line(13)?>');
                return false;
            }
            var reader = new FileReader();
            reader.onload = function(){
                attach_img.attr('src',reader.result);
            };

            reader.readAsDataURL(file);
            // console.log($(this).val());
        }
    });

    $("form").on('submit', function(event){
        if(!$("#img_file").val()){
            alert('<?php echo $this->lang->line('require_image')?>');
            event.preventDefault();
        }
    });
    
    function validFileType(file) {
        for (var i = 0; i < fileTypes.length; i++) {
            if (file.type) {
                    if (file.type === fileTypes[i]) { return true; }
            }else if (file.name.toLowerCase().endsWith('jpg') || file.name.toLowerCase().endsWith('jpeg') || file.name.toLowerCase().endsWith('png')) { 
                // Edge file.type 안나오는 것을 위해서.
                return true; 
            } 
        } 
        return false;
    }
</script>