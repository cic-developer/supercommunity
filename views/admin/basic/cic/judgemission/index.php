<div class="box">
	<div class="box-table">
		<?php
		echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="box-table-header">
				<div class="btn-group btn-group-sm" role="group">
					<a href="<?=$this->input->get('wht_id') ? '?wht_id='.$this->input->get('wht_id') : '?'?>" class="btn btn-sm <?php echo ( ! $this->input->get('jud_state') && $this->input->get('jud_state') !== '0' ) ? 'btn-success' : 'btn-default'; ?>">전체목록</a>
					<a href="?jud_state=1<?=$this->input->get('wht_id') ? '&wht_id='.$this->input->get('wht_id') : ''?>" class="btn btn-sm <?php echo ($this->input->get('jud_state')) === '1' ? 'btn-success' : 'btn-default'; ?>">대기목록</a>
					<a href="?jud_state=3<?=$this->input->get('wht_id') ? '&wht_id='.$this->input->get('wht_id') : ''?>" class="btn btn-sm <?php echo ($this->input->get('jud_state')) === '3' ? 'btn-success' : 'btn-default'; ?>">승인목록</a>
					<a href="?jud_state=0<?=$this->input->get('wht_id') ? '&wht_id='.$this->input->get('wht_id') : ''?>" class="btn btn-sm <?php echo ($this->input->get('jud_state')) === '0' ? 'btn-success' : 'btn-default'; ?>">반려목록</a>
				</div>
				<div class="btn-group btn-group-sm" role="group">
					<a href="<?=$this->input->get('jud_state')||$this->input->get('jud_state')==='0' ? '?jud_state='.$this->input->get('jud_state') : '?'?>" class="btn btn-sm <?php echo ( ! $this->input->get('wht_id')) ? 'btn-success' : 'btn-default'; ?>">화이트리스트 전체</a>
					<?php
					foreach (element('list',element('all_whitelist', $view)) as $wkey => $wval) {
					?>
						<a href="?wht_id=<?php echo element('wht_id', $wval); ?><?=$this->input->get('jud_state')||$this->input->get('jud_state')==='0' ? '&jud_state='.$this->input->get('jud_state') : ''?>" class="btn btn-sm <?php echo (element('wht_id', $wval) === $this->input->get('wht_id')) ? 'btn-success' : 'btn-default'; ?>"><?php echo element('wht_title', $wval); ?></a>
					<?php
					}
					?>
				</div>
				<?php
				ob_start();
				?>
					<div class="btn-group pull-right" role="group" aria-label="...">
						<button type="button" class="btn btn-outline btn-success btn-sm" id="export_to_excel"><i class="fa fa-file-excel-o"></i> 엑셀 다운로드</button>
						<a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
						<a href="<?php echo element('denyreason_url', $view); ?>" class="btn btn-outline btn-default btn-sm">반려사유</a>
					</div>
				<?php
				$buttons = ob_get_contents();
				ob_end_flush();
				?>
			</div>
			<div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th><a href="<?php echo element('jud_id', element('sort', $view)); ?>">번호</a></th>
							<th><a href="<?php echo element('mis_title', element('sort', $view)); ?>">미션제목</a></th>
							<th><a href="<?php echo element('jud_med_wht_id', element('sort', $view)); ?>">미디어플랫폼</a></th>
							<th>관리자명</th>
							<th>링크</th>
							<th>첨부이미지</th>
							<th><a href="<?php echo element('jud_state', element('sort', $view)); ?>">상태</a></th>
							<th>신청자</th>
							<th><a href="<?php echo element('jud_wdate', element('sort', $view)); ?>">신청일</a></th>
							<th>승인</th>
							<th>자세히</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td><?php echo number_format(element('num', $result)); ?></td>
							<td><?php echo html_escape(element('mis_title', $result)); ?></td>
							<td><?php echo html_escape(element('wht_title', $result)); ?></td>
							<td><?php echo html_escape(element('jud_med_admin', $result)); ?></td>
							<td><a href="<?php echo element('jud_med_url', $result); ?>" target="_blank"><?php echo mb_strlen(element('jud_med_url', $result)) > 15 ? mb_substr(element('jud_med_url', $result),0,15).'...' : element('jud_med_url', $result); ?></a></td>
							<td><img class="img_modal" src="<?php echo thumb_url('judge_img', element('jud_attach', element('data', $view)), 200, 160); ?>" alt="제출이미지" title="제출이미지" style="cursor:pointer;" data-img="<?=thumb_url('judge_img', element('jud_attach', element('data', $view)), 800, 600)?>"/></td>
							<td><?php echo rs_get_state(element('jud_state', $result)); ?></td>
							<td><?php echo element('display_name', $result); ?></td>
							<td><?php echo display_datetime(element('jud_wdate', $result), 'user', 'Y-m-d'); ?><br/><?php echo display_datetime(element('jud_wdate', $result), 'user', 'H:i:s'); ?></td>
							<td><a class="btn btn-outline btn-default btn-xs set_confirm" data-judid="<?php echo element(element('primary_key', $view), $result); ?>" data-value="confirm" <?=element('jud_state', $result)!=1 ? 'disabled' : ''?>><?=element('jud_state', $result)!=1 ? rs_get_state(element('jud_state', $result)) : '승인'?></a></td>
							<td><a href="<?php echo admin_url($this->pagedir); ?>/detail/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">자세히</a></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="17" class="nopost">자료가 없습니다</td>
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
			<div class="box-info">
				<?php echo element('paging', $view); ?>
				<div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
				<?php echo $buttons; ?>
			</div>
		<?php echo form_close(); ?>
	</div>
	<form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
		<div class="box-search">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<select class="form-control" name="sfield" >
						<?php echo element('search_option', $view); ?>
					</select>
					<div class="input-group">
						<input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
	
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
	
		<!-- Modal content-->
		<div class="modal-content" style="position:absolute; z-index:2000">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">이미지 상세</h4>
			</div>
			<div class="modal-body" style="text-align:center;">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
		
	</div>
</div>
<!-- Modal End -->

<script type="text/javascript">
//<![CDATA[

$(document).on('click', '#export_to_excel', function(){
	exporturl = '<?php echo admin_url($this->pagedir . '/excel' . '?' . $this->input->server('QUERY_STRING', null, '')); ?>';
	document.location.href = exporturl;
});

$(document).on('click', '.img_modal', function(){
	$(".modal-body").html("<img src='"+$(this).attr('data-img')+"' alt='제출이미지' style='width:100%;height:auto;'/>" );
	$("#myModal").modal({
		backdrop:false
	});
});

$(document).on('click','.set_confirm',function(){
  if(!confirm('정말 승인처리 하시겠습니까?')) return false;
	let csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  let csrfHash  = '<?php echo $this->security->get_csrf_hash(); ?>';
  let _jul_id   = $(this).attr('data-judid');;
  let _value    = $(this).attr('data-value');
  let _state    = 3;
  $.ajax({
		type: 'post',
		dataType: "json",
		url:'/admin/cic/judgemission/ajax_set_state',
		data:{
			[csrfName]: csrfHash,
			jud_id:_jul_id,
      value:_value,
      state:_state
		},
		success(result){
			if(result.type == 'success'){
        alert('승인되었습니다.');
				location.reload();
			} else if (result.type == 'error'){
				alert(result.data);
				return;
			} else {
				throw new error('unhandled error occur');
			}
			
		}
	});
});
//]]>
</script>