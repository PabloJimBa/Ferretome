var param_id = 0;

function load_fields(pid) {
	
	new Ajax.Updater('parameter_fields','index.php/parameters/ajaxGetFields', {
		  method: 'post',
		  postBody:'pid='+pid,
	});
	
	param_id = pid;
	
	
}

function delete_field(fid,pid) {
	
	new Ajax.Request('index.php/parameters/ajaxDeleteField', {
		  method: 'post',
		  postBody:'fid='+fid,
	
	});
	
	
	load_fields(param_id);
	
	
}

function load_param_fields_form(pid) {
	
	
	new Ajax.Updater('new_field_form','index.php/parameters/ajaxGetFieldsForm', {
		  method: 'post',
		  postBody:'pid='+pid,
	});
	
	
}

function cancel_new_field_form(){
	
	
	$('new_field_form').update();
	
	
}

function save_new_field(pid) {}