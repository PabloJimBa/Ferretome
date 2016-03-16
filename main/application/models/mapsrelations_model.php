<?php 
class Mapsrelations_model extends CI_Model {
	
	
	var $fields = array
	(
			"acronym_name_a",
			"acronym_full_name_a",
			"relation_codes_desc",			
			"acronym_name_b",
			"acronym_full_name_b",
			"reference_text",
			"reference_figures",
			"citation",
			"comments"
				
	);

    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
    
	
	function get_one($id){
		
		return $this->get_all(array("methods_id"=>$id));
		
	}
	
	
	function get_for_l($id){
	
		return $this->get_all(array("literature_id"=>$id));
	
	}
	
     
	function get_all($args=array(),$orderby='methods_id',$order='asc',$limit='999',$offset='0'){
		
		
		
		if (!empty($order_by)) $this->db->order_by($order_by,$order);
		 
		
		$this->db->join('relation_codes','relation_codes.relation_codes_id = maps_relations.maps_relations_code');
		
		//bsa
		
		$this->db->join('brain_sites as bsa','bsa.brain_sites_id = maps_relations.brain_sites_id_a');
		
		$this->db->join('brain_site_acronyms as bsaa','bsaa.brain_site_acronyms_id = bsa.brain_sites_acronyms_id');
		
		//bsb
		
		$this->db->join('brain_sites as bsb','bsb.brain_sites_id = maps_relations.brain_sites_id_b');
		
		$this->db->join('brain_site_acronyms as bsab','bsab.brain_site_acronyms_id = bsb.brain_sites_acronyms_id');
		
		// selectin all this mess 
		$this->db->select('maps_relations.*, relation_codes.*, bsaa.acronym_name as acronym_name_a, bsaa.acronym_full_name as acronym_full_name_a, bsab.acronym_name as acronym_name_b, bsab.acronym_full_name as acronym_full_name_b,');
		
		
		 
		if (!empty($args)){
			
			$qida = $this->db->get_where('maps_relations',$args,$limit,$offset);
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
				 
				return FALSE;
			}
		
		} else {
		
			$qida = $this->db->get('maps_relations',$limit,$offset);
		
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