<?php

class Brainsites extends CI_Controller {

	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		//$this->load->library('journal');

		$this->load->helper('login');

		require_login();
	}

	function index() {

		$this->data['action'] = 'index';
		$this->load->view('bsites_view',$this->data);


	}

	function load(){


		$id = $this->input->post('id');


		$this->data['block_message'] = "Nothing was sent";

		if (!empty($id)){

			$this->data['block_message'] = "Nothing was found";
			
			
			$this->db->select('brain_sites.brain_sites_index as bsindex,
						
					brain_sites.brain_sites_id as bsid,
						
					brain_site_acronyms.brain_site_acronyms_acronymName as acr_name,
						
					brain_site_acronyms.brain_site_acronyms_acronymFullName as acr_fname,
						
					');
			
			$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');


			$qida = $this->db->get_where('brain_sites',array('brain_sites_id' => $id));

			if ($qida->num_rows() > 0) {

				unset($this->data['block_message']);
				
				$this->data['bsite_data'] = $qida->row();

				
				//selecting all architecture params for this b site
				
				$this->db->join('parameters','parameters.parameters_id = architecture.parameters_id');
				$this->db->order_by('layer_number','asc');
				$qidb = $this->db->get_where('architecture',array('brain_sites_id' => $id));
				
				if ($qidb->num_rows() > 0) {
					
					$layers = array();
					
					foreach ($qidb->result() as $rowb) {
						$layers[$rowb->layer_number][$rowb->architecture_id] = $rowb->parameters_name." : ".$rowb->parameters_value;
						
					}
				
					$this->data['bsite_architecture_data'] = $layers;
				
				}
				
				
				
				
				
			}
		}
		
		
		$this->data['action'] = 'load';
		$this->load->view('bsites_view',$this->data);
	
	
	}
	
	
}

?>