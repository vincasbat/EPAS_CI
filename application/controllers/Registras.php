<?php
class Registras extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->helper(array('form'));
	$this->load->library(array('form_validation'));
	$this->load->library('pagination');
	
	$this->load->helper(array('form')); 
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Registras_Model');
	$this->load->library('session');
	}
	
	private function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
	}
	
	
	public function index()
	{
	$result['isdavejai']=$this->Registras_Model->isdavejai();
	$result['adresatai']=$this->Registras_Model->adresatai();
	if($this->input->post('submit'))
		{
		$where = "";
	
		$wherepno = "";
		$pno = $this->input->post('pno'); 
		if(strlen($pno)>2) {	 $wherepno = " AND pno = '$pno' ";}
		
		$wheredoktipas = "";
		$doktipas = $this->input->post('doktipas'); 
		if(strlen($doktipas)>2) {   $wheredoktipas = " AND dokumentas = '$doktipas' "; }
		
		$whereregnr = "";
		$regnr = $this->input->post('regnr'); 
		if(strlen($regnr)>2) {	   $whereregnr = " AND reg_nr = '$regnr' "; 	}
		 
		 $wherenuo = "";
		$nuo = $this->input->post('nuo'); 
		if($this->validateDate($nuo)) {	   $wherenuo = " AND data >= '$nuo' ";  }
		
		 $whereiki = "";
		$iki = $this->input->post('iki'); 
		if($this->validateDate($iki)) {	 $whereiki = " AND data <= '$iki' "; 	 }
		 
		 
		$whereisdave = "";
		$isdave = $this->input->post('isdave'); 
		if(strlen($isdave)>2) {
		   $whereisdave = " AND isdave = '$isdave' "; 
		 }
		 
		 
		$whereadresatas = "";
		$adresatas = $this->input->post('adresatas'); 
		if(strlen($adresatas)>2) {
		   $whereadresatas = " AND adresatas = '$adresatas' "; 
		 }

		 
		 
		 
$where = $wherepno . $wheredoktipas . $whereregnr . $wherenuo . $whereiki . $whereisdave . $whereadresatas;

		$result['data']=$this->Registras_Model->displayrecords_where($where);
		$this->load->view('registras', $result);
				}  else {
		$result['data']=$this->Registras_Model->displayrecords();
		$this->load->view('registras',$result);
		}
	}//func
		
	
	
	public function delete()
	{
	$id=$this->input->get('reg_ai');
	$kelias = $this->Registras_Model->getpath($id);
	$this->Registras_Model->deleterecord($id);
	unlink(FCPATH.'assets/pazymos/'.$kelias);
	$this->session->set_flashdata('siunc_istrintas', "Dokumentas $id ištrintas");
	redirect("registras");    
	}//func
	
	
	
	
	
	}//class
	
	
	
	
	?>
