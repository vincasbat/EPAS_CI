<?php
class Login extends CI_Controller {

public function __construct() {
	parent::__construct();
	$this->load->helper(array('form'));
	$this->load->library(array('form_validation'));
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Naudotojai_Model');
	$this->load->library('session');
}
public function index() {

		if($this->input->post('prisijungti'))
		{ 
		
		$naud_email=$this->input->post('naud_email');
		$naud_passw=$this->input->post('naud_passw');
		$ats = $this->Naudotojai_Model->login($naud_email,  $naud_passw);
		if($ats['ok'])  {
		$this->session->naud = $ats['pareiskejas'];
		$this->session->grupe = $ats['naud_grupe'];
		$this->session->naud_email = $ats['naud_email'];
		
		
		switch ($ats['naud_grupe']) {
	    case 'par':
		redirect("pradzia");
		break;
	    case 'admins':
		redirect("prasymai");
		break;
	    case 'pr':
	   	redirect("priemimas");
		break;
	    case 'is':
	    	redirect("isduoti");
		break;
	}
			  
		
		}
    		else { 
      		$this->session->set_flashdata('bad_login', 'Neteisingas el. pašto adresas arba slaptažodis');
    		redirect('login');    		
    		     }
   		}//if
	else
	
	unset(
        $_SESSION['naud'],
        $_SESSION['grupe'],
        $_SESSION['naud_email']
	);
	
	$this->load->view('login');
	
	}// end function











}
?>


