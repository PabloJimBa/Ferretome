<?php

class Bmaps extends CI_Controller {

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
		$this->load->view('bmaps_view',$this->data);


	}
	
	function load(){
		
		
		$id = $this->input->post('id');
		
		
		$this->data['block_message'] = "Nothing was sent";
		
		if (!empty($id)){
		
			$this->data['block_message'] = "Nothing was found";
		
		
			$qida = $this->db->get_where('brain_maps',array('literature_id' => $id));
		
			if ($qida->num_rows() > 0) {
		
				unset($this->data['block_message']);
				
				
				
				
				$this->data['fields'] = $this->db->field_data('brain_maps');
				
				$this->data['block_data'] = $qida->row();
				
				
				
				//selecting all mapped bsites
					
				$this->db->select('brain_sites.brain_sites_index as bsindex,
							
						brain_sites.brain_sites_id as bsid,
							
						brain_site_acronyms.brain_site_acronyms_acronymName as acr_name,
							
						brain_site_acronyms.brain_site_acronyms_acronymFullName as acr_fname
							
						');
					
				//$this->db->join('brain_sites','brain_sites.brain_sites_id = labelled_sites.brain_sites_id');
					
				$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
					
				$qidb = $this->db->get_where('brain_sites',array('brain_maps_id' => $this->data['block_data']->brain_maps_id));
					
				if ($qidb->num_rows() > 0) {
						
					$this->data['bsite_data'] = $qidb;
						
				}
				
				
				
				
				
			}
		}
		
		
		
		$this->data['action'] = 'load';
		$this->load->view('bmaps_view',$this->data);
		
		
		
		
		
		
		
	}

}

?>