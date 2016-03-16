var sel_lit_num = 0;

var sel_inj_num = 0;

var sel_source_num = 0;

var current_param = 0;


function literature_select() {
	
	if (sel_lit_num > 0 ) {
		
		var str = $F('autocomplite_auth');
	
		$('autocomplite_auth').value = '';			
		$('auto_block').hide();
		
		
		new Ajax.Updater ('injection_block','index.php/injections/ajaxGetInjections',
				{
			
				method: 'post',
				postBody:'pubid2='+sel_lit_num+'&method=special',
			
				});
		
		
			
		$('literature').insert({bottom:'<span id="lit_'+sel_lit_num+'">'+str+'<a href="#" onclick="lit_replace(\''+sel_lit_num+'\'); return false;"> Replace</a><br/></span>'});
		$('lit_block').show();
		$('injections_tr').show();
		
		
			
	
	} else {
		
		alert('You must find and select an Literature first!');
		
	}
	
}

function lit_replace(id) {
	
	sel_lit_num = 0;
	$('lit_'+id).hide();
	$('lit_'+id).update();
	
	$('injection_block').update();
	sel_inj_num = 0;
	
	$('parameters_block').update();
	
	$('auto_block').show();
	
	$('lit_block').hide();
	
}


function load_data(){
	
	
	sel_inj_num =  $F('injections_id');
	
	if (sel_inj_num > 0) {
		
		new Ajax.Updater ('parameters_block','index.php/injectionsdata/ajaxGetInjectionsData',
				{
			
				method: 'post',
				postBody:'id='+sel_inj_num
			
				});
		
		
		
		
	} 
	
	
	var box = $('injections_id');
	
	var key = box.selectedIndex >= 0 ? box.options[box.selectedIndex].innerHTML : undefined;
		
	$('sel_injection_block').update(key);
	
	
	$('sel_injection_block').show();
	$('sel_injection_block_button').show();
	$('data_block').show();
	
	$('injections_id').hide();
	$('sel_injection_block_button_select').hide();
	
	
	
	
}


function replace_injection (){
	
	$('sel_injection_block').hide();
	$('sel_injection_block_button').hide();
	$('data_block').hide();
	
	$('parameters_block').update();
	
	$('injections_id').show();
	$('sel_injection_block_button_select').show();
	
	
}


function add_data(){
	
	if (sel_inj_num > 0) {
	
	
		new Ajax.Updater('parameters_block','index.php/injectionsdata/ajaxGetDataForm', {
			  method: 'post',
			  postBody:'injections_id='+sel_inj_num+'&literature_id='+sel_lit_num,
			  insertion: Insertion.Bottom,
		});
	
	} 
	
	
}


function save_data(id) {
	
	
var poststring = $('data_form_'+id).serialize();
	
	new Ajax.Request('index.php/injectionsdata/ajaxInsertData', {
		  method: 'post',
		  postBody:poststring,
	
	});
	
	var box = $('parameters_id');
	var key = box.selectedIndex >= 0 ? box.options[box.selectedIndex].innerHTML : undefined;
	
	var val = $F('parameters_value');
	
	$('data_'+id).update(key+' : '+val+'<a href="#" onclick="del_data(\''+id+'\')">Delete</a><br/>');
	
	
	
}


function del_data(id) {
	
	
	new Ajax.Request('index.php/injectionsdata/ajaxDelData', {
		  method: 'post',
		  postBody:'data_id='+id,
	
	});
	
	$('data_'+id).remove();
	
	
}






function specify_literature(pm){
	
	$('source_table').show();
	
	$('data_table').hide();
	
	current_param = pm;
	
	
	
	
}


function source_select(){
	
	if (current_param == 0) {
		
		alert('error nothing was selected');
		cancel_source();
		return false;
	}
	
	if (sel_source_num > 0) {
		
		var str = $F('autocomplite_source');
		
		$('selected_source_parameter_'+current_param).update(str);
		$('literature_id_'+current_param).value = sel_source_num;
		cancel_source();
	}
	
	
}

function cancel_source(){
	
	$('autocomplite_source').value = '';
	
	$('source_table').hide();
	
	$('data_table').show();
	
	current_param = 0;
	sel_source_num = 0;
	
	
}



function show_description() {
	
	var pid = $F('parameters_id');
	
	
	new Ajax.Updater('popup_block','index.php/injectionsparameters/ajaxGetParametersDescription', {
		  method: 'post',
		  postBody:'pid='+pid
		  
	});
	
	$('popup_block').style.zIndex = 10;
	$('popup_block').show();
	
	
}

function hide_description() {
	
	$('popup_block').style.zIndex = 0;
	$('popup_block').hide();
	
	
}

function change_input(){
	
	
var pid = $F('parameters_id');
	
	
	new Ajax.Updater('parameters_value_block','index.php/parameters/ajaxGetParametersInput', {
		  method: 'post',
		  postBody:'pid='+pid
		  
	});
	
	
}



