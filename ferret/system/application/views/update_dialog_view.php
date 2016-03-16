<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<div id="update_dlg" style="display:none;">
<p><strong>Please provide a feedback for update action</strong> <a href="#" onclick="close_upd_form(); return false;">Hide</a></p>

<form id="upd_dialog_frm" action="index.php?c=journal&m=saveUpdateReason" method="post" name="upd_dialog_frm">
<table>
<tr><td><strong>Reason for update</strong></td><td><?php echo form_dropdown('log_parameter', $journal_options_data);?><input type="hidden" id="log_id" name="log_id" value=""></td></tr>
<tr><td><strong>Comments</strong></td><td><textarea class="textarea" id="log_comment" name="log_comment" cols="30" rows="10" ></textarea></td></tr>
<tr><td></td><td><input type="submit" value="Send"></td></tr>
</table>
</form>

</div>
