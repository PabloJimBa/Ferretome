<?php 
class Users_model extends Model {

	var $fields = array 
	(
			"user_id",
			"user_email",
			"user_password",
			"user_surname",
			"user_name",
			"user_reg_time",
			"user_class"
			
	);

	function get_all($limit='999') {
    
    
    		return $this->get_all_where(array(),'user_reg_time','acs',$limit);
    
    	}

	function get_fields(){
    	
    	
    		return $this->fields;
    	
    	}

	function get_all_where($args=array(),$order_by='users_id',$order='desc',$limit='10',$offset='0') {
    	
	    	if (!empty($order_by)) $this->db->order_by($order_by,$order);
	    	
	    	
	    	if (!empty($args)){
	    		return $this->db->get_where('ferretdb_users',$args,$limit,$offset);
	    	} else {
	    		return $this->db->get('ferretdb_users',$limit,$offset);
	    		
	    	}
	    	
	}

	function get_for_user($uid){
    	
    	$qida = $this->db->query("SELECT user_class FROM ferretdb_users", array($uid));
    	
    	if ($qida->num_rows() > 0){
    		return $qida;
    	} else {
    	
    		return FALSE;
    	}
    	
    	
    }

}
?>
