<?php 
class Injections_model extends CI_Model {
	
	
	var $fields = array
	(
			"injections_index",
			"injections_citation",
			"injections_refText",
			"injections_refFigures",
			"injections_hemisphere",
			"injection_volume",
			"injections_concentration",
			"injections_laminae",
			
			
			
				
	);

    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
    
	
	function get_from_l($id){
		
		
		return $this->get_all(array("literature_id"=>$id));
	}
	
     
	function get_all($args=array(),$orderby='injection_id',$order='asc',$limit='999',$offset='0'){
		
		
		
		if (!empty($order_by)) $this->db->order_by($order_by,$order);
		 
		//this->db->join('brain_sites','brain_sites.brain_sites_id = injections.brain_sites_id');
		
		//$this->db->join('brain_site_acronyms','brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
		
		//$this->db->join('brain_sites_types','brain_sites_types.brain_sites_type_id = brain_sites.brain_sites_type');
		 
		if (!empty($args)){
			
			$qida = $this->db->get_where('injections',$args,$limit,$offset);
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
				 
				return FALSE;
			}
		
		} else {
		
			$qida = $this->db->get('injections',$limit,$offset);
		
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