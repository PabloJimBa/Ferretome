<?php 
class Jobjournal_model extends Model {
	
	var $types = array 
	(
			
			"input is required",
			"proofreading required"
			
			
	);
	
	var $states = array
	(
			
			"in progress",
			"finished"
			
	);
	
	// virtual(constant) name => field name in database 
	var $insert_fields = array(
		
		"user_id"=>"user_id",
		"job_id"=>"job_id"
			
		
	);
	
	
	var $fields = array 
	(
			
			"job_title" => array 
			(
					"real_name" => "job_title",
					"type" => "string"
			),
			
			"job_type" => array
			(
					"real_name" => "job_type",
					"type" => "array",
					"array_data" => array ()
			),
			
			"date_taken" => array
			(
					"real_name" => "record_time",
					"type" => "string"
					
			),
			
			"go_to_job" => array
			(
					"real_name" => "literature_id",
					"type" => "replace",
					"replace_data" => '<a href="index.php?c=literature&m=edit&id={literature_id}">click here</a>'
						
			),
			
						
			"action" => array
			(
					"real_name" => "job_id",
					"type" => "replace",
					"replace_data" => '<a href="#" onclick="reject_job(\'{job_id}\'); return false;"> reject this job</a> &nbsp;'
			)
			
			
			
			
	);
		
		
		
	

    
 	function Jobjournal_model(){
         
         parent::Model();
         
         $this->fields['job_type']['array_data'] = $this->types;
         $this->fields['job_state']['array_data'] = $this->states;
    }
    
    
    function insert($parameters) {
    	
    	
    	
    	$fields = array();
    	
    	foreach ($parameters as $key => $val) {
    		
    		$fields[$this->insert_fields[$key]] = $val;
    		
    	}
    
    	
    	
    	return $this->db->insert('ferretdb_job_journal',$fields);
    	
    	
    }
    
    
    function delete_current($uid) {
    	
    	
    	return $this->db->delete('ferretdb_job_journal',array($this->insert_fields['user_id']=>$uid,'state'=>'0'));
    	
    	
    }
    
    
    function finish_current($uid) {
    	
    	$this->db->where(array($this->insert_fields['user_id']=>$uid,'state'=>'0'));
    	
    	return $this->db->update('ferretdb_job_journal',array('state'=>'1'));
    	
    }
    
    
    
     
    function all_number($type=0,$state=0) {
    	
    	$this->db->where
    	( 
    			array( 
    					"job_type" => $type,
    					"job_state" => $state
    					
    			
    			)
    	);
    	
    	return  $this->db->count_all_results('ferretdb_workflow');
    	    	
    	
    } 
    
    
    function get_one($id) {
    	
    	return $this->get_all_where(array('job_id'=>$id));
    	
    	
    }
    
    function get_current($user_id) {
    	
    	
    	return $this->get_all_where(array('user_id'=>$user_id,'state'=>'0'));
    	
    	
    }
    
    
    
    function get_all_where($args=array(),$order_by='record_id',$order='desc',$limit='999',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	
    	$this->db->join('ferretdb_workflow','ferretdb_workflow.job_id = ferretdb_job_journal.job_id');
    	
    	    	
    	if (!empty($args)){
    		$qida = $this->db->get_where('ferretdb_job_journal',$args,$limit,$offset);
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			
    			return FALSE;
    		}
    		
    	} else {
    		
    		$qida = $this->db->get('ferretdb_job_journal',$limit,$offset);
    		
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			 
    			return FALSE;
    		}
    		
    	}
    	
    }
    
       
    
    
    
    function get_types(){
    	 
    	return $this->types;
    	 
    }
    
    function get_fields(){
    
    	return $this->fields;
    
    }
    
    function get_ifields(){
    
    	return $this->insert_fields;
    
    }
    
    
    
}

?>