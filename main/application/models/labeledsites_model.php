<?php 
class Labeledsites_model extends CI_Model {
	
	
	var $fields = array
	(
			
			"acronym_name",
			"acronym_full_name",
			"brain_sites_type_name",
			"extension_codes_name",			
			"labelled_sites_density",
			"total_neurons_number",
			"percent_neurons_labeled",
			"labelled_sites_laminae"
			
			
				
	);

    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
    
	
	function get_one($id){
		
		return $this->get_all(array("labelled_sites_id"=>$id));
		
	}
	
     
	function get_all($args=array(),$orderby='labelled_sites_id',$order='asc',$limit='999',$offset='0'){
		
		
		
		if (!empty($order_by)) $this->db->order_by($order_by,$order);
		
				 
		$this->db->join('brain_sites','brain_sites.brain_sites_id = labelled_sites.brain_sites_id');
		
		$this->db->join('brain_site_acronyms','brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
		
		$this->db->join('brain_sites_types','brain_sites_types.brain_sites_type_id = brain_sites.brain_sites_type');
		
		$this->db->join('extension_codes','extension_codes.extension_codes_id = labelled_sites.EC');
		 
		if (!empty($args)){
			
			$qida = $this->db->get_where('labelled_sites',$args,$limit,$offset);
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
				 
				return FALSE;
			}
		
		} else {
		
			$qida = $this->db->get('labelled_sites',$limit,$offset);
		
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
		
				return FALSE;
			}
		
		}
		
		
	}
	
	function get_for_o($id) {
		
		
		return $this->get_all(array("outcome_id"=>$id));
		
	}
	
	
	
	function get_fields(){
	
	
		return $this->fields;
	
	}
	
	
	
}