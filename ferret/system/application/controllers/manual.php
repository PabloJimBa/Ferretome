<?php

class Manual extends Controller {

	private $data;

	function Manual()
	{
		parent::Controller();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('login');
		require_login();
	}

	function index()
	{
		$this->data['action'] = 'index';
		$this->load->view('manual',$this->data);

	}
	
	function literature_add()
	{
		$this->data['action'] = 'literature_add';
		$this->load->view('manual',$this->data);
	}

	function author_add()
	{
		$this->data['action'] = 'author_add';
		$this->load->view('manual',$this->data);
	}

	function journal_add()
	{
		$this->data['action'] = 'journal_add';
		$this->load->view('manual',$this->data);
	}

	function acronym_add()
	{
		$this->data['action'] = 'acronym_add';
		$this->load->view('manual',$this->data);
	}

	function brainmap_add()
	{
		$this->data['action'] = 'brainmap_add';
		$this->load->view('manual',$this->data);
	}

	function brainsite_add()
	{
		$this->data['action'] = 'brainsite_add';
		$this->load->view('manual',$this->data);
	}

	function architecture_add()
	{
		$this->data['action'] = 'architecture_add';
		$this->load->view('manual',$this->data);
	}

	function bmrelation_add()
	{
		$this->data['action'] = 'bmrelation_add';
		$this->load->view('manual',$this->data);
	}

	function injectionmethod_add()
	{
		$this->data['action'] = 'injectionmethod_add';
		$this->load->view('manual',$this->data);
	}

	function injection_add()
	{
		$this->data['action'] = 'injection_add';
		$this->load->view('manual',$this->data);
	}

	function injectiondata_add()
	{
		$this->data['action'] = 'injectiondata_add';
		$this->load->view('manual',$this->data);
	}

	function outcome_add()
	{
		$this->data['action'] = 'outcome_add';
		$this->load->view('manual',$this->data);
	}

	function labelledsite_add()
	{
		$this->data['action'] = 'labelledsite_add';
		$this->load->view('manual',$this->data);
	}

	function injectionoutcome_add()
	{
		$this->data['action'] = 'injectionoutcome_add';
		$this->load->view('manual',$this->data);
	}

	function parameter_add()
	{
		$this->data['action'] = 'parameter_add';
		$this->load->view('manual',$this->data);
	}
}
