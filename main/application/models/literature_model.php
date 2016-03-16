<?php 
class Literature_model extends CI_Model {

	
	var $fields = array
			(
					"literature_title",
					"literature_year",
					"abbreviations_full",
					"number_or_chapter",
					"page_number",
					"literature_abstract"
			
			);
    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	
	function get_fields(){
		
		
		return $this->fields;
		
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
    
    function get_like($q,$orderby='literature_id',$ord='desc') {
    	
    	$q = trim($q);
    	
    	$qstr = explode(" ", $q); 
    		
    	foreach ($qstr as $qs) {

    		$this->db->or_like('literature_title',$qs);
    		$this->db->or_like('literature_year',$qs);
    		$this->db->or_like('literature_abstract',$qs);
    		
    			
    	}
    	
    	return $this->get_all_where(array(),$orderby,$ord);
    	    	
    	
    }
    
    
    
}

?>