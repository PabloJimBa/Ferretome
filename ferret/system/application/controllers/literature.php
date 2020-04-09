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
		
		$this->load->model('Literature_model','literM',TRUE); // Load "Literature_model" as "literM"; TRUE = autoconnect to database
		$this->load->model('Authors_model','authorsM',TRUE); // Load "Authors_model" as "amodel"; TRUE = autoconnect to database
		
		// Collecting last inserted publications.
		
		if (($qida = $this->literM->get_last_inserted()) != FALSE){ // Function localised in models/literature_model.php file --> get the last 3 inputs
		
			foreach ($qida->result() as $rowa) {
				
				$this->data['last_inserted_authors'][$rowa->literature_id] =  $this->authorsM->get_a_for_l($rowa->literature_id); // Obtain the authors list from the last 3 inputs
			}
			
			$this->data['last_inserted'][] = $qida; // Load the above data into data['last_inserted'][]
		
		}
		
		// Collecting last updated publications.

				
		if (($qida = $this->literM->get_last_updated()) != FALSE){	// Function localised in models/literature_model.php file --> get the last 3 updated inputs
		
		
			foreach ($qida->result() as $rowa) {
					
				$this->data['last_updated_authors'][$rowa->literature_id] =  $this->authorsM->get_a_for_l($rowa->literature_id); // Obtain the authors list from the last 3 updated inputs
			}
			
			
			$this->data['last_updated'][] = $qida;	// Load the above data into data['last_updated'][]
		
		}
		
		// Collecting 3 puplication for proofreading.
		
		if (($qida = $this->literM->get_for_proof()) != FALSE){		// Function localised in models/literature_model.php file --> get the last 3 inputs which required proofreading
			
			foreach ($qida->result() as $rowa) {
					
				$this->data['for_proof_authors'][$rowa->literature_id] =  $this->authorsM->get_a_for_l($rowa->literature_id);	// Obtain the authors list from the above inputs
			}
				
				
			$this->data['for_proof_data'][] = $qida;	// Load the above data into data['for_proof_data'][]
			
		}
		
		// Load literature autocomplete Javascripts (from ferret/js)
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/literature.js"></script>';
			
		// Load the application/views/literature_view.php file with all above data

		$this->load->view('literature_view',$this->data);
		
		
		
		
	}

	
	function add(){
		
		// Load the field names from literature (table in database) into data
		
		$this->data['fields'] = $this->db->field_data('literature');
		
		// Action "add" is chosen
		
		$this->data['action'] = 'add';
		
		// Load literature autocomplete and upload button Javascripts (from ferret/js)

		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/literature.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/upclick-min.js"></script>';
			
		// Load /views/literature_view.php file with this data (action: "add"; fields: from literature table)

		$this->load->view('literature_view',$this->data);
		
		
	}
	
	function insert() {
		
		$fields = $_POST; // Load fields from post method
		
		
		$authors = array(); // Create an array called "authors"
		
		$authors = $fields['authors_id']; // Load fields into the above array
		unset($fields['authors_id']); // Reset the fields variable
		
		
		
		// Search the authors_surname from the database thanks to the authors_id
		$this->db->select('authors_surname');
		$this->db->where_in('authors_id', $authors);
		$qida = $this->db->get('authors'); // Load the authors table (from the database)

		
		
		
		// Create the literature index name

		$fields['literature_index'] = ''; // Create $fields['literature_index'] variable
		
		foreach ($qida->result() as $row) {

			
			$fields['literature_index'] .= $row->authors_surname[0]; // Write the initial of each author into the $fields['literature_index'] variable
						
		}
		
		$fields['literature_index'].= $fields['literature_year']; // Write the year of publication after the above initials.

// 		echo $fields['literature_index'];

				
		//$fields['literature_mappingData'] = 0;
		//$fields['literature_tracingData'] = 0;
		
		//print_r($fields);
			
		
		if ($this->db->insert('literature',$fields) === FALSE){ 			
			
			$result = '{"result":"0","message":"Error!"}';
			
		} else {
			
			$lid = $this->db->insert_id();	// Load all insert_id into lid variable
			
			$this->journal->newrecord($this->session->userdata('user_id'),$this->table_id,$lid);	// Save record in journal of actions table (database)
			
			
			
			if (!empty($authors)) {
				
				foreach ($authors as $auth) {

					$this->db->insert('literature_and_authors',array('literature_id' => $lid, 'authors_id' => $auth)); // Save new authors in literature_and_authors table (database)
					
				}
				
			}
			
			
			$this->session->set_userdata('pub_id',$lid);	// Add userdata lid value to pub_id variable
			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$lid.'"}';
		}
		
		echo $result;


	}
	
	function search(){
		
		
		//$this->data['fields'] = $this->db->field_data('literature');
		
		
		
		// Load models from application/models
		$this->load->model('Literature_model','literM',TRUE);
		$this->load->model('Authors_model','authorsM',TRUE);
		
		
		
		
		// Action "search" is chosen
		$this->data['action'] = 'search';

		// Load literature autocomplete Java scripts
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/literature.js"></script>';
			
		// Load views/literature_view.php file with above data
		$this->load->view('literature_view',$this->data);
		
		
		
		
	}
	
	
	function edit(){
		
		$lid = $this->input->get('id'); // Obtain the literature ID
		

		// Action "edit" is chosen
		$this->data['action'] = 'edit';
		
		$this->data['block_message'] = "Nothing was sent";
		
		if (!empty($lid)){
			
			$this->data['block_message'] = "Nothing was found";
			
			//$this->db->join('literature_abbreviations', 'literature_abbreviations.authors_id = literature_and_authors.authors_id');
			$qida = $this->db->get_where('literature',array('literature_id' => $lid)); // Load literature (from database) from lid variable
			
			if ($qida->num_rows() > 0) {
				
				
				
				unset($this->data['block_message']);
			
				
				// Load literature autocomplete and upload button Javascripts
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/literature.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/upclick-min.js"></script>';
				
				// Feedback module 
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/journal_update.js"></script>';
				
				$this->data['journal_options_data'] = $this->journal->get_options();
				
								
				$this->data['fields'] = $this->db->field_data('literature');
				
				
				$this->load->model('Literature_model','litm',TRUE);
				
				$this->data['liteature_types'] = $this->litm->get_types();

				// Literature data
				$rowa = $qida->row();
				
				$this->data['lit_data'] =  $rowa; // Load all literature data

				// Abbreviations
				$qidabbr =  $this->db->get_where('literature_abbreviations',array('abbreviations_id' => $rowa->literature_source)); // Load literature_abbreviations from abbreviations_id table (database) 				
				$this->data['abbr_data'] = $qidabbr->row();	// Load above abbreviations data
				
				// Authors
				$this->db->join('authors', 'authors.authors_id = literature_and_authors.authors_id');	// Join authors from literature_and_authors/authors_id with authors/authors_id		
				$this->db->order_by('lna_id','ASC');	// Order data by lna_id (literature_and_authors table; database) in an ascendent way
												
				$this->data['auth_data'] =  $this->db->get_where('literature_and_authors',array('literature_id' => $lid));	// Load literature_and_authors table (from database) from lid variable
				$this->data['auth_data_numr'] = $this->data['auth_data']->num_rows();	// Count the number of authors
				
				// Brain maps
				$qidbmap = $this->db->get_where('brain_maps',array('literature_id' => $lid)); // Load brain maps (from database) from lid variable

				if ($qidbmap->num_rows() > 0) { 
				
					$this->data['bmaps_data'] = $qidbmap->row();  // Load above brain maps data
				
				}
				
				// Injections
				
				$this->db->join('brain_sites', 'brain_sites.brain_sites_id = injections.brain_sites_id');	// Join brain_sites from injections/brain_sites_id with brain_sites/brain_sites_id
				
				$this->db->join('brain_site_acronyms', 'brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');	// Join brain_site_acronyms from brain_sites/brain_sites_acronyms_id with brain_site_acronyms/brain_site_acronyms_id

				$this->db->join('methods', 'methods.methods_id = injections.methods_id');	// Join methods from injections/methods_id with methods/methods_id
				
				$this->db->join('tracers', 'methods.tracers_id = tracers.tracers_id');	// Join tracers from tracers/tracers_id with methods/tracers_id
									
				$this->db->select('injections_id, injections_index, brain_sites_index,acronym_full_name, tracers_name');	// Load these tables from the database
				

				$qidinj = $this->db->get_where('injections',array('injections.literature_id' => $lid));	// Load injections (from database) from lid variable
				
				if ($qidinj->num_rows() > 0) {
				
					$this->data['inj_data'] = $qidinj;	// Load above injections data
				
				}

				// Outcomes of labelings
				$qidout = $this->db->get_where('labeling_outcome',array('literature_id' => $lid));	// Load labeling_outcomes table (from database) from lid variable
				
				if ($qidout->num_rows() > 0) {
				
					$this->data['outcomes_data'] = $qidout;	// Load above outcome data
				
				}
				// Their connection to injections
				$qid = $this->db->get_where('injections_and_outcomes',array('literature_id' => $lid));	// Load injections_and_outcomes (from database) from lid variable
				
				if ($qid->num_rows() > 0) {
				
					$this->data['relation_data'] = $qid;	// Load above data
				
				}
				
				
				// Maps relations
				$this->db->where('literature_id',$lid); // Load literature_id from lid variable
				
				$mrN = $this->db->count_all_results('maps_relations');	// Count number of maps relations			
				
				if ($mrN > 0) {
				
					$this->data['mr_data_num'] = $mrN;	// Load the number of maps relations
					$this->data['mr_data'] = $lid;	// Load the above maps relations data
				
				}
				
				
				// Literature status
				
				$this->load->model('Workflow_model','wfmod',TRUE);	// Load model "Workflow_model" as "wfmod"; TRUE = autoconnect to database
					
				if (($qidb = $this->wfmod->get_current($this->session->userdata('user_id'))) != FALSE) {	// Function localised in models/workflow_model.php file --> get all users with input queue
				
					$rowb = $qidb->row();	// Load above users
				
					if ($rowb->literature_id == $lid) {
				
				
						$this->data['lit_changeble_state'] = true; // Allow us to change the user status
					
					}
					
				}
				
				
				
			
			}
			
		} 
		
		// Load view/literature_view.php file with the above data
		$this->load->view('literature_view',$this->data);
		
	}
	
	
	function update(){
		
		$fields = $_POST;	// Load fields data from user input
		
		
		$authors = array();	// Create an array called authors
		
		$authors = $fields['authors_id'];	// Load authors_id from fields variable into authors array
		unset($fields['authors_id']);	// Reset authors_id from fields variable
		
		
		
		// Load authors_surname from authors table (from database) whose authors_id are in authors array
		$this->db->select('authors_surname');
		$this->db->where_in('authors_id', $authors);
		$qida = $this->db->get('authors');

		
		


		$fields['literature_index'] = '';	// Create fields['literature_index'] variable
		
		foreach ($qida->result() as $row) {

			
			$fields['literature_index'] .= $row->authors_surname[0];	// Get the initial of each authors_surname to create the literature_index
						
		}
		
		$fields['literature_index'].= $fields['literature_year'];	// Add the literature_year to the literature_index

// 		echo $fields['literature_index'];

				
		//$fields['literature_mappingData'] = 0;
		//$fields['literature_tracingData'] = 0;
		
		//print_r($fields);
		
		$lid = $this->input->get('lid');	// Load literature_id input into lid variable
		
		// Collecting previously saved data for journal
		
		$prev_data = $this->db->get_where('literature',array('literature_id' => $lid));		// Load literature whose literature_id are in lid variable
		
		$prev_data = $prev_data->row();		// Load the above data
		
		// Finaly inserting...
		
		$this->db->where('literature_id',$lid);		// Load the literature_id from lid variable
		
		if ($this->db->update('literature',$fields) === FALSE){					
			
			$result = '{"result":"0","message":"An error has occured!"}';	// Error message
			
		} else {
			
			
			
						
			if (!empty($authors)) {
				
				$this->db->where('literature_id', $lid);
				$this->db->delete('literature_and_authors');	// Delete literature_and_authors whose literature_id are in lid variable
				
				foreach ($authors as $auth) {

					$this->db->insert('literature_and_authors',array('literature_id' => $lid, 'authors_id' => $auth));	// Load new literature_id and authors_id in literature_and_authors (database)
					
				}
				
			}
			
			
			$this->session->set_userdata('pub_id',$lid);	// Load userdata session
			
			// Newrecord (USER_ID,TABLE_ID,ENTRY_ID,ACTION_ID(1=ins,2=update,3=del)=1,DATA='');
			
			$jid = $this->journal->newrecord($this->session->userdata('user_id'),$this->table_id,$lid,2,$prev_data);	// Save new record
			
			$this->data['block_message'] = "Publication was updated";	// Info message
			
			$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=literature&m=edit&id='.$lid.'","jid":"'.$jid.'"}';
			
		}
		
		
		echo $result;
		
		
	}
	
	
	
	
	function searchDo(){		
		
		$strig = $this->input->post('strigger');
		
		if (!empty($strig)){
			
			if ($strig == 1){	// Search publication using its title
		
				$id = $this->input->post('pubid');	// Load input name in id variable
				
				$result = 'nothing sent';
				
				if (!empty($id)){
					
					$result = 'nothing found';
					
					$this->db->join('literature_abbreviations','literature_abbreviations.abbreviations_id = literature.literature_source');		// Join literature_abbreviations from literature/literature_source with literature_abbreviations/abbreviations_id
					
					$qida = $this->db->get_where('literature',array('literature_id' => $id));	// Load literature whose literature_id are in id variable
					
					if ($qida->num_rows() > 0) {
						
						
						$this->data['lit_data'][] = $qida;	// Load above literature_data
						
						
						
						$this->db->join('authors', 'authors.authors_id = literature_and_authors.authors_id');	// Join authors from literature_and_authors/authors_id with authors/authors_id
						
						$this->db->order_by('literature_and_authors.authors_id','asc');		// Order by authors_id in an ascendent way
						
		
						$this->data['auth_data'][$id] =  $this->db->get_where('literature_and_authors',array('literature_id' => $id));		// Load data from literature_and_authors whose literature_id are in id variable
						
						
						
						//print_r($this->db->);
						
						
		
						$this->data['search_title'] = "Search result";		// Load search_title
						$result = $this->load->view('literature_search_view',$this->data,TRUE);		// Load view/literature_search_view.php file with the above data
						
						
					}
					
					
					
				}
				
				echo $result; 
				
			} elseif ($strig == 2) {	// Search publication using its authors
				
				$id = $this->input->post('authid');	// Load author input in id variable
				$result = 'nothing sent';
				
				
				if (!empty($id)){
					
					$result = 'nothing found';
					
					$this->db->select('literature_id');	// Load literature_id from database
										
					$qidb = $this->db->get_where('literature_and_authors',array('authors_id' => $id));	// Load literature_and_authors whose authors_id are in id variable

					if ($qidb->num_rows()>0){
						
						foreach ($qidb->result() as $rowb){
							$this->db->join('literature_abbreviations','literature_abbreviations.abbreviations_id = literature.literature_source');		// Join literature_abbreviations from literature/literature_source with literature_abbreviations/abbreviations_id
							$qida = $this->db->get_where('literature',array('literature_id' => $rowb->literature_id));	// Load literature whose literature_id are in the above literature_and_authors data
								
							if ($qida->num_rows() > 0) {
						
						
								$this->data['lit_data'][$rowb->literature_id] = $qida;		// Load above data
						
						
								$this->db->join('authors', 'authors.authors_id = literature_and_authors.authors_id');	// Join authors from literature_and_authors/authors_id with authors/authors_id
								$this->db->order_by('lna_id','asc');		// Order by authors_id in an ascendent way
								
								$this->data['auth_data'][$rowb->literature_id] =  $this->db->get_where('literature_and_authors',array('literature_id' => $rowb->literature_id));	// Load auth data from literature_and_authors whose literature_id are selected above
						
						
							}
							
							
							
						}
						
						$this->data['search_title'] = "Search result";	// Load search_title
						
						$result =  $this->load->view('literature_search_view',$this->data,TRUE);	// Load view/literature_search_view.php file with the above data
					}		
						
						
				}
				
				echo $result;
				
			} elseif ($strig == 3) {
				
				
				
				$limit = $this->input->post('limit');	// Select a limit of results
				$offset = $this->input->post('offset');		// Do not show the numbers of result set in offset
				
				$result = 'nothing found';
				
					
				$this->db->join('literature_abbreviations','literature_abbreviations.abbreviations_id = literature.literature_source');		// Join literature_abbreviations from literature/literature_source with literature_abbreviations/abbreviations_id
				
				$this->db->order_by('literature_year','desc');		// Order by literature_year in a descendent way
				
				
													
				$qida = $this->db->get('literature',$limit,$offset);	// Load literature from database until a limit numbers of results, and avoiding the offset one
				
				if ($qida->num_rows() > 0) {
					
					$this->data['lit_data'][] = $qida;	// Load above data
					
					foreach ($qida->result() as $rowa){
						
						
						$this->db->join('authors', 'authors.authors_id = literature_and_authors.authors_id');		// Join authors from literature_and_authors/authors_id with authors/authors_id
						$this->db->order_by('lna_id','ASC');		// Order by lna_id in an ascendent way
						
						$this->data['auth_data'][$rowa->literature_id] =  $this->db->get_where('literature_and_authors',array('literature_id' => $rowa->literature_id));	// Load auth data from literature_and_authors whose literature_id are selected above
							
						
					}
				
					
					$this->data['freesearch'] = 'yes';	// Free search is on
					
					if ($offset != '0') {
						
						$this->data['notable'] = 'yes';		// Notable is on if offset is set
						
						
					}
					
					$this->data['offset'] = $offset+10;	// Load offset
					$this->data['limit'] = $limit;		// Load limit
					

					$result = $this->load->view('literature_search_view',$this->data,TRUE);	// Load view/literature_search_view.php file with the above data
							
				}
				
				echo $result;
			 }
				
				
				
				
				
				
			}
			
			
		
	}
	
	
	
	function viewAll(){
		
		
		$this->load->model('Literature_model','literM',TRUE);
		
		// Arrays with literature_id and all data from literature_and_authors (table from database)
		
		$this->data['block_data'] = $this->literM->get_all();
		$this->data['block_fields'] = $this->literM->get_fields();
		
		
		$this->load->model('Authors_model','amodel',TRUE);
		
		// To obtain an array called $auth with names and surnames

		$auth = array();
		
		foreach ($this->data['block_data']->result() as $rowa) {
			
			$qida = $this->amodel->get_a_for_l($rowa->literature_id);	// Function localised in models/authors_model --> Obtain the authors list from literature

			if ($qida->num_rows() > 0) {
				
				$str = '';
				foreach ($qida->result() as $rowb ) {
					
					$str .= $rowb->authors_surname . ' ' . $rowb->authors_name . "<br/>"; 
					
				}
				
				$auth[$rowa->literature_id] = $str;
				
				
			}
			
			
		}
		
		$this->data['block_fields']['authors']['array_data'] = $auth;	// Load the above data
		
		
		// Action "all_literature" is chosen
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
	
	// ajax call from literature.edit -> literature.js
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
		$filename = md5(time()).'.pdf';		// Create a MD5 name for the pdf file
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
	
	function confirm(){
	
		$id = $this->input->get('id');
		echo "<script>if(confirm('Are you sure?')){
		document.location='index.php?c=literature&m=del_lit&id=$id';}
		else{ javascript:history.go(-1);
		}</script>"; 
	}
	
	function del_lit(){
		
		$id = $this->input->get('id');
		
		$result = "empty query";
		
		if (!empty($id)){
			
			$this->db->delete('literature',array('literature_id'=>$id));
				
			echo "Deleted. Please, reload the page.";

			echo "<script>document.location='index.php?c=literature'</script>;";
				
			return true;
				
				
		}
		echo "Not deleted";

		echo "<script>document.location='index.php?c=literature'</script>;";
	}
		
}

?>
