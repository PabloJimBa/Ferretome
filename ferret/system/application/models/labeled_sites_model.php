<?php 
class Labeled_sites_model extends Model {
	
	var $density_options = array 
	(
			
			'1' => 'weak, sparse, light',
				'2' => 'moderate , medium',
				'3' => 'strong, dense, heavy'
			
			
	);
	
	
	
	
	var $fields = array 
	(
			
			"standart" => array(
					
				"b_site_index" => array 
				(
						"real_name" => "brain_sites_index",
						"type" => "string"
				),
				
				"acronym_full_name" => array
				(
						"real_name" => "acronym_full_name",
						"type" => "string"
				),
				
												
				"density" => array
				(
						"real_name" => "labelled_sites_density",
						"type" => "array",
						"array_data" => array ()
				),
				
				"density_PDC" => array
				(
						"real_name" => "PDC_DENSITY",
						"type" => "array",
						"array_data" => array ()
				),
					
				"extension_code" => array
				(
						"real_name" => "EC",
						"type" => "array",
						"array_data" => array ()
				),
					
				"EC_PDC" => array
				(
						"real_name" => "PDC_EC",
						"type" => "array",
						"array_data" => array ()
				),
					
				"neurons_number" => array
				(
						"real_name" => "total_neurons_number",
						"type" => "string"
				),
				
				"percent_neurons" => array
				(
						"real_name" => "percent_neurons_labelled",
						"type" => "string"
				),
					
				"site_laminae" => array
				(
						"real_name" => "labelled_sites_laminae",
						"type" => "string"
				),
					
				"laminae_PDC" => array
				(
						"real_name" => "PDC_LAMINAE",
						"type" => "array",
						"array_data" => array ()
				),
					
				
				
				"action" => array
				(
						"real_name" => "labelled_sites_id",
						"type" => "replace",
						"replace_data" => '<a target="_blank" href="index.php?c=labelledsites&m=edit&id={labelled_sites_id}">edit</a>'
				)
			)
			
			
			
	);
		
		
		
	

    
 	function Labeled_sites_model(){
         
         parent::Model();
         
         //collecting PDC
         
         $qida = $this->db->get('pdc');
         
         $pdc_options = array();
         
         $temp_arr = array();
         
         foreach ($qida->result() as $rowa) {
         
         	$temp_arr[$rowa->PDC_id] = $rowa->PDC_name;
         
         }
         
         $pdc_options = $temp_arr;
         
         // collecting EC
         $qida = $this->db->get('extension_codes');
         
         $ec_options = array();
         
         $temp_arr = array();
         
         foreach ($qida->result() as $rowa) {
         
         	$temp_arr[$rowa->extension_codes_id] = $rowa->extension_codes_name . " - " . $rowa->extension_codes_desc ;
         
         }
         
         $ec_options = $temp_arr;
         
         
         
         $this->fields['standart']['density_PDC']['array_data'] = $pdc_options;
         $this->fields['standart']['EC_PDC']['array_data'] = $pdc_options;
         $this->fields['standart']['laminae_PDC']['array_data'] = $pdc_options;
         
         
         $this->fields['standart']['density']['array_data'] = $this->density_options;
         $this->fields['standart']['extension_code']['array_data'] = $ec_options;
         
    }
    
    
   
    
     
   
    
       
    
    function get_one($id) {
    	
    	return $this->get_all_where(array('labelled_sites_id'=>$id));
    	
    	
    }
    
    
   
    
    function get_all_where($args=array(),$order_by='brain_sites_id',$order='asc',$limit='999',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	
    	
    	$this->db->select('brain_sites.brain_sites_index,  labelled_sites.*, brain_site_acronyms.acronym_full_name');
    	$this->db->join('brain_sites','brain_sites.brain_sites_id = labelled_sites.brain_sites_id');
    	$this->db->join('brain_site_acronyms','brain_sites.brain_sites_acronyms_id = brain_site_acronyms.brain_site_acronyms_id');
    		
    	
    	    	
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
    
    
        
    function get_fields($set='standart'){
    
    	return $this->fields[$set];
    
    }
    
    
    
    
}

?>
