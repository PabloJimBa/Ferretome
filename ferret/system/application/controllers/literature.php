<?php

class Literature extends Controller {

	private $data;
	private $table_id = 1;
	
	function Literature()
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
		
		
		$this->load->model('Workflow_model','wfmod',TRUE);
		
		if (($num = $this->wfmod->all_number()) != 0) {
				
			$this->data['input_queue_number'] = $num;
				
		}
		
		if (($num = $this->wfmod->all_number_for_user($this->session->userdata('user_id'))) != 0) {
		
			$this->data['proof_queue_number'] = $num;
		
		}
		
	}
	
	function index() {
		
		// Action 'index' is chosen.

		$this->data['action'] = 'index';

		// Load all literature and authors to be shown.
		
		$this->load->model('Literature_model','literM',TRUE);
		$this->load->model('Authors_model','authorsM',TRUE);
		
		if (($qida = $this->literM->get_all_where()) != FALSE){
		
			foreach ($qida->result() as $rowa) {
				
				$this->data['all_authors'][$rowa->literature_id] =  $this->authorsM->get_authors_for_literature($rowa->literature_id); 
			}
			
			$this->data['all'][] = $qida;
		
		}
	
		// Collecting last inserted publications.
		
		if (($qida = $this->literM->get_last_inserted()) != FALSE){
		
			foreach ($qida->result() as $rowa) {
				
				$this->data['last_inserted_authors'][$rowa->literature_id] =  $this->authorsM->get_a_for_l($rowa->literature_id); 
			}
			
			$this->data['last_inserted'][] = $qida;
		
		}
		
		// Collecting last updated publications.

				
		if (($qida = $this->literM->get_last_updated()) != FALSE){
		
		
			foreach ($qida->result() as $rowa) {
					
				$this->data['last_updated_authors'][$rowa->literature_id] =  $this->authorsM->get_a_for_l($rowa->literature_id);
			}
			
			
			$this->data['last_updated'][] = $qida;
		
		}
		
		// Collecting 3 puplication for proofreading.
		
		if (($qida = $this->literM->get_for_proof()) != FALSE){
			
			foreach ($qida->result() as $rowa) {
					
				$this->data['for_proof_authors'][$rowa->literature_id] =  $this->authorsM->get_a_for_l($rowa->literature_id);
			}
				
				
			$this->data['for_proof_data'][] = $qida;
			
		}
		
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/literature.js"></script>';
			
		// Load the application/views/literature_view.php file.

		$this->load->view('literature_view',$this->data);
		
		
		
		
	}

	
	function add(){
		
		// Load the field names from literature (table in database) into data
		
		$this->data['fields'] = $this->db->field_data('literature');
		
		// Action "add" is chosen
		
		$this->data['action'] = 'add';
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/literature.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/upclick-min.js"></script>';
			
		// Load /views/literature_view.php file with this data (action: "add"; fields: from literature table)

		$this->load->view('literature_view',$this->data);
		
		
	}
	
	function insert() {
		
		$fields = $_POST;
		
		
		$authors = array();
		
		$authors = $fields['authors_id'];
		unset($fields['authors_id']);
		
		
		
		
		$this->db->select('authors_surname');
		$this->db->where_in('authors_id', $authors);
		$qida = $this->db->get('authors');

		
		


		$fields['literature_index'] = '';
		
		foreach ($qida->result() as $row) {

			
			$fields['literature_index'] .= $row->authors_surname[0];
						
		}
		
		$fields['literature_index'].= $fields['literature_year'];

// 		echo $fields['literature_index'];

				
		//$fields['literature_mappingData'] = 0;
		//$fields['literature_tracingData'] = 0;
		
		//print_r($fields);
			
		
		if ($this->db->insert('literature',$fields) === FALSE){ 			
			
			$result = '{"result":"0","message":"Error!"}';
			
		} else {
			
			$lid = $this->db->insert_id();
			
			$this->journal->newrecord($this->session->userdata('user_id'),$this->table_id,$lid);
			
			
			
			if (!empty($authors)) {
				
				foreach ($authors as $auth) {

					$this->db->insert('literature_and_authors',array('literature_id' => $lid, 'authors_id' => $auth));
					
				}
				
			}
			
			
			$this->session->set_userdata('pub_id',$lid);
			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$lid.'"}';
		}
		
		echo $result;


	}
	
	function search(){
		
		
		//$this->data['fields'] = $this->db->field_data('literature');
		
		
		
		
		$this->load->model('Literature_model','literM',TRUE);
		$this->load->model('Authors_model','authorsM',TRUE);
		
		// collecting last inserted publications 
		
		if (($qida = $this->literM->get_last_inserted()) != FALSE){
		
			foreach ($qida->result() as $rowa) {
				
				$this->data['last_inserted_authors'][$rowa->literature_id] =  $this->authorsM->get_a_for_l($rowa->literature_id); 
			}
			
			$this->data['last_inserted'][] = $qida;
		
		}
		
		// collecting last updated publications

				
		if (($qida = $this->literM->get_last_updated()) != FALSE){
		
		
			foreach ($qida->result() as $rowa) {
					
				$this->data['last_updated_authors'][$rowa->literature_id] =  $this->authorsM->get_a_for_l($rowa->literature_id);
			}
			
			
			$this->data['last_updated'][] = $qida;
		
		}
		
		// collecting 3 puplication for proofreading
		
		if (($qida = $this->literM->get_for_proof()) != FALSE){
			
			foreach ($qida->result() as $rowa) {
					
				$this->data['for_proof_authors'][$rowa->literature_id] =  $this->authorsM->get_a_for_l($rowa->literature_id);
			}
				
				
			$this->data['for_proof_data'][] = $qida;
			
		}
		
		
		$this->data['action'] = 'search';

		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/literature.js"></script>';
			
		$this->load->view('literature_view',$this->data);
		
		
		
		
	}
	
	
	function edit(){
		
		$lid = $this->input->get('id');
		
		$this->data['action'] = 'edit';
		
		$this->data['block_message'] = "Nothing was sent";
		
		if (!empty($lid)){
			
			$this->data['block_message'] = "Nothing was found";
			
			//$this->db->join('literature_abbreviations', 'literature_abbreviations.authors_id = literature_and_authors.authors_id');
			$qida = $this->db->get_where('literature',array('literature_id' => $lid));
			
			if ($qida->num_rows() > 0) {
				
				
				
				unset($this->data['block_message']);
			
				
				
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/literature.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/upclick-min.js"></script>';
				
				// feedback module 
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/journal_update.js"></script>';
				
				$this->data['journal_options_data'] = $this->journal->get_options();
				
								
				$this->data['fields'] = $this->db->field_data('literature');
				
				
				$this->load->model('Literature_model','litm',TRUE);
				
				$this->data['liteature_types'] = $this->litm->get_types();
				// literature data
				$rowa = $qida->row();
				
				$this->data['lit_data'] =  $rowa;
				// abbreviations
				$qidabbr =  $this->db->get_where('literature_abbreviations',array('abbreviations_id' => $rowa->literature_source));				
				$this->data['abbr_data'] = $qidabbr->row();
				
				// authors
				$this->db->join('authors', 'authors.authors_id = literature_and_authors.authors_id');				
				$this->db->order_by('lna_id','ASC');
												
				$this->data['auth_data'] =  $this->db->get_where('literature_and_authors',array('literature_id' => $lid));
				$this->data['auth_data_numr'] = $this->data['auth_data']->num_rows();  
				
				//brain maps
				$qidbmap = $this->db->get_where('brain_maps',array('literature_id' => $lid));

				if ($qidbmap->num_rows() > 0) { 
				
					$this->data['bmaps_data'] = $qidbmap->row();  
				
				}
				
				// injetions
				
				$this->db->join('brain_sites', 'brain_sites.brain_sites_id = injections.brain_sites_id');
				
				$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');

				$this->db->join('methods', 'methods.methods_id = injections.methods_id');
				
				$this->db->join('tracers', 'methods.tracers_id = tracers.tracers_id');
									
				$this->db->select('injections_id, injections_index, brain_sites_index,acronym_full_name, tracers_name');
				

				$qidinj = $this->db->get_where('injections',array('injections.literature_id' => $lid));
				
				if ($qidinj->num_rows() > 0) {
				
					$this->data['inj_data'] = $qidinj;
				
				}

				// outcomes of labelings
				$qidout = $this->db->get_where('labeling_outcome',array('literature_id' => $lid));
				
				if ($qidout->num_rows() > 0) {
				
					$this->data['outcomes_data'] = $qidout;
				
				}
				// their connection to injections
				$qid = $this->db->get_where('injections_and_outcomes',array('literature_id' => $lid));
				
				if ($qid->num_rows() > 0) {
				
					$this->data['relation_data'] = $qid;
				
				}
				
				
				// maps relations
				$this->db->where('literature_id',$lid);
				
				$mrN = $this->db->count_all_results('maps_relations');				
				
				if ($mrN > 0) {
				
					$this->data['mr_data_num'] = $mrN;
					$this->data['mr_data'] = $lid;
				
				}
				
				
				
				
				$this->load->model('Workflow_model','wfmod',TRUE);
					
				if (($qidb = $this->wfmod->get_current($this->session->userdata('user_id'))) != FALSE) {
				
					$rowb = $qidb->row();
				
					if ($rowb->literature_id == $lid) {
				
				
						$this->data['lit_changeble_state'] = true;
					
					}
					
				}
				
				
				
			
			}
			
		} 
		
		$this->load->view('literature_view',$this->data);
		
	}
	
	
	function update(){
		
		$fields = $_POST;
		
		
		$authors = array();
		
		$authors = $fields['authors_id'];
		unset($fields['authors_id']);
		
		
		
		
		$this->db->select('authors_surname');
		$this->db->where_in('authors_id', $authors);
		$qida = $this->db->get('authors');

		
		


		$fields['literature_index'] = '';
		
		foreach ($qida->result() as $row) {

			
			$fields['literature_index'] .= $row->authors_surname[0];
						
		}
		
		$fields['literature_index'].= $fields['literature_year'];

// 		echo $fields['literature_index'];

				
		//$fields['literature_mappingData'] = 0;
		//$fields['literature_tracingData'] = 0;
		
		//print_r($fields);
		
		$lid = $this->input->get('lid');
		
		// collecting previously saved data for journal
		
		$prev_data = $this->db->get_where('literature',array('literature_id' => $lid));
		
		$prev_data = $prev_data->row();
		
		// finaly inserting...
		
		$this->db->where('literature_id',$lid);			
		
		if ($this->db->update('literature',$fields) === FALSE){ 			
			
			$result = '{"result":"0","message":"An error has occured!"}';
			
		} else {
			
			
			
						
			if (!empty($authors)) {
				
				$this->db->where('literature_id', $lid);
				$this->db->delete('literature_and_authors');
				
				foreach ($authors as $auth) {

					$this->db->insert('literature_and_authors',array('literature_id' => $lid, 'authors_id' => $auth));
					
				}
				
			}
			
			
			$this->session->set_userdata('pub_id',$lid);
			
			//newrecord (USER_ID,TABLE_ID,ENTRY_ID,ACTION_ID(1=ins,2=update,3=del)=1,DATA='');
			
			$jid = $this->journal->newrecord($this->session->userdata('user_id'),$this->table_id,$lid,2,$prev_data);
			
			$this->data['block_message'] = "Publication was updated";
			
			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$lid.'","jid":"'.$jid.'"}';
			
		}
		
		
		echo $result;
		
		
	}
	
	
	
	
	function searchDo(){		
		
		$strig = $this->input->post('strigger');
		
		if (!empty($strig)){
			
			if ($strig == 1){
		
				$id = $this->input->post('pubid');
				
				$result = 'nothing sent';
				
				if (!empty($id)){
					
					$result = 'nothing found';
					
					$this->db->join('literature_abbreviations','literature_abbreviations.abbreviations_id = literature.literature_source');
					
					$qida = $this->db->get_where('literature',array('literature_id' => $id));
					
					if ($qida->num_rows() > 0) {
						
						
						$this->data['lit_data'][] = $qida;
						
						
						
						$this->db->join('authors', 'authors.authors_id = literature_and_authors.authors_id');
						
						$this->db->order_by('literature_and_authors.authors_id','asc');
						
		
						$this->data['auth_data'][$id] =  $this->db->get_where('literature_and_authors',array('literature_id' => $id));
						
						
						
						//print_r($this->db->);
						
						
		
						$this->data['search_title'] = "Search result";
						$result = $this->load->view('literature_search_view',$this->data,TRUE);
						
						
					}
					
					
					
				}
				
				echo $result; 
				
			} elseif ($strig == 2) {
				
				$id = $this->input->post('authid');
				$result = 'nothing sent';
				
				
				if (!empty($id)){
					
					$result = 'nothing found';
					
					$this->db->select('literature_id');
										
					$qidb = $this->db->get_where('literature_and_authors',array('authors_id' => $id));

					if ($qidb->num_rows()>0){
						
						foreach ($qidb->result() as $rowb){
							$this->db->join('literature_abbreviations','literature_abbreviations.abbreviations_id = literature.literature_source');
							$qida = $this->db->get_where('literature',array('literature_id' => $rowb->literature_id));
								
							if ($qida->num_rows() > 0) {
						
						
								$this->data['lit_data'][$rowb->literature_id] = $qida;
						
						
								$this->db->join('authors', 'authors.authors_id = literature_and_authors.authors_id');
								$this->db->order_by('literature_and_authors.authors_id','asc');
								
								$this->data['auth_data'][$rowb->literature_id] =  $this->db->get_where('literature_and_authors',array('literature_id' => $rowb->literature_id));
						
						
							}
							
							
							
						}
						
						$this->data['search_title'] = "Search result";
						
						$result =  $this->load->view('literature_search_view',$this->data,TRUE);
					}		
						
						
				}
				
				echo $result;
				
			} elseif ($strig == 3) {
				
				
				
				$limit = $this->input->post('limit');
				$offset = $this->input->post('offset');
				
				$result = 'nothing found';
				
					
				$this->db->join('literature_abbreviations','literature_abbreviations.abbreviations_id = literature.literature_source');
				
				$this->db->order_by('literature_year','desc');
				
				
													
				$qida = $this->db->get('literature',$limit,$offset);
				
				if ($qida->num_rows() > 0) {
					
					$this->data['lit_data'][] = $qida;
					
					foreach ($qida->result() as $rowa){
						
						
						$this->db->join('authors', 'authors.authors_id = literature_and_authors.authors_id');
						$this->db->order_by('literature_and_authors.authors_id','asc');
						
						$this->data['auth_data'][$rowa->literature_id] =  $this->db->get_where('literature_and_authors',array('literature_id' => $rowa->literature_id));
							
						
					}
				
					
					$this->data['freesearch'] = 'yes';
					
					if ($offset != '0') {
						
						$this->data['notable'] = 'yes';
						
						
					}
					
					$this->data['offset'] = $offset+10;
					$this->data['limit'] = $limit;
					

					$result = $this->load->view('literature_search_view',$this->data,TRUE);
							
				}
				
				echo $result;
			 }
				
				
				
				
				
				
			}
			
			
		
	}
	
	
	
	function viewAll(){
		
		
		$this->load->model('Literature_model','literM',TRUE); // Load "Literature_model" as "literM"; TRUE = autoconnect to database
		
		// Arrays with literature_id and all data from literature_and_authors (table from database)
		
		$this->data['block_data'] = $this->literM->get_all();
		$this->data['block_fields'] = $this->literM->get_fields();
		
		
		$this->load->model('Authors_model','amodel',TRUE); // Load "Authors_model" as "amodel"; TRUE = autoconnect to database
		
		// To obtain an array called $auth with names and surnames

		$auth = array();
		
		foreach ($this->data['block_data']->result() as $rowa) {
			
			$qida = $this->amodel->get_a_for_l($rowa->literature_id);

			if ($qida->num_rows() > 0) {
				
				$str = '';
				foreach ($qida->result() as $rowb ) {
					
					$str .= $rowb->authors_surname . ' ' . $rowb->authors_name . "<br/>"; 
					
				}
				
				$auth[$rowa->literature_id] = $str;
				
				
			}
			
			
		}
		
		$this->data['block_fields']['authors']['array_data'] = $auth; 
		
		

		$this->data['action'] = 'all_literature';

		// Load views/literature_view with all data obtained in this function

		$this->load->view('literature_view',$this->data);
		
		
		
		
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
	
	
	function ajaxGetTitle(){
		
		$lit = $this->input->post('literature_id');
		
		$result = '{"result":"0","error":"No input"}';
		
		if (!empty($lit)) {
			
			$result = '{"result":"0","error":"No records"}';
			
			$this->db->select('literature_title, literature_index');
			
			$qida = $this->db->get_where('literature',array('literature_id' =>$lit));
			
			if ($qida->num_rows() > 0) {
				
				$result = '{"result":"1"';
			
				$rowa = $qida->row();
				
				$result .= ',"title":"'.$rowa->literature_title.'"';
				
				$result .= ',"index":"'.$rowa->literature_index.'"';
				
				$result .= '}';
			
			}
			
		
		
		}
		
		
		echo $result;
		
		
		
	}
	
	// ajax call from litearature.edit -> literature.js
	function changeState() {
		
		$literature_id = $this->input->post('literature_id');
		$status_id = $this->input->post('status_id');
		$uid = '';  
		
		
		$result = '{"result":"0","error":"No input"}';
		
		if (!empty($literature_id) && !empty($status_id)) {
			
			$result = '{"result":"0","error":"Nothing found"}';
			

			$this->load->model('Literature_model','literM',TRUE);
			
			if (($qida = $this->literM->get_one($literature_id)) != FALSE){
			
				$result = '{"result":"0","error":"You cannot change this paper status back to Draft or Proofreading"}';
				
				$row = $qida->row();
				
				if ($status_id > $row->literature_state) {
					
					
					$result = '{"result":"0","error":"You do not have current jobs at all, take this and come back"}';
					
					
					$this->load->model('Workflow_model','wfmod',TRUE);
					
					if (($qidb = $this->wfmod->get_current($this->session->userdata('user_id'))) != FALSE) {
						
						
						$result = '{"result":"0","error":"You do not have this paper as a current job, change it and come back"}';
						
						$rowb = $qidb->row();
						
						if ($rowb->literature_id == $literature_id) {
							
							$result = '{"result":"0","error":"Something wrong with finishing current job"}';
							
							if ($this->wfmod->finish_current($this->session->userdata('user_id')) != FALSE) {
									
								$this->literM->change_state($literature_id,$status_id);
								
								if ($status_id < 2) {

									$this->wfmod->create_job($row->literature_title,$row->literature_id,1);
								
								}

								$state = $status_id;
									
								$arr = $this->literM->get_types();
									
								$state = $arr[$status_id];
							
								$result = '{"result":"1","message":"Succes!","succes_data":"'.$state.'"}';
																							
								
							}
							
							
							
						}
						
						
					}
					
					
					
				}
				
				
			
			
			}
			
			
			
			
			
		}
		
		
		
		echo $result;
		
		
	}
	
	function uploadPdfFile() {
		
		
		$tmp_file_name = $_FILES['Filedata']['tmp_name'];
		$filename = md5(time()).'.pdf';
		$ok = move_uploaded_file($tmp_file_name, './upload/'.$filename);
		
		// This message will be passed to 'oncomplete' function
		echo $ok ? $filename : "FAIL";
		
		
	}
	
	
	function cmd(){
		
		//echo md5("14pass02");
		
		/*
		$qida = $this->db->get('literature');
		
		$this->load->model('Workflow_model','wfmod',TRUE);
		$this->load->model('Literature_model','literM',TRUE);
		
		foreach ($qida->result() as $rowa) {
			
			$this->wfmod->create_job($rowa->literature_title,$rowa->literature_id,0,2);
			
			$jid = $this->db->insert_id();
			
			$this->wfmod->take_job($jid,$this->session->userdata('user_id'));			 
			
			$this->wfmod->create_job($rowa->literature_title,$rowa->literature_id,1);
			
			$this->literM->change_state($rowa->literature_id,1);
			
		}
		
		
		$this->wfmod->finish_current($this->session->userdata('user_id'));
		
		
		echo "done";
		*/
		
		
		//$this->load->model('Workflow_model','wfmod',TRUE);
		
		//$this->wfmod->create_job("The connectivity of the area postrema in the ferret.",16);
		
		
	} 
	
	function genjob(){
		
		$id = $this->input->get('id');
		
		$this->load->model('Literature_model','litm',TRUE);
		
		
		if (($qida = $this->litm->get_one($id)) != FALSE) {
			
			
			$rowa = $qida->row();
			
			$this->load->model('Workflow_model','wfmod',TRUE);
			
			$this->wfmod->create_job($rowa->literature_title." - ". $rowa->literature_year,$rowa->literature_id);
			
			
			echo "generated";
			
		}
		
		
		
		
		
	}
	
	
}

?>
