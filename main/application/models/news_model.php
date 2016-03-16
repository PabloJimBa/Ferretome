<?php


class News_model extends CI_Model {

	var $prefix = "ferretdb_";
	var $states = array
			(
					"0"=>"Draft",
					"1"=>"Posted",
					"2"=>"Deleted"
			
			
			);
	
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_one($id) {
		
		return $this->get_all(array('news_id'=>$id));
		
	}
	
	function get_all($args=array(),$orderby='news_posted',$order='desc', $limit='3',$offset='0'){
		
		
		$this->db->order_by($orderby,$order);
		
		
		$this->db->join($this->prefix.'users',$this->prefix.'users.user_id = '.$this->prefix.'news.user_id');
		
		if (!empty($args)){
			
			
			$qida = $this->db->get_where($this->prefix.'news',$args,$limit,$offset);
			
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
				 
				return FALSE;
			}
		
		} else {
		
			$qida = $this->db->get($this->prefix.'news',$limit,$offset);
		
			if ($qida->num_rows() > 0){
				return $qida;
			} else {
		
				return FALSE;
			}
		
		}
		
		
		
		
		
	}
	
	function get_drafts(){
	
		return $this->get_all(array('news_state'=>'0'));
	}
	
	function get_published(){
		
		return $this->get_all(array('news_state'=>'1'));
	}
	
	
	
	function get_states() {
		
		return $this->states;
		
	}
	
	function get_fields() {
		
		return $this->db->field_data($this->prefix.'news');
		
	}


}




?>