<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Index Page for this controller.
 *
 * Maps to the following URL
 * 		http://example.com/index.php/welcome
 *	- or -
 * 		http://example.com/index.php/welcome/index
 *	- or -
 * Since this controller is set as the default controller in
 * config/routes.php, it's displayed at http://example.com/
 *
 * So any other public methods not prefixed with an underscore will
 * map to /index.php/welcome/<method_name>
 * @see http://codeigniter.com/user_guide/general/urls.html
 */


class Welcome extends CI_Controller {
	
	private $data;
	
	
	public function __construct()
	{
		parent::__construct();
		
		
		
		$this->load->database('default');
		//$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('login');
		//require_login();
		
		if (islogged()) $this->data['logintoken'] = TRUE;
		
		$this->load->model('pages_model','pagem',TRUE);
		
		if (($qida = $this->pagem->get_page('header_page')) != FALSE){
		
			$this->data['header_page'] = substr($qida, 3,-4);
		
		}
		
		
	
	}
	
	
	public function index()	{
		
		$this->startpage();
		/*
		$this->data['action'] = 'index';
		
		$this->load->view('welcome_view',$this->data);
		*/
	}
	
	public function startpage() {
		
		$this->data['action'] = 'startpage';
		
		//require_login();
		
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/welcome.js"></script>';
		
		//$this->data['extraHeader'] .= '<script type="text/javascript" src="js/jit.js"></script>';
		
		$this->load->model('news_model','newsm',TRUE);
		
		if (($qida = $this->newsm->get_published()) != FALSE){
		
			$this->data['news'] = $qida;
		
		}
		
		$this->load->model('pages_model','pagem',TRUE);
		
		if (($qida = $this->pagem->get_page('main_page')) != FALSE){
		
			$this->data['main_page'] = $qida;
		
		}

		
		
		$this->load->view('welcome_view',$this->data);
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */