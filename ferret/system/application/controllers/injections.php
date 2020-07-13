<?php
class Injections extends Controller {

	private $data;

	function Injections()
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
		$this->load->view('injections_view',$this->data);


	}

	function add(){


		$this->data['fields'] = $this->db->field_data('injections');

		$this->data['action'] = 'add';
		
		
		$qida = $this->db->get('pdc');
		
		$this->data['pdc_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
				
			if ($rowa->PDC_id <= 15) {
				$temp_arr[$rowa->PDC_id] = $rowa->PDC_name;
			}
		}
		
		$this->data['pdc_options'] = $temp_arr;
		
		
		$qida = $this->db->get('extension_codes');
		
		$this->data['ec_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
		
			$temp_arr[$rowa->extension_codes_id] = $rowa->extension_codes_name . " - " . $rowa->extension_codes_desc ;
		
		}
		
		$this->data['ec_options'] = $temp_arr;


		$qida = $this->db->get('hemispheres');
		
		$this->data['hemisp_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
		
			$temp_arr[$rowa->hemispheres_code] = $rowa->hemispheres_code . " - " . $rowa->hemispheres_name ;
		
		}
		
		$this->data['hemisp_options'] = $temp_arr;
		
		
		$qida = $this->db->get('injections_laminae');

		$this->data['injections_laminae'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
		
			$temp_arr[$rowa->laminae_id] = $rowa->laminae_code . " - " . $rowa->laminae_desc ;
		
		}
		
		$this->data['inj_laminae_options'] = $temp_arr;
		

		$qida = $this->db->get('pdc_laminae');
		
		$this->data['pdc_laminae_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
				
			$temp_arr[$rowa->pdc_laminae_id] = $rowa->pdc_laminae_code;
				
		}
		
		$this->data['pdc_laminae_options'] = $temp_arr;


		$litid = $this->input->get('id');

		if (!empty($litid)) {
		
			$this->load->model('Literature_model','literM',TRUE);
				
			if (($qida = $this->literM->get_one($litid)) != FALSE){
		
				$this->data['lit_data'] = $qida->row();
		
			}
				
				
		
		}
		
		
		
		

		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/injections.js"></script>';

		// 		print_r($this->data);
			
		$this->load->view('injections_view',$this->data);


	}
	
	function insert() {
		
		
		$fields = $_POST;
	/*
		$qida = $this->db->get_where('injections',array('literature_id'=>$fields['literature_id'],'brain_sites_id' =>$fields['brain_sites_id']));
		
		if ($qida->num_rows() > 0) {
		
		
			$this->data['add_message'] = "An error has occured: You are trying to add already exitsting data";
			
			echo "redir to add";
		
			$this->add();
			
		
		
			return false;
		}
		
*/
		$hemis = $fields['hemispheres'];

		$fields['injections_hemisphere'] = $hemis;

		unset($fields['hemispheres']);

		$lit_id = $fields['literature_id'];
		
		
		
		$this->db->select('literature_index');
			
		$qida = $this->db->get_where('literature',array('literature_id' => $lit_id));
		
			
		if ($qida->num_rows() > 0){
				
			$rowa = $qida->row();

			//$fields['injections_index'] = $rowa->literature_index;
							
		}
		
		
		if ($this->db->insert('injections',$fields) === FALSE){
			$result = '{"result":"0","message":"Error!"}';
	
		} else {
			
			$id = $this->db->insert_id();
			$this->db->where('injections_id', $id);
			$this->db->update('injections',array('injections_index' => $rowa->literature_index."_".$id)); 
			
			
			$this->journal->newrecord($this->session->userdata('user_id'),7,$id);
				

			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$lit_id.'"}';
		}
		
		echo $result;
	
	
	}
	
	
	function edit() {
		
		$lid = $this->input->get('id');
		
		$this->data['action'] = 'edit';
		
		$this->data['block_message'] = "Nothing was sent";
		
		
		if (!empty($lid)){
				
				
			$qida = $this->db->get_where('injections',array('injections_id' => $lid));
			
			$this->data['block_message'] = "Nothing was found";
				
			if ($qida->num_rows() > 0) {
				
				unset($this->data['block_message']);				
		
		
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/injections.js"></script>';
		
		
				$this->data['fields'] = $this->db->field_data('injections');
		
				$this->data['inj_data'] = $qida->row();
				
				
				$this->db->select('literature_title, literature_year, literature_id');
				
				$qidb = $this->db->get_where('literature',array('literature_id' => $this->data['inj_data']->literature_id));
				
				$this->data['lit_data'] = $qidb->row();
				
				
				$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
				
				$qidb = $this->db->get_where('brain_sites',array('brain_sites_id' => $this->data['inj_data']->brain_sites_id));
				
				$this->data['bsite_data'] = $qidb->row();
				
				
				$qida = $this->db->get('pdc');
				
				$this->data['pdc_options'] = array();
				
				$temp_arr = array();
				
				foreach ($qida->result() as $rowa) {
				
					if ($rowa->PDC_id <= 15) {
						$temp_arr[$rowa->PDC_id] = $rowa->PDC_name;
					}	
									
				}
				
				$this->data['pdc_options'] = $temp_arr;
				
				
				$qida = $this->db->get('extension_codes');
				
				$this->data['ec_options'] = array();
				
				$temp_arr = array();
				
				foreach ($qida->result() as $rowa) {
				
					$temp_arr[$rowa->extension_codes_id] = $rowa->extension_codes_name . " - " . $rowa->extension_codes_desc ;
				
				}
				
				$this->data['ec_options'] = $temp_arr;
				
				
				$qida = $this->db->get('hemispheres');
				
				$this->data['hemisp_options'] = array();
				
				$temp_arr = array();
				
				foreach ($qida->result() as $rowa) {
				
					$temp_arr[$rowa->hemispheres_id] = $rowa->hemispheres_code . " - " . $rowa->hemispheres_name ;
				
				}
				
				$this->data['hemisp_options'] = $temp_arr;

				
				$qida = $this->db->get('injections_laminae');

				$this->data['inj_laminae_options'] = array();
				
				$temp_arr = array();
				
				foreach ($qida->result() as $rowa) {
				
					$temp_arr[$rowa->laminae_id] = $rowa->laminae_code . " - " . $rowa->laminae_desc ;
				
				}
				
				$this->data['inj_laminae_options'] = $temp_arr;

				
				$qida = $this->db->get('pdc_laminae');
				
				$this->data['pdc_laminae_options'] = array();
				
				$temp_arr = array();
				
				foreach ($qida->result() as $rowa) {
				
					$temp_arr[$rowa->pdc_laminae_id] = $rowa->pdc_laminae_code;
				
				}
				
				$this->data['pdc_laminae_options'] = $temp_arr;
				
				/*
				$this->db->where('injections_id',$lid)->from('labelled_sites');
				$number = $this->db->count_all_results();
				
				if ($number > 0) {
					
					$this->data['labelled_num'] = $number;

					
				}
				*/
							
			} 
				
		} 
		
		$this->load->view('injections_view',$this->data);
		
		
		
		
		
	}
	
	function show() {
	
	
		
		$this->data['action'] = 'show';
		
		$this->load->model('Injections_model','injm',TRUE);
		
		if (($qida = $this->injm->get_all(array(),'injections_index','asc','999')) != FALSE){
			
			
			$this->data['block_data'] = $qida;
			$this->data['block_fields'] = $this->injm->get_fields();
			
			
			
		}
			
			

		$this->load->view('injections_view',$this->data);
	}
	
	function search() {
	
		
		$this->data['action'] = 'search';
	
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/injections.js"></script>';
			
		$this->load->view('injections_view',$this->data);
	
	}

	function searchDo() {
	
		$id = $this->input->post('inj_id');
	
		$result = 'nothing found: empty';

		if (!empty($id)){
	
			$qida = $this->db->get_where('injections',array('injections_id' => $id));
			
			$result = 'nothing found: no records';
				
			if ($qida->num_rows()>0){
	
				$this->data['inj_data'] = $qida->row();
	
				$result = $this->load->view('injections_search_view',$this->data);
	
			
	
			}
	
	
		}
	
		echo $result;
	}

	function update() {
		
		$fields = $_POST;
				
		$hemis = $fields['hemispheres'];

		$fields['injections_hemisphere'] = $hemis;

		unset($fields['hemispheres']);

		$lit_id = $fields['literature_id'];
		
		
		$this->db->select('literature_index');
			
		$qida = $this->db->get_where('literature',array('literature_id' => $lit_id));
		
			
		if ($qida->num_rows() > 0){
		
			$rowa = $qida->row();
						
		}
		
		
		$inj_id = $this->input->get('injid');
		
		// collecting previously saved data for journal 
		
		$this->data['fields'] = $this->db->field_data('injections');
		
		$qid_before = $this->db->get_where('injections',array('injections_id' => $inj_id));
		
		$qid_before = $qid_before->row();
		
		
		// updating...
		
		$this->db->where('injections_id',$inj_id);
		
		if ($this->db->update('injections',$fields) === FALSE){
			$result = '{"result":"0","message":"Error!"}';
	
		} else {
			
			// if successs updating injection_index for the case if literature was changed  
				
			
			$this->db->where('injections_id', $inj_id);
			$this->db->update('injections',array('injections_index' => $rowa->literature_index."_".$inj_id));
				
			// logging update action with old data and new 
				
			$this->journal->newrecord($this->session->userdata('user_id'),7,$inj_id,2,$this->data['fields'],$qid_before);
		
			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$lit_id.'"}';
		}
		
		
		echo $result;
		
		
	}
	
	
	function ajaxSetInjectionId(){
		
		$inid = $this->input->post('inid');
		
		if (!empty($inid)) { 
			
			$this->db->select('literature_id');
			
			$qida = $this->db->get_where('injections',array('injections_id' => $inid));
			
			if ($qida->num_rows() > 0){
			
				$rowa = $qida->row();
				
				$this->session->set_userdata('pub_id',$rowa->literature_id);
				echo $rowa->literature_id;
				
				
			
			}
			
			
			
			
		}
		
		
	}

	function confirm(){
	
		$id = $this->input->get('id');
		echo "<script>if(confirm('Are you sure?')){
		document.location='index.php?c=injections&m=del_lit&id=$id';}
		else{ javascript:history.go(-1);
		}</script>"; 
	}
	
	function del_lit(){
		
		$id = $this->input->get('id');
		
		$result = "empty query";
		
		if (!empty($id)){
			
			$this->db->delete('injection',array('injection_id'=>$id));
				
			echo "Deleted. Please, reload the page.";

			echo "<script>document.location='index.php?c=injections&m=show'</script>;";
				
			return true;
				
				
		}
		echo "Not deleted";

		echo "<script>document.location='index.php?c=injections&m=show'</script>;";
	}
	
	function ajaxAtocomplit() {
		
		$qr = $this->input->post('query');
			
		$result = 'no thing';
		
		if (!empty($qr))  {
				
			$qida = $this->db->query("SELECT injections_id as inid, injections_index as inind FROM injections WHERE injections_index LIKE ?",array($qr.'%'));
			
		
			if ($qida->num_rows() > 0) {
		
				$result = "{ query:'" . $qr . "', suggestions:[";
				foreach ($qida->result() as $rowa) {
					$result .= "'". $rowa->inind. "',";
				}
		
				$result = substr($result, 0, strlen($result) - 1);
		
				$result .="],data:[";
		
				foreach ($qida->result() as $rowa) {
					$result .= "'". $rowa->inid ."',";
				}
		
				$result = substr($result, 0, strlen($result) - 1);
					
					
				$result .="]}";
			}
		}
		
		echo $result;
		
		
		
		
		
	}

	function ajaxGetInjections(){
		
		
		$pid = $this->input->post('pubid2');
		$method = $this->input->post('method');
		$result = "empty";
		
		if (!empty($pid)){
			
			$this->db->join('brain_sites', 'brain_sites.brain_sites_id = injections.brain_sites_id');
		
			$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
			
			
			$this->db->select('injections_id, injections_index, brain_sites_index,acronym_full_name');
			$qida = $this->db->get_where('injections',array('literature_id' => $pid));
			
			$result = "no records";
			
			if ($qida->num_rows() > 0) {
				
				
				
				
				//$qidb = $this->db->get_where('',array('brain_sites_id' => $this->data['inj_data']->brain_sites_id));
				
				//$this->data['bsite_data'] = $qidb->row();
				
				
				$this->data['inj_options'] = array();
				
				$temp_arr = array();
				
				foreach ($qida->result() as $rowa) {
				
					$temp_arr[$rowa->injections_id] = $rowa->injections_index ." - " . $rowa->brain_sites_index  ." - " . substr($rowa->acronym_full_name,0,50);
				
				}
				
				$this->data['inj_options'] = $temp_arr;
				
				if (!empty($method)){
					
					if ($method == 'special'){
				
						$this->data['special'] = 'id="injections_id"';
					
					}
				}
				
				
				
				$result = $this->load->view('injection_ajax_get_view',$this->data,TRUE);
				
				
			}
			
			
		}
		
		
		echo $result;
		
		
	}
	
	
	
}
?>
