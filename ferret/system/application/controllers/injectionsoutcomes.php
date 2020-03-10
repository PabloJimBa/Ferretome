<?php 
class Injectionsoutcomes extends Controller {

	private $data;

	function Injectionsoutcomes()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('journal');
		
		$this->load->helper('login');
		require_login();
		
		$this->data['table_id'] = '14';
		$this->data['outcome_type'] = array('overall','ipsilateral','contralateral');
		
		$this->load->model('Leftmenu','lmenu',TRUE);
		
		if ($this->lmenu->all_number() > 0) {
				
			$this->data['leftMenu'] = $this->lmenu->get_all();
				
		}
		
		
	function index(){

		$this->data['action'] = 'index';
		$this->load->view('injections_and_outcomes',$this->data);

	}
		
		
	}

	function add() {
		
		$id = $this->input->get('id');
		
		if (!empty($id)) {
			
			$this->db->select('literature_title, literature_index, literature_id');
				
			$qida = $this->db->get_where('literature',array('literature_id' =>$id));
			
			if ($qida->num_rows()>0) {
				
				$this->data['lit_block'] = $qida->row();
				
			}
			
			
		}
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/injectionsoutcomes.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/autocomplete.js"></script>';
		

		$this->data['action'] = 'add';
		$this->load->view('injections_and_outcomes',$this->data);
		
		


	}
	
	function ajaxGetRelationsForm(){
		
		
		$lid = $this->input->post('literature_id');
		$oid = $this->input->post('oid');
		$result = 'Error: nothing was sent';
		
		if (!empty($lid)) {
			
			//collecting injections
			
			$this->db->join('brain_sites', 'brain_sites.brain_sites_id = injections.brain_sites_id');
			
			$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
			
			$this->db->join('methods', 'methods.methods_id = injections.methods_id');
			
			$this->db->join('tracers', 'methods.tracers_id = tracers.tracers_id');
							
			$this->db->select('injections_id, injections_index, brain_sites_index,acronym_full_name, tracers.tracers_name');
			
			
			$qida = $this->db->get_where('injections',array('injections.literature_id' => $lid));
			 
			$this->data['injections_data'] = array();
			
			foreach ($qida->result() as $rowa) {
			
				$this->data['injections_data'][$rowa->injections_id] = $rowa->injections_index ." - " . $rowa->brain_sites_index ." - " . $rowa->acronym_full_name . " - " . $rowa->tracers_name;
			
			}
			
			
			
			//generating empty relation
			
			$this->db->insert('injections_and_outcomes',array("literature_id"=>$lid,"outcome_id"=>$oid));
			
			$rid = $this->db->insert_id();
			
			$this->data['rel_id'] = $rid;
			$this->data['oid'] = $oid;
			
			$this->data['action'] = 'input_form';
			$result = $this->load->view('injections_and_oucomes_form',$this->data,TRUE);
			
			
			
			
		}
		
		echo $result;
		
		
	}
	
	
	
	
	function ajaxGetAllRelations(){
		
		/*
		//collecting injections
			
		$this->db->join('brain_sites', 'brain_sites.brain_sites_id = injections.brain_sites_id');
			
		$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
			
		$this->db->select('injections_id, injections_index, brain_sites_index,acronym_full_name');
			
		$this->data['injections_data'] = $this->db->get_where('injections',array('literature_id' => $lid));
		
		*/
		
		$lid = $this->input->post('literature_id');
		
		$result = 'Error: nothing was sent';
		
		if (!empty($lid)) {
		
		
			//collecting outcomes
				
			$this->data['outcomes_data'] = $qida = $this->db->get_where('labeling_outcome',array('literature_id' => $lid));
			
			$this->data['rel_data'] = array();
			
			if ($qida->num_rows > 0) {
				
				
				 foreach ($qida->result() as $rowa) {
				 	
				 	//collecting injetions
				 	
				 	$this->db->join('injections', 'injections.injections_id = injections_and_outcomes.injections_id');
				 	
				 	$this->db->join('brain_sites', 'brain_sites.brain_sites_id = injections.brain_sites_id');
				 		
				 	$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
				 	
				 	$this->db->join('methods', 'methods.methods_id = injections.methods_id');
				 	
				 	$this->db->join('tracers', 'methods.tracers_id = tracers.tracers_id');
				 		
				 	$this->db->select('injections.injections_id,
							 			injections_index,
							 			brain_sites_index,
							 			acronym_full_name,
							 			injections_and_outcomes.outcome_id,
							 			injections_and_outcomes.relation_id,
							 			injections_and_outcomes.literature_id,
				 						tracers.tracers_name'
				 			
				 					 );
				 	
				
				 	$this->data['rel_data'][$rowa->outcome_id] = $this->db->get_where('injections_and_outcomes',array('outcome_id' => $rowa->outcome_id));
				 	
				 	//collecting labeled sites
				 	
				 	$this->db->join('brain_sites', 'brain_sites.brain_sites_id = labelled_sites.brain_sites_id');
				 	
				 	$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
				 	
				 	$this->db->select('brain_sites_index,
							 		   acronym_full_name'
				 					 );
				 	
				 	$this->data['labeled_data'][$rowa->outcome_id] = $this->db->get_where('labelled_sites',array('outcome_id' => $rowa->outcome_id));
				 	
				 	
				 	// counting all records
				 	$this->db->where('outcome_id', $rowa->outcome_id);
				 	
				 	$this->db->from('labelled_sites');
				 	
				 	$this->data['labeled_number'][$rowa->outcome_id] = $this->db->count_all_results();
				 	
				 	
				 	
				 	
				 	
				 }
				
				
			}
			
		}	
		$this->data['action'] = 'load_data';
		$this->load->view('injections_and_oucomes_form',$this->data);
		
		
		
	}
	
	function ajaxSaveRelation () {
		
		$fields = $_POST;
		
		$result = 'Error: nothing was sent';
		
		if (!empty($fields['relation_id'])) {
			
			
			$this->db->where('relation_id',$fields['relation_id']);
			
			unset($fields['relation_id']);
			
			$this->db->update('injections_and_outcomes',$fields);
			
			
			
		}
		
		
	}
	
	
	function ajaxDelRelation (){
		
		$relation_id = $this->input->post('relation_id');
		
		if (!empty($relation_id)) {
		
		
			$this->db->delete('injections_and_outcomes',array('relation_id'=>$relation_id));
		
		
		}
		
		
		
	}

	
}

?>
