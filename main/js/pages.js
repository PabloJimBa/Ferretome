function refresh_file_list(response_data) {
	
	new Ajax.Updater('files_block','index.php/pages/ajaxGetFiles', {
		  method: 'post',
		  postBody:'something=1',
	});
	
}