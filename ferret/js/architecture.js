var param_number = 0;
var layers_added = [false,false,false,false,false,false,false];
var sel_lit_num = 0;
var sel_bsite_num = 0;
var current_param = 0;
var sel_source_num = 0;


function add_layer(id) {
	
	if (layers_added[id]) {
		
		alert("This layer was already added!");
		return false;  
		
	}	
	
	$('layer_'+id).show();
	
	layers_added[id] = true;
	
	
	
}

function del_layer(id){
	
	if (confirm('Are you sure you want to delete all parameters from this layer?')) {
	
		layers_added[id] = false;
		$('layer_'+id).hide();
		$('layer_'+id).update();
		
		new Ajax.Request('index.php/architecture/ajaxDelParametersFromLayer', {
			  method: 'post',
			  postBody:'bsite_id='+sel_bsite_num+'&layer_id='+id,
		});
	}
	
	
}


function add_parameter(id){
	
	new Ajax.Updater('layer_'+id+'_parameters','index.php/architecture/ajaxGetParametersForm', {
		  method: 'post',
		  postBody:'layer_id='+id+'&bsite_id='+sel_bsite_num+'&literature_id='+sel_lit_num,
		  insertion: Insertion.Bottom,
	});
	
	
	
}


function save_parameter(pid,lid){
	
	var poststring = $('layer_'+lid+'_parameter_'+pid).serialize();
	
	new Ajax.Request('index.php/architecture/ajaxInsertParameter', {
		  method: 'post',
		  postBody:poststring,
	
	});
	
	var box = $('parameters_id');
	var key = box.selectedIndex >= 0 ? box.options[box.selectedIndex].innerHTML : undefined;
	
	var val = $F('parameters_value');
	
	$('parameter_'+pid).update(key+' : '+val+'<a href="#" onclick="remove_parameter(\''+pid+'\')"> delete param </a><br/>');
	
	
	
}

function remove_parameter(pid){
	
	
	new Ajax.Request('index.php/architecture/ajaxDelParameter', {
		  method: 'post',
		  postBody:'architecture_id='+pid,
	
	});
	
	$('parameter_'+pid).remove();
	
	
	
	
}



function literature_select() {
	
	if (sel_lit_num > 0 ) {
		
		var str = $F('autocomplite_auth');
	
		$('autocomplite_auth').value = '';			
		$('auto_block').hide();
		
		$('autocomplite_bsite').enable();
		
		
		new Ajax.Request('index.php/brainsites/ajaxSetPublicationId', {
			  method: 'post',
			  postBody:'pubid='+sel_lit_num,
		});
		
		
			
		$('literature').insert({bottom:'<span id="'+sel_lit_num+'">'+str+'<a href="#" onclick="lit_replace(\''+sel_lit_num+'\'); return false;"> Replace</a><br/></span>'});
		$('lit_block').show();
		
	
	
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
	
	bsite_replace();
	
	
	$('autocomplite_bsite').value = '';
	
	$('autocomplite_bsite').disable();
	
	$('bsite_block').hide();
	$('sel_bsite').update();
	
}




function bsite_select() {
	
	if (sel_bsite_num > 0 ) {
		
	var str = $F('autocomplite_bsite');
	
		$('autocomplite_bsite').value = '';
				
		$('bsite_auto_block').hide();
		
		$('sel_bsite').insert({bottom:'<span id="'+sel_bsite_num+'"><input type="hidden" name="brain_sites_id" value="'+sel_bsite_num+'"> '+str+'<a href="#" onclick="bsite_replace(\''+sel_bsite_num+'\'); return false;"> Replace</a><br/>'});
		
		$('bsite_block').show();
		
		populate_layers(sel_bsite_num);
		
		
		$('layer_menu').show();
		
	
	
	} else {
		
		alert('You must find and select an Brain site first!');
		
	}
	
}

function bsite_replace(id) {
	
	sel_bsite_num = 0;
	
	$('bsite_auto_block').show();
	
	$('bsite_block').hide();
	
	$('sel_bsite').update();
	
	$('layer_menu').hide();
	
	flush_layers();
	
		
	
}



function populate_layers(bid){
	
	new Ajax.Request('index.php/architecture/ajaxGetAllParameters', {
		  method: 'post',
		  postBody:'bsite_id='+bid,
		  
		  
		  
		  onSuccess: function(transport){
		     var json = transport.responseText.evalJSON(true);
		     
		     if (json.result != '0') {
		    	 
		    	 for (var i=0; i<json.result; i++) {
		    		 
		    		 
		    		 $('layer_'+json.data[i].lnumber+'_parameters').insert({bottom:'<div id="parameter_'+json.data[i].pid+'"></div>'});
		    		 $('parameter_'+json.data[i].pid).update(json.data[i].pdc+' = '+json.data[i].pname+' : '+json.data[i].pvalue+'<a href="#" onclick="remove_parameter(\''+json.data[i].pid+'\')"> delete param </a><br/>');
		    		 
		    		 layers_added[json.data[i].lnumber] = true;
		    		 
		    		 $('layer_'+json.data[i].lnumber).show();
		    		 
		    		 
		    	 }
		    	 
		     } 
		     
		     
		   }
		});
	
	
	
}

function flush_layers(){
	
for (var i = 0; i <= 6; i++) {
		
		layers_added[i] = false;
		
		//var lname = 'layer_'+i+'_parameters';
		
		$('layer_'+i).hide();
		
		$('layer_'+i+'_parameters').update();
		
		
	}

return true;
		
}


function specify_literature(pm){
	
	$('source_table').show();
	
	$('archhitecture_table').hide();
	
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
	
	$('archhitecture_table').show();
	
	current_param = 0;
	sel_source_num = 0;
	
	
}

function show_description() {
	
	var pid = $F('parameters_id');
	
	
	new Ajax.Updater('popup_block','index.php/parameters/ajaxGetParametersDescription', {
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




function check_form(){
	
	if (sel_acron_num == 0) {alert('This Brain Site has no related Acronym! Please select!');return false;}
	if (sel_bmap_num == 0) {alert('This Brain Site has no related Brain Map! Please select!');return false;}
		
	
}

function show_coding_rules(id){
	
	new Ajax.Updater('help_div','index.php/welcome/ajaxGetCodingRules', {
		  method: 'post',
		  postBody:'rule_id='+id,
	});
	
	
}

