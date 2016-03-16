<?php 
class Journal extends Controller {

	private $data;

	function Journal()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		
		$this->load->library('journal');
		
		$this->load->helper('login');
		require_login();
		
		$this->data['act_types'] = array(
				'1'=>'Insert',
				'2'=>'Update',
				'3'=>'Delete',
				);
		
		$this->load->model('Leftmenu','lmenu',TRUE);
		
		if ($this->lmenu->all_number() > 0) {
				
			$this->data['leftMenu'] = $this->lmenu->get_all();
				
		}
		
	}

	function index() {

		
		$this->db->join('ferretdb_tables_descriptions','ferretdb_tables_descriptions.tables_descriptions_id = ferretdb_log.log_table_id');
		
		$this->db->join('ferretdb_log_parameter','ferretdb_log_parameter.parameter_id = ferretdb_log.log_parameter','left');
		
		$this->db->join('ferretdb_users','ferretdb_log.user_id = ferretdb_users.user_id');
		
		$this->db->order_by('log_time','desc');
		
		$this->data['block_data'] = $this->db->get('ferretdb_log',50);
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/journal.js"></script>';
		//$this->data['extraHeader'] .= '<script type="text/javascript" src="js/injections.js"></script>';
		

		$this->data['action'] = 'index';
		$this->load->view('journal_view',$this->data);


	}
	
	function saveUpdateReason() {
		
		$fields = $_POST;
		
		
		$lid = $fields['log_id'];
		
		unset($fields['log_id']);
		
		$this->db->where('log_id',$lid);
		
		$this->db->update('ferretdb_log',$fields);
		
		
		
		
	}
}
?>