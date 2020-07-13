<?php 
class Injections_model extends Model {
	
	var $fields = array 
	(
			"injections_index",
			"methods_id",
			"brain_sites_id"
			
	);


    function get_all($args=array(),$order_by='injections_id',$order='desc',$limit='999',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	
    	
    	if (!empty($args)){
    		return $this->db->get_where('injections',$args,$limit,$offset);
    	} else {
    		return $this->db->get('injections',$limit,$offset);
    		
    	}
    	
    }

    function get_fields(){
    	
    	
    	return $this->fields;
    	
    }
}
?>
