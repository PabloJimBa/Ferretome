<?php
class Injectionsparameters extends Controller {

	private $data;

	function Injectionsparameters()
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
		$this->load->view('injections_parameters_view',$this->data);


	}

	function show() {


		//$this->data['fields'] = $this->db->field_data('brain_site_acronyms');

		$this->data['action'] = 'show';

		$this->data['block_data'] = $this->db->get('injections_parameters');
			
		$this->load->view('injections_parameters_view',$this->data);


	}

	
	function add() {
	
		$this->data['fields'] = $this->db->field_data('injections_parameters');
	
		$this->data['action'] = 'add';
		
		$this->load->model('Architecture_parameters_model','pmodel',TRUE);
		
		$this->data['types_options'] = $this->pmodel->get_types();
		
	
		//headers go here
	
		//$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
	
		//$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
	
	
		$this->load->view('injections_parameters_view',$this->data);
	
	
	
	}
	
	function insert(){
	
		$fields = $_POST;
	
	
		if ($this->db->insert('injections_parameters',$fields) === FALSE){
	
			$this->index();
	
		} else {
	
	
			//$this->journal->newrecord($this->session->userdata('user_id'),5,$id,2);
	
			$this->data['block_message'] = "tracer was created";
			$this->show();
		}
	
	
	
	
	}
	
	function edit() {
	
		$id = $this->input->get('id');
	
		$this->data['action'] = 'edit';
	
	
	
		if (!empty($id)){
	
	
			$qida = $this->db->get_where('injections_parameters',array('parameters_id' => $id));
	
			if ($qida->num_rows()>0){
	
				$this->data['block_data'] = $qida->row();
	
				$this->data['fields'] = $this->db->field_data('injections_parameters');
				
				$this->load->model('Architecture_parameters_model','pmodel',TRUE);
				
				$this->data['types_options'] = $this->pmodel->get_types();
				
	
				//$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
				//$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
	
	
	
			}
		}
	
		$this->load->view('injections_parameters_view',$this->data);
			
	}
	
	
	
	function update() {
	
	
	
		$fields = $_POST;
	
		// 		print_r($fields);
	
	
		$id = $this->input->get('id');
	
	
		if (!empty($id)){
	
	
			$this->db->where('parameters_id',$id);
	
			if ($this->db->update('injections_parameters',$fields) === FALSE){
	
				$this->index();
	
			} else {
	
	
				//$this->journal->newrecord($this->session->userdata('user_id'),5,$id,2);
	
				$this->data['block_message'] = "tracer was updated";
				$this->show();
			}
		}
	
	
	}

	function confirm(){
	
		$id = $this->input->get('id');
		echo "<script>if(confirm('Are you sure?')){
		document.location='index.php?c=injectionsparameters&m=del_lit&id=$id';}
		else{ javascript:history.go(-1);
		}</script>"; 
	}
	
	function del_lit(){
		
		$id = $this->input->get('id');
		
		$result = "empty query";
		
		if (!empty($id)){
			
			$this->db->delete('injections_parameters',array('parameters_id'=>$id));
				
			echo "Deleted. Please, reload the page.";

			echo "<script>document.location='index.php?c=injectionsparameters&m=show'</script>;";
				
			return true;
				
				
		}
		echo "Not deleted";

		echo "<script>document.location='index.php?c=injectionsparameters&m=show'</script>;";
	}
	
	
	function ajaxAtocomplit(){
		
		$qr = $this->input->post('query');
		
		$result = 'no thing';
		
		if (!empty($qr)) {
		
		
			$qida = $this->db->query("SELECT DISTINCT parameters_id as aid, parameters_name as ash, parameters_description as af FROM injections_parameters WHERE parameters_name LIKE ? LIMIT 7", array($qr . '%'));
			
			
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
				
			$qida = $this->db->get_where('injections_parameters',array('parameters_id' => $id));
				
			if ($qida->num_rows()>0){
					
				$rowa = $qida->row();
	
				$result = $rowa->parameters_description;
	
			}
				
				
				
		}
	
		echo $result.' <a href="#" onclick="hide_description(); return false;">hide</a>';
	
	
	
	
	}
	
	
	
	
	function ajaxGetParametersInput(){
	
	
		$id = $this->input->post('pid');
		$result = 'no input';
	
		if (!empty($id)) {
			$result = 'nothing found';
	
	
			$qida = $this->db->get_where('injections_parameters',array('parameters_id' => $id));
	
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
		
