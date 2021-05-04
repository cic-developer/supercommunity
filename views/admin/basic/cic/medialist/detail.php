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
				<label class="col-sm-2 control-label">사용자지정 미디어 이름</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="med_name" value="<?php echo set_value('med_name', element('med_name', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">미디어플랫폼</label>
				<div class="col-sm-10">
					<select name="med_wht_id" class="form-control">
						<?php foreach(element('list',element('all_whitelist', $view)) as $l){ ?>
							<option value="<?=element('wht_id',$l)?>" <?php echo set_select('med_wht_id', element('wht_id',$l), ( element('med_wht_id', element('data', $view)) == element('wht_id',$l) )); ?>><?=element('wht_title',$l)?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">링크</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="med_url" value="<?php echo set_value('med_url', element('med_url', element('data', $view))); ?>" />
					<a href="<?php echo set_value('med_url', element('med_url', element('data', $view))); ?>" target="_blank"><?php echo set_value('med_url', element('med_url', element('data', $view))); ?></a>
					<?php if(element('med_duplicate', $view)){ ?>
						<a href="/admin/cic/judgemedia?sfield=jud_med_url&skeyword=<?php echo urlencode(element('jud_med_url', element('data', $view))); ?>&search_submit=">
							<span class="label label-danger" style="margin-left:10px;">중복된 미디어입니다.</span>
						</a>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">미디어 성격</label>
				<div class="col-sm-10">
				<?php 
					foreach(element('list',element('all_mediatype', $view)) as $l){ 
					$chkvalue = in_array(element('met_id', $l), element('all_mediatype_map', $view)) ? element('met_id', $l) : '';
				?>
					<label class="checkbox-inline">
						<input type="checkbox" name="met_id[]" value="<?php echo set_value('met_id[]', element('met_id', $l)); ?>" <?=element('met_deletion',$l) == 'Y' ? 'disabled' : ''?> <?php echo set_checkbox('met_id[]', element('met_id', $l), ($chkvalue ? true : false)); ?> />
						<?=element('met_title',$l)?><?=element('met_deletion',$l) == 'Y' ? '(삭제)' : ''?>
					</label>
				<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">관리자명</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="med_admin" value="<?php echo set_value('med_admin', element('med_admin', element('data', $view))); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">SUPERPOINT</label>
				<div class="col-sm-10">
				<?php if(element('med_state', element('data', $view)) == 3) {?>
					<input type="number" class="form-control" name="med_superpoint" value="<?php echo set_value('med_superpoint', element('med_superpoint', element('data', $view))); ?>" />
				<?php }else{  ?>
					<input type="text" style="all:unset; height:30px; display:inline-block; vertical-align:middle;" disabled value="<?php echo number_format(element('med_superpoint', element('data', $view))); ?>" />
				<?php }?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">PERFRIEND</label>
				<div class="col-sm-10">
				<?php if(element('med_state', element('data', $view)) == 3) {?>
					<input type="number" class="form-control" name="med_member" value="<?php echo set_value('med_member', element('med_member', element('data', $view))); ?>" />
				<?php }else{  ?>
					<input type="text" style="all:unset; height:30px; display:inline-block; vertical-align:middle;" disabled value="<?php echo number_format(element('med_superpoint', element('data', $view))); ?>" />
				<?php }?>


					<!-- <input type="text" style="all:unset; height:30px; display:inline-block; vertical-align:middle;" value="<?php //echo number_format(element('med_member', element('data', $view))); ?>" /> -->
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">상태</label>
				<div class="col-sm-10 form-inline">
					<input type="text" style="all:unset; height:30px; display:inline-block; vertical-align:middle;" disabled value="<?=rs_get_state(element('med_state', element('data', $view)))?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">회원정보</label>
				<div class="col-sm-10">
					<span class="form-control" style="border:0;box-shadow:none;padding:6px 0;"><?php echo element('display_name',$view); ?> </span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">등록유저IP</label>
				<div class="col-sm-10">
					<input type="text" style="all:unset; height:30px; width:150px; display:inline-block; vertical-align:middle;" disabled value="<?=element('med_ip', element('data', $view))?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">등록일</label>
				<div class="col-sm-10 form-inline">
					<input type="text" style="all:unset; height:30px; width:150px; display:inline-block; vertical-align:middle;" disabled value="<?=date('Y-m-d H:i:s',strtotime(element('med_wdate', element('data', $view))))?>" />
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
	$('#fadminwrite').validate({
		rules: {
			med_name: { required: true, minlength:2, maxlength :255 },
			med_wht_id: { required: true, digits:true, min:1, maxlength :11 },
			med_url: { required: true, url:true, minlength:5, maxlength :255 },
			met_id: { required: true},
			med_admin: { required: true, minlength:1, maxlength :255 }
		}
	});
});

//]]>
</script>
