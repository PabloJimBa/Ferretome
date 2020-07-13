<?php
class Welcome extends Controller {

	private $data;

	function Welcome()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('login');
		require_login();
	}

	function index() {

		$this->data['action'] = 'index';
		$this->load->view('welcome_view',$this->data);


	}
	
	function ajaxGetCodingRules() {
		
		$id = $this->input->post('rule_id');
		
		$result = 'No thing';
		
		if (!empty($id)) {
			
			$qida = $this->db->get_where('coding_rules',array('coding_rules_name' => $id));
			
			if ($qida->num_rows() > 0) {
				
				$rowa = $qida->row();
				
				$result = $rowa->coding_rules_desc; 
								
				
			} else {
				
				$result = 'Nothing found';
			}
		}
		
		echo $result;
		
		
		
	}
	
}

?>
