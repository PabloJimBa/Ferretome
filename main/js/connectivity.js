var sel_lit_num = 0;
var lit_title = '';

function select_lit(){
	
	
	if (sel_lit_num != 0) {
	
		new Ajax.Updater('connectivity_output','index.php/connectivity/outputConnectivity', {
			method: 'get',
			parameters:'lid='+sel_lit_num
		});
	
	}
	
	$('selected_lit_field').update(lit_title);
	$('selected_lit_block').show();
	$('frm').hide();
	
	
	
	
}


function replace_lit() {
	
	$('selected_lit_block').hide();
	$('frm').show();
	
	$('autocomplite_1').value = '';
	
	
	
}

function show_logic(bsa,bsb) {
	
	new Ajax.Updater('connectivity_explanation','index.php/connectivity/getExplanation', {
		method: 'get',
		parameters:'bsa='+bsa+'&bsb='+bsb
	});
	
	
}