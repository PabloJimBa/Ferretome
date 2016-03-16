<?php
class Labelingoutcome extends Controller {

	private $data;

	function Labelingoutcome()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		
		$this->load->library('journal');
		$this->data['table_id'] = 13;
		
		$this->data['outcome_type'] = array('overall','ipsilateral','contralateral');
		
		
		$this->load->helper('login');
		require_login();
		
		
		$this->load->model('Leftmenu','lmenu',TRUE);
		
		if ($this->lmenu->all_number() > 0) {
				
			$this->data['leftMenu'] = $this->lmenu->get_all();
				
		}
		
		
	}

	function index() {

		$this->data['action'] = 'index';
		$this->load->view('labelingoutcome_view',$this->data);


	}

	function add(){

		// if specific lit id should be opened right after loading page
		$id = $this->input->get('id');
		
		if (!empty($id)) {
				
			$this->db->select('literature_title, literature_index, literature_id');
		
			$qida = $this->db->get_where('literature',array('literature_id' =>$id));
				
			if ($qida->num_rows()>0) {
		
				$this->data['lit_block'] = $qida->row();
		
			}
				
				
		}
		

		
		//loading js files		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/labelingoutcome.js"></script>';
		
		
		//selecting action
		$this->data['action'] = 'add';
			
		$this->load->view('labelingoutcome_view',$this->data);


	}
	
	
	
	function insert() {
	
		$fields = $_POST;
	
	
		if ($this->db->insert('labeling_outcome',$fields) === FALSE){
			$this->data['add_message'] = "An error has occured";
				
			$this->add();
	
		} else {
	
				
			$lid = $this->db->insert_id();
			$this->journal->newrecord($this->session->userdata('user_id'),$this->data['table_id'],$lid);
	
	
			$this->data['index_message'] = "Labeling outcome was added";
			$this->index();
		}
	
	
	}
	
	function edit() {
	
		$lid = $this->input->get('id');
	
		$this->data['action'] = 'edit';
	
		$this->data['block_message'] = "Nothing was sent";
	
		if (!empty($lid)){
				
				
			$qida = $this->db->get_where('labeling_outcome',array('outcome_id' => $lid));
				
			$this->data['block_message'] = "Nothing was found";
				
			if ($qida->num_rows() > 0) {
					
				unset($this->data['block_message']);
	
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/labelingoutcome.js"></script>';
				
	
				$this->data['block_data'] = $qida->row();
	
				$this->db->select('literature_title, literature_index, literature_id');
	
				$qidb = $this->db->get_where('literature',array('literature_id' => $this->data['block_data']->literature_id));
	
				$this->data['lit_data'] = $qidb->row();
	
	
				// collecting number of labeled sites for this outcome
				
				
	
					
			}
				
		}
	
	
		$this->load->view('labelingoutcome_view',$this->data);
	
	
	
	
	}
	
	
	
	function update() {
	
		$fields = $_POST;
		$inj_id = $this->input->get('id');
		
		// updating...
	
		$this->db->where('outcome_id',$inj_id);
	
		if ($this->db->update('labeling_outcome',$fields) === FALSE){
			$this->data['edit_message'] = "An error has occured";
	
			$this->edit();
	
		} else {
				
			
			// logging update action with old data and new
	
			$this->journal->newrecord($this->session->userdata('user_id'),$this->data['table_id'],$inj_id,2);
	
	
			$this->data['index_message'] = "Outcome was updated";
			$this->index();
		}
	
	
	
	
	
	}
	
	
	
	
	function ajaxGetOutcomes(){
	
	
		$pid = $this->input->post('pubid2');
		
		$method = 'normal';
		$method = $this->input->post('method');
		$result = "empty";
		
		$result = "nothing was sent";
		
		if (!empty($pid)){
				
			
			$qida = $this->db->get_where('labeling_outcome',array('literature_id' => $pid));
				
			$result = "no records";
				
				if ($qida->num_rows() > 0) {
		
					
					if ($method == 'extended') {
						
						$this->data['mode'] = 'extended';
						
						$this->load->model('Labeled_sites_model','lsmod',TRUE);
						
						foreach ($qida->result() as $rowa) {
								
							// counting all records
							$this->db->where('outcome_id', $rowa->outcome_id);
								
							$this->db->from('labelled_sites');
								
							$this->data['outcome_data'][$rowa->outcome_id] =  $this->db->count_all_results();
							
							
							//collecting labeled sites
							
							if (($qidls = $this->lsmod->get_all_where(array("outcome_id"=>$rowa->outcome_id))) != FALSE) {
							
								$this->data['labeled_fields'] = $this->lsmod->get_fields();
							
								$this->data['labeled_data'][$rowa->outcome_id] = $qidls;
								
								//print_r($this->data['labeled_data'][$rowa->outcome_id]->result());
							
							}
							
						
						}
						
						$this->data['outcomes'] = $qida;
						
					} else {
						
						$this->data['mode'] = 'normal';
						
						$temp_arr = array();
						
						foreach ($qida->result() as $rowa) {
								
							// counting all records
							$this->db->where('outcome_id', $rowa->outcome_id);
								
							$this->db->from('labelled_sites');
								
							$temp_arr[$rowa->outcome_id] = $rowa->outcome_id . " - " . $this->data['outcome_type'][$rowa->outcome_type]." has ". $this->db->count_all_results(). " labeled sites";
						
						}
						
						$this->data['outcome_options'] = $temp_arr;
						
					}
					
					$this->data['action'] = 'load_outcomes';
					$result = $this->load->view('labelingoutcome_ajax_get_view',$this->data,TRUE);
				
				}
					
				
				
			
		
	
		}
				
				
	
	
	
		echo $result;
	
	
	}
	
	
	function ajaxGetInsertForm() {
		
		
		$pid = $this->input->post('literature_id');
		
		$result = "empty";
		
		if (!empty($pid)){
			
			
			$this->data['frmid'] = md5(time());
			$this->data['lid'] = $pid;
			
			$this->data['action'] = 'new_outcome';
			
			$result = $this->load->view('labelingoutcome_ajax_get_view',$this->data,TRUE);
		}
		
		echo $result;
		
		
		
		
	}
	
	function ajaxSaveOutcome () {
		
		
		$fields = $_POST;
		
		$result = 'Error: nothing was sent';
		
		if (!empty($fields['literature_id'])) {
				
			
			$this->db->insert('labeling_outcome',$fields);
			$id = $this->db->insert_id();
			$this->journal->newrecord($this->session->userdata('user_id'),$this->data['table_id'],$id,1);
			
			$result = 'ok';
				
				
		}
		echo $result;
		
		
	}
	
	
	
	


}