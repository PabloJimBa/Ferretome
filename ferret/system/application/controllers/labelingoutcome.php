<?php
class Labelingoutcome extends Controller {

	private $data;

	function Labelingoutcome()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		
		$this->load->library('journal');
		$this->data['table_id'] = 13;
		
		$this->db->join('labeling_outcome', 'labeling_outcome.outcome_type = outcome.type_id');

		$qida = $this->db->get('outcome');
		
		$this->data['labelling_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
				
			$temp_arr[$rowa->type_id] = $rowa->type_name;
				
		}
		
		$this->data['labelling_options'] = $temp_arr;
		
		$this->load->helper('login');
		require_login();
		
		
		$this->load->model('Leftmenu','lmenu',TRUE);
		
		if ($this->lmenu->all_number() > 0) {
				
			$this->data['leftMenu'] = $this->lmenu->get_all();
				
		}
		
		
	}

	function index() {

		$this->data['action'] = 'index';
		$this->load->view('labelingoutcome_view',$this->data);


	}

	function add(){

		// if specific lit id should be opened right after loading page
		$id = $this->input->get('id');
		
		if (!empty($id)) {
				
			$this->db->select('literature_title, literature_index, literature_id');
		
			$qida = $this->db->get_where('literature',array('literature_id' =>$id));	
	
			if ($qida->num_rows()>0) {
		
				$this->data['lit_block'] = $qida->row();
		
			}
				
				
		}
		

		// labelling options

		$this->db->join('labeling_outcome', 'labeling_outcome.outcome_type = outcome.type_id');

		$qida = $this->db->get('outcome');
		
		$this->data['labelling_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
				
			$temp_arr[$rowa->type_id] = $rowa->type_name;
				
		}
		
		$this->data['labelling_options'] = $temp_arr;

		//loading js files		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/labelingoutcome.js"></script>';
		
		
		//selecting action
		$this->data['action'] = 'add';
			
		$this->load->view('labelingoutcome_view',$this->data);


	}
	
	
	
	function insert() {

		$fields = $_POST;

		if ($this->db->insert('labeling_outcome',$fields) === FALSE){
			$this->data['add_message'] = "An error has occured";
				
			$this->add();
	
		} else {
	
				
			$lid = $this->db->insert_id();
			$this->journal->newrecord($this->session->userdata('user_id'),$this->data['table_id'],$lid);
	
	
			$this->data['index_message'] = "Labelling outcome was added";
			$this->index();
		}
	
	
	}
	
	function edit() {
	
		$lid = $this->input->get('id');
	
		$this->data['action'] = 'edit';
	
		$this->data['block_message'] = "Nothing was sent";
	
		if (!empty($lid)){
				
				
			$qida = $this->db->get_where('labeling_outcome',array('outcome_id' => $lid));
				
			$this->data['block_message'] = "Nothing was found";
				
			if ($qida->num_rows() > 0) {
					
				unset($this->data['block_message']);
	
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/labelingoutcome.js"></script>';
				
	
				$this->data['block_data'] = $qida->row();
	
				$this->db->select('literature_title, literature_index, literature_id');
	
				$qidb = $this->db->get_where('literature',array('literature_id' => $this->data['block_data']->literature_id));
	
				$this->data['lit_data'] = $qidb->row();

				$this->db->join('labeling_outcome', 'labeling_outcome.outcome_type = outcome.type_id');
				
				$qida = $this->db->get('outcome');
		
				$this->data['labelling_options'] = array();
		
				$temp_arr = array();
		
				foreach ($qida->result() as $rowa) {
				
					$temp_arr[$rowa->type_id] = $rowa->type_name;
				
				}
		
				$this->data['labelling_options'] = $temp_arr;
			
				
			}	
		
		}
	
	
		$this->load->view('labelingoutcome_view',$this->data);
	
	
	
	
	}
	
	
	
	function update() {
	
		$fields = $_POST;
		$inj_id = $this->input->get('id');
		
		// updating...
	
		$this->db->where('outcome_id',$inj_id);
	
		if ($this->db->update('labeling_outcome',$fields) === FALSE){
			$this->data['edit_message'] = "An error has occured";
	
			$this->edit();
	
		} else {
				
			
			// logging update action with old data and new
	
			$this->journal->newrecord($this->session->userdata('user_id'),$this->data['table_id'],$inj_id,2);
	
	
			$this->data['index_message'] = "Outcome was updated";
			$this->index();
		}
	
	
	
	
	
	}
	
	
	
	
	function ajaxGetOutcomes(){
	
	
		$pid = $this->input->post('pubid2');
		
		$method = 'normal';
		$method = $this->input->post('method');
		$result = "empty";
		
		$result = "nothing was sent";
		
		if (!empty($pid)){
				

			$qida = $this->db->get_where('labeling_outcome',array('literature_id' => $pid));
				
			$result = "no records";

			$this->db->join('labeling_outcome', 'labeling_outcome.outcome_type = outcome.type_id');

			$qidb = $this->db->get('outcome');
		
			$this->data['labelling_options'] = array();
	
			$temp_arr = array();
	
			foreach ($qidb->result() as $rowb) {
			
				$temp_arr[$rowb->type_id] = $rowb->type_name;
			
			}
	
			$this->data['labelling_options'] = $temp_arr;
			
				
				if ($qida->num_rows() > 0) {
		
					
					if ($method == 'extended') {
						
						$this->data['mode'] = 'extended';
						
						$this->load->model('Labeled_sites_model','lsmod',TRUE);
						
						foreach ($qida->result() as $rowa) {
								
							// counting all records
							$this->db->where('outcome_id', $rowa->outcome_id);
								
							$this->db->from('labelled_sites');
								
							$this->data['outcome_data'][$rowa->outcome_id] =  $this->db->count_all_results();

							
							
							//collecting labeled sites
							
							if (($qidls = $this->lsmod->get_all_where(array("outcome_id"=>$rowa->outcome_id))) != FALSE) {
							
								$this->data['labeled_fields'] = $this->lsmod->get_fields();
							
								$this->data['labeled_data'][$rowa->outcome_id] = $qidls;
								
								//print_r($this->data['labeled_data'][$rowa->outcome_id]->result());
							
							}

							$this->db->join('labeling_outcome', 'labeling_outcome.outcome_type = outcome.type_id');

							$qidb = $this->db->get('outcome');
		
							$this->data['labelling_options'] = array();
	
							$temp_arr = array();
	
							foreach ($qidb->result() as $rowb) {
			
								$temp_arr[$rowb->type_id] = $rowb->type_name;
			
							}
	
							$this->data['labelling_options'] = $temp_arr;
							
						
						}
					
						$this->data['outcomes'] = $qida;
						


						
					} else {
						
						$this->data['mode'] = 'normal';
						
						$this->db->join('labeling_outcome', 'labeling_outcome.outcome_type = outcome.type_id');

						$qidb = $this->db->get('outcome');
		
						$this->data['labelling_options'] = array();
	
						$temp_arr = array();
	
						foreach ($qidb->result() as $rowb) {
			
							$temp_arr[$rowb->type_id] = $rowb->type_name;
			
						}
	
						$this->data['labelling_options'] = $temp_arr;

						$temp_arr = array();

						foreach ($qida->result() as $rowa) {
								
							// counting all records
							$this->db->where('outcome_id', $rowa->outcome_id);
								
							$this->db->from('labelled_sites');

								
							$temp_arr[$rowa->outcome_id] = $rowa->outcome_name . " - " . $this->data['labelling_options'][$rowb->type_id]." has ". $this->db->count_all_results(). " labeled sites";
						
						}
						
						$this->data['outcome_options'] = $temp_arr;

						
						
					}
					$this->db->join('labeling_outcome', 'labeling_outcome.outcome_type = outcome.type_id');
					$qida = $this->db->get('outcome');
		
					$this->data['labelling_options'] = array();

					$temp_arr = array();

					foreach ($qida->result() as $rowa) {
		
						$temp_arr[$rowa->type_id] = $rowa->type_name;
		
					}

					$this->data['labelling_options'] = $temp_arr;
					$this->data['action'] = 'load_outcomes';
					$result = $this->load->view('labelingoutcome_ajax_get_view',$this->data,TRUE);
				
				}
					
				
				
			
		
	
		}
				
				
	
	
	
		echo $result;
	
	
	}
	
	
	function ajaxGetInsertForm() {
		
		
		$pid = $this->input->post('literature_id');
		
		$result = "empty";
		
		if (!empty($pid)){
			
			
			$this->data['frmid'] = md5(time());
			$this->data['lid'] = $pid;
			
			$this->data['action'] = 'new_outcome';
			
			$result = $this->load->view('labelingoutcome_ajax_get_view',$this->data,TRUE);
		}
		
		echo $result;
		
		
		
		
	}
	
	function ajaxSaveOutcome () {
		
		
		$fields = $_POST;
		
		$result = 'Error: nothing was sent';
		
		if (!empty($fields['literature_id'])) {
				
			
			$this->db->insert('labeling_outcome',$fields);
			$id = $this->db->insert_id();
			$this->journal->newrecord($this->session->userdata('user_id'),$this->data['table_id'],$id,1);
			
			$result = 'ok';
				
				
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
						$result = $this->load->view('labellingoutcome_search_view',$this->data,TRUE);		// Load view/labellingoutcome_search_view.php file with the above data
						
						
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
						
						$result =  $this->load->view('labellingoutcome_search_view',$this->data,TRUE);	// Load view/labellingoutcome_search_view.php file with the above data
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
					

					$result = $this->load->view('labellingoutcome_search_view',$this->data,TRUE);	// Load view/labellingoutcome_search_view.php file with the above data
							
				}
				
				echo $result;
			 }
				
				
				
				
				
				
		}
			
			
		
	}
	
	


}
