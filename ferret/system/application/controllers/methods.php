

<?php
class Methods extends Controller {

	private $data;
	private $table_id = 17;

	function Methods()
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
		$this->load->view('methods_view',$this->data);


	}

	function show() {


		//$this->data['fields'] = $this->db->field_data('brain_site_acronyms');

		$this->data['action'] = 'show';
		$this->db->join('tracers','methods.tracers_id = tracers.tracers_id');
		$this->data['block_data'] = $this->db->get('methods');
			
		$this->load->view('methods_view',$this->data);


	}

	
	function add() {
	
		$this->data['fields'] = $this->db->field_data('methods');
	
		$this->data['action'] = 'add';
	
		//headers go here
	
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/methods.js"></script>';
	
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/autocomplete.js"></script>';
	
	
		$this->load->view('methods_view',$this->data);
	
	
	
	}
	
	function insert(){
	
		$fields = $_POST;
	
		$fields['bilateral_use'] = "N";
		
		if (isset($fields['yes'])) {	
			$fields['bilateral_use'][0] = "Y"; 
		}	

		if ($this->db->insert('methods',$fields) === FALSE){
	
			$result = '{"result":"0","message":"Error!"}';
	
		} else {
	
			$lid = $fields['literature_id'];
			
			$id = $this->db->insert_id();
			$this->journal->newrecord($this->session->userdata('user_id'),$this->table_id,$id);
			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$lid.'"}';
		}
		
		echo $result;
	
	
	
	
	}
	
	function edit() {
	
		$id = $this->input->get('id');
	
		$this->data['action'] = 'edit';
	
		$this->data['block_message'] = "No thing was sent"; 
	
	
		if (!empty($id)){
			
			$this->data['block_message'] = "No thing was found";
			
			$this->db->select('
							 literature.literature_title,
							 literature.literature_index,
							 tracers.*,
							 methods.*,
							');
			
			$this->db->join('tracers','methods.tracers_id = tracers.tracers_id');
			$this->db->join('literature','methods.literature_id = literature.literature_id');
	
			$qida = $this->db->get_where('methods',array('methods_id' => $id));
	
			if ($qida->num_rows()>0){
				
				unset($this->data['block_message']);
	
				$this->data['block_data'] = $qida->row();
	
				$this->data['fields'] = $this->db->field_data('methods');
	
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/methods.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/autocomplete.js"></script>';
	
	
	
			}
		}
	
		$this->load->view('methods_view',$this->data);
			
	}
	
	
	
	function update() {
	
	
	
		$fields = $_POST;
	
		// 		print_r($fields);
	
	
		$id = $this->input->get('id');
		
		
		// collecting previously saved data for journal
		
		//$this->data['fields'] = $this->db->field_data('injections');
		
		$qid_before = $this->db->get_where('methods',array('methods_id' => $id));
		
		$qid_before = $qid_before->row();
		
		$fields['bilateral_use'] = "N";
		
		if (isset($fields['yes'])) {	
			$fields['bilateral_use'][0] = "Y"; 
		}
	
	
		if (!empty($id)){
	
	
			$this->db->where('methods_id',$id);
	
			if ($this->db->update('methods',$fields) === FALSE){
	
				$result = '{"result":"0","message":"Error!"}';
	
			} else {
	
				$lid = $fields['literature_id'];
				
				$id = $this->db->insert_id();
				$this->journal->newrecord($this->session->userdata('user_id'),$this->table_id,$id,2,$qid_before);
				$result = '{"result":"1","message":"Succes!"}';
			}
			
			echo $result;
		}
		
		
	
	
	}

	function confirm(){
	
		$id = $this->input->get('id');
		echo "<script>if(confirm('Are you sure?')){
		document.location='index.php?c=methods&m=del_lit&id=$id';}
		else{ javascript:history.go(-1);
		}</script>"; 
	}
	
	function del_lit(){
		
		$id = $this->input->get('id');
		
		$result = "empty query";
		
		if (!empty($id)){
			
			$this->db->delete('methods',array('methods_id'=>$id));
				
			echo "Deleted. Please, reload the page.";

			echo "<script>document.location='index.php?c=methods&m=show'</script>;";
				
			return true;
				
				
		}
		echo "Not deleted";

		echo "<script>document.location='index.php?c=methods&m=show'</script>;";
	}
	
	function ajaxGetMethods(){
		
		$pid = $this->input->post('lit_id');
		$result = "empty";
		
		
		if (!empty($pid)){
				
			$this->db->select('methods_id,tracers_name, injection_method');
			$this->db->join('tracers', 'tracers.tracers_id = methods.tracers_id');
			$qida = $this->db->get_where('methods',array('literature_id' => $pid));
				
			$result = 'no records were found <a href="index.php?c=methods">please add first</a> ';
				
			if ($qida->num_rows() > 0) {
		
				$this->data['met_options'] = array();
		
				$temp_arr = array();
		
				foreach ($qida->result() as $rowa) {
		
					$temp_arr[$rowa->methods_id] = $rowa->tracers_name . " - " . $rowa->injection_method;
		
				}
		
				$this->data['met_options'] = $temp_arr;
		
		
				$result = $this->load->view('injection_ajax_get_view',$this->data,TRUE);
		
		
			}
				
				
		}
		
		
		echo $result;
		
		
		
		
	}
	
	
	function ajaxAtocomplit(){
		
		$qr = $this->input->post('query');
		
		$result = 'no thing';
		
		if (!empty($qr)) {
		
		
			$qida = $this->db->query("SELECT DISTINCT methods_id as aid, tracers_name as ash, tracers_description as af FROM tracers WHERE tracers_name LIKE ? LIMIT 7", array($qr . '%'));
			
			
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
		
