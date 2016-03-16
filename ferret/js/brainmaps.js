var sel_lit_num = 0;
function literature_select() {
	
	if (sel_lit_num > 0 ) {
		
	var str = $F('autocomplite_auth');
	
		$('autocomplite_auth').value = '';
		$('autocomplite_auth').disable();		
		$('auto_block').hide();
		$('lit_block').show();
			
		$('literature').insert({bottom:'<span id="'+sel_lit_num+'"><input type="hidden" id="literature_id" name="literature_id" value="'+sel_lit_num+'"> '+str+'<a href="#" onclick="lit_replace(\''+sel_lit_num+'\'); return false;"> Replace</a><br/></span>'});
		
	
	
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

function show_coding_rules(id){
	
	new Ajax.Updater('help_div','index.php/welcome/ajaxGetCodingRules', {
		  method: 'post',
		  postBody:'rule_id='+id,
	});
	
	
}


function check_form(frm){
	
	if (sel_lit_num == 0) {alert('This Brain Map has no related publication! Please select!');return false;}
		
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

function show_brain_sites_block(id){
	
	new Ajax.Updater('brain_sites_block','index.php/brainsites/ajaxGetBrainSites', {
		  method: 'post',
		  postBody:'bm_id='+id,
	});
	//$('edit_bmap_block').hide();
	$('a_show_all').hide();

	$('a_hide_all_refresh').show();
	$('brain_sites_block').show();
}

function hide_brain_sites_block(){
	
	$('a_show_all').show();
	//$('edit_bmap_block').show();
	
	$('a_hide_all_refresh').hide();
	$('brain_sites_block').hide();
	
}