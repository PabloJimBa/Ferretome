<?php

class Mapsrelations extends Controller {

	private $data;

	function Mapsrelations()
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
		$this->load->view('mapsrelations_view',$this->data);


	}

	function add(){


		$this->data['fields'] = $this->db->field_data('maps_relations');

		$this->data['action'] = 'add';
		
		$qida = $this->db->get('pdc');
		
		$this->data['pdc_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
			
			$temp_arr[$rowa->PDC_id] = $rowa->PDC_name;
			
		}
		
		$this->data['pdc_options'] = $temp_arr;
		
		
		$qida = $this->db->get('relation_codes');
		
		$this->data['rel_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
				
			$temp_arr[$rowa->relation_codes_id] = $rowa->relation_codes_name . " - " .$rowa->relation_codes_desc;
				
		}
		
		$this->data['rel_options'] = $temp_arr;
		
		
		$litid = $this->input->get('id');
		
		if (!empty($litid)) {
		
			$this->load->model('Literature_model','literM',TRUE);
		
			if (($qida = $this->literM->get_one($litid)) != FALSE){
		
				$this->data['lit_data'] = $qida->row();
		
			}
		
		
		
		}
		
		

		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/mapsrelations.js"></script>';

		// 		print_r($this->data);
			
		$this->load->view('mapsrelations_view',$this->data);


	}
//
	function insert() {

		$fields = $_POST;

			

		if ($this->db->insert('maps_relations',$fields) === FALSE){
			
				
			$result = '{"result":"0","message":"Error!"}';

		} else {
			
			$lid = $this->db->insert_id();
			$this->journal->newrecord($this->session->userdata('user_id'),9,$lid);
				
			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$fields['literature_id'].'"}';
		}
		
		echo $result;


	}
	
	function ajaxGetAll() {
		
		
		$pid = $this->input->post('mr_id');
		$result = "empty";
		
		if (!empty($pid)){
		
			
			
			$this->db->select('bsa.brain_sites_index as bsinda, bsb.brain_sites_index as bsindb, maps_relations.*');
			$this->db->join('brain_sites as bsa','bsa.brain_sites_id = maps_relations.brain_sites_id_a');
			$this->db->join('brain_sites as bsb','bsb.brain_sites_id = maps_relations.brain_sites_id_b');
				
			
			$qida = $this->db->get_where('maps_relations',array('literature_id' => $pid));
			
			$result = "no records";
			
			if ($qida->num_rows() > 0) {
				
				
				$this->data['mr_data'] = $qida;
				
				//collecting pdcs and rcs 
			
				
				$qida = $this->db->get('pdc');
				
				$this->data['pdc_options'] = array();
				
				foreach ($qida->result() as $rowa) {
						
					$this->data['pdc_options'][$rowa->PDC_id] = $rowa->PDC_name;
						
				}
				
				
				$qida = $this->db->get('relation_codes');
				
				$this->data['rel_options'] = array();
				
				foreach ($qida->result() as $rowa) {
				
					$this->data['rel_options'][$rowa->relation_codes_id] = $rowa->relation_codes_name . " - " .$rowa->relation_codes_desc;
				
				}
				
				//
				
				
				
				$result = $this->load->view('maps_relations_ajax_get',$this->data,TRUE);
			
			
			}
			
			
			
		
		
		
		}
		
		
		echo $result;
		
	}
	
	
	function  edit(){
		
		$lid = $this->input->get('id');
		
		$this->data['action'] = 'edit';
		
		$this->data['block_message'] = "MR was empty";
		
		if (!empty($lid)){
			
			
			$this->db->select('
					bma.literature_id as lida,
					bmb.literature_id as lidb,
					bsa.brain_sites_index as bsinda,
					bsb.brain_sites_index as bsindb,
					maps_relations.*,
					lit.literature_index as lindex,
					lit.literature_title as ltitle
					');
			// brain sites a and b
			
			$this->db->join('brain_sites as bsa','bsa.brain_sites_id = maps_relations.brain_sites_id_a');
			$this->db->join('brain_sites as bsb','bsb.brain_sites_id = maps_relations.brain_sites_id_b');
			
			$this->db->join('brain_maps as bma','bma.brain_maps_id = bsa.brain_maps_id');
			$this->db->join('brain_maps as bmb','bmb.brain_maps_id = bsb.brain_maps_id');
			
			// literature
			
			$this->db->join('literature as lit','lit.literature_id = maps_relations.literature_id');
				
			
			$qida = $this->db->get_where('maps_relations',array('maps_relations_id' => $lid));
			
			$this->data['block_message'] = "Nothing was found";
			/*
			<span id="lit_a_<?=$mr_data->literature_id_a?>"><?=$mr_data->ltitle_a?> - <?=$mr_data->lindex_a?> <a href="#" onclick="lit_replace_a('<?=$mr_data->literature_id_a?>'); return false;"> Replace</a><br/></span>
			*/
			if ($qida->num_rows() > 0) {
				
				
				$this->data['fields'] = $this->db->field_data('maps_relations');
				
				$this->data['mr_data'] = $qida->row();
				
				$this->db->select('
						literature_id as literature_id_a,
						literature_index as lindex_a,
						literature_title as ltitle_a
						
						');
				$qidaa = $this->db->get_where('literature',array('literature_id' => $this->data['mr_data']->lida));
				
				$this->db->select('
						literature_id as literature_id_b,
						literature_index as lindex_b,
						literature_title as ltitle_b
				
						');
				$qidab =$this->db->get_where('literature',array('literature_id' => $this->data['mr_data']->lidb));
						
				
				$this->data['mr_data_a'] = $qidaa->row();
				$this->data['mr_data_b'] = $qidab->row();
				
				
				//collecting pdcs and rcs 
			
				
				$qida = $this->db->get('pdc');
				
				$this->data['pdc_options'] = array();
				
				foreach ($qida->result() as $rowa) {
						
					$this->data['pdc_options'][$rowa->PDC_id] = $rowa->PDC_name;
						
				}
				
				
				$qida = $this->db->get('relation_codes');
				
				$this->data['rel_options'] = array();
				
				foreach ($qida->result() as $rowa) {
				
					$this->data['rel_options'][$rowa->relation_codes_id] = $rowa->relation_codes_name . " - " .$rowa->relation_codes_desc;
				
				}
				
				//
				
				
				unset ($this->data['block_message']);
				
				
				
			}
		}
	
	
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/mapsrelations.js"></script>';
		
		$this->load->view('mapsrelations_view',$this->data);
	
	}
	
	
	
	function update() {
	
		$fields = $_POST;
	
	
		$inj_id = $this->input->get('mrid');
	
	
	/*
		$qida = $this->db-get_where('labelled_sites',array('injection_id'=>$fields['injection_id'],'brain_sites_id' =>$fields['brain_sites_id']));
	
		if ($qida->num_rows() > 0) {
	
	
			$this->data['edit_message'] = "An error has occured: You are trying to add already exitsting data";
	
			$this->edit();
	
			return false;
		}
	
	*/
		
		$this->db->where('maps_relations_id',$inj_id);
	
		if ($this->db->update('maps_relations',$fields) === FALSE){
			
			$result = '{"result":"0","message":"Error!"}';
	
		} else {
	
	
				
			$this->journal->newrecord($this->session->userdata('user_id'),9,$inj_id,2);
			
			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$fields['literature_id'].'"}';
		}
		
		echo $result;
	
	
	
	
	
	}
	
	
	

}

?>
