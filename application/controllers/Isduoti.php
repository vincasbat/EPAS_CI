<?php
class Isduoti extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Registras_Model');
	$this->load->library('session');
	}

	public function index()
	{
	$this->load->view('isduoti');
	}
	
	
	public function getregistras() {
	 $start=$this->input->get('start');
	 $end= $this->input->get('end');
	 $isduoti = $this->Registras_Model->get_registras($start,   $end );
	 echo json_encode($isduoti ); 
	}
	
	
	public function getataskaitos () {
	$start_week=$this->input->get('start');
	  $end_week= $this->input->get('end');
	echo json_encode($this->Registras_Model->get_ataskaitos($start_week,   $end_week ));
	}
	
	
	
		
	}//class
