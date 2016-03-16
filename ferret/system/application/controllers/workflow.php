<?php

class Workflow extends Controller {

	
	
	function Workflow()
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
		
		
		$type = $this->input->get('type');
		
		$q = array();
		
		$showed = 0;
		
		if (empty($type)) {
			
			
			$q['job_state'] = 0;
			$q['job_type'] = 0;
			
			$showed = 0;
			
			
		} else {
			
			$q['job_state'] = 0;
			$q['job_type'] = 0;
			
			if ($type == 'input') {
				
				$q['job_type'] = 0;
				
				$showed = 1;
				
			} elseif ($type == 'proofreading') {
				
				$q['job_type'] = 1;
				
				$showed = 2;
				
			}
			
			
			
		}
		
		
		$this->load->model('Workflow_model','wfmod',TRUE);
		
		
		
		if (isset($q['job_type'])) {
			
			
			if ($q['job_type'] == 1) {
			
				if (($qida = $this->wfmod->get_for_user($this->session->userdata('user_id'))) != FALSE){
			
			
					$this->data['fields'] = $this->wfmod->get_fields();
					$this->data['job_data'] = $qida;
			
			
				}
			
			} else {
			
			
				if (($qida = $this->wfmod->get_all_where($q)) != FALSE){
						
						
					$this->data['fields'] = $this->wfmod->get_fields();
					$this->data['job_data'] = $qida;
						
						
				}
				
				
				
				
			}
			
			
			
			
			
			
		} else {
			
			
			
			if (($qida = $this->wfmod->get_all_where($q)) != FALSE){
					
					
				$this->data['fields'] = $this->wfmod->get_fields();
				$this->data['job_data'] = $qida;
					
					
			}
			
			
			
			
		}
		
		
		if (($qida = $this->wfmod->get_current($this->session->userdata('user_id'))) != FALSE) {
		
			$this->data['current_job'] = $qida->row();
			$this->data['current_job_fields'] = $this->wfmod->get_fields('current_job');

			//changeing above mentioned fields set in case if this user already have job
			
			unset($this->data['fields']['action']);
			unset($this->data['current_job_fields']['job_state']);
			
			
			 
		
		}
		
		$this->data['show_section'] = array 
		(
				"all jobs",
				"only input jobs",
				"only proofreading jobs"
		);

		$this->data['show_section_index'] = $showed;
		
		
		
		
		$this->data['workflow_data'] = $this->wfmod->get_statistics();
		$this->data['workflow_fields'] =$this->wfmod->get_fields('statistics');
		
		
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/workflow.js"></script>';
		
		
		
		$this->data['action'] = 'index';
		$this->load->view('workflow_view',$this->data);
		
		
		
		
	}
	
	
	function takeJob(){
		
		$id = $this->input->post('job_id');
		
		$result = '{"result":"0","error":"No proper input"}';
		
		if (!empty($id)) {
				
			$result = '{"result":"0","error":"You already have a job"}';
			
			$this->load->model('Workflow_model','wfmod',TRUE);
			
			if (($qida = $this->wfmod->get_current($this->session->userdata('user_id'))) == FALSE) {
				
				$result = '{"result":"0","error":"Something wrong with taking job"}';
					
				if ($this->wfmod->take_job($id,$this->session->userdata('user_id')) != FALSE){
						
					$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=workflow"}';
						
				}
					
				
				
				
			}
			
			
		
		}
		
		echo $result;
		
		
	}
	
	
	function rejectJob(){
		
		$id = $this->input->post('job_id');
		
		$result = '{"result":"0","error":"No proper input"}';
		
		if (!empty($id)) {
			
			$this->load->model('Workflow_model','wfmod',TRUE);
			
			$result = '{"result":"0","error":"something wrong with deletion"}';
			
			if (($qida = $this->wfmod->delete_current($this->session->userdata('user_id'))) != FALSE) {
				
				$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=workflow"}';
				
			}
			
			
			
			
		}
		
		echo $result;
		
		
		
	}
	
	
	function finishJob(){
	
		$id = $this->input->post('job_id');
	
		$result = '{"result":"0","error":"No proper input"}';
	
		if (!empty($id)) {
				
			$this->load->model('Workflow_model','wfmod',TRUE);
			
			$result = '{"result":"0","error":"something wrong with deletion"}';
				
			if (($qida = $this->wfmod->finish_current($this->session->userdata('user_id'))) != FALSE) {
				
				$result = '{"result":"1","message":"Succes!","newurl":"index.php?c=workflow"}';
				
			}
				
				
				
				
		}
	
		echo $result;
	
	
	
	}
	
	
	
			
		
		
		
	
	
	
}

?>
