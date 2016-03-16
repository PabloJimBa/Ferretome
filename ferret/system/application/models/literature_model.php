<?php 
class Literature_model extends Model {
	
	var $types = array 
	(
			
			"input in progress",
			"proofreading required",
			"proofreading finished"
			
	);
	
		
	var $fields = array
	(
				
			"standart" => array(
					
					
					"authors" => array
					(
							"real_name" => "literature_id",
							"type" => "array",
							"array_data" => array ()
					),
					
					
					"literature_title" => array
					(
							"real_name" => "literature_title",
							"type" => "string"
					),
					"literature_year" => array
					(
							"real_name" => "literature_year",
							"type" => "string"
					),
					
					"journal" => array
					(
							"real_name" => "abbreviations_full",
							"type" => "string"
					),
														
					"action" => array
					(
							"real_name" => "literature_id",
							"type" => "replace",
							"replace_data" => '<a href="index.php?c=literature&m=edit&id={literature_id}" >details</a>'
					)
			)
	);

    
 function Literature_model(){
         
         parent::Model();
     }
    
     
    function all_number() {
    	
    	return  $this->db->count_all_results('literature');
    	    	
    	
    } 
    
    
    function get_one($id) {
    	
    	return $this->get_all_where(array('literature_id'=>$id));
    	
    	
    }
    
    function get_all_where($args=array(),$order_by='literature_id',$order='desc',$limit='10',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	
    	$this->db->join('literature_abbreviations','literature_abbreviations.abbreviations_id = literature.literature_source');
    	
    	if (!empty($args)){
    		$qida = $this->db->get_where('literature',$args,$limit,$offset);
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			
    			return FALSE;
    		}
    		
    	} else {
    		
    		$qida = $this->db->get('literature',$limit,$offset);
    		
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			 
    			return FALSE;
    		}
    		
    	}
    	
    }
    
    function get_last_inserted($limit='3') {
    	 
    	
    	return $this->get_all_where(array(),'literature_id','desc',$limit);
    	 
    }
    
    
    
    function get_for_proof($limit='3') {
    
    	 
    	return $this->get_all_where(array("literature_state"=>"1"),'literature_id','desc',$limit);
    
    }
    
    
    function get_all($limit='999') {
    
    
    	return $this->get_all_where(array(),'literature_year','acs',$limit);
    
    }
    
    
    function get_last_updated($limit='3') {
    	
    	$this->db->join('literature','literature.literature_id = ferretdb_log.log_entry_id');
    	
    	$this->db->join('literature_abbreviations','literature_abbreviations.abbreviations_id = literature.literature_source');
    	    	  	
    	$this->db->order_by('log_id','desc');
    	
    	$this->db->distinct();
    	
    	$qida = $this->db->get_where('ferretdb_log',array('log_table_id'=>'1','log_action'=>'2'),$limit);
    	
    	if ($qida->num_rows() > 0){
    		return $qida;
    	} else {
    	
    		return FALSE;
    	}
    	    	
    	
    	
    	
    }
    
    
    
    function get_from_map($id){
    	
    	$this->db->select('literature_id');
    	$qida = $this->db->get_where('brain_maps',array('brain_maps_id'=>$id));
    	
    	if ($qida->num_rows()>0){
    		
    		$rowa = $qida->row(); 
    		$lid = $rowa->literature_id;
    		
    		return $this->get_one($lid);
    		
    		
    		
    	} else {
    		
    		return false;
    	}
    	
    	
    }
    
    function change_state($id,$state){
    	
    	
    	$this->db->where(array('literature_id'=>$id));
    	
    	return $this->db->update('literature',array('literature_state'=>$state));
    	
    	
    	
    }
    
    
    function get_types(){
    	 
    	return $this->types;
    	 
    }
    
    function get_fields($set = 'standart'){
    
    	return $this->fields[$set];
    
    }
    
    
    
}

?>