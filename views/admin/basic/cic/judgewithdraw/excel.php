<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
			<th>index</th>
			<th>지갑주소</th>
			<th>수량</th>
			<th>상태</th>
			<th>반려사유</th>
			<th>작성자</th>
			<th>작성자ip</th>
			<th>작성일</th>
			<th>수정자</th>
			<th>수정자ip</th>
			<th>수정일</th>
			<th>미션삭제여부</th>
		</tr>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
			<tr>
				<td height="30"><?php echo element('jud_id', $result); ?></td>
				<td><?php echo html_escape(element('jud_wallet', $result)); ?></td>
				<td><?php echo number_format(element('jud_point', $result),1); ?></td>
				<td><?php echo rs_get_state(element('jud_state', $result)); ?></td>
				<td><?php echo html_escape(element('judn_reason', $result)); ?></td>
				<td><?php echo html_escape(element('jud_mem_nickname', $result).'('.(element('mem_userid', element('register_member', $result)) ? element('mem_userid', element('register_member', $result)) : '탈퇴회원').')'); ?></td>
				<td><?php echo element('jud_register_ip', $result); ?></td>
				<td><?php echo element('jud_wdate', $result); ?></td>
				<td><?php echo html_escape(element('mem_userid', element('modifier_member', $result))); ?></td>
				<td><?php echo element('jud_modifier_ip', $result); ?></td>
				<td><?php echo element('jud_mdate', $result); ?></td>
				<td><?php echo element('jud_deletion', $result); ?></td>
			</tr>
		<?php
			}
		}
		?>
</table>
