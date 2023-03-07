<?php
class Prasymas extends CI_Controller 
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
		
	$dok_id =  $this->input->get('dok_id');//??????
				
	$result['data']=$this->Prasymai_Model->manoprasymas($dok_id);
	$result['kiti']=$this->Prasymai_Model->kitus($dok_id);
	$result['mokejimas']=$this->Prasymai_Model->mokejimas($dok_id);
	
		$this->load->view('prasymas',$result);
	}
			
			
		public function download() {   
		$fileName = $this->input->get('file');
		if ($fileName) {
	        $file = FCPATH . "assets/uploaded_files/" . $fileName;
	        if (file_exists ( $file )) {
	        $data = file_get_contents ( $file );
	        force_download ( $fileName, $data );
	    } else {
	    
	     $this->session->set_flashdata("nerastaspra", "Failas nerastas");
		redirect(base_url () . "index.php/priemimas");   
		  
	    }
	   }
	   }//download
	
	
	
			
			
}//class
