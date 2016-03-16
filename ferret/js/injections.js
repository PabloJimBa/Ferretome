var sel_bsite_num = 0;
var sel_lit_num = 0;
var sel_lit_inj_num = 0;



function get_methods(){
	
	new Ajax.Updater('method_block_data','index.php/methods/ajaxGetMethods', {
		  method: 'post',
		  postBody:'lit_id='+sel_lit_inj_num,
	});
	
}


function literature_for_inj_select() {
	
	if (sel_lit_inj_num > 0 ) {
		
		var str = $F('autocomplite_auth_inj');
	
		$('autocomplite_auth_inj').value = '';			
		$('auto_block_inj').hide();
		
			
		$('literature_inj').insert({bottom:'<span id="inj_'+sel_lit_inj_num+'"><input type="hidden" name="literature_id" value="'+sel_lit_inj_num+'"> '+str+'<a href="#" onclick="lit_inj_replace(\''+sel_lit_inj_num+'\'); return false;"> Replace</a><br/></span>'});
		$('lit_block_inj').show();
		
		
		new Ajax.Updater('method_block_data','index.php/methods/ajaxGetMethods', {
			  method: 'post',
			  postBody:'lit_id='+sel_lit_inj_num,
		});
		
		
		
		
	
	
	} else {
		
		alert('You must find and select an Literature first!');
		
	}
	
}

function lit_inj_replace(id) {
	
	sel_lit_inj_num = 0;
	$('inj_'+id).hide();
	$('inj_'+id).update();
	$('method_block_data').update('Select paper above');
	
	$('auto_block_inj').show();
	
	$('lit_block_inj').hide();
	
	
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
		
		$('sel_bsite').insert({bottom:'<span id="'+sel_bsite_num+'"><input type="hidden" name="brain_sites_id" value="'+sel_bsite_num+'"> '+str+'<a href="#" onclick="bsite_replace(\''+sel_bsite_num+'\'); return false;"> Replace</a><br/></span>'});
		
		$('bsite_block').show();
			
		
		
	
	
	} else {
		
		alert('You must find and select an Brain site first!');
		
	}
	
}

function bsite_replace(id) {
	
	sel_bsite_num = 0;
	
	$('bsite_auto_block').show();
	
	$('bsite_block').hide();
	
	$('sel_bsite').update();
	
		
	
}


function check_form(frm){
	
	
	if (sel_lit_inj_num == 0) {alert('This Injection has no related publication! Please select!');return false;}
	if (sel_bsite_num == 0) {alert('This Injection has no related Brain Site! Please select!');return false;}
	
	var params = frm.serialize();
	new Ajax.Request(frm.action, {
		  method: 'post',
		  postBody:params,
		  
		  	  
		  onSuccess: function(transport){
		     var json = transport.responseText.evalJSON(true);
		     
		     
		    	 alert(json.message);
		    	 
		    	 if (json.result=='1') {
		    		 if (json.newurl.length > 0)
		    		 window.location.replace(json.newurl);
		    		 
		    	 }
		     
		     
		     
		   }
		});
	
	return false;
	
	
	
}

function show_coding_rules(id){
	
	new Ajax.Updater('help_div','index.php/welcome/ajaxGetCodingRules', {
		  method: 'post',
		  postBody:'rule_id='+id,
	});
	
	
}



function show_labelled_sites_block(id){
	
	new Ajax.Updater('labelled_sites_block','index.php/labelledsites/ajaxGetLabelledSites', {
		  method: 'post',
		  postBody:'inj_id='+id,
	});
	//$('edit_inj_block').hide();
	$('a_show_all').hide();

	$('a_hide_all_refresh').show();
	$('labelled_sites_block').show();
}

function hide_labelled_sites_block(){
	$('a_show_all').show();
	//$('edit_inj_block').show();
	
	$('a_hide_all_refresh').hide();
	$('labelled_sites_block').hide();
	
}


function show_lamina(){
	
	$('lamina_hide_button').show();
	$('lamina_fields_1').show();
	$('lamina_fields_2').show();
	$('lamina_show_button').hide();
	

	
} 

function hide_lamina(){
	
	$('lamina_hide_button').hide();
	$('lamina_fields_1').hide();
	$('lamina_fields_2').hide();
	$('lamina_show_button').show();

} 