var sel_auth_num = 0;

function search_do(){
	
	
	if (sel_auth_num > 0){
		
		new Ajax.Updater('search_result','index.php/authors/searchDo', {
			method: 'post',
			postBody:'authid='+sel_auth_num,
		});
	
	
	
		sel_auth_num = 0;
	
	
	
	} 
	
}