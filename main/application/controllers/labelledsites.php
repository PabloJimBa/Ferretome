<?php

class Labelledsites extends CI_Controller {

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
		
		$this->data['dens_options'] = array(
		
				'1' => 'weak, sparse, light',
				'2' => 'moderate , medium',
				'3' => 'strong, dense, heavy',
		);
	}

	function index() {

		$this->data['action'] = 'index';
		$this->load->view('lsites_view',$this->data);


	}

	function load(){


		$id = $this->input->post('id');


		$this->data['block_message'] = "Nothing was sent";

		if (!empty($id)){

			$this->data['block_message'] = "Nothing was found";
			
			$this->db->select('
										
					brain_site_acronyms.brain_site_acronyms_acronymName as acr_name,
						
					brain_site_acronyms.brain_site_acronyms_acronymFullName as acr_fname,
						
					labelled_sites.*,
					
					extension_codes.*
					
					');
				
			$this->db->join('brain_sites','brain_sites.brain_sites_id = labelled_sites.brain_sites_id');
				
			$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
			
			$this->db->join('extension_codes', 'labelled_sites.EC = extension_codes.extension_codes_id');
			
			//$this->db->join('pdc', 'labelled_sites.PDC_EC = pdc.PDC_id');
				
			$qidb = $this->db->get_where('labelled_sites',array('labelled_sites_id' => $id));
			
			
				
			if ($qidb->num_rows() > 0) {
				
				unset($this->data['block_message']);
					
				$this->data['labelled_bsite_data'] = $qidb->row();
					
			}
					
			
		}
		
		
		$this->data['action'] = 'load';
		$this->load->view('lsites_view',$this->data);
	
	
	}
	
	
}

?>