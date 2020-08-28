<meta http-equiv="Content-Type" content="text/html; charset=<?php echo config_item('charset');?>" />
<style type="text/css">
th {font-weight:bold;padding:5px; min-width:120px; width:120px; _width:120px; text-align:center; line-height:18px; font-size:12px; color:#959595; font-family:dotum,돋움; border-right:1px solid #e4e4e4;}
td {text-align:center; line-height:40px; font-size:12px; color:#474747; font-family:gulim,굴림; border-right:1px solid #e4e4e4;}
</style>
<table width="100%" border="1" bordercolor="#E4E4E4" cellspacing="0" cellpadding="0">
		<tr>
			<th>index</th>
			<th>제목</th>
			<th>본문</th>
			<th>썸네일유형</th>
			<th>썸네일이미지</th>
			<th>썸네일이미지경로</th>
			<th>썸네일유튜브</th>
			<th>목표포인트</th>
			<th>노출여부</th>
			<th>미션시작예정일</th>
			<th>강제마감여부</th>
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
				<td height="160"><?php echo element('mis_id', $result); ?></td>
				<td><?php echo html_escape(element('mis_title', $result)); ?></td>
				<td><?php echo html_escape(element('mis_content', $result)); ?></td>
				<td><?php echo html_escape(element('mis_thumb_type', $result)); ?></td>
				<td style="width:200px;"><?php if(element('mis_thumb_image', $result)){ ?><img src="<?php echo thumb_url('mission_thumb_img', element('mis_thumb_image', $result), 200, 160); ?>" alt="제출이미지" title="제출이미지"/> <?php } ?></td>
				<td><?php echo element('mis_thumb_image', $result) ? thumb_url('mission_thumb_img', element('mis_thumb_image', $result), 200, 160) : ''; ?></td>
				<td><?php echo html_escape(element('mis_thumb_youtube', $result)); ?></td>
				<td><?php echo html_escape(element('mis_max_point', $result)); ?></td>
				<td><?php echo element('mis_allowed', $result)? '노출' : '미노출'; ?></td>
				<td><?php echo html_escape(element('mis_opendate', $result)); ?></td>
				<td><?php echo element('mis_end', $result) ? 'O': 'X'; ?></td>
				<td><?php echo html_escape(element('mem_userid', element('register_member', $result))); ?></td>
				<td><?php echo element('mis_register_ip', $result); ?></td>
				<td><?php echo element('mis_wdate', $result); ?></td>
				<td><?php echo html_escape(element('mem_userid', element('modifier_member', $result))); ?></td>
				<td><?php echo element('mis_modifier_ip', $result); ?></td>
				<td><?php echo element('mis_mdate', $result); ?></td>
				<td><?php echo element('mis_deletion', $result); ?></td>
			</tr>
		<?php
			}
		}
		?>
</table>
