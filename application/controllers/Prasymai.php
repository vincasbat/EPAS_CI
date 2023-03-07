<?php
class Prasymai extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->helper(array('form')); //?
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Prasymai_Model');
	$this->load->library('session');
	}
	
	
	public function index()
	{
		$this->load->view('prasymai');
			}
		
	public function get_prasymai()
	{
	$result=$this->Prasymai_Model->prasymai();
	echo json_encode($result);
	}	
	
	
	
	
	public function trinti()
	{
	$json = file_get_contents('php://input');   
	$data = json_decode($json);
	
	//$fkelias = "/var/www/html/ep_ci/newfile.txt";
	//$myfile = fopen($fkelias, "w");  fwrite($myfile, $json);  fclose($myfile); 
	 	
	$this->Prasymai_Model->trinti($data);
				
	$msg = "Ištrinta " . count($data);	
	
	$atsakymas = array("rez" => "OK", "msg" =>  $msg);
	header('Content-Type: application/json');
	echo json_encode($atsakymas);
	}
	
	
	
	
	
	
	}//class
