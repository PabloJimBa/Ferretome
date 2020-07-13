<?php
class Menueditor extends Controller {

	private $data;

	function Menueditor()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');

		$this->load->library('journal');

		$this->load->helper('login');
		require_login();
		
		$this->data['item_type_options'] = array ("0"=> "Block Item", "1"=> "Link Item");
		
		$this->load->model('Leftmenu','lmenu',TRUE);
		
		if ($this->lmenu->all_number() > 0) {
				
			$this->data['leftMenu'] = $this->lmenu->get_all();
				
		}
		
	}

	function index() {

		$this->data['action'] = 'index';
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/menueditor.js"></script>';
		
		
		$this->db->order_by('item_mass','desc');		
		$qida = $this->db->get('ferretdb_left_menu');
		
		
		 
		if ($qida->num_rows() > 0) {
			
			$this->data['left_menu'] = $qida;
			
		}
		 
		$this->load->view('menueditor_view',$this->data);

		

	}
	
	
	function ajaxGetAllItems () {
		
		
		$this->data['action'] = 'load_data';
		
		$this->db->order_by('item_mass','desc');
		$qida = $this->db->get('ferretdb_left_menu');
		
		
		$result = 'No thing so far';
			
		if ($qida->num_rows() > 0) {
				
			$this->data['left_menu'] = $qida;
			
			$result = $this->load->view('menueditor_ajax_view',$this->data, TRUE);
				
		}
			
		echo $result;
		
		
		
		
	}
	
	
	function ajaxInsertItem() {
		
		$fields = $_POST;
		
		$this->db->insert('ferretdb_left_menu',$fields);
		
		
	}
	
	function ajaxMoveItem() {
		
		
		
		$met = $this->input->post('method');
		$id = $this->input->post('id');
		
		if ((!empty($met)&&(!empty($id)))) {
			
			if ($met == 'up') {
				
				$this->load->model('Leftmenu','lmenu',TRUE);
				// 1 = up, 2 = down; default = 1
				$this->lmenu->change_mass($id);
				
				
				
			} else {
				
				
				$this->load->model('Leftmenu','lmenu',TRUE);
				// 1 = up, 2 = down; default = 1
				$this->lmenu->change_mass($id,2);
				
				
				
			}
			
			
		}
		
	
		
	}
	

}