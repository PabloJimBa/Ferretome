var sel_lit_num = 0;
var sel_lit_num_2 = 0;
var sel_bsite_num = 0;




function literature_select() {
	
	if (sel_lit_num > 0 ) {
		
		var str = $F('autocomplite_auth');
	
		$('autocomplite_auth').value = '';			
		$('auto_block').hide();
		
		
		
		
		new Ajax.Request('index.php/brainsites/ajaxSetPublicationId2', {
			  method: 'post',
			  postBody:'pubid2='+sel_lit_num,
		});
		
		new Ajax.Updater ('injection_block','index.php/labelingoutcome/ajaxGetOutcomes',
				{
			
				method: 'post',
				postBody:'method=normal&pubid2='+sel_lit_num,
			
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
	
}

function literature_select_2() {
	
	if (sel_lit_num_2 > 0 ) {
		
		var str = $F('autocomplite_auth_bsite');
	
		$('autocomplite_auth_bsite').value = '';			
		$('auto_block_2').hide();
		
		$('autocomplite_bsite').enable();
		
		
		new Ajax.Request('index.php/brainsites/ajaxSetPublicationId', {
			  method: 'post',
			  postBody:'pubid='+sel_lit_num_2,
		});
		
			
		$('literature_2').insert({bottom:'<span id="'+sel_lit_num+'_2">'+str+'<a href="#" onclick="lit_replace_2(\''+sel_lit_num_2+'\'); return false;"> Replace</a><br/></span>'});
		$('lit_block_2').show();
		
	
	
	} else {
		
		alert('You must find and select an Literature first!');
		
	}
	
}

function lit_replace_2(id) {
	
	sel_lit_num = 0;
	$(id+'_2').hide();
	$(id+'_2').update();
	
	$('auto_block_2').show();
	
	$('lit_block_2').hide();
	
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
	
	if (sel_lit_num == 0) {alert('This Labbeled Site has no related Injection! Please select!');return false;}	
	if (sel_bsite_num == 0) {alert('This Injection has no related Brain Site! Please select!');return false;}
	
	var params = frm.serialize();
	new Ajax.Request(frm.action, {
		  method: 'post',
		  postBody:params+'&literature_id='+sel_lit_num,
		  
		  	  
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