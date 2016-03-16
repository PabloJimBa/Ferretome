var sel_acr_num = 0;

function search_do(){
	
	
	if (sel_acr_num > 0){
		
		new Ajax.Updater('search_result','index.php/acronyms/searchDo', {
			method: 'post',
			postBody:'acrid='+sel_acr_num,
		});
	
	
	
		sel_acr_num = 0;
	
	
	
	} 
	
}