<?php

class Literature extends CI_Controller {

	private $data;
	
	public function __construct()
	{
		parent::__construct();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('login');
		
		if (islogged()) $this->data['logintoken'] = TRUE;
		
		$this->load->model('pages_model','pagem',TRUE);
		
		if (($qida = $this->pagem->get_page('header_page')) != FALSE){
		
			$this->data['header_page'] = substr($qida, 3,-4);
		
		}
		
		
	}
	
	function index() {
		
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/welcome.js"></script>';
		
		$this->data['action'] = 'index';
		$this->load->view('literature_view',$this->data);
		
		
	}
	
	
	function view_index(){
		
		
	
		$lid = $this->input->get('id'); 
	
		
	
		$this->data['block_message'] = "Nothing was sent";
	
		if (!empty($lid)){
				
			$this->data['block_message'] = "Nothing was found";
			

			$this->load->model('Literature_model','literm',TRUE);
			
			if (($qida = $this->literm->get_one($lid)) != FALSE){
				
				unset($this->data['block_message']);
				
				
				// literature data
				$this->data['fields'] = $this->literm->get_fields();
				
				$this->data['lit_data'] = $qida->row();
				
				
				// authors for literature
				$this->load->model('Authors_model','authorsM',TRUE);
				
				$this->data['auth_data'] = $this->authorsM->get_a_for_l($lid);
							
			}
				
				
			$qida = $this->db->get_where('literature',array('literature_id' => $lid));
				
			
				
		}
	
		$this->data['action'] = 'view_index';
		
		
			
		$this->load->view('literature_view',$this->data);
			
		
	
	}
	
	function view_map(){
		
		
	
		$lid = $this->input->get('id'); 
	
		
	
		$this->data['block_message'] = "Nothing was sent";
	
		if (!empty($lid)){
				
			$this->data['block_message'] = "Nothing was found";
			
			$this->load->model('Literature_model','literm',TRUE);
			
			if (($qida = $this->literm->get_one($lid)) != FALSE){
				
				unset($this->data['block_message']);
				
				// map for this literature
				
				$this->load->model('Maps_model','mapm',TRUE);
				
				
				if (($qida = $this->mapm->get_from_l($lid)) != FALSE){
					
					
					$this->data['bmaps_data'] = $qida->row();
					
					$this->data['mfields'] = $this->mapm->get_fields();
					
					$this->data['map_types'] = $this->mapm->get_types();
					
					
					$this->load->model('Brainsite_model','bsm',TRUE);
					
					
					if (($qida = $this->bsm->get_for_map($this->data['bmaps_data']->brain_maps_id)) != FALSE){
						
					
						$this->data['bs_data'] = $qida;
							
						$this->data['bsfields'] = $this->bsm->get_fields();
							
						
						
					}
					
					
					
				}
				
				
				
				
			}
				
				
			$qida = $this->db->get_where('literature',array('literature_id' => $lid));
				
			
				
		}
	
		$this->data['action'] = 'view_map';
		
		
			
		$this->load->view('literature_view',$this->data);
			
		
	
	}
	
	
	function view_exp(){
		
		
	
		$lid = $this->input->get('id'); 
	
		$this->data['literature_id'] = $lid;
	
		$this->data['block_message'] = "Nothing was sent";
	
		if (!empty($lid)){
				
			$this->data['block_message'] = "Nothing was found";
			
			$this->load->model('Literature_model','literm',TRUE);			

			if (($qida = $this->literm->get_one($lid)) != FALSE){
				
				unset($this->data['block_message']);
				
				// loading injections

				
				$this->load->model('Injections_model','injm',TRUE);
								
				if (($qida = $this->injm->get_from_l($lid)) != FALSE){
					
					
					$this->data['inj_data'] = $qida;
					$this->data['injfields'] = $this->injm->get_fields();
					
					$this->data['inj_bs_data'] = array();
					$this->data['inj_out_data'] = array();
								
					// outcomes
					$this->load->model('Outcomes_model','outm',TRUE);
					
					$this->data['outcomes_types'] = $this->outm->get_types();
					
					
					//labeled sites for oucomes
					$this->load->model('labeledsites_model','lsm',TRUE);
					
					$this->data['outlsfields'] = $this->lsm->get_fields(); 
					
					$this->data['out_ls_data'] = array();
					

					//method of injection
					$this->load->model('methods_model','mtm',TRUE);
						
					$this->data['mtmfields'] = $this->mtm->get_fields();
						
					$this->data['mtm_data'] = array();
					
					
					
					foreach ($this->data['inj_data']->result() as $idata) {
												
						// site of injection
						
						$this->load->model('Brainsite_model','bsm',TRUE);
						


						if (($qida = $this->bsm->get_one($idata->brain_sites_id)) != FALSE){
								
							$this->data['bsfields'] = $this->bsm->get_fields();
							$this->data['inj_bs_data'][$idata->injections_id] = $qida;
						
						
						}
						
						//outcomes of injection
						
						
						
						if (($qida = $this->outm->get_for_i($idata->injections_id)) != FALSE){
							
							
							$this->data['inj_out_data'][$idata->injections_id] = $qida;
							
							
							foreach ($qida->result() as $rowa) {
							
							
								if (($qida = $this->lsm->get_for_o($rowa->outcome_id)) != FALSE){
										
										
									$this->data['out_ls_data'][$rowa->outcome_id] = $qida;
										
										
								}
							}
							
							
							
							
						}
						
						
						// method of injection
						
						
						if (($qida = $this->mtm->get_one($idata->methods_id)) != FALSE){
								
								
							$this->data['mtm_data'][$idata->injections_id] = $qida;
								
								
						}
						
						
						
					}
					
					
					
				}//injections section ends here
				
				
				
			}
				
				
			$qida = $this->db->get_where('literature',array('literature_id' => $lid));
				
			
				
		}
	
		$this->data['action'] = 'view_exp';
		
		
			
		$this->load->view('literature_view',$this->data);
			
		
	
	}
	

	
	function view_rel(){
		
		
	
		$lid = $this->input->get('id'); 
	
		
		$this->data['literature_id'] = $lid;
	
		$this->data['block_message'] = "Nothing was sent";
	
		if (!empty($lid)){
				
			$this->data['block_message'] = "Nothing was found";
			
			$this->load->model('Literature_model','literm',TRUE);
			
			if (($qida = $this->literm->get_one($lid)) != FALSE){
				
				unset($this->data['block_message']);
				
				// maps relations
				
				$this->load->model('mapsrelations_model','mrm',TRUE);
				
				$this->data['mrmfields'] = $this->mrm->get_fields();
				
				
				
				if (($qida = $this->mrm->get_for_l($lid)) != FALSE){
					
					
					$this->data['mrm_data'] = $qida;
					
					
					
				}
				
				
			}
				
				
			$qida = $this->db->get_where('literature',array('literature_id' => $lid));
				
			
				
		}
	
		$this->data['action'] = 'view_rel';
		
		
			
		$this->load->view('literature_view',$this->data);
			
		
	
	}
	
	
	
	function searchDo(){
	
	
		$strig = $this->input->post('strigger');
		
		$result = 'Nothing was sent as a query';
		
		
	
		if (!empty($strig)){
			
				
			if ($strig == 'title'){
	
				$id = $this->input->post('q');
	
				$result = 'No id';
	
				if (!empty($id)){
					
					$result = 'Nothing found';
						
					$this->load->model('Literature_model','literm',TRUE);
			
					if (($qida = $this->literm->get_one($id)) != FALSE){
	
						$this->data['lit_data'][] = $qida;
	
	
						$this->load->model('Authors_model','authorsM',TRUE);
						
						$this->data['auth_data'][$id] = $this->authorsM->get_a_for_l($id);
	
	
						$result = $this->load->view('literature_search_view',$this->data,TRUE);
	
	
					}
						
						
						
				}
	
			} elseif ($strig == 'authors') {
	
				$id = $this->input->post('q');
	
				$result = 'No id';
	
				if (!empty($id)){
					//$this->db->distinct();
					$this->db->select('literature_id');
						
						
					$qidb = $this->db->get_where('literature_and_authors',array('authors_id' => $id));
	
					if ($qidb->num_rows()>0){
						
						$this->load->model('Literature_model','literm',TRUE);
						$this->load->model('Authors_model','authorsM',TRUE);
	
						foreach ($qidb->result() as $rowb){
								
							if (($qida = $this->literm->get_one($rowb->literature_id)) != FALSE){
	
								$this->data['lit_data'][$rowb->literature_id] = $qida;
	
								$this->data['auth_data'][$rowb->literature_id] = $this->authorsM->get_a_for_l($rowb->literature_id);
	
							}
								
								
								
						}
	
						$result = $this->load->view('literature_search_view',$this->data,TRUE);
					}
	
	
				}
	
	
	
			} elseif ( $strig =='journal') {
				
				
				$id = $this->input->post('q');
				
				$result = 'No id';
				
				if (!empty($id)){
						
					$result = 'Nothing found';
					
					$ordby = $this->input->post('orderby');
					$ord = $this->input->post('order');
				
					$this->load->model('Literature_model','literm',TRUE);
						
					if (($qida = $this->literm->get_all_where(array('literature_source'=>$id),$ordby,$ord)) != FALSE){
				
						$this->data['lit_data'][] = $qida;
				
						foreach ($qida->result() as $rowa) {

							$this->load->model('Authors_model','authorsM',TRUE);
				
							$this->data['auth_data'][$rowa->literature_id] = $this->authorsM->get_a_for_l($rowa->literature_id);
						}
				
				
						$result = $this->load->view('literature_search_view',$this->data,TRUE);
				
				
					}
				
				
				
				}
				
				
				
				
			} elseif ($strig =='year') {
				
				$id = $this->input->post('q');
				
				$result = 'No id';
				
				if (!empty($id)){
				
					$result = 'Nothing found';
				
					$this->load->model('Literature_model','literm',TRUE);
				
					if (($qida = $this->literm->get_all_where(array('literature_year'=>$id))) != FALSE){
				
						$this->data['lit_data'][] = $qida;
				
						foreach ($qida->result() as $rowa) {
				
							$this->load->model('Authors_model','authorsM',TRUE);
				
							$this->data['auth_data'][$rowa->literature_id] = $this->authorsM->get_a_for_l($rowa->literature_id);
						}
				
				
						$result = $this->load->view('literature_search_view',$this->data,TRUE);
				
				
					}
				
				
				
				}
				
				
				
				
			} elseif ($strig =='anything'){
				
				
				$q = $this->input->post('q');
				
				$result = 'No query string';
				
				if (!empty($q)){
					
					
					
					// searching in literature
					
					$result = '';
					
					$this->load->model('Literature_model','literm',TRUE);
					
					$ordby = $this->input->post('orderby');
					$ord = $this->input->post('order');
					
					
					if (($qida = $this->literm->get_like($q,$ordby,$ord)) != FALSE){
					
						$this->data['lit_data'][] = $qida;
					
						foreach ($qida->result() as $rowa) {
					
							$this->load->model('Authors_model','authorsM',TRUE);
					
							$this->data['auth_data'][$rowa->literature_id] = $this->authorsM->get_a_for_l($rowa->literature_id);
						}
						
						
						$result .= $this->load->view('literature_search_view',$this->data,TRUE);
					}
					
					
					$this->load->model('brainsite_model','bsitem',TRUE);
					
					
					if (($qida = $this->bsitem->get_like($q)) != FALSE){
						
						
						$this->data['liter_data'][] = $qida;
						

						
						$result .= $this->load->view('literature_search_acronym_view',$this->data,TRUE);
						
						
					}
					
					
					if (empty($result)){
							
						$result = 'Nothing was found';
							
					}
					
				
				
				
				}
				
				
				
			}
			
			
			
				
		}
		
		echo $result;
	
	
	}
	
	

	
	function ajaxAtocomplit() {
		
		
		
		$qr = $this->input->post('query');
		
		$result = 'no thing';
		
		if (!empty($qr)) {
		
		
		
			$qida = $this->db->query("SELECT DISTINCT literature_id as lid, literature_index as lyear, literature_title as ltitle FROM literature WHERE literature_title LIKE ? OR literature_title LIKE ? LIMIT 7", array($qr . '%','%' . $qr . '%'));
		
			if ($qida->num_rows() > 0) {
		
				$result = "{ query:'" . $qr . "', suggestions:[";
				foreach ($qida->result() as $rowa) {
					$result .= "'". substr($rowa->ltitle, 0,70) . " " . $rowa->lyear . "',";
				}
		
				$result = substr($result, 0, strlen($result) - 1);
		
				$result .="],data:[";
		
				foreach ($qida->result() as $rowa) {
					$result .= "'". $rowa->lid ."',";
				}
		
				$result = substr($result, 0, strlen($result) - 1);
					
					
				$result .="]}";
			}
		}
		
		echo $result;
		
		
	}
	
	function ajaxAtocomplitAuthors() {
	
	
		$qr = $this->input->post('query');
	
		$result = 'no thing';
	
		if (!empty($qr)) {
	
	
	
			$qida = $this->db->query("SELECT DISTINCT authors_id as aid, authors_surname as asname, authors_name as aname FROM authors WHERE authors_surname LIKE ? LIMIT 7", array($qr . '%'));
	
			if ($qida->num_rows() > 0) {
	
				$result = "{ query:'" . $qr . "', suggestions:[";
				foreach ($qida->result() as $rowa) {
					$result .= "'". $rowa->asname . " " . $rowa->aname . "',";
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
	

	function ajaxGetExpData(){
		
		
	
		$lid = $this->input->post('lit_id'); 

		$result = "empty";
	
		$this->data['literature_id'] = $lid;
	
		$this->data['block_message'] = "Nothing was sent";
	
		if (!empty($lid)){
				
			$this->data['block_message'] = "Nothing was found";
			
			$this->load->model('Literature_model','literm',TRUE);	

			$result = "no records";		

			if (($qida = $this->literm->get_one($lid)) != FALSE){
				
				unset($this->data['block_message']);
				
				// loading injections

				
				$this->load->model('Injections_model','injm',TRUE);
				
				
				if (($qida = $this->injm->get_from_l($lid)) != FALSE){
					
					
					$this->data['inj_data'] = $qida;
					$this->data['injfields'] = $this->injm->get_fields();
					
					$this->data['inj_bs_data'] = array();
					$this->data['inj_out_data'] = array();
					
					// outcomes
					$this->load->model('Outcomes_model','outm',TRUE);
					
					$this->data['outcomes_types'] = $this->outm->get_types();
					
					
					//labeled sites for oucomes
					$this->load->model('labeledsites_model','lsm',TRUE);
					
					$this->data['outlsfields'] = $this->lsm->get_fields(); 
					
					$this->data['out_ls_data'] = array();
					

					//method of injection
					$this->load->model('methods_model','mtm',TRUE);
						
					$this->data['mtmfields'] = $this->mtm->get_fields();
						
					$this->data['mtm_data'] = array();
					
					
					
					foreach ($this->data['inj_data']->result() as $idata) {
						
						
						// site of injection
						
						$this->load->model('Brainsite_model','bsm',TRUE);
						


						if (($qida = $this->bsm->get_one($idata->brain_sites_id)) != FALSE){
								
							$this->data['bsfields'] = $this->bsm->get_fields();
							$this->data['inj_bs_data'][$idata->injections_id] = $qida;
						
						
						}
						
						//outcomes of injection
						
						
						
						if (($qida = $this->outm->get_for_i($idata->injections_id)) != FALSE){
							
							
							$this->data['inj_out_data'][$idata->injections_id] = $qida;
							
							
							foreach ($qida->result() as $rowa) {
							
							
								if (($qida = $this->lsm->get_for_o($rowa->outcome_id)) != FALSE){
										
										
									$this->data['out_ls_data'][$rowa->outcome_id] = $qida;
										
										
								}
							}
							
							
							
							
						}
						
						
						// method of injection
						
						
						if (($qida = $this->mtm->get_one($idata->methods_id)) != FALSE){
								
								
							$this->data['mtm_data'][$idata->injections_id] = $qida;
								
								
						}
						
						
						
					}
					
					
					
				}//injections section ends here
				
				
				
			}
				
				
			$qida = $this->db->get_where('literature',array('literature_id' => $lid));
				
			
				
		}
	
		$result = $this->load->view('literature_ajax_get_view',$this->data,TRUE);

		echo $result;
			
	}
	
}

?>
