function save_new_item() {
	
var poststring = $('new_menu_item_form').serialize();
	
	new Ajax.Request('index.php/menueditor/ajaxInsertItem', {
		  method: 'post',
		  postBody:poststring,
		  
		  onSuccess: function(){
			  
			  $('new_menu_item_form').reset();
			  load_data();
			  
			  
		  }
	
	});
	
	
	
}


function load_data() {
	
	
	new Ajax.Updater('menu_structure','index.php/menueditor/ajaxGetAllItems', {
		  method: 'get',
	});
	

	
}

function move_up(id){
	
	new Ajax.Request('index.php/menueditor/ajaxMoveItem', {
		  method: 'post',
		  postBody:'method=up&id='+id,
		  
		  onSuccess: function(){
			  
			  
			  load_data();
			  
			  
		  }
	
	});
	
	
	
}

function move_down(id){
	
	
	new Ajax.Request('index.php/menueditor/ajaxMoveItem', {
		  method: 'post',
		  postBody:'method=down&id='+id,
		  
		  onSuccess: function(){
			  
			 
			  load_data();
			  
			  
		  }
	
	});
	
	
	
	
	
}