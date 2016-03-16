<?php 
class Outcomes_model extends CI_Model {
	
	
	var $types = array 
	(
			'overall',
			'ipsilateral',
			'contralateral'
			
	);
	
	
	var $fields = array
	(
			
			"acronym_name",
			"acronym_full_name",
			"brain_sites_type_name"
			
				
	);

    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	
	function get_types(){
	
	
		return $this->types;
	
	}
    
	
	function get_one($id){
		
		return $this->get_all(array("brain_sites_id"=>$id));
		
	}
	
	function get_for_i($id) {
		
		return $this->get_all(array("injections_id"=>$id));
		
	}
	
     
	function get_all($args=array(),$orderby='outcome_id',$order='asc',$limit='999',$offset='0'){
		
		
		
		if (!empty($order_by)) $this->db->order_by($order_by,$order);
		
		$this->db->join('labeling_outcome','labeling_outcome.outcome_id = injections_and_outcomes.outcome_id');
		
				 
		if (!empty($args)){
			
			$qida = $this->db->get_where('injections_and_outcomes',$args,$limit,$offset);
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
				 
				return FALSE;
			}
		
		} else {
		
			$qida = $this->db->get('brain_sites',$limit,$offset);
		
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