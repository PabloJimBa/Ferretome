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
}
