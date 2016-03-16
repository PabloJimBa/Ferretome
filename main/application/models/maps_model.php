<?php 
class Maps_model extends CI_Model {
	
	
	var $fields = array
	(
			
			"brain_maps_index",
			"reference_figures",
			"reference_text",
			"citation",
			"comments",
			
				
	);
	var $map_types = array 
	(

			"tt" => "Adopted Deliniated",
			"tf" => "Adopted",
			"ft" => "Deliniated",
			"ff" => "Unknown"
			
	);

    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
    
	
	
     
	function get_all($args=array(),$orderby='brain_maps_index',$order='asc',$limit='1',$offset='0'){
		
		
		
		if (!empty($order_by)) $this->db->order_by($order_by,$order);
		 
		
		if (!empty($args)){
			
			$qida = $this->db->get_where('brain_maps',$args,$limit,$offset);
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
				 
				return FALSE;
			}
		
		} else {
		
			$qida = $this->db->get('brain_maps',$limit,$offset);
		
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
		
				return FALSE;
			}
		
		}
		
		
	}
	
	function get_one($id) {
		
		
		return $this->get_all(array("brain_maps_id"=>$id));
		
	}
	
	function get_from_l($id) {
		
		return $this->get_all(array("literature_id"=>$id));
		
		
	}
	
	function get_fields(){
	
	
		return $this->fields;
	
	}
	
	function get_types(){
	
	
		return $this->map_types;
	
	}
	
	
	
}