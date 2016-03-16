<?php 
class Brainsite_model extends CI_Model {
	
	
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
    
	
	function get_one($id){
		
		return $this->get_all(array("brain_sites_id"=>$id));
		
	}
	
     
	function get_all($args=array(),$orderby='brain_sites_index',$order='asc',$limit='999',$offset='0'){
		
		
		
		if (!empty($order_by)) $this->db->order_by($order_by,$order);
		 
		
		$this->db->join('brain_site_acronyms','brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
		
		$this->db->join('brain_sites_types','brain_sites_types.brain_sites_type_id = brain_sites.brain_sites_type');
		 
		if (!empty($args)){
			
			$qida = $this->db->get_where('brain_sites',$args,$limit,$offset);
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
	
	function get_for_map($id) {
		
		
		return $this->get_all(array("brain_maps_id"=>$id));
		
	}
	
	function get_like($q) {
		 
		$q = trim($q);
		 
		$qstr = explode(" ", $q);
	
		foreach ($qstr as $qs) {
	
			$this->db->or_like('acronym_name',$qs);
			$this->db->or_like('acronym_full_name',$qs);
			 
		}
		
		
		$this->db->join('brain_sites','brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
		
		$this->db->join('brain_maps','brain_sites.brain_maps_id = brain_maps.brain_maps_id');
		
		$this->db->join('literature','literature.literature_id = brain_maps.literature_id');
		
		$this->db->join('literature_abbreviations','literature_abbreviations.abbreviations_id = literature.literature_source');
		 
		
		$qida = $this->db->get('brain_site_acronyms');
		 
		if ($qida->num_rows() > 0){
			return $qida;
		} else {
			 
			return FALSE;
		}
		
	
		 
	}
	
	function get_fields(){
	
	
		return $this->fields;
	
	}
	
	
	
}