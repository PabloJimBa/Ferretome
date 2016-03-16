<?php 
class Login extends Controller {

	private $data;
	
	function Login()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		
		$this->data['login_token'] = 'true';
	}
	
	function index() {
		
		$this->data['action'] = 'index';
		$this->load->view('login_view',$this->data);
		
		
	}
	
	function signin(){
		
		
		$name = $this->input->post('name', true);
		
		$pass = md5($this->input->post('pass', true));
		
		
		$qid = $this->db->query("SELECT * FROM ferretdb_users WHERE user_email=? AND user_password=?",array($name,$pass));
		
		if($qid->num_rows() > 0) {
		
			$row = $qid->row();
					 
				$this->session->set_userdata('is_logged', true);
				$this->session->set_userdata('user_id', $row->user_id);
		
					
				header('Location: index.php');
		
					
		} else {
		
			$this->data['index_message'] = "Invalid email or/and password. Try agan! Check Capslock and keyboard language";
			$this->index();
		
		}
		
		
		
		
		
	}
	
	function signout(){
	
		$this->session->sess_destroy();
		$this->index();
		 
	}
	
	
	function getmd5(){
		
		echo md5($this->input->get('str'));
		
		
	}
	
}
?>