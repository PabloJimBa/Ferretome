<?php 
class Brain_sites_model extends Model {
	
	var $fields = array 
	(
			"brain_sites_index",
			"brain_maps_id"
			
	);


    function get_all($args=array(),$order_by='brain_sites_id',$order='desc',$limit='999',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	
    	
    	if (!empty($args)){
    		return $this->db->get_where('brain_sites',$args,$limit,$offset);
    	} else {
    		return $this->db->get('brain_sites',$limit,$offset);
    		
    	}
    	
    }

    function get_fields(){
    	
    	
    	return $this->fields;
    	
    }
}
?>
