<?php


class Files_model extends CI_Model {

	var $prefix = "ferretdb_";
		
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	
	function add($fname,$uid,$rname) {
		
		
		$fields = array();
		
		$fields['file_name'] = $fname;
		$fields['user_id'] = $uid;
		$fields['real_name'] = $rname;
		
		
		$this->db->insert($this->prefix.'files',$fields);
		
		
	}
	
	function get_files($uid) {
		
		
		return $this->get_all(array('user_id'=>$uid));
		
	}
	
	
	function get_all($args=array(),$order_by='file_id',$order='asc',$limit='10',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	   	
    	if (!empty($args)){
    		$qida = $this->db->get_where($this->prefix.'files',$args,$limit,$offset);
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			
    			return FALSE;
    		}
    		
    	} else {
    		
    		$qida = $this->db->get($this->prefix.'files',$limit,$offset);
    		
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			 
    			return FALSE;
    		}
    		
    	}
    	
    }


}




?>