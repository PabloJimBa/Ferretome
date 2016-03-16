var sel_bsite_num_a = 0;
var sel_bsite_num_b = 0;
var sel_lit_num = 0;
var sel_lit_num_a = 0;
var sel_lit_num_b = 0;

function literature_select() {
	
	if (sel_lit_num > 0 ) {
		
		var str = $F('autocomplite_auth');
	
		$('autocomplite_auth').value = '';			
		$('auto_block').hide();
		
		new Ajax.Request('index.php/brainsites/ajaxSetPublicationId', {
			  method: 'post',
			  postBody:'pubid='+sel_lit_num,
		});
		
		
			
		$('literature').insert({bottom:'<span id="'+sel_lit_num+'"><input type="hidden" name="literature_id" value="'+sel_lit_num+'"> '+str+'<a href="#" onclick="lit_replace(\''+sel_lit_num+'\'); return false;"> Replace</a><br/></span>'});
		$('lit_block').show();
		
	
	
	} else {
		
		alert('You must find and select an Literature first!');
		
	}
	
}

function lit_replace(id) {
	
	sel_lit_num = 0;
	
	$('literature').update();
	
	$('auto_block').show();
	
	$('lit_block').hide();	
	
}
/////////////a

function literature_select_a() {
	
	if (sel_lit_num_a > 0 ) {
		
		var str = $F('autocomplite_auth_a');
	
		$('autocomplite_auth_a').value = '';			
		$('auto_block_a').hide();
		
		new Ajax.Request('index.php/brainsites/ajaxSetPublicationIdA', {
			  method: 'post',
			  postBody:'pubid='+sel_lit_num_a,
		});
		
		
			
		$('literature_a').insert({bottom:'<span id="lit_a_'+sel_lit_num_a+'">'+str+'<a href="#" onclick="lit_replace_a(\''+sel_lit_num_a+'\'); return false;"> Replace</a><br/></span>'});
		$('lit_block_a').show();
		$('bsite_auto_block_a').show();
		
	
	
	} else {
		
		alert('You must find and select an Literature first!');
		
	}
	
}

function lit_replace_a(id) {
	
	sel_lit_num_a = 0;
	
	$('literature_a').update();
	
	$('auto_block_a').show();
	
	$('lit_block_a').hide();
	
	$('bsite_auto_block_a').hide();
	
}

///////////b


function literature_select_b() {
	
	if (sel_lit_num_b > 0 ) {
		
		var str = $F('autocomplite_auth_b');
	
		$('autocomplite_auth_b').value = '';			
		$('auto_block_b').hide();
		
		new Ajax.Request('index.php/brainsites/ajaxSetPublicationIdB', {
			  method: 'post',
			  postBody:'pubid='+sel_lit_num_b,
		});
		
		$('bsite_auto_block_b').show();
			
		$('literature_b').insert({bottom:'<span id="lit_b_'+sel_lit_num_b+'">'+str+'<a href="#" onclick="lit_replace_b(\''+sel_lit_num_b+'\'); return false;"> Replace</a><br/></span>'});
		$('lit_block_b').show();
		
	
	
	} else {
		
		alert('You must find and select an Literature first!');
		
	}
	
}

function lit_replace_b(id) {
	
	sel_lit_num_b = 0;
	
	$('literature_b').update();
	
	$('auto_block_b').show();
	
	$('lit_block_b').hide();
	
	$('bsite_auto_block_b').hide();
	
	
}
///////////// end b

function set_pub_id(){
	
	new Ajax.Request('index.php/brainsites/ajaxSetPublicationIdA', {
		  method: 'post',
		  postBody:'pubid='+sel_lit_num_a,
	});
	
	new Ajax.Request('index.php/brainsites/ajaxSetPublicationIdB', {
		  method: 'post',
		  postBody:'pubid='+sel_lit_num_b,
	});
	
	
}


function bsite_select_a() {
	
	if (sel_bsite_num_a > 0 ) {
		
	var str = $F('autocomplite_bsite_a');
	
		$('autocomplite_bsite_a').value = '';
				
		$('bsite_auto_block_a').hide();
		
		$('sel_bsite_a').insert({bottom:'<span id="b_site_a_'+sel_bsite_num_a+'"><input type="hidden" name="brain_sites_id_a" value="'+sel_bsite_num_a+'"> '+str+'<a href="#" onclick="bsite_replace_a(\''+sel_bsite_num_a+'\'); return false;"> Replace</a><br/></span>'});
		
		$('bsite_block_a').show();
			
		
		
	
	
	} else {
		
		alert('You must find and select an Brain site (A) first!');
		
	}
	
}

function bsite_replace_a(id) {
	
	sel_bsite_num_a = 0;
	
	$('bsite_auto_block_a').show();
	
	$('bsite_block_a').hide();
	
	$('sel_bsite_a').update();
	
}

function bsite_select_b() {
	
	if (sel_bsite_num_b > 0 ) {
		
	var str = $F('autocomplite_bsite_b');
	
		$('autocomplite_bsite_b').value = '';
				
		$('bsite_auto_block_b').hide();
		
		$('sel_bsite_b').insert({bottom:'<span id="b_site_b_'+sel_bsite_num_b+'"><input type="hidden"  name="brain_sites_id_b" value="'+sel_bsite_num_b+'"> '+str+'<a href="#" onclick="bsite_replace_b(\''+sel_bsite_num_b+'\'); return false;"> Replace</a><br/></span>'});
		
		$('bsite_block_b').show();
			
		
		
	
	
	} else {
		
		alert('You must find and select an Brain site (A) first!');
		
	}
	
}

function bsite_replace_b(id) {
	
	sel_bsite_num_b = 0;
	
	$('bsite_auto_block_b').show();
	
	$('bsite_block_b').hide();
	
	$('sel_bsite_b').update();
	
}

function check_form(frm){
	
	if (sel_lit_num == 0) {alert('This Relation has no related publication! Please select!');return false;}	
	if (sel_bsite_num_a == 0) {alert('This Relation has no related Brain Site A ! Please select!');return false;}
	if (sel_bsite_num_b == 0) {alert('This Relation has no related Brain Site B ! Please select!');return false;}
	
	
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

