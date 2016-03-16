<?php


class Pages_model extends CI_Model {

	var $prefix = "ferretdb_";
	
	var $ptypes = array (
			"1"=>"public",
			"2"=>"private",
			
			);
	
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_one($id) {
		
		
		$qida = $this->db->get_where($this->prefix.'pages', array('page_id'=>$id));
		
		
		if ($qida->num_rows() > 0){
			return $qida;
		} else {
			 
			return FALSE;
		}
		
		
		
		
	}
	
	function get_types() {
		
		
		return $this->ptypes;
		
	}
	
	function get_page($pname) {
		
		$qida = $this->db->get_where($this->prefix.'pages', array('page_name'=>$pname));
		
		
		if ($qida->num_rows() > 0){
			
			$rowa = $qida->row();
			return $rowa->page_content;
			
		} else {
		
			return FALSE;
		}
		
		
	}
	
	function get_page_public($pname) {
	
		$qida = $this->db->get_where($this->prefix.'pages', array('page_name'=>$pname,'page_type'=>'1'));
	
	
		if ($qida->num_rows() > 0){
				
			$rowa = $qida->row();
			return $rowa->page_content;
				
		} else {
	
			return FALSE;
		}
	
	
	}
	
	function get_all($args=array(),$order_by='page_name',$order='asc',$limit='10',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	   	
    	if (!empty($args)){
    		$qida = $this->db->get_where($this->prefix.'pages',$args,$limit,$offset);
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			
    			return FALSE;
    		}
    		
    	} else {
    		
    		$qida = $this->db->get($this->prefix.'pages',$limit,$offset);
    		
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			 
    			return FALSE;
    		}
    		
    	}
    	
    }


}




?>