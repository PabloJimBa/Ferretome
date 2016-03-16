var search_trigger = 1;
var activ_block = 'literature';
var activ_search = 'title';
var sel_lit_num = 0;
var sel_auth_num = 0;
var search_string = '';
var last_search = '';
var orderby = 'literature_title';
var order = 'desc';

function show_block(id){
	
	if (activ_block != id) {
		
		
		$(activ_block+'_search_block').hide();
		
		activ_block = id;
		
		$(activ_block+'_search_block').show();
		
	}
	
	
	
}

function switch_search(id){
	
	if (activ_search != id) {
		
		$(activ_search+'_search_field').hide();
		
		activ_search = id;
		
		$(activ_search+'_search_field').show();
		
		
	} 
	
	
	
}

function search_do(){
	
	
	last_search = 'q='+search_string+'&strigger='+activ_search;
	
	new Ajax.Updater('search_result','index.php/literature/searchDo', {
		method: 'post',
		postBody:last_search+'&orderby='+orderby+'&order='+order
	});
	
	
}


function search_literature_by_authors_id(id){
	
	switch_search('authors');
	search_string = id;
	search_do();
	
}

function search_by(id,sblock) {
	
	
	var temp = activ_search;
	search_string = id;
	activ_search = sblock;
	search_do();
	activ_search = temp;
	
	
}

function change_order(oby,ord){
	
	orderby = oby;
	order =  ord;
	
	new Ajax.Updater('search_result','index.php/literature/searchDo', {
		method: 'post',
		postBody:last_search+'&orderby='+orderby+'&order='+order
	});
	
}



function check_form(frm){
	
	search_by($F('autocomplite_1')+" "+$F('autocomplite_2'), 'anything');
	
	
	return false;	
}
