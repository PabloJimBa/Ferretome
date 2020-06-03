<?php

class Manual extends CI_Controller {

	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('login');
	}

	function main()
	{
		$this->data['action'] = 'main';
		$this->load->view('manual_view',$this->data);

	}

	function index()
	{
		$this->data['action'] = 'index';
		$this->load->view('manual_view',$this->data);

	}

	function home()
	{
		$this->data['action'] = 'home';
		$this->load->view('manual_view',$this->data);

	}
	function news()
	{
		$this->data['action'] = 'news';
		$this->load->view('manual_view',$this->data);

	}
	function news_add()
	{
		$this->data['action'] = 'news_add';
		$this->load->view('manual_view',$this->data);

	}
	function news_delete()
	{
		$this->data['action'] = 'news_delete';
		$this->load->view('manual_view',$this->data);

	}
	function lit()
	{
		$this->data['action'] = 'lit';
		$this->load->view('manual_view',$this->data);

	}
	function lit_details()
	{
		$this->data['action'] = 'lit_details';
		$this->load->view('manual_view',$this->data);

	}
	function lit_map()
	{
		$this->data['action'] = 'lit_map';
		$this->load->view('manual_view',$this->data);

	}
	function lit_exp()
	{
		$this->data['action'] = 'lit_exp';
		$this->load->view('manual_view',$this->data);

	}
	function lit_exp_injection()
	{
		$this->data['action'] = 'lit_exp_injection';
		$this->load->view('manual_view',$this->data);

	}
	function lit_exp_site()
	{
		$this->data['action'] = 'lit_exp_site';
		$this->load->view('manual_view',$this->data);

	}
	function lit_exp_outcome()
	{
		$this->data['action'] = 'lit_exp_outcome';
		$this->load->view('manual_view',$this->data);

	}
	function lit_exp_method()
	{
		$this->data['action'] = 'lit_exp_method';
		$this->load->view('manual_view',$this->data);

	}
	function lit_relation()
	{
		$this->data['action'] = 'lit_relation';
		$this->load->view('manual_view',$this->data);

	}
	function connectivity()
	{
		$this->data['action'] = 'connectivity';
		$this->load->view('manual_view',$this->data);

	}
	function connectivity_ferret()
	{
		$this->data['action'] = 'connectivity_ferret';
		$this->load->view('manual_view',$this->data);

	}
	function connectivity_cat()
	{
		$this->data['action'] = 'connectivity_cat';
		$this->load->view('manual_view',$this->data);

	}
	function contacts()
	{
		$this->data['action'] = 'contacts';
		$this->load->view('manual_view',$this->data);

	}
	function admin()
	{
		$this->data['action'] = 'admin';
		$this->load->view('manual_view',$this->data);

	}
	function login()
	{
		$this->data['action'] = 'login';
		$this->load->view('manual_view',$this->data);

	}

}

?>
