<?php
class Authors extends Controller {

	private $data;

	function Authors()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		
		$this->load->library('journal');
		
		$this->load->helper('login');		
		require_login();
		
		$this->load->model('Leftmenu','lmenu',TRUE);
		
		if ($this->lmenu->all_number() > 0) {
				
			$this->data['leftMenu'] = $this->lmenu->get_all();
				
		}
		
	}
	
	function index() {
	
		$this->data['action'] = 'index';
		$this->load->view('authors_view',$this->data);
	
	
	}
	
	
	function show() {
	
	
	
		$this->data['action'] = 'show';
		
		$this->load->model('Authors_model','aum',TRUE);
		
		if (($qida = $this->aum->get_all_where(array(),'authors_surname','asc','999')) != FALSE){
			
			
			$this->data['block_data'] = $qida;
			$this->data['block_fields'] = $this->aum->get_fields();
			
			
			
		}
	 
			
		$this->load->view('authors_view',$this->data);
	
	
	}
	
	function add($view='standart'){
	
	
		$this->data['fields'] = $this->db->field_data('authors');
	
		$this->data['action'] = 'add';
		
		
			
		$this->load->view('authors_view',$this->data);
	
	
	}
	
	function insert() {
	
		$fields = $_POST;
	
	
	
		//print_r($fields);
			
	
		if ($this->db->insert('authors',$fields) === FALSE){
			$this->add();
		}
		else {
			
			$lid = $this->db->insert_id();
			$this->journal->newrecord($this->session->userdata('user_id'),2,$lid);
				
			$this->data['index_message'] = "Author was added";
			$this->index();
		}
	
	
	}
	
	// Autocomplete function	

	function ajaxAtocomplit() {
		
		
		$qr = $this->input->post('query'); // $qr variable is what user writes
		
		$result = 'no thing';
		
		if (!empty($qr)) {
				
			// Load data (which matching with surname of $qr) from authors table (from database) into $qida variable
			$qida = $this->db->query("SELECT DISTINCT authors_id as aid, authors_surname as asname, authors_name as aname FROM authors WHERE authors_surname LIKE ? LIMIT 7", array($qr . '%'));
		
			if ($qida->num_rows() > 0) {
		
				$result = "{ query:'" . $qr . "', suggestions:[";
				foreach ($qida->result() as $rowa) {
					$result .= "'". $rowa->asname . " " . $rowa->aname . "',";
				}
		
				$result = substr($result, 0, strlen($result) - 1);
		
				$result .="],data:[";
				
				foreach ($qida->result() as $rowa) {
					$result .= "'". $rowa->aid ."',";
				}
				
				$result = substr($result, 0, strlen($result) - 1);
			
			
				$result .="]}";
			}
		}
		
		echo $result;
		
		
		
		
	}
	
	
	function search(){
	
	
		//$this->data['fields'] = $this->db->field_data('literature');
	
		$this->data['action'] = 'search';
	
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/authors.js"></script>';
			
		$this->load->view('authors_view',$this->data);
	
	
	
	
	}
	
	function searchDo() {

		$id = $this->input->post('authid');
		
		$result = 'nothing found';
		
		if (!empty($id)){
		
			$qida = $this->db->get_where('authors',array('authors_id' => $id));
			
			if ($qida->num_rows()>0){
				
				
				$this->data['auth_data'] = $qida->row();
				
				$result = $this->load->view('authors_search_view',$this->data);
				
				
			}
		
		
		}
		
		echo $result;
	
	
	}
	
	
	function edit() {
		
		
		$id = $this->input->get('id');
		
		$this->data['action'] = 'edit';
		
		$this->data['block_message'] = "Nothing was sent";
		
		
		
		if (!empty($id)){
				
				
			$qida = $this->db->get_where('authors',array('authors_id' => $id));
			
			$this->data['block_message'] = "Nothing was found";
			
			if ($qida->num_rows()>0){
				
				$this->data['auth_data'] = $qida->row();
				
				unset($this->data['block_message']);
				
				$this->data['fields'] = $this->db->field_data('authors');
								
				
			}
		}
		
		$this->load->view('authors_view',$this->data);
					
	}
	
	function update() {
		
		
		
		$fields = $_POST;
		
// 		print_r($fields);
		

		$id = $this->input->get('aid'); 
		
		
		if (!empty($id)){
			
			
			$this->db->where('authors_id',$id);
			
			if ($this->db->update('authors',$fields) === FALSE){

				$this->search();
			
			} else {
					
				
				$this->journal->newrecord($this->session->userdata('user_id'),2,$id,2);
			
				$this->data['index_message'] = "Author was updated";
				$this->index();
			}
		}

		
	}
	
}

?>
