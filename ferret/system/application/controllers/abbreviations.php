<?php
class Abbreviations extends Controller {

	private $data;

	function Abbreviations()
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
		$this->load->view('abbreviations_view',$this->data);


	}

	function show() {


		//$this->data['fields'] = $this->db->field_data('brain_site_acronyms');

		$this->data['action'] = 'show';

		$this->data['block_data'] = $this->db->get('literature_abbreviations');
			
		$this->load->view('abbreviations_view',$this->data);


	}

	
	function add() {
	
		$this->data['fields'] = $this->db->field_data('literature_abbreviations');
	
		$this->data['action'] = 'add';
	
		//headers go here
	
		//$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
	
		//$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
	
	
		$this->load->view('abbreviations_view',$this->data);
	
	
	
	}
	
	function insert(){
	
		$fields = $_POST;
	
	
		if ($this->db->insert('literature_abbreviations',$fields) === FALSE){
	
			$this->index();
	
		} else {
	
	
			//$this->journal->newrecord($this->session->userdata('user_id'),5,$id,2);
	
			$this->data['block_message'] = "Abbr was created";
			$this->show();
		}
	
	
	
	
	}
	
	function edit() {
	
		$id = $this->input->get('id');
	
		$this->data['action'] = 'edit';
	
	
	
		if (!empty($id)){
	
	
			$qida = $this->db->get_where('literature_abbreviations',array('abbreviations_id' => $id));
	
			if ($qida->num_rows()>0){
	
				$this->data['block_data'] = $qida->row();
	
				$this->data['fields'] = $this->db->field_data('literature_abbreviations');
	
				//$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
				//$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
	
	
	
			}
		}
	
		$this->load->view('abbreviations_view',$this->data);
			
	}
	
	
	
	function update() {
	
	
	
		$fields = $_POST;
	
		// 		print_r($fields);
	
	
		$id = $this->input->get('id');
	
	
		if (!empty($id)){
	
	
			$this->db->where('abbreviations_id',$id);
	
			if ($this->db->update('literature_abbreviations',$fields) === FALSE){
	
				$this->index();
	
			} else {
	
	
				//$this->journal->newrecord($this->session->userdata('user_id'),5,$id,2);
	
				$this->data['block_message'] = "Abbr. was updated";
				$this->show();
			}
		}
	
	
	}

	function confirm(){
	
		$id = $this->input->get('id');
		echo "<script>if(confirm('Are you sure?')){
		document.location='index.php?c=abbreviations&m=del_lit&id=$id';}
		else{ javascript:history.go(-1);
		}</script>"; 
	}
	
	function del_lit(){
		
		$id = $this->input->get('id');
		
		$result = "empty query";
		
		if (!empty($id)){
			
			$this->db->delete('literature_abbreviations',array('abbreviations_id'=>$id));
				
			echo "Deleted. Please, reload the page.";

			echo "<script>document.location='index.php?c=abbreviations&m=show'</script>;";
				
			return true;
				
				
		}
		echo "Not deleted";

		echo "<script>document.location='index.php?c=abbreviations&m=show'</script>;";
	}
	
	// Autocomplete function	
	
	function ajaxAtocomplit(){
		
		$qr = $this->input->post('query'); // $qr variable is what user writes
		
		$result = 'no thing';
		
		if (!empty($qr)) {
		
			// Load data (which matching with abbr_short of $qr) from literature_abbr table (from database) into $qida variable
			$qida = $this->db->query("SELECT DISTINCT abbreviations_id as aid, abbreviations_short as ash, abbreviations_full as af FROM literature_abbreviations WHERE abbreviations_short LIKE ? OR abbreviations_full LIKE ? LIMIT 7", array($qr . '%','%' . $qr . '%'));
			
			
			if ($qida->num_rows() > 0) {
			
				$result = "{ query:'" . $qr . "', suggestions:[";
				foreach ($qida->result() as $rowa) {
					$result .= "'".  $rowa->ash . " - ".substr($rowa->af, 0,100).  "',";
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
	
	
	
	
	
	
	
	
	}
	
	?>
		
