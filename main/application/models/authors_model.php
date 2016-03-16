<?php 
class Authors_model extends CI_Model {

    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
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
    	
    		$args = array ('literature_id'=>$lid);
    		
    		$this->db->join('authors','literature_and_authors.authors_id = authors.authors_id');
    	     	
    		return $this->db->get_where('literature_and_authors',$args);
    	    
    	 
    }
    
    function get_a_for_l($lid) {
    	
    	return $this->get_authors_for_literature($lid);
    	
    }
    
    
    
    
    
}

?>