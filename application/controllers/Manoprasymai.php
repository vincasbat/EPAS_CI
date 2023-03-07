<?php
class Manoprasymai extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Prasymai_Model');
	$this->load->library('session');
	}
	
	
	public function index()
	{
	$naud_email = $this->session->naud_email;
								
	$result['data']=$this->Prasymai_Model->displaymyrecords($naud_email);
		$this->load->view('manoprasymai',$result);
			}
			
			
			
			
}//class
