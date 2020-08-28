<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
			<th>index</th>
			<th>사용자지정 미디어 이름</th>
			<th>미디어플랫폼</th>
			<th>링크</th>
			<th>미디어 성격</th>
			<th>관리자명</th>
			<th>SUPERPOINT</th>
			<th>PERFRIEND</th>
			<th>상태</th>
			<th>회원index</th>
			<th>회원닉네임</th>
			<th>등록유저 IP</th>
			<th>등록일</th>
			<th>미션삭제여부</th>
		</tr>
	<?php
	if (element('list', element('data', $view))) {
		foreach (element('list', element('data', $view)) as $result) {
	?>
			<tr>
				<td height="30"><?php echo element('med_id', $result); ?></td>
				<td><?php echo html_escape(element('med_name', $result)); ?></td>
				<td><?php echo html_escape(element('wht_title', $result)); ?></td>
				<td>
					<?php echo html_escape(element('med_url', $result)); ?>
					<?php if(element('med_duplicate',$result)){ ?>
						(중복)
					<?php } ?>
				</td>
				<td><?php echo html_escape(element('mediatype', $result)); ?></td>
				<td><?php echo html_escape(element('med_admin', $result)); ?></td>
				<td><?php echo number_format(element('med_superpoint', $result)); ?></td>
				<td><?php echo number_format(element('med_member', $result)); ?></td>
				<td><?php echo rs_get_state(element('med_state', $result)); ?></td>
				<td><?php echo html_escape(element('mem_id', $result)); ?></td>
				<td><?php echo html_escape(html_escape(element('mem_nickname', $result).'('.(element('mem_userid', element('register_member', $result)) ? element('mem_userid', element('register_member', $result)) : '탈퇴회원').')')); ?></td>
				<td><?php echo element('med_ip', $result); ?></td>
				<td><?php echo element('med_wdate', $result); ?></td>
				<td><?php echo element('mis_deletion', $result); ?></td>
			</tr>
		<?php
			}
		}
		?>
</table>
