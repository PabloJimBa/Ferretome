<?php 
class Methods_model extends CI_Model {
	
	
	var $fields = array
	(
			"tracers_name",
			"reference_text",
			"reference_figures",
			"bilateral_use",
			"injection_method",
			"survival_time",
			"section_thickness",
			"number_of_sections"
			
				
	);

    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
    
	
	function get_one($id){
		
		return $this->get_all(array("methods_id"=>$id));
		
	}
	
     
	function get_all($args=array(),$orderby='methods_id',$order='asc',$limit='999',$offset='0'){
		
		
		
		if (!empty($order_by)) $this->db->order_by($order_by,$order);
		 
		
		$this->db->join('tracers','tracers.tracers_id = methods.tracers_id');
		
		
		 
		if (!empty($args)){
			
			$qida = $this->db->get_where('methods',$args,$limit,$offset);
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
				 
				return FALSE;
			}
		
		} else {
		
			$qida = $this->db->get('methods',$limit,$offset);
		
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
		
				return FALSE;
			}
		
		}
		
		
	}
	
	
	function get_fields(){
	
	
		return $this->fields;
	
	}
	
	
	
}