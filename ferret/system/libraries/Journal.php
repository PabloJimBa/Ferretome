<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Journal {
	
	var $CI;
	
	function CI_Journal(){ 
		
		$this->CI =& get_instance();
		$this->CI->load->database();
		
	}
	// newrecord (USER_ID,TABLE_ID,ENTRY_ID,ACTION_ID,DATA);
function newrecord($user_id,$log_table_id,$log_entry_id,$log_action=1,$data = ''){
		
	
	$log_previous_data = '';
	
	if (!empty($data) ) {
		/*
		foreach($fields as $field){
			
			$f=$field->name;
			
			$log_previous_data .= $f. " = " . $data->$f."\n";
			
		}
		*/
		
		
		$log_previous_data = serialize($data);
		
			 
	
		
		
	}
	
		$record = array(
				'user_id' => $user_id,
				'log_table_id' => $log_table_id,
				'log_entry_id' => $log_entry_id,
				'log_action' => $log_action,
				'log_previous_data' => $log_previous_data				
				);
		
		$this->CI->db->insert('ferretdb_log',$record);
		
		return $this->CI->db->insert_id();
		
		
	}
	
	
	function get_options() {
		
		
		$qida = $this->CI->db->get('ferretdb_log_parameter');
		
		$opt = array();
		
		if ($qida->num_rows() > 0) {
			
			foreach ($qida->result() as $rowa) {
				
				$opt[$rowa->parameter_id] = $rowa->parameter_name; 
				
			}
			
			
		}
		
		return $opt;
		
		
	}
	
} 
