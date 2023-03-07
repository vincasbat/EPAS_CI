<?php
class Pdfas extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Prasymai_Model');
	$this->load->model('Mokejimai_Model');
	$this->load->library('session');
	$this->load->helper('download');
	}
	
	
	public function index()
	{
	$dok_id =  $this->input->post('dok_id');
	$result['data']=$this->Prasymai_Model->manoprasymas($dok_id);
	$result['kiti']=$this->Prasymai_Model->kitus($dok_id);
	$result['mokejimas']=$this->Prasymai_Model->mokejimas($dok_id);
	$this->load->view('pazyma',$result);
	$dompdf = new Dompdf\Dompdf();
	$html = $this->output->get_output();
	$dompdf->loadHtml($html);
	$dompdf->render();
	$dompdf->stream($dok_id . '.pdf');
	}//index
	
	
	
	
}


