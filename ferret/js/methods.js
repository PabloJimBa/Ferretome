var sel_lit_num = 0;
var sel_tracer_num = 0;

function literature_select() {
	
	if (sel_lit_num > 0 ) {
		
	var str = $F('autocomplite_auth');
	
		$('autocomplite_auth').value = '';
		$('autocomplite_auth').disable();		
		$('auto_block').hide();
		$('lit_block').show();
			
		$('literature').insert({bottom:'<span id="'+sel_lit_num+'"><input type="hidden" name="literature_id" value="'+sel_lit_num+'"> '+str+'<a href="#" onclick="lit_replace(\''+sel_lit_num+'\'); return false;"> Replace</a><br/></span>'});
		
	
	
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
	
		
	
}


function tracer_select() {
	
	if (sel_tracer_num > 0 ) {
		
	var str = $F('autocomplite_tracer');
	
		$('autocomplite_tracer').value = '';
		$('autocomplite_tracer').disable();		
		$('auto_block_tracer').hide();
		$('tracer_block').show();
			
		$('tracer').insert({bottom:'<span id="tracer_'+sel_tracer_num+'"><input type="hidden" name="tracers_id" value="'+sel_tracer_num+'"> '+str+'<a href="#" onclick="tracer_replace(\''+sel_tracer_num+'\'); return false;"> Replace</a><br/></span>'});
		
	
	
	} else {
		
		alert('You must find and select an tracer first!');
		
	}
	
}

function tracer_replace(id) {
	
	sel_tracer_num = 0;
	$("tracer_"+id).hide();
	$("tracer_"+id).update();
	
	$('autocomplite_tracer').enable();
	$('auto_block_tracer').show();
	
	$('tracer_block').hide();
	
		
	
}


function check_form(frm){
	
	if (sel_lit_num == 0) {alert('This inj Method has no related publication! Please select!');return false;}
	if (sel_tracer_num == 0) {alert('This inj Method has no related Tracer! Please select!');return false;}
	
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
