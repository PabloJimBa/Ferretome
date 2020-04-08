<?php
class Codingrules extends Controller {

	private $data;

	function Codingrules()
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
		$this->load->view('codingrules_view',$this->data);


	}
	
	function show() {
		
		
		//$this->data['fields'] = $this->db->field_data('brain_site_acronyms');
		
		$this->data['action'] = 'show';
		
		$this->db->select('coding_rules_id, coding_rules_name');
		
		$this->data['block_data'] = $this->db->get('coding_rules');
			
		$this->load->view('codingrules_view',$this->data);
		
		
	}
	
	function add() {
		
		$this->data['fields'] = $this->db->field_data('coding_rules');
		
		$this->data['action'] = 'add';
		
		//headers go hier
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
		
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
		
		
		$this->load->view('codingrules_view',$this->data);
		
		
		
	}
	
	function insert(){
		
		$fields = $_POST;
		
		
		if ($this->db->insert('coding_rules',$fields) === FALSE){
		
			$this->index();
		
		} else {
		
		
			//$this->journal->newrecord($this->session->userdata('user_id'),5,$id,2);
		
			$this->data['block_message'] = "Coding rule was updated";
			$this->show();
		}
		
		
		
		
	}
	
	function edit() {
		
		$id = $this->input->get('id');
		
		$this->data['action'] = 'edit';
		
		
		
		if (!empty($id)){
		
		
			$qida = $this->db->get_where('coding_rules',array('coding_rules_id' => $id));
		
			if ($qida->num_rows()>0){
		
				$this->data['block_data'] = $qida->row();
		
				$this->data['fields'] = $this->db->field_data('coding_rules');
				
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
				
		
		
			}
		}
		
		$this->load->view('codingrules_view',$this->data);
			
		}
		
		
		
	function update() {
	
	
	
		$fields = $_POST;
	
		// 		print_r($fields);
	
	
		$id = $this->input->get('id');
	
	
		if (!empty($id)){
	
	
			$this->db->where('coding_rules_id',$id);
	
			if ($this->db->update('coding_rules',$fields) === FALSE){
	
				$this->index();
					
			} else {
					
	
				//$this->journal->newrecord($this->session->userdata('user_id'),5,$id,2);
					
				$this->data['block_message'] = "Coding rule was updated";
				$this->show();
			}
		}
	
	
	}

	function confirm(){
	
		$id = $this->input->get('id');
		echo "<script>if(confirm('Are you sure?')){
		document.location='index.php?c=codingrules&m=del_lit&id=$id';}
		else{ javascript:history.go(-1);
		}</script>"; 
	}
	
	function del_lit(){
		
		$id = $this->input->get('id');
		
		$result = "empty query";
		
		if (!empty($id)){
			
			$this->db->delete('coding_rules',array('coding_rules_id'=>$id));
				
			echo "Deleted. Please, reload the page.";

			echo "<script>document.location='index.php?c=codingrules&m=show'</script>;";
				
			return true;
				
				
		}
		echo "Not deleted";

		echo "<script>document.location='index.php?c=codingrules&m=show'</script>;";
	}
		
	
}

?>
