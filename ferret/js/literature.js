var auth_id = 0;
var auth_num = 0;
var search_trigger = 1;
var sel_lit_num = 0;
var sel_auth_num = 0;

var abbr_id = 0;


function author_add() {
	
	var str = $F('autocomplite_auth');
		
	if (str.length > 0 && auth_id > 0) { 
		auth_num++;
		$('auth_list').insert({bottom:'<span id="auth_id_'+auth_id+'">'+auth_num+' <input type="hidden" name="authors_id[]" value="'+auth_id+'"> '+str+' <a href="#" onclick="auth_del(\''+auth_id+'\'); return false;">X</a><br/></span>'});
		$('autocomplite_auth').value = '';
		auth_id = 0;
		

	} else {
		
		alert('You must find and select an author first!');
		
	}
	
	
}


function abbr_select(){

	
	var str = $F('autocomplite_abbr');
	
	if (str.length > 0 && abbr_id > 0) { 
		
		$('abbr_block').insert({bottom:'<span id="abbr_id_'+abbr_id+'"><input type="hidden" id="literature_source" name="literature_source" value="'+abbr_id+'"> '+str+' <a href="#" onclick="abbr_replace(\''+abbr_id+'\'); return false;">Replace</a><br/></span>'});
		$('autocomplite_abbr').value = '';
		
		$('abbrevaiture_blk_sel').show();
		$('abbrevaiture_blk_srch').hide();
		
		

	} else {
		
		alert('You must abbr. and select it first!');
		
	}

	
	
	
}

function abbr_replace(id){
	
	abbr_id = 0;
	
	$('abbrevaiture_blk_sel').hide();
	$('abbrevaiture_blk_srch').show();
	
	$('abbr_block').update();
	
	
	
	
	
}




function auth_del(id) {
	auth_num--;
	$("auth_id_"+id).hide();
	$("auth_id_"+id).update();	
	
} 


function open_authors_dlg(){
    newwin = window.open('index.php?c=authors&m=add','','width=800,height=300,resizable=0,scrollbars=yes,menubar=no,status=no');
    newwin.focus();
}

function open_abbr_dlg(){
    newwin = window.open('index.php?c=abbreviations&m=add','','width=800,height=300,resizable=0,scrollbars=yes,menubar=no,status=no');
    newwin.focus();
}

function switch_search(id){
	if (id == 2){
		$('search_link_2').hide();
		$('search_link_1').show();
		
		$('search_type_1').hide();
		$('search_type_2').show();
		
		$('autocomplite_1').hide();
		$('autocomplite_2').show();
		
		search_trigger = 2;
		
				
	} else {
		
		$('search_link_1').hide();
		$('search_link_2').show();
		
		$('search_type_2').hide();
		$('search_type_1').show();
		
		$('autocomplite_2').hide();
		$('autocomplite_1').show();
		
		search_trigger = 1;
		
		
	}
	
	
}

function search_by_author(id){
	
	switch_search(2);
	sel_auth_num = id;
	search_do();
	
	
	
}

function search_do(limit,offset){
	
	
	if (limit === undefined) limit = '10';
    if (offset === undefined) offset = '0';
	
	if (search_trigger == 1) {
	
		if (sel_lit_num > 0){
		
			new Ajax.Updater('search_result','index.php/literature/searchDo', {
				method: 'post',
				postBody:'pubid='+sel_lit_num+'&strigger='+search_trigger,
			});
		
		
		
			sel_lit_num = 0;
		
		
		
		} 
	}
	
	if (search_trigger == 2) {
		
		if (sel_auth_num > 0){
		
			new Ajax.Updater('search_result','index.php/literature/searchDo', {
				method: 'post',
				postBody:'authid='+sel_auth_num+'&strigger='+search_trigger+'&limit='+limit+'&offset='+offset,
			});
		
		
		
			sel_auth_num = 0;
		
		
		
		} 
	}
	
if (search_trigger == 3) {
		
		
		if (offset =='0'){
			
			new Ajax.Updater('search_result','index.php/literature/searchDo', {
				method: 'post',
				postBody:'strigger='+search_trigger+'&limit='+limit+'&offset='+offset,
			});
			
		} else {
			
			new Ajax.Updater('search_result_table','index.php/literature/searchDo', {
				method: 'post',
				postBody:'strigger='+search_trigger+'&limit='+limit+'&offset='+offset,
				insertion: Insertion.Bottom,
			});
			
			
		}
		
		
		
		
			
		search_trigger = 1;
		
		
		 
	}
	
	
}

function next_search(lim,off){
	$('search_next_button').remove();
	search_trigger = 3;
	search_do(lim,off);
	
	
	
}

function show_all_mapsrel(id){
	
	new Ajax.Updater('mrel_block','index.php/mapsrelations/ajaxGetAll', {
		  method: 'post',
		  postBody:'mr_id='+id,
	});
	
	$('show_all_mr_a').hide();
	$('literature_block').hide();

	$('hide_all_mr_a').show();
	$('mrel_block').show();
	
	
	
}

function hide_all_mapsrel(){
	
	$('show_all_mr_a').show();
	$('literature_block').show();
	
	$('hide_all_mr_a').hide();
	$('mrel_block').hide();
	
	
}


function select_file(response_data) {
	
	   $('upload_block_file_name').insert({bottom:'<span id="'+response_data+'">File was uploaded. <a target="_blank" href="/ferret/upload/'+response_data+'">Click here to see the file</a> - <a href="#" onclick="replace_upd_file(\''+response_data+'\'); return false;"> Replace</a><br/></span>'});
	   $('upload_block_file').show();
	   $('upload_block_button').hide();
	   $('literature_physicalCopy').value = response_data;
	
}


function replace_upd_file(id){
	
	
	$(id).remove();
	$('upload_block_file').hide();
	$('upload_block_button').show();
	$('literature_physicalCopy').value = '';
	
		
}


function change_literature_state(lid,sid) { 
	
	if(confirm('Are you sure, you want to change status of this paper and this is your job?')){
		new Ajax.Request('index.php/literature/changeState', {
		  method: 'post',
		  postBody:'literature_id='+lid+'&status_id='+sid,
		  
		  	  
		  onSuccess: function(transport){
		     var json = transport.responseText.evalJSON(true);
		     
		     
		    	 
		    	 
		    	 if (json.result=='1') {
		    		 
		    		 alert(json.message);
		    		 
		    		 if (json.succes_data.length > 0) {
		    			 $('lit_status').update(json.succes_data);
		    			 $('lit_status_buttons').hide();
		    		 }
		    		 
		    	 } else {
		    		 
		    		 alert(json.error);
		    		 
		    	 }
		     
		     
		     
		   }
		});
	}
	
	
	
}




function check_form(frm){
	var str = '';
	if (auth_num == 0) {alert('This publication has no authors! Please add!');return false;}
	if (abbr_id == 0) {alert('No journal or book was selected! Select first!');return false;}
	str = $F('literature_title');	
	if (str.length < 5) {alert('Title is too short! Please check!');return false;}
	str = $F('literature_year');
	if (str.length != 4) {alert('Year is incorrect! Please check!');return false;}
	
	var params = frm.serialize();
	new Ajax.Request(frm.action, {
		  method: 'post',
		  postBody:params,
		  
		  	  
		  onSuccess: function(transport){
		     var json = transport.responseText.evalJSON(true);
		     
		     
		    	 alert(json.message);
		    	 
		    	 if (json.result=='1') {
		    		 
		    		 
		    		 if (json.jid.length > 0) {

		    			 $('log_id').value = json.jid;
		    			 
		    			 gotourl = json.newurl;
		    		 
		    			 $('update_dlg').show();
		    			 
		    		 } else {
		    		 
		    		 
		    		 if (json.newurl.length > 0) window.location.replace(json.newurl);
		    		 
		    		 }
		    		 
		    		 
		    	 }
		     
		     
		     
		   }
		});
	
	return false;	
}


