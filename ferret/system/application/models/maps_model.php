<?php 
class Maps_model extends Model {
	
	

    
	function Maps_model(){
         
         parent::Model();
    }
    
    function get_from_lit_id($lid){
    	
    	return $this->get_all(array("literature_id"=>$lid)); 	
    	    	
    }
     
    
    
    function get_all($args=array(),$order_by='brain_maps_id',$order='desc',$limit='999',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	
    	
    	if (!empty($args)){
    		return $this->db->get_where('brain_maps',$args,$limit,$offset);
    	} else {
    		return $this->db->get('brain_maps',$limit,$offset);
    		
    	}
    	
    }
    
        
    
    
    
    
}

?>