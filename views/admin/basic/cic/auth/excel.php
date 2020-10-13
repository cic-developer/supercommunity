<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
			<th>index</th>
			<th>회원 닉네임(ID)</th>
			<th>지갑주소</th>
			<th>주소등록일</th>
		</tr>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
			<tr>
				<td height="30"><?php echo element('num', $result); ?></td>
				<td><?php echo html_escape(element('display_name', $result)); ?></td>
				<td><?php echo html_escape(element('wallet_address',$result)); ?></td>
				<td><?php echo element('wallet_date', $result); ?></td>
			</tr>
		<?php
			}
		}
		?>
</table>
