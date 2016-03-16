function reject_job (id){
	
	if(confirm('Are you sure you want to reject this job')) {
		new Ajax.Request('index.php/workflow/rejectJob', {
		  method: 'post',
		  postBody:'job_id='+id,
		  
		  	  
		  onSuccess: function(transport){
		     var json = transport.responseText.evalJSON(true);
		     
		     
		    	 alert(json.message);
		    	 
		    	 if (json.result=='1') {
		    		 if (json.newurl.length > 0)
		    		 window.location.replace(json.newurl);
		    		 
		    	 }
		     
		     
		     
		   }
		});
	}
	
	
	
	
	
}
function take_job (id){
	
	if(confirm('Are you sure you want to take this job')) {
		new Ajax.Request('index.php/workflow/takeJob', {
		  method: 'post',
		  postBody:'job_id='+id,
		  
		  	  
		  onSuccess: function(transport){
		     var json = transport.responseText.evalJSON(true);
		     
		     
		    	 alert(json.message);
		    	 
		    	 if (json.result=='1') {
		    		 if (json.newurl.length > 0)
		    		 window.location.replace(json.newurl);
		    		 
		    	 }
		     
		     
		     
		   }
		});
	}
	
	
	
}
function finish_job (id){
	
	if(confirm('Are you sure you want to finish this job')) {
		new Ajax.Request('index.php/workflow/finishJob', {
		  method: 'post',
		  postBody:'job_id='+id,
		  
		  	  
		  onSuccess: function(transport){
		     var json = transport.responseText.evalJSON(true);
		     
		     
		    	 alert(json.message);
		    	 
		    	 if (json.result=='1') {
		    		 if (json.newurl.length > 0)
		    		 window.location.replace(json.newurl);
		    		 
		    	 }
		     
		     
		     
		   }
		});
	}
	
	
	
}