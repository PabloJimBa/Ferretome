<?php
class Parameters extends Controller {

	private $data;
	
	private $table_id = 11;

	function Parameters()
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
		$this->load->view('parameters_view',$this->data);


	}

	function show() {


		//$this->data['fields'] = $this->db->field_data('brain_site_acronyms');

		$this->data['action'] = 'show';

		$this->data['block_data'] = $this->db->get('parameters');
			
		$this->load->view('parameters_view',$this->data);


	}

	
	function add() {
	
		$this->data['fields'] = $this->db->field_data('parameters');
		
		
		$this->load->model('Architecture_parameters_model','pmodel',TRUE);
		
		$this->data['types_options'] = $this->pmodel->get_types();
	
		$this->data['action'] = 'add';
	
		//headers go here
	
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/parameters.js"></script>';
	
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/autocomplete.js"></script>';
	
	
		$this->load->view('parameters_view',$this->data);
	
	
	
	}
	
	function insert(){
	
		$fields = $_POST;
	
	
		if ($this->db->insert('parameters',$fields) === FALSE){
	
			$this->index();
	
		} else {
	
			$lid = $this->db->insert_id();
				
			$this->journal->newrecord($this->session->userdata('user_id'),$this->table_id,$lid);
			
			
			$this->data['block_message'] = "parameter was created";
			$this->show();
		}
	
	
	
	
	}
	
	function edit() {
	
		$id = $this->input->get('id');
	
		$this->data['action'] = 'edit';
	
	
	
		if (!empty($id)){
	
	
			$qida = $this->db->get_where('parameters',array('parameters_id' => $id));
	
			if ($qida->num_rows()>0){
	
				$this->data['block_data'] = $qida->row();
	
				$this->data['fields'] = $this->db->field_data('parameters');
				
				$this->load->model('Architecture_parameters_model','pmodel',TRUE);
				
				$this->data['types_options'] = $this->pmodel->get_types();
	
//				$this->data['extraHeader'] = '<script type="text/javascript" src="js/parameters.js"></script>';
				//$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
	
	
	
			}
		}
	
		$this->load->view('parameters_view',$this->data);
			
	}
	
	
	
	function update() {
	
	
	
		$fields = $_POST;
	
		// 		print_r($fields);
	
	
		$id = $this->input->get('id');
		
		
		$prev_data = $this->db->get_where('parameters',array('parameters_id' => $id));
		
		$prev_data = $prev_data->row();
	
	
		if (!empty($id)){
	
	
			$this->db->where('parameters_id',$id);
	
			if ($this->db->update('parameters',$fields) === FALSE){
	
				$this->index();
	
			} else {
	
	
				//newrecord (USER_ID,TABLE_ID,ENTRY_ID,ACTION_ID(1=ins,2=update,3=del)=1,DATA='');
			
				$this->journal->newrecord($this->session->userdata('user_id'),$this->table_id,$id,2,$prev_data);
			
				$this->data['block_message'] = "parameter was updated";
				$this->show();
			}
		}
	
	
	}
	
	
	function ajaxAtocomplit(){
		
		$qr = $this->input->post('query');
		
		$result = 'no thing';
		
		if (!empty($qr)) {
		
		
			$qida = $this->db->query("SELECT DISTINCT parameters_id as aid, tracers_name as ash, tracers_description as af FROM tracers WHERE tracers_name LIKE ? LIMIT 7", array($qr . '%'));
			
			
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
	
	
	
	function ajaxGetParametersDescription() {
		
		$id = $this->input->post('pid');
		$result = 'no input';
		
		if (!empty($id)) {
			$result = 'nothing found';
			
			
			$qida = $this->db->get_where('parameters',array('parameters_id' => $id));
			
			if ($qida->num_rows()>0){
			
				$rowa = $qida->row();
				
				$result = $rowa->description;
				
			}
			
			
			
		}
		
		echo $result.' <a href="#" onclick="hide_description(); return false;">hide</a>';
		
		
		
		
	}
	
	
	
	
	function ajaxGetParametersInput(){
		
		
		$id = $this->input->post('pid');
		$result = 'no input';
		
		if (!empty($id)) {
			$result = 'nothing found';
				
				
			$qida = $this->db->get_where('parameters',array('parameters_id' => $id));
				
			if ($qida->num_rows()>0){
					
				$rowa = $qida->row();
		
				$type = $rowa->parameters_type;
				
				if ($type == '1') {
					$result = '<input type="text" id="parameters_value" name="parameters_value" value=""/>';
					
				}
				if ($type == '2') {
					$result = '<textarea id="parameters_value" name="parameters_value"></textarea>';
				}
				if ($type == '3') {
					$result = '<input type="checkbox" name="parameters_value" id="parameters_value"/>Click if true';
				}
				
		
			}
				
				
				
		}
		
		echo $result;
		
		
		
		
	}
	
	
	
	
	
	
	
	
}
	
?>
		