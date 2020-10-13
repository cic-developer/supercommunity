<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
			<th>index</th>
			<th>문의 유형</th>
			<th>문의자</th>
			<th>문의 단체</th>
			<th>회신 이메일</th>
			<th>연락처</th>
			<th>문의내용</th>
			<th>작성일</th>
		</tr>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
			<tr>
				<td><?php echo element('inq_id', $result); ?></td>
				<td><?php echo element('inq_type', $result) == 1 ? '광고문의' : '컨설팅문의'; ?></td>
				<td><?php echo html_escape(element('inq_name', $result)); ?></td>
				<td><?php echo html_escape(element('inq_group', $result)); ?></td>
				<td><?php echo html_escape(element('inq_email', $result)); ?></td>
				<td><?php echo html_escape(element('inq_tel', $result)); ?></td>
				<td><?php echo preg_replace('(&lt;br&gt;|&lt;br \/&gt;)', "<br />", html_escape(element('inq_contents', $result))); ?></td>
				<td><?php echo element('inq_wdate', $result); ?></td>
			</tr>
		<?php
			}
		}
		?>
</table>
