<table width="600" border="0" cellpadding="0" cellspacing="0" style="border-left: 1px solid rgb(226,226,225);border-right: 1px solid rgb(226,226,225);background-color: rgb(255,255,255);border-top:10px solid #348fe2; border-bottom:5px solid #348fe2;border-collapse: collapse;">
	<tr>
		<td width="101" style="padding:20px 30px;font-family: Arial,sans-serif;color: rgb(0,0,0);font-size: 14px;line-height: 20px;"><?php echo html_escape(element('site_title', $email_data)); ?></td>
		<td width="497" style="font-size:12px;padding:20px 30px;font-family: Arial,sans-serif;color: rgb(0,0,0);font-size: 14px;line-height: 20px;"><span style="font-size:14px;font-weight:bold;color:rgb(0,0,0)"><?=$this->lang->line(0)?> <?php echo html_escape(element('mem_nickname',$email_data))?> <?=$this->lang->line(1)?>
		</td>
	</tr>
	<tr style="border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2;">
		<td colspan="2" style="padding:20px 30px;font-family: Arial,sans-serif;color: rgb(0,0,0);font-size: 14px;line-height: 20px;">
		<p><?=$this->lang->line(2)?></p>
		<p><?=$this->lang->line(3)?> <?php echo html_escape(element('auth_code', $email_data)) ?> <?=$this->lang->line(4)?></p>
		<p><?=$this->lang->line(5)?></p>
		</td>
	</tr>
</table>
