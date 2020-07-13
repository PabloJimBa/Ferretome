<?php 
class Authors_model extends Model {
	
	var $fields = array 
	(
			"authors_surname",
			"authors_name",
			"authors_middleName"
			
	);
	


    
	function Authors_model(){
         
         parent::Model();
    }
    
    function get_fields(){
    	
    	
    	return $this->fields;
    	
    }
    
     
    function all_number() {
    	
    	return  $this->db->count_all_results('authors');
    	    	
    	
    } 
    
    function get_all_where($args=array(),$order_by='authors_id',$order='desc',$limit='10',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	
    	
    	if (!empty($args)){
    		return $this->db->get_where('authors',$args,$limit,$offset);
    	} else {
    		return $this->db->get('authors',$limit,$offset);
    		
    	}
    	
    }
    
    function get_authors_for_literature($lid) {
    	
    		$args = array ('literature_id'=>$lid);	// Load all "literature_id" (from $lid parameter) in an array
    		
    		$this->db->join('authors','literature_and_authors.authors_id = authors.authors_id'); // Join authors from authors/authors_id with literature_and_authors/authors_id
    	     	$this->db->order_by('lna_id','ASC'); // Order the authors names

    		return $this->db->get_where('literature_and_authors',$args); // Load all literature_and_authors data into the above array
    	    
    	 
    }
    
    function get_a_for_l($lid) {
    	
    	return $this->get_authors_for_literature($lid); // Redirect to the above function
    	
    }
    
    
    
    
    
}

?>
