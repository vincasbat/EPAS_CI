<?php
class Sign extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->database();
	$this->load->helper('url');
	//$this->load->model('Registras_Model');
	$this->load->library('session');
	}
	
	public function index()
	{
	
	$file_name=$this->input->get('file_name');
	$vpbinic=$this->input->get('vpbinic');
	$annot=$this->input->get('annot');
	$formatas=$this->input->get('formatas');
	
	$result['file_name'] = $file_name;
	$result['vpbinic'] = $vpbinic;
	$result['annot'] = $annot;
	$result['formatas'] = $formatas;
	
	
	$this->load->view('sign_gateway', $result);
	
	
	
	}//index
	
	
	
	
	
	
	}//class
	
	
	
	?>

