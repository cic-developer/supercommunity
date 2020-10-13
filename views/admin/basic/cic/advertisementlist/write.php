<script type="text/javascript" src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<input type="hidden" name="<?php echo element('primary_key', $view); ?>"	value="<?php echo element(element('primary_key', $view), element('data', $view)); ?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">광고 분류</label>
				<div class="col-sm-10 form-inline">
					<select name="ad_type" class="form-control">
						<option value="1" <?php echo element('ad_type', element('data', $view)) == 1 ? 'selected' : '' ?>>이미지</option>
						<option value="2" <?php echo element('ad_type', element('data', $view)) == 2 ? 'selected' : '' ?>>유튜브</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">노출여부</label>
				<div class="col-sm-10 form-inline">
					<select name="ad_state" class="form-control">
						<option value="1" <?php echo element('ad_state', element('data', $view)) == 1 ? 'selected' : '' ?>>노출</option>
						<option value="0" <?php echo element('ad_state', element('data', $view)) === 0 ? 'selected' : '' ?>>미노출</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">유튜브 링크</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="ad_url_link" value="<?php echo element('ad_type', element('data', $view)) == 1? '' : element('ad_url', element('data', $view)); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">이미지</label>
				<div class="col-sm-10">
					<img id='ad_img' src="<?php echo element('ad_type', element('data', $view)) == 1? thumb_url('advertise', element('ad_url', element('data', $view)), 400, 300) : base_url('/uploads/noimage.gif')?>" alt="광고 사진" title="광고 사진"/>
					<input type="file" name="ad_url_img" id="ad_url_img" />
					<p class="help-block"> gif, jpg, png 파일 업로드가 가능합니다.(최대 20MB)</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">메모</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" name="ad_memo"><?php echo set_value('ad_memo', element('ad_memo', element('data', $view))); ?></textarea>
				</div>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
				<button type="submit" class="btn btn-success btn-sm">저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	var fileTypes = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];

	$("#ad_url_img").on('change', function(){
		var file = $(this).get(0).files[0];
        if(file){
            if(file.size > 20000000){
								alert('파일은 최대 20MB까지 업로드 가능합니다.');
								$("#ad_url_img").val('');
                return false;
            }
            if(file.type.indexOf('image') == -1 ){
                alert('이미지 파일만 업로드 가능합니다.');
								$("#ad_url_img").val('');
                return false;
            }
            if(!validFileType(file)){
                alert('지원하지 않는 이미지 파일입니다.');
								$("#ad_url_img").val('');
                return false;
            }
			var reader = new FileReader();
            reader.onload = function(){
                $("#ad_img").attr('src',reader.result);
            };
			reader.readAsDataURL(file);
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
});
//]]>
</script>
