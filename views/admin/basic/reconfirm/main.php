<div class="box">
	<div class="box-table">
		<?php
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="form-group">
				<label class="col-sm-2 control-label">성함</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cic_name" value="" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">비밀번호</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="cic_password" value="" required />
				</div>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="submit" class="btn btn-success btn-sm">본인인증</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>