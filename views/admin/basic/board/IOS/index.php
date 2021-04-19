<?php 
    // print_r(element('ios_wallet_noti',element('data', $view)));exit;
?>
<div class="box">
	<div class="box-table">
		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('message', $view), '<div class="alert alert-warning">', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open_multipart(current_full_url(), $attributes);
		?>
			<div class="form-group">
				<label class="col-sm-2 control-label">월렛 가이드</label>
				<div class="col-sm-10">
					<?php 
					if($disabled){
						echo element('ios_wallet_noti', element('data', $view));
					} else {
						echo display_dhtml_editor(
                            'ios_wallet_noti',
                            set_value('ios_wallet_noti',
                                element('ios_wallet_noti',
                                element('data', $view))
                            ), 
                            $classname = 'dhtmleditor', 
                            true, 
                            $editor_type = $this->cbconfig->item('post_editor_type')
                        ); 
					}
					?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">스테이킹 가이드</label>
				<div class="col-sm-10">
					<?php 
					if($disabled){
						echo element('ios_stacking_noti', element('data', $view));
					} else {
						echo display_dhtml_editor(
                            'ios_stacking_noti',
                            set_value(
                                'ios_stacking_noti', 
                                element('ios_stacking_noti', 
                                    element('data', $view)
                                )
                            ),
                            $classname = 'dhtmleditor', 
                            true, 
                            $editor_type = $this->cbconfig->item('post_editor_type')
                        ); 
					}
					?>
				</div>
			</div>

			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-default btn-sm btn-history-back" >취소하기</button>
				<button type="submit" class="btn btn-success btn-sm" <?=$disabled?>>저장하기</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[

$(function() {
	$('#fadminwrite').validate({
		rules: {
			ios_wallet_noti: { '<?='required_' . $this->cbconfig->item('post_editor_type')?>' :true },
			ios_stacking_noti: { '<?='required_' . $this->cbconfig->item('post_editor_type')?>' :true },
		}
	});
});
//]]>
</script>
