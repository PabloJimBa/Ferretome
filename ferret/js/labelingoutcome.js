var sel_lit_num = 0;
function literature_select() {
	
	if (sel_lit_num > 0 ) {
		
	var str = $F('autocomplite_auth');
	
		$('autocomplite_auth').value = '';
		$('autocomplite_auth').disable();		
		$('auto_block').hide();
		$('lit_block').show();
			
		$('literature').insert({bottom:'<span id="'+sel_lit_num+'"><input type="hidden" name="literature_id" value="'+sel_lit_num+'"> '+str+'<a href="#" onclick="lit_replace(\''+sel_lit_num+'\'); return false;"> Replace</a><br/></span>'});
		
		load_data();
	
	
	} else {
		
		alert('You must find and select an Literature first!');
		
	}
	
}

function lit_replace(id) {
	
	sel_lit_num = 0;
	$(id).hide();
	$(id).update();
	
	$('autocomplite_auth').enable();
	$('auto_block').show();
	
	$('lit_block').hide();
	
	clear_data();
	
		
	
}

function load_data() {
	
	if (sel_lit_num > 0 ) {
		
		new Ajax.Updater('data_column','index.php/labelingoutcome/ajaxGetOutcomes', {
			  method: 'post',
			  postBody:'pubid2='+sel_lit_num+'&method=extended',
		});
		
		
	}
	
	$('data_row').show();
	
	
}

function clear_data(){
	
	$('data_row').hide();
	$('data_column').update();
	
}

function add_outcome() {
	
if (sel_lit_num > 0 ) {
		
		new Ajax.Updater('data_column','index.php/labelingoutcome/ajaxGetInsertForm', {
			  method: 'post',
			  postBody:'literature_id='+sel_lit_num,
			  insertion: Insertion.Bottom,
		});
		
		
	}
	
}

function save_outcome(id){
	
	var str = $('insert_form_'+id).serialize();
	new Ajax.Request('index.php/labelingoutcome/ajaxSaveOutcome', {
		  method: 'post',
		  postBody:str,
	
	});
	
	load_data();
	
	
}

function delete_outcome(id){
	
	$('outcome_'+id).remove();
	
	
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


function show_coding_rules(id){
	
	new Ajax.Updater('help_div','index.php/welcome/ajaxGetCodingRules', {
		  method: 'post',
		  postBody:'rule_id='+id,
	});
	
	
}

