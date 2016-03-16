<?php 
class Architecture_parameters_model extends Model {

    
 function Architecture_parameters_model(){
         
         parent::Model();
     }
     
     
     
     function get_types(){
     	
     	$arr = array (
     			"1"=>"Varchar",
     			"2"=>"Text",
     			"3"=>"Boolean"
     			
     			);
     	
     	return $arr;
     	
     }
    
     
   
    
    
    
    
    
}

?>