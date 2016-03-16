var gotourl = '';
function send_update_reason(frm){
	
	var params = frm.serialize();
	new Ajax.Request(frm.action, {
		  method: 'post',
		  postBody:params,
		  
		});
	
	close_upd_form();
	
	return false;	
}


function close_upd_form() {
	
	$('update_dlg').hide();
	
	if (gotourl.length > 0) window.location.replace(gotourl);
	
}


