<?php 
class Leftmenu extends Model {

    
 function Leftmenu()
     {
         
         parent::Model();
     }
    
    
    function all_number() {
    	
    	return  $this->db->count_all_results('ferretdb_left_menu');
    	    	
    	
    } 
    
    function get_all() {
    	
    	$this->db->order_by('item_mass','desc');
    	return $this->db->get('ferretdb_left_menu');
    	
    }
    
    function change_mass($id,$act = 1) {
    	
    	$qida = $this->db->get_where('ferretdb_left_menu',array('item_id'=>$id));
    	
    	if ($qida->num_rows()>0) {
    		
    		if ($act == 1) {
    			
    			$rowa = $qida->row();
    			
    			$mass = $rowa->item_mass+1;
    			
    			$this->db->where('item_id',$id);
    			
    			$this->db->update('ferretdb_left_menu',array("item_mass"=>$mass));
    			
    		} else {
    			
    			$rowa = $qida->row();
    			 
    			$mass = $rowa->item_mass-1;
    			 
    			$this->db->where('item_id',$id);
    			 
    			$this->db->update('ferretdb_left_menu',array("item_mass"=>$mass));
    			
    			
    			
    			
    		}
    		
    		
    		
    	} else {
    		
    		return false;
    		
    	} 
    	
    	
    	
    }
    
    
}

?>