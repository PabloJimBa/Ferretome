<?php
class Labelledsites extends Controller {

	private $data;

	function Labelledsites()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('journal');
		
		$this->load->helper('login');
		require_login();
		
		
		
		
		$this->data['dens_options'] = array(
				
				'1' => 'weak, sparse, light',
				'2' => 'moderate , medium',
				'3' => 'strong, dense, heavy',
		);
		
		
		$this->data['outcome_type'] = array('overall','ipsilateral','contralateral');
		
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


		$this->data['fields'] = $this->db->field_data('labelled_sites');

		$this->data['action'] = 'add';

		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/labelledsites.js"></script>';
		
		//collecting PDC
		
		$qida = $this->db->get('pdc');
		
		$this->data['pdc_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
		
			$temp_arr[$rowa->PDC_id] = $rowa->PDC_name;
		
		}
		
		$this->data['pdc_options'] = $temp_arr;
		
		// collecting EC
		$qida = $this->db->get('extension_codes');
		
		$this->data['ec_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
		
			$temp_arr[$rowa->extension_codes_id] = $rowa->extension_codes_name . " - " . $rowa->extension_codes_desc ;
		
		}
		
		$this->data['ec_options'] = $temp_arr;
		
		
		//collecting Literature and Injections
		
		$pid = $this->session->userdata('pub_id');
		
		if (!empty($pid)){
		
		$this->db->select('literature_id, literature_index, literature_title');
		$qida = $this->db->get_where('literature',array('literature_id' => $pid));
		
			if ($qida->num_rows() > 0) {
			
				$this->data['lit_data_2'] = $qida->row();
			
			}
		}
		// if last time was inserterted some thing 
		$pid2 = $this->session->userdata('pub_id2');
		
		if (!empty($pid2)){
		
			$this->load->model('Literature_model','literM',TRUE);
		
			if (($qida = $this->literM->get_one($pid2)) != FALSE){
		
				$this->data['lit_data'] = $qida->row();
		
			}
		}
		// if the case we want insert to a specific publication 
		
		$litid = $this->input->get('id');
		
		if (!empty($litid)) {
		
			$this->load->model('Literature_model','literM',TRUE);
		
			if (($qida = $this->literM->get_one($litid)) != FALSE){
		
				$this->data['lit_data'] = $qida->row();
		
			}
		
		
		
		}
		
			
		$this->load->view('labelledsites_view',$this->data);


	}
	
	function insert() {
	
		$fields = $_POST;
		
		//print_r($fields); return;
		
		
		$qida = $this->db->get_where('labelled_sites',array('outcome_id'=>$fields['outcome_id'],'brain_sites_id' =>$fields['brain_sites_id']));

		if ($qida->num_rows() > 0) {
			
			
			$this->data['add_message'] = "An error has occured: You are trying to add already exitsting data";
			
			$result = '{"result":"0","message":"An error has occured: You are trying to add already exitsting data"}';
			
			echo $result;
			
			return false;
		}

		
		$lid = $fields['literature_id'];
		
		$liter_id = $lid;
		
		unset($fields['literature_id']);
	
	
		if ($this->db->insert('labelled_sites',$fields) === FALSE){

			$result = '{"result":"0","message":"Error!"}';
	
		} else {
			
			$lid = $this->db->insert_id();
			$this->journal->newrecord($this->session->userdata('user_id'),8,$lid);
			
							
			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$liter_id.'"}';
		}
		
		echo $result;
	 
	
	}
	
	
	function edit() {
	
		$lid = $this->input->get('id');
	
		$this->data['action'] = 'edit';
		
		$this->data['block_message'] = "Nothing was sent";
	
		if (!empty($lid)){
	
	
			$qida = $this->db->get_where('labelled_sites',array('labelled_sites_id' => $lid));
			
			$this->data['block_message'] = "Nothing was found";
	
			if ($qida->num_rows() > 0) {
				
				unset($this->data['block_message']);
					
	
	
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/labelledsites.js"></script>';
	
	
				$this->data['fields'] = $this->db->field_data('labelled_sites');
	
				$this->data['ls_data'] = $qida->row();
				
				
				//collectign outcomes 
	
				
				$qidb = $this->db->get_where('labeling_outcome',array('outcome_id' => $this->data['ls_data']->outcome_id));
				
				$rowb = $qidb->row();
				
				$this->data['inj_data_selected'] = $rowb->outcome_id;
				
				$litid = $rowb->literature_id; 
				
				
				
				$qidb = $this->db->get_where('labeling_outcome',array('literature_id' => $litid));
				

				
				if ($qidb->num_rows() > 0) {
				
					$this->data['inj_options'] = array();
				
					$temp_arr = array();
				
					foreach ($qidb->result() as $rowb) {
				
						$temp_arr[$rowb->outcome_id] = $rowb->outcome_id . " - " . $this->data['outcome_type'][$rowb->outcome_type];
				
					}
				
					$this->data['inj_options'] = $temp_arr;
				
				}
				
				
				/*
				$qidb = $this->db->get_where('injections',array('literature_id' => $rowb->literature_id));
				
				$this->data['inj_options'] = array();
				
				
				
				foreach ($qidb->result() as $rowb) {
						
					$this->data['inj_options'][$rowb->outcome_id] = $rowb->outcome_id . " - " . $this->data['outcome_type'][$rowb->outcome_type];
						
						
				}
				
				*/	
				
				//collectign literature for injection
				
				$this->db->select('literature_title, literature_index, literature_id');
	
				$qidb = $this->db->get_where('literature',array('literature_id' =>$litid));
				
				$this->data['lit_data'] = $qidb->row();
				
						
	
	
				//collectign brain site				
				$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
	
				$qidb = $this->db->get_where('brain_sites',array('brain_sites_id' => $this->data['ls_data']->brain_sites_id));
	
				$this->data['bsite_data'] = $qidb->row();
				
				
				//collecting literature for brain map
				
				$this->db->select('literature_id');
				
				$qidb = $this->db->get_where('brain_maps',array('brain_maps_id' => $this->data['bsite_data']->brain_maps_id));
				
				$rowb = $qidb->row();
				
				$this->db->select('literature_title, literature_index, literature_id');
				
				$qidb = $this->db->get_where('literature',array('literature_id' => $rowb->literature_id));
				
				$this->data['lit_data_2'] = $qidb->row();
				
				
				//collecting PDC
				
				$qida = $this->db->get('pdc');
	
				$this->data['pdc_options'] = array();
	
				$temp_arr = array();
	
				foreach ($qida->result() as $rowa) {
	
					$temp_arr[$rowa->PDC_id] = $rowa->PDC_name;
	
				}
	
				$this->data['pdc_options'] = $temp_arr;
	
	
				//collecting EC
				
				$qida = $this->db->get('extension_codes');
	
				$this->data['ec_options'] = array();
	
				$temp_arr = array();
	
				foreach ($qida->result() as $rowa) {
	
					$temp_arr[$rowa->extension_codes_id] = $rowa->extension_codes_name . " - " . $rowa->extension_codes_desc ;
	
				}
	
				$this->data['ec_options'] = $temp_arr;
	
	
					
			} 
	
		} 
	
		$this->load->view('labelledsites_view',$this->data);
	
	
	
	
	
	}
	
	
	
	function update() {
	
		$fields = $_POST;
	
	
		$inj_id = $this->input->get('id');
		
		// collecting previously saved data for journal
		
		$qid_before = $this->db->get_where('labelled_sites',array('labelled_sites_id' => $inj_id));
			
		$qid_before = $qid_before->row();
			
		///
		
		unset($fields['literature_id']);
		
				
		$this->db->where('labelled_sites_id',$inj_id);
		
		if ($this->db->update('labelled_sites',$fields) === FALSE){
			$result = '{"result":"0","message":"Error!"}';
	
		} else {
	
			
			
			$this->journal->newrecord($this->session->userdata('user_id'),8,$inj_id,2,$qid_before);
	
			$result = '{"result":"1","message":"Success!"}';
		}
		
		echo $result;
	
	
	
	
	
	}
	
	
	
	
	
	function ajaxGetLabelledSites() {
		
		
		$pid = $this->input->post('inj_id');
		$result = "empty";
		
		if (!empty($pid)){
			
			
			$this->load->model('Labeled_sites_model','lsmod',TRUE);
			
			$result = "no records";
			
			if (($qida = $this->lsmod->get_all_where(array("outcome_id"=>$pid))) != FALSE) {
				
			
				$this->data['labeled_data'] = $qida;
				
				$this->data['labeled_fields'] = $this->lsmod->get_fields();

				//print_r($this->data['labeled_data']);
				//print_r($this->data['labeled_fields']);
				
				$result = $this->load->view('labelledsites_ajax_get_view',$this->data,TRUE);
			
			}
				
			
			
				
			
			
				
				
		}
		
		
		echo $result;
		
		
		
		
	}
	
	
	
	
}
?>