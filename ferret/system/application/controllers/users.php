<?php

class Users extends Controller {

	private $data;
	
	function Users()
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
		
		
	}

	function index() {
	
		$this->data['action'] = 'index';
		
		$this->load->model('Users_model','userM',TRUE);
		
		if (($qida = $this->userM->get_all(array(),'user_reg_time','asc','999')) != FALSE){
			
			
			$this->data['block_data'] = $qida;
			$this->data['block_fields'] = $this->userM->get_fields();
			
			
			
		}
	 
			
		$this->load->view('users_view',$this->data);
	
	
	}

	function add(){
		
		$this->data['action'] = 'add';
	
		$this->data['fields'] = $this->db->field_data('ferretdb_users');

		$this->load->model('Users_model','userM',TRUE);

		$this->data['uclass'] = $this->userM->get_for_user($this->session->userdata('user_id'));
			
		$this->load->view('users_view',$this->data);
	
	
	}

	function insert() {
	
		$fields = $_POST;
	
		$fields['user_password'] = md5($fields['user_password']); // Create a MD5 name for the password

		if ($this->db->insert('ferretdb_users',$fields) === FALSE){
			$this->add();
		}
		else {
			
			$lid = $this->db->insert_id();
			$this->journal->newrecord($this->session->userdata('user_id'),2,$lid);
				
			$this->data['index_message'] = "User was added";
			$this->index();
		}
	
	
	}

	function edit() {
		
		
		$id = $this->input->get('id');
		
		$this->data['action'] = 'edit';
		
		$this->data['block_message'] = "Nothing was sent";
		
		
		
		if (!empty($id)){
				
				
			$qida = $this->db->get_where('ferretdb_users',array('user_id' => $id));
			
			$this->data['block_message'] = "Nothing was found";
			
			if ($qida->num_rows()>0){
				
				$this->data['user_data'] = $qida->row();
				
				unset($this->data['block_message']);
				
				$this->data['fields'] = $this->db->field_data('ferretdb_users');
								
				
			}
		}
		
		$this->load->view('users_view',$this->data);
					
	}
	
	function update() {
		
		
		
		$fields = $_POST;

		$fields['user_password'] = md5($fields['user_password']); // Create a MD5 name for the password
		
		$id = $this->input->get('userid'); 
		
		
		if (!empty($id)){
			
			
			$this->db->where('user_id',$id);
			
			if ($this->db->update('ferretdb_users',$fields) === FALSE){

				$this->search();
			
			} else {
					
				
				$this->journal->newrecord($this->session->userdata('user_id'),2,$id,2);
			
				$this->data['index_message'] = "Author was updated";
				$this->index();
			}
		}

		
	}

	function confirm(){
	
		$id = $this->input->get('id');
		echo "<script>if(confirm('Are you sure?')){
		document.location='index.php?c=users&m=del_lit&id=$id';}
		else{ javascript:history.go(-1);
		}</script>"; 
	}
	
	function del_lit(){
		
		$id = $this->input->get('id');
		
		$result = "empty query";
		
		if (!empty($id)){
			
			$this->db->delete('ferretdb_users',array('user_id'=>$id));
				
			echo "Deleted. Please, reload the page.";

			echo "<script>document.location='index.php?c=users&m=show'</script>;";
				
			return true;
				
				
		}
		echo "Not deleted";

		echo "<script>document.location='index.php?c=users&m=show'</script>;";
	}

}

?>
