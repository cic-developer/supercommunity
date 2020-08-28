
<?php 
	if(element('data', $view) && element('state', element('data', $view)) == 'end'){
		$disabled = 'disabled';
	} else {
		$dusabled = '';
	}
?>
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
				<label class="col-sm-2 control-label">제목</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="mis_title" value="<?php echo set_value('mis_title', element('mis_title', element('data', $view))); ?>"  <?=$disabled?>/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">썸네일 유형</label>
				<div class="col-sm-10 form-inline">
					<select name="mis_thumb_type" class="form-control" <?=$disabled?>>
						<option value="1" <?php echo set_select('mis_thumb_type', '1', ( element('mis_thumb_type', element('data', $view)) == 1 ? true : false)); ?>>이미지</option>
						<option value="2" <?php echo set_select('mis_thumb_type', '2', ( element('mis_thumb_type', element('data', $view)) == 2 ? true : false)); ?>>유튜브</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">썸네일 이미지</label>
				<div class="col-sm-10">
					<?php
					if (element('mis_thumb_image', element('data', $view))) {
					?>
						<img src="<?php echo thumb_url('mission_thumb_img', element('mis_thumb_image', element('data', $view)), 400, 300); ?>" alt="썸네일" title="썸네일" />
						<label for="mis_thumb_image_del">
							<input type="checkbox" name="mis_thumb_image_del" id="mis_thumb_image_del" value="1" <?php echo set_checkbox('mis_thumb_image_del', '1'); ?>  <?=$disabled?>/> 삭제
						</label>
					<?php
					}
					?>
					<input type="file" name="mis_thumb_image" id="mis_thumb_image"  <?=$disabled?>/>
					<p class="help-block">가로길이 : 400px, 세로길이 : 300px 에 최적화되어있습니다, gif, jpg, jpeg, png 파일 업로드가 가능합니다</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">썸네일 유튜브 주소</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="mis_thumb_youtube" value="<?php echo set_value('mis_thumb_youtube', element('mis_thumb_youtube', element('data', $view))); ?>" placeholder="ex) https://www.youtube.com/watch?v=cRNCHHtmWYM"  <?=$disabled?>/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">마감 유형</label>
				<div class="col-sm-10 form-inline">
					<select name="mis_endtype" class="form-control" <?=$disabled?>>
						<option value="1" <?php echo set_select('mis_endtype', '1', ( element('mis_endtype', element('data', $view)) === '1' ? true : false)); ?>>둘다 적용</option>
						<option value="2" <?php echo set_select('mis_endtype', '2', ( element('mis_endtype', element('data', $view)) === '2' ? true : false)); ?>>마감일 마감</option>
						<option value="3" <?php echo set_select('mis_endtype', '3', ( element('mis_endtype', element('data', $view)) === '3' ? true : false)); ?>>최대 Superpooint 마감</option>
						<option value="0" <?php echo set_select('mis_endtype', '0', ( element('mis_endtype', element('data', $view)) === '0' ? true : false)); ?>>마감 사용 안함</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">지급 PER TOKEN</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="mis_per_token" value="<?php echo set_value('mis_per_token', element('mis_per_token', element('data', $view))); ?>"  <?=$disabled?>/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">최대 슈퍼포인트</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="mis_max_point" value="<?php echo set_value('mis_max_point', element('mis_max_point', element('data', $view))); ?>"  <?=$disabled?>/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">슈퍼프랜드 추가지급 비율</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="mis_sf_percentage" value="<?php echo set_value('mis_sf_percentage', element('mis_sf_percentage', element('data', $view))); ?>"  <?=$disabled?>/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">노출/미노출</label>
				<div class="col-sm-10">
					<div class="input-group">
						<input type="radio" name="mis_allowed" value="1"  id="allowed" <?php echo set_radio('mis_allowed', '1', (element('mis_allowed', element('data', $view)) === '1' ? true : false)); ?> <?=$disabled?> /> <label for="allowed" style="margin:0 5px;">노출</label>
						<input type="radio" name="mis_allowed" value="0"  id="not_allowed" <?php echo set_radio('mis_allowed', '0', (element('mis_allowed', element('data', $view)) === '2' ? true : false)); ?> <?=$disabled?> /> <label for="not_allowed" style="margin-left:5px;">미노출</label>
					</div>
				</div>
			</div>
			<?php if(element('data', $view)){ ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">현재 상태</label>
				<div class="col-sm-10 form-inline">
					<input type="text" style="all:unset; height:30px; display:inline-block; vertical-align:middle;" disabled value="<?=element('state', element('data', $view)) == 'end' ? '마감' : (element('state', element('data', $view)) == 'planned' ? '오픈예정' : '진행중')?>" />
				</div>
			</div>
			<?php } ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">오픈날짜(오픈예정시에만)</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="mis_opendate" value="<?php echo set_value('mis_opendate', element('mis_opendate', element('data', $view))); ?>" readonly /> * 날짜 선택시 오픈예정으로 미션목록에 출력됩니다.
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">마감날짜(마감시간 사용시에만)</label>
				<div class="col-sm-10 form-inline">
					<input type="text" class="form-control" name="mis_enddate" value="<?php echo set_value('mis_enddate', element('mis_enddate', element('data', $view))); ?>" readonly />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">본문</label>
				<div class="col-sm-10">
					<!-- <textarea class="form-control" rows="10" name="mis_content"><?php echo set_value('mis_content', element('mis_content', element('data', $view))); ?></textarea> -->
					<?php 
					if($disabled){
						echo element('mis_content', element('data', $view));
					} else {
						echo display_dhtml_editor('mis_content', set_value('mis_content', element('mis_content', element('data', $view))), $classname = 'dhtmleditor', true, $editor_type = $this->cbconfig->item('post_editor_type')); 
					}
					?>
				</div>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-danger btn-sm" id="finish" data-finish="1" <?=$disabled?>>마감하기</button>
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
				<button type="submit" class="btn btn-success btn-sm" <?=$disabled?>>저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
<?php if(!$disabled){ ?>
	$("input[name=mis_opendate]").datetimepicker({
		format: 'yyyy-mm-dd hh:ii:00',
		startDate: moment().format("YYYY-MM-DD HH:mm:00"),
		todayBtn: true,
		autoclose: true
	});
	$("input[name=mis_enddate]").datetimepicker({
		format: 'yyyy-mm-dd hh:ii:00',
		startDate: moment().format("YYYY-MM-DD HH:mm:00"),
		todayBtn: true,
		autoclose: true
	});
	<?php if(element('data', $view)){ ?>
	$("#finish").on('click',function(){
		if(!confirm('마감후 되돌릴 수 없습니다.\n정말 강제로 마감하시겠습니까?')) return false;
		let csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
		let csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
		$.ajax({
			type: 'post',
			dataType: "json",
			url:'/admin/cic/missionlist/ajax_finish_mission',
			data:{
				[csrfName]: csrfHash,
				'mid': <?php echo element(element('primary_key', $view), element('data', $view)); ?>,
				'finish' : $(this).attr('data-finish')
			},
			success(result){
				if(result.type == 'success'){
					alert($('#finish').attr('data-finish')==1 ? '마감되었습니다.' : '강제마감이 취소되었습니다.');
					location.reload();
					return;
				} else if (result.type == 'error'){
					alert(result.data);
					return;
				} else {
					throw new error('unhandled error occur');
				}
				
			}
		});
	});
<?php 
	}
} 
?>
//<![CDATA[
$(function() {
	$('#fadminwrite').validate({
		rules: {
			mis_title: { required: true, minlength:2, maxlength:20 },
			mis_thumb_type: { required :true, digits:true, range:[1,2] },
			mis_thumb_youtube: { url :true },
			mis_per_token: { required :true, digits :true, min :1, maxlength :11},
			// mis_max_point: { required :true, digits :true, min :1, maxlength :11},
			mis_sf_percentage: { required :true, digits :true, min :0, max :9999},
			mis_allowed: { required :true, digits :true, range :[0,1] },
			// mis_opendate: { date :true },
			// mis_enddate: { date :true },
			mis_content: { '<?='required_' . $this->cbconfig->item('post_editor_type')?>' :true }
		}
	});
});

//]]>
</script>
