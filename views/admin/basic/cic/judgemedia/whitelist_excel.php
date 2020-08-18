<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
			<th>제목</th>
			<th>도메인</th>
			<th>관리용 메모</th>
			<th>작성자</th>
			<th>작성일</th>
			<th>최근 수정자</th>
			<th>최근 수정일</th>
			<th>최근 작성/수정자 ip</th>
			<th>삭제여부</th>
		</tr>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
			<tr>
				<td height="30"><?php echo html_escape(element('wht_title', $result)); ?></td>
				<td><?php echo html_escape(element('wht_domains', $result)); ?></td>
				<td><?php echo html_escape(element('wht_memo', $result)); ?></td>
				<td><?php echo html_escape(element('mem_userid', element('member', $result))); ?></td>
				<td><?php echo element('wht_wdate', $result); ?></td>
				<td><?php echo html_escape(element('mem_userid', element('latest_member', $result))); ?></td>
				<td><?php echo element('wht_mdate', $result); ?></td>
				<td><?php echo element('wht_ip', $result); ?></td>
				<td><?php echo element('wht_deletion', $result); ?></td>
			</tr>
		<?php
			}
		}
		?>
</table>
