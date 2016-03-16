<?php
class Injections extends CI_Controller {

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
	
	function load() {
		
		
		$mode = $this->input->post('mode');
		
		if ($mode == 'ajax') {
				
			$lid = $this->input->post('id');
				
			$mode = TRUE;
				
		} else {
		
			$lid = $this->input->get('id');
		}
		
		
		
		
		$this->data['action'] = 'load';
		
		$this->data['block_message'] = "Nothing was sent";
		
		
		if (!empty($lid)){
				
			// collecting all injection of this literature id
				
			$qida = $this->db->get_where('injections',array('literature_id' => $lid));
			
			$this->data['block_message'] = "Nothing was found";
				
			if ($qida->num_rows() > 0) {
				
				unset($this->data['block_message']);

				
				$this->data['fields'] = $this->db->field_data('injections');
				
				
			 
				
				foreach ($qida->result() as $rowa) {
		
					$this->data['inj_data'][$rowa->injections_id] = $rowa;
					
					
					
					// Selecting bsite of injections
					
					$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
					
					$qidb = $this->db->get_where('brain_sites',array('brain_sites_id' => $rowa->brain_sites_id));
					
					$this->data['bsite_data'][$rowa->injections_id] = $qidb->row();
					
					
					
					//selecting all labelled bsites
					
					$this->db->select('brain_sites.brain_sites_index as bsindex,
							
							brain_sites.brain_sites_id as bsid, 
							
							brain_site_acronyms.brain_site_acronyms_acronymName as acr_name, 
							
							brain_site_acronyms.brain_site_acronyms_acronymFullName as acr_fname, 
							
							labelled_sites.*');
					
					$this->db->join('brain_sites','brain_sites.brain_sites_id = labelled_sites.brain_sites_id');
					
					$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
			
					$qidb = $this->db->get_where('labelled_sites',array('injections_id' => $rowa->injections_id));
			
					if ($qidb->num_rows() > 0) {
							
						$this->data['bsite_data_labelled'][$rowa->injections_id] = $qidb;
							
					}
					
					
					
					// Collecting data about injection method
					
					
					$this->db->join('tracers','methods.tracers_id = tracers.tracers_id');
					
					$qidb = $this->db->get_where('methods',array('methods_id' => $rowa->methods_id));
					
					if ($qidb->num_rows() > 0) {
							
						$this->data['method_data'][$rowa->injections_id] = $qidb->row();
							
					}
					
					
					

					
					
					
					
					
				
				}
				
									
			} 
				
		} 
		
		
		if ($mode){
				
				
			$this->load->view('injections_ajax_view',$this->data);
		} else {
				
			$this->load->view('injections_view',$this->data);
				
		}
		
		
	}
	
	
	
	
	
	
	
}
?>