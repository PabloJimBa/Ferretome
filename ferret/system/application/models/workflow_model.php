<?php 
class Workflow_model extends Model {
	
	var $types = array 
	(
			
			"input is required",
			"proofreading required",
			"proofreading finished"
			
			
	);
	
	var $states = array
	(
			
			"not started",
			"in progress",
			"finished"
			
	);
	
	var $insert_fields = array(
	
			"user_id"=>"user_id",
			"job_id"=>"job_id"
				
	
	);
	
	
	var $fields = array 
	(
			
			"standart" => array(
					
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
				
				"job_state" => array
				(
						"real_name" => "job_state",
						"type" => "array",
						"array_data" => array ()
				),
				
				
				
				"action" => array
				(
						"real_name" => "job_id",
						"type" => "replace",
						"replace_data" => '<a href="#" onclick="take_job(\'{job_id}\'); return false;"> take this job</a>'
				)
			),
			
			"statistics" => array(
						
					"user_name" => array
					(
							"real_name" => "user_name",
							"type" => "string"
					),
					
					"user_last_name" => array
					(
							"real_name" => "user_surname",
							"type" => "string"
					),
						
			
			
					"inserted" => array
					(
							"real_name" => "number_inserted",
							"type" => "string"
					),
			
			
			
					"profreaded" => array
					(
							"real_name" => "number_profreaded",
							"type" => "string"
					)
			),
			
			"current_job" => array(

					
								
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
								
								
								
								
					
			
					
			)
			
			
			
			
			
	);
		
		
		
	

    
 	function Workflow_model(){
         
         parent::Model();
         
         $this->fields['standart']['job_type']['array_data'] = $this->types;
         $this->fields['standart']['job_state']['array_data'] = $this->states;
         $this->fields['current_job']['job_type']['array_data'] = $this->types;
    }
    
    
    function insert($parameters) {
    	 
    	 
    	 
    	$fields = array();
    	 
    	foreach ($parameters as $key => $val) {
    
    		$fields[$this->insert_fields[$key]] = $val;
    
    	}
    
    	 
    	 
    	return $this->db->insert('ferretdb_job_journal',$fields);
    	 
    	 
    }
    
    function  create_job($title,$id,$type='0',$state='0') {
    	
    	
    	$fields = array
    	(
    			
    			"job_title" => $title,
    			"literature_id" => $id,
    			"job_type" => $type,
    			"job_state" => $state
    			
    			
    	);
    	 
    	 
    	return $this->db->insert('ferretdb_workflow',$fields);
    	
    	
    	
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
    
    /*@
     * 
     * 
     */

    function all_number_for_user($uid) {
    	 
    	$qida = $this->db->query("SELECT COUNT(*) as num FROM ferretdb_workflow WHERE job_type = 1 AND job_state = 0 AND literature_id NOT IN (SELECT literature_id from ferretdb_workflow WHERE user_id = ? AND job_type = 0 and job_state = 2)", array($uid));
    	
    	if ($qida->num_rows() > 0){
    		$row = $qida->row();
    		return $row->num;
    	} else {
    	
    		return FALSE;
    	}
    
    	 
    }
    
    
    function get_one($id) {
    	
    	return $this->get_all_where(array('job_id'=>$id));
    	
    	
    }
    
    function get_statistics(){
    	
    	$this->db->select("user_id, user_name, user_surname");
    	$qida = $this->db->get("ferretdb_users");
    	
    	$ins_number = 0;
    	$proof_number = 0;
    	
    	$this->db->query("DROP TABLE IF EXISTS user_workflow_statistics");
    	$this->db->query("CREATE TEMPORARY TABLE user_workflow_statistics (user_name VARCHAR(255), user_surname VARCHAR(255), number_inserted INT, number_profreaded INT) ");
    	
    	
    	foreach  ($qida->result() as $rowa) {
    		
    		// counting number of inserted by a specific user
    		$this->db->where
    		(
    				array(
    						"job_type" => 0,
    						"job_state" => 2,
    						"user_id" => $rowa->user_id
    							
    							
    				)
    		);
    		 
    		$ins_number = $this->db->count_all_results('ferretdb_workflow');
    		
    		// counting number of proofreaded by a specific user
    		
    		$this->db->where
    		(
    				array(
    						"job_type" => 1,
    						"job_state" => 2,
    						"user_id" => $rowa->user_id
    							
    							
    				)
    		);
    		 
    		$proof_number = $this->db->count_all_results('ferretdb_workflow');
    		
    		// pool everything together and insert into temp table
    		$fields = array
    		(
    				 
    				"user_name" => $rowa->user_name,
    				"user_surname" => $rowa->user_surname,
    				"number_inserted" => $ins_number,
    				"number_profreaded" => $proof_number
    				 
    				 
    		);
    		
    		
    		$this->db->insert('user_workflow_statistics',$fields);
    		
    		
    		
    	}
    	

    	
    	
		return  $this->db->get("user_workflow_statistics");    	
    	
    	
    	
    	
    	
    }
    
    
    function change_state($id,$state){
    	
    	
    	$this->db->where(array('job_id'=>$id));
    	 
    	return $this->db->update('ferretdb_workflow',array('job_state'=>$state));
    	
    	
    	
    }
    
    function get_all_where($args=array(),$order_by='job_id',$order='desc',$limit='999',$offset='0') {
    	
    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
    	
    	    	
    	if (!empty($args)){
    		$qida = $this->db->get_where('ferretdb_workflow',$args,$limit,$offset);
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			
    			return FALSE;
    		}
    		
    	} else {
    		
    		$qida = $this->db->get('ferretdb_workflow',$limit,$offset);
    		
    		if ($qida->num_rows() > 0){
    			return $qida;
    		} else {
    			 
    			return FALSE;
    		}
    		
    	}
    	
    }
    
    
    function get_for_user($uid){
    	
    	$qida = $this->db->query("SELECT * FROM ferretdb_workflow WHERE job_type = 1 AND job_state = 0 AND literature_id NOT IN (SELECT literature_id from ferretdb_workflow WHERE user_id = ? AND job_type = 0 and job_state = 2)", array($uid));
    	
    	if ($qida->num_rows() > 0){
    		return $qida;
    	} else {
    	
    		return FALSE;
    	}
    	
    	
    }
    

    
    function get_current($user_id) {
    	 
    	 
    	return $this->get_all_where(array('user_id'=>$user_id,'job_state'=>'1'));
    	 
    	 
    }
    
    
	function take_job($id,$uid) {
    	 
    	$this->db->where(array("job_id"=>$id));
    	return $this->db->update('ferretdb_workflow',array($this->insert_fields['user_id']=>$uid,'job_state'=>'1'));
    	 
    	 
    }
    
    function delete_current($uid) {
    	 
    	$this->db->where(array($this->insert_fields['user_id']=>$uid,'job_state'=>'1'));
    	return $this->db->update('ferretdb_workflow',array($this->insert_fields['user_id']=>'0','job_state'=>'0'));
    	 
    	 
    }
    
    
    function finish_current($uid) {
    	 
    	$this->db->where(array($this->insert_fields['user_id']=>$uid,'job_state'=>'1'));
    	 
    	return $this->db->update('ferretdb_workflow',array('job_state'=>'2'));
    	 
    }
    
    
    
    function get_types(){
    	 
    	return $this->types;
    	 
    }
    
    function get_fields($set='standart'){
    
    	return $this->fields[$set];
    
    }
    
    function get_ifields(){
    
    	return $this->insert_fields;
    
    }
    
    
    
}

?>