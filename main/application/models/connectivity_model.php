<?php


class Connectivity_model extends CI_Model {

	var $prefix = "";
		
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	
	function add($lid,$content,$type="1") {
		
		
		$fields = array();
		
		$fields['literature_id'] = $lid;
		$fields['type'] = $type;
		$fields['content'] = $content;
		
		
		$this->db->insert('connectivity_cache',$fields);
		
		
	}
	
	function update($lid,$content,$type="1") {
	
	
		$fields = array();
	
		//$fields['literature_id'] = $lid;
		$fields['type'] = $type;
		$fields['content'] = $content;
		
		$this->db->where(array("literature_id"=>$lid));
	
	
		$this->db->update('connectivity_cache',$fields);
	
	
	}
	
	function get_connectivity($lid,$type="1") {
		
		
		return $this->get_all(array('literature_id'=>$lid,'type'=>$type));
		
	}
	
	
	function get_all($args=array(),$order_by='record_id',$order='asc',$limit='10',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	   	
    	if (!empty($args)){
    		$qida = $this->db->get_where('connectivity_cache',$args,$limit,$offset);
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			
    			return FALSE;
    		}
    		
    	} else {
    		
    		$qida = $this->db->get('connectivity_cache',$limit,$offset);
    		
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			 
    			return FALSE;
    		}
    		
    	}
    	
    }


}




?>