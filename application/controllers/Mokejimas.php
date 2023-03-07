<?php
class Mokejimas extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Mokejimai_Model');
	$this->load->library('session');
	}
	
	public function index()
	{
	$naud_email = $this->session->naud_email;
	$result['data']=$this->Mokejimai_Model->displaymyrecords($naud_email);
	$result['total']=$this->Mokejimai_Model->getmytotal($naud_email);
	$this->load->view('mokejimas',$result);
	
	}
	
	
}
