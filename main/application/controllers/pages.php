<?php

class Pages extends CI_Controller {

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
		
		$page = $this->input->get('p');
		
		$this->data['page_data'] = '<p>No input</p>';
		
		if (!empty($page)) {
			
			$this->data['page_data'] = '<p>Not found</p>';
			
		
			$this->load->model('pages_model','pagem',TRUE);
			
			
			if (islogged()) {
			
				if (($qida = $this->pagem->get_page($page)) != FALSE){
				
					$this->data['page_data'] = $qida;
				
				}
			} else {
				
				if (($qida = $this->pagem->get_page_public($page)) != FALSE){
				
					$this->data['page_data'] = $qida;
				
				}
				
				
			}
			
			
			
		}
		
		
		$this->data['action'] = 'index';
		$this->load->view('pages_view',$this->data);
		
		
	}
	
	
	function show() {
	
		require_login();
	
		//$this->data['fields'] = $this->db->field_data('brain_site_acronyms');
	
		$this->data['action'] = 'show';
		
		
		$this->load->model('pages_model','pagem',TRUE);
		
					
		if (($qida = $this->pagem->get_all()) != FALSE){
				
			$this->data['block_data'] = $qida;
			$this->data['types_options'] = $this->pagem->get_types();
				
		}
			
		$this->load->view('pages_view',$this->data);
	
	
	}
	
	
	
	function add() {
		
		require_login();
		
		$this->data['fields'] = $this->db->field_data('ferretdb_pages');
						
		$this->data['action'] = 'add';
		
		$this->load->model('pages_model','pagem',TRUE);
		$this->data['types_options'] = $this->pagem->get_types();
		
		//headers go here
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
		
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
		
		
		
		// headers for files
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/pages.js"></script>';

		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/upclick-min.js"></script>';
		
		$this->load->model('files_model','filem',TRUE);
		
		if (($qida = $this->filem->get_all(array('user_id'=>$this->session->userdata('user_id')))) != FALSE){
				
			//$qida = $this->db->get_where('ferretdb_files',array('user_id'=>$this->session->userdata('user_id')));
		
			$this->data['files_data'] = $qida;
				
		
		}
		
		
		$this->load->view('pages_view',$this->data);
		
		
	}
	
	
	function insert(){
		
		require_login();
	
		$fields = $_POST;
	
	
		if ($this->db->insert('ferretdb_pages',$fields) === FALSE){
	
			$this->show();
	
		} else {
	
	
			$this->data['block_message'] = "Coding rule was updated";
			$this->show();
		}
	
	
	
	}
	
	
	function edit() {
		
		require_login();
	
		$id = $this->input->get('id');
	
		$this->data['action'] = 'edit';
	
	
	
		if (!empty($id)){
			
			
			$this->load->model('pages_model','pagem',TRUE);
				
			if (($qida = $this->pagem->get_one($id)) != FALSE){
					
				$this->data['block_data'] = $qida->row();
				
				$this->data['fields'] = $this->db->field_data('ferretdb_pages');
				
				
				$this->data['extraHeader'] = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/tinymceinit.js"></script>';
				
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/pages.js"></script>';
				$this->data['extraHeader'] .= '<script type="text/javascript" src="js/upclick-min.js"></script>';
				
				
				$this->load->model('pages_model','pagem',TRUE);
				$this->data['types_options'] = $this->pagem->get_types();
				
				

				$this->load->model('files_model','filem',TRUE);
				
				if (($qida = $this->filem->get_all(array('user_id'=>$this->session->userdata('user_id')))) != FALSE){
					
					//$qida = $this->db->get_where('ferretdb_files',array('user_id'=>$this->session->userdata('user_id')));
						
					$this->data['files_data'] = $qida;
					
																
				}
				
				
					
			}
	
				
		}
	
		$this->load->view('pages_view',$this->data);
			
	}
	
	
	
	function update() {
	
		require_login();
	
		$fields = $_POST;
	
		$id = $this->input->get('id');
	
	
		if (!empty($id)){
	
	
			$this->db->where('page_id',$id);
	
			if ($this->db->update('ferretdb_pages',$fields) === FALSE){
	
				$this->index();
	
			} else {
	
	
				//$this->journal->newrecord($this->session->userdata('user_id'),5,$id,2);
	
				$this->data['block_message'] = "Coding rule was updated";
				$this->show();
			}
		}
	
	
	}
	
	
	function uploadFile () {
		
		
		$tmp_file_name = $_FILES['Filedata']['tmp_name'];
		
		$real_name = $_FILES['Filedata']['name'];
		
		
		
		
		
		$allowedExts = array("jpg", "jpeg", "gif", "png");
		
		$extension = end(explode(".", $_FILES["Filedata"]["name"]));
		
		if ((($_FILES["Filedata"]["type"] == "image/gif")
				|| ($_FILES["Filedata"]["type"] == "image/jpeg")
				|| ($_FILES["Filedata"]["type"] == "image/png")
				|| ($_FILES["Filedata"]["type"] == "image/pjpeg"))
				&& in_array($extension, $allowedExts))
		{
			
		
			$filename = md5(time()).".".$extension;
			
			$ok = move_uploaded_file($tmp_file_name, './upload/'.$filename);
			
			$this->load->model('files_model','filem',TRUE);
			
			
			$this->filem->add($filename,$this->session->userdata('user_id'),$real_name);
			
			
			
			// This message will be passed to 'oncomplete' function
			echo $ok ? "Uploaded" : "FAIL";
		
		}
		else
		{
			echo "Invalid file";
		}
		
		
		
	}
	
	
	function ajaxGetFiles(){
		
		$result = "<p>No files</p>";
		
		$this->load->model('files_model','filem',TRUE);
		
		if (($qida = $this->filem->get_files($this->session->userdata('user_id'))) != FALSE){
		
			
			$this->data['files_data'] = $qida;
			$result = $this->load->view('files_view',$this->data,TRUE);
			
		}
		
		
		echo $result;	
		
		
		
	}
	
	
	
	
	
	
}

?>