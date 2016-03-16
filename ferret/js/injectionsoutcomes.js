var sel_lit_num = 0;


function literature_select() {
	
	if (sel_lit_num > 0 ) {
		
		var str = $F('autocomplite_auth');
	
		$('autocomplite_auth').value = '';			
		$('auto_block').hide();			
		$('literature').insert({bottom:'<span id="'+sel_lit_num+'">'+str+'<a href="#" onclick="lit_replace(\''+sel_lit_num+'\'); return false;"> Replace</a><br/></span>'});
		$('lit_block').show();
		
		load_data();
		
		
		
	
	
	} else {
		
		alert('You must find and select an Literature first!');
		
	}
	
}

function lit_replace(id) {
	
	sel_lit_num = 0;
	$(id).hide();
	$(id).update();
	
	$('auto_block').show();
	
	$('lit_block').hide();
	
	clear_data();
	
	
}


function load_data(){
	
	
	if (sel_lit_num > 0 ) {
		
		
		
		new Ajax.Updater('data_column','index.php/injectionsoutcomes/ajaxGetAllRelations', {
			  method: 'post',
			  postBody:'literature_id='+sel_lit_num,
			  
		});
		
		
		
		$('data_block').show();	
	}
}
	

function clear_data(){
	
	
	$('data_column').update();
	
	$('data_block').hide();
	
		
		
}


function add_relation(oid){
	
	if (sel_lit_num > 0 ) {
		
		new Ajax.Updater('outcome_injections_column_'+oid,'index.php/injectionsoutcomes/ajaxGetRelationsForm', {
			  method: 'post',
			  postBody:'literature_id='+sel_lit_num+'&oid='+oid,
			  insertion: Insertion.Bottom,
		});
		
		
	}
	
	
}

function delete_relation(id){
	
	if (confirm('Are you sure you want to delete relation?')){
	
		$('relation_id_'+id).remove();
		
		new Ajax.Request('index.php/injectionsoutcomes/ajaxDelRelation', {
			  method: 'post',
			  postBody:'relation_id='+id,
		
		});
	}
	
}

function save_relation(id){
	
	var str = $('save_form_'+id).serialize();
	new Ajax.Request('index.php/injectionsoutcomes/ajaxSaveRelation', {
		  method: 'post',
		  postBody:'relation_id='+id+'&'+str,
	
	});
	
	var box = $('injections_id_'+id);
	var boxtext = box.selectedIndex >= 0 ? box.options[box.selectedIndex].innerHTML : undefined;
	
	
	
	$('relation_id_'+id).update(boxtext+'<a href="#" onclick="delete_relation(\''+id+'\')"> Delete</a><br/>');
	
	
	
	
}

function show_labeled(id) {
	
	$('labeled_sites_'+id).show();
	$('labeled_sites_show_button_'+id).hide();
	$('labeled_sites_hide_button_'+id).show();
	
}

function hide_labeled(id) {
	
	$('labeled_sites_'+id).hide();
	$('labeled_sites_show_button_'+id).show();
	$('labeled_sites_hide_button_'+id).hide();
	
}


function select_outcome(oid,rid) {
	$('save_form_'+rid).insert('<input type="hidden" value='+oid+' name="outcome_id" id="input_outcome_'+oid+'">');
	
	$('left_outcome_'+oid).hide();
	$('right_outcome_'+oid).show();
	
	$('outcomes_left_column_'+rid).hide();
	
}

function deselect_outcome(oid,rid) {
	
	
	$('input_outcome_'+oid).remove();
	
	$('left_outcome_'+oid).show();
	$('right_outcome_'+oid).hide();
	
	
}

function select_injection(nid,rid) {
	$('save_form_'+rid).insert('<input type="hidden" value='+nid+' name="injections_id" id="input_injection_'+nid+'">');
	
	$('left_injection_'+nid).hide();
	$('right_injection_'+nid).show();
	
	
}

function deselect_injection(nid,rid) {
	$('input_injection_'+nid).remove();
	
	$('left_injection_'+nid).show();
	$('right_injection_'+nid).hide();
	
}

	
	
	
	
	
	
	
	

