<?php 
class Acronyms_model extends Model {
	
	var $fields = array 
	(
			"acronym_name",
			"acronym_full_name"
			
			
	);
	


    
	function Acronyms_model(){
         
         parent::Model();
    }
    
    function get_fields(){
    	
    	
    	return $this->fields;
    	
    }
    
    
    function get_for_id($id) {
    	
    	
    	$qida = $this->get_all(array('brain_site_acronyms_id'=>$id));
    	
    	if ($qida->num_rows() > 0){
    		
    		$rowa =$qida->row();
    		
    		return $rowa->acronym_name;
    		
    	}
    	
    }  
     
    
    
    function get_all($args=array(),$order_by='brain_site_acronyms_id',$order='desc',$limit='999',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	
    	
    	if (!empty($args)){
    		return $this->db->get_where('brain_site_acronyms',$args,$limit,$offset);
    	} else {
    		return $this->db->get('brain_site_acronyms',$limit,$offset);
    		
    	}
    	
    }
    
        
    
    
    
    
}

?>