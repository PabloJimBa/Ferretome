<?php 
class News extends CI_Controller {
	
	private $data;
	
	
	public function __construct()
	{
		parent::__construct();
		
		
		
		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('login');
		//require_login();
		
		if (islogged()) $this->data['logintoken'] = TRUE;
		
		$this->load->model('pages_model','pagem',TRUE);
		
		if (($qida = $this->pagem->get_page('header_page')) != FALSE){
		
			$this->data['header_page'] = substr($qida, 3,-4);
		
		}
		
		//$this->data['logintoken'] = TRUE;
		
		
	
	}
	
	
	public function index()	{
		
		
		
		$id = $this->input->get('id');
		
		$this->load->model('news_model','newsm',TRUE);
		
		if (!empty($id)) {
			
			if (($qida = $this->newsm->get_one($id)) != FALSE){
								
				$this->data['news_one'] = $qida->row();
				
			}
			
			
			
		}
		
		
		
		if (($qida = $this->newsm->get_published()) != FALSE){
		
			$this->data['news'] = $qida;
		
		}
		
		
		
		
		$this->data['action'] = 'index';
		
		$this->load->view('news_view',$this->data);
	}
	
	public function show () {
		
		
		require_login();
		
		//$this->data['fields'] = $this->db->field_data('brain_site_acronyms');
		
		$this->data['action'] = 'show';
		
		
		$this->load->model('news_model','newsm',TRUE);
		
		
		
		
			
		if (($qida = $this->newsm->get_all()) != FALSE){
		
			$this->data['block_data'] = $qida;
			$this->data['types_options'] = $this->newsm->get_states();
			$this->data['fields'] = $this->newsm->get_fields();
			
		
		}
			
		$this->load->view('news_view',$this->data);
		
		
		
	}
	
	
	
	
	function add() {
	
		require_login();
		
		
	
		$this->data['action'] = 'add';
	
		
		$this->load->model('news_model','newsm',TRUE);
		
		$this->data['fields'] = $this->newsm->get_fields();
		
		$this->data['types_options'] = $this->newsm->get_states();
	
		//headers go here
	
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
	
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
		
		// headers for files
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/pages.js"></script>';
		
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/upclick-min.js"></script>';

		/*
		$this->load->model('files_model','filem',TRUE);
		
		if (($qida = $this->filem->get_all(array('user_id'=>$this->session->userdata('user_id')))) != FALSE){
		
		
			$this->data['files_data'] = $qida;
		
		
		}
		*/
	
		$this->load->view('news_view',$this->data);
	
	
	}
	
	
	function insert(){
	
		require_login();
	
		$fields = $_POST;
		
		
		$fields['user_id'] = $this->session->userdata('user_id');
		
		
		if ($this->db->insert('ferretdb_news',$fields) === FALSE){
	
			$this->show();
	
		} else {
	
	
			$this->data['block_message'] = "news updated";
			$this->show();
		}
	
	
	}
	
	function edit() {
	
		require_login();
	
		$id = $this->input->get('id');
	
		$this->data['action'] = 'edit';
	
	
	
		if (!empty($id)){
				
				
			$this->load->model('news_model','newsm',TRUE);
		
		
			if (($qida = $this->newsm->get_one($id)) != FALSE){
					
				$this->data['block_data'] = $qida->row();
	
				$this->data['fields'] = $this->newsm->get_fields();
		
				$this->data['types_options'] = $this->newsm->get_states();
		
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
				
				// headers for files
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/pages.js"></script>';
				
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/upclick-min.js"></script>';
				
				/*
				$this->load->model('files_model','filem',TRUE);
				
				if (($qida = $this->filem->get_all(array('user_id'=>$this->session->userdata('user_id')))) != FALSE){
				
				
					$this->data['files_data'] = $qida;
				
				
				}
				*/
				
				
					
			}
	
	
		}
	
		$this->load->view('news_view',$this->data);
			
	}
	
	
	
	function update() {
	
		require_login();
	
		$fields = $_POST;
		
		$fields['user_id'] = $this->session->userdata('user_id');
	
		$id = $this->input->get('id');
	
	
		if (!empty($id)){
	
	
			$this->db->where('news_id',$id);
	
			if ($this->db->update('ferretdb_news',$fields) === FALSE){
	
				$this->index();
	
			} else {
	
	
				//$this->journal->newrecord($this->session->userdata('user_id'),5,$id,2);
	
				$this->data['block_message'] = "Coding rule was updated";
				$this->show();
			}
		}
	
	
	}

}
?>
