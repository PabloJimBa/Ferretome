<?php
class Architecture extends Controller {

	private $data;

	function Architecture()
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
		$this->load->view('architecture_view',$this->data);


	}
	
	function add() {
	
		$this->data['action'] = 'add';
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/architecture.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/autocomplete.js"></script>';
		
		$this->load->view('architecture_view',$this->data);
		
		
	
	
	}
	
	
	function ajaxGetParametersForm(){

		
		
		// collecting parameters 
		$qida = $this->db->get('parameters');
		
		$this->data['arc_param'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
		
			$temp_arr[$rowa->parameters_id] = $rowa->parameters_name;
		
		}
		
		$this->data['arc_param'] = $temp_arr;
		
		// end of collectin param
		
		$this->db->insert('architecture',array("brain_sites_id"=>$this->input->post('bsite_id'),"layer_number"=>$this->input->post('layer_id'),"literature_id"=>$this->input->post('literature_id')));
		
		$pid = $this->db->insert_id();
		
		$lid = $this->input->post('literature_id');
		
		
		//selecting lit title for describing source of architecture data
		 
		$this->db->select('literature_title, literature_index');
		
		$qida = $this->db->get_where('literature',array("literature_id"=>$lid));
		
		$rowa = $qida->row();
		
		// preparing out put
		
		$this->data['ltitle'] = substr($rowa->literature_title, 0,50) . " ... " .$rowa->literature_index;
		$this->data['fullltitle'] = $rowa->literature_title . " " .$rowa->literature_index;
		
		
		$this->data['bsite'] = $this->input->post('bsite_id');
		$this->data['layer'] = $this->input->post('layer_id');
		$this->data['param'] = $pid;
		$this->data['lid'] = $lid;
		
		
		
		// collecting pdc
		
		
		$qida = $this->db->get('pdc');
		
		$this->data['pdc_options'] = array();
		
		$temp_arr = array();
		
		foreach ($qida->result() as $rowa) {
		
			$temp_arr[$rowa->PDC_id] = $rowa->PDC_name;
		
		}
		
		$this->data['pdc_options'] = $temp_arr;
		 
		
		
		
		// output
		$this->load->view('architecture_parameter',$this->data);
		
		
		
	}
	
	
	function ajaxDelParameter() {
		
		$a_id = $this->input->post('architecture_id');
		
		if (!empty($a_id)) {
			
			
			$this->db->delete('architecture',array('architecture_id'=>$a_id));
			
			echo "deleted";
			
			return true;
			
			
		}
		echo "not deleted";
		
		
		
		
		
		
	}
	
	function ajaxGetAllParameters(){
		
		$result = '{"result":"0"}';
		$bsite_id = $this->input->post('bsite_id');
		
		if (!empty($bsite_id)) {
			
			// number to pdc 
			$qida = $this->db->get('pdc');
			
			$this->data['pdc_options'] = array();
			
			$temp_arr = array();
			
			foreach ($qida->result() as $rowa) {
			
				$temp_arr[$rowa->PDC_id] = $rowa->PDC_name;
			
			}
			
			// end
			
			
			$this->db->join('parameters','parameters.parameters_id = architecture.parameters_id');
			$qida = $this->db->get_where('architecture',array('brain_sites_id' => $bsite_id ));
			
			
			if ($qida->num_rows() > 0) {
				
				$result = '{"result":"'.$qida->num_rows().'", "data":[';
				foreach ($qida->result() as $rowa) {
					
					$result .= '{"lnumber":"'.$rowa->layer_number.'", "pid":"'.$rowa->architecture_id.'", "pname":"'.$rowa->parameters_name.'","pvalue":"'.$rowa->parameters_value.'","pdc":"'.$temp_arr[$rowa->architecture_pdc].'"},';
					
					
				}
				
				$result = substr($result, 0,-1);
				
				$result .= ']}';
				
				
				
				
				
			}
			
			echo $result;
			
			
			
			
		}
		 
		
		
	}
	
	
	
	function ajaxInsertParameter() {
		
		
		$fields = $_POST;
		
		$this->db->where('architecture_id',$fields['architecture_id']);
		
		unset($fields['architecture_id']);
		
		$this->db->update('architecture',$fields);
		
		
		
	}
	
	
	function ajaxDelParametersFromLayer(){
		
		$bsite_id = $this->input->post('bsite_id');
		$layer_id = $this->input->post('layer_id');
		
		
		if (!empty($bsite_id)) {
				
				
			$this->db->delete('architecture',array('layer_number'=>$layer_id,'brain_sites_id'=>$bsite_id));
				
				
		}
		
		
		
		
		
		
	}
	


}