var sel_acron_num = 0;
var sel_lit_num = 0;


function check_form(frm){
	
	if (sel_lit_num == 0) {alert('This Brain Site has no related Brain Map! Please select!');return false;}
	if (sel_acron_num == 0) {alert('This Brain Site has no related Acronym! Please select!');return false;}
	
	
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



function literature_select_2() {
	
	if (sel_lit_num > 0 ) {
		
		var str = $F('autocomplite_auth_bsite');
	
		$('autocomplite_auth_bsite').value = '';			
		$('auto_block_2').hide();
		
		
		
			
		$('literature_2').insert({bottom:'<span id="liter_'+sel_lit_num+'"><input type="hidden" id= "brain_maps_id" name="brain_maps_id" value="'+sel_lit_num+'">'+str+'<a href="#" onclick="lit_replace_2(\''+sel_lit_num+'\'); return false;"> Replace</a><br/></span>'});
		$('lit_block_2').show();
		
	
	
	} else {
		
		alert('You must find and select an Literature first!');
		
	}
	
}

function lit_replace_2(id) {
	
	sel_lit_num = 0;
	$('liter_'+id).hide();
	$('liter_'+id).update();
	
	$('auto_block_2').show();
	
	$('lit_block_2').hide();
	
	
	
	
		
	
}


function acron_select() {
	
	if (sel_acron_num > 0 ) {
		
		var str = $F('autocomplite_acron');
		
			$('autocomplite_acron').value = '';
			$('autocomplite_acron').disable();		
			$('acron_auto_block').hide();
			$('acron_block').show();
				
			$('sel_acron').insert({bottom:'<span id="'+sel_acron_num+'"><input type="hidden" name="brain_sites_acronyms_id" id="brain_sites_acronyms_id" value="'+sel_acron_num+'"> '+str+'<a href="#" onclick="acron_replace(\''+sel_acron_num+'\'); return false;"> Replace</a><br/></span>'});
			
		
		
		} else {
			
			alert('You must find and select an Acronym first!');
			
		}
	
	
}

function acron_replace(id){
	
	sel_acron_num = 0;
	$('acron_block').hide();
	$('sel_acron').update();
	
	$('autocomplite_acron').enable();	
	$('acron_auto_block').show();
	
	
	
}

function show_coding_rules(id){
	
	new Ajax.Updater('help_div','index.php/welcome/ajaxGetCodingRules', {
		  method: 'post',
		  postBody:'rule_id='+id,
	});
	
	
}


