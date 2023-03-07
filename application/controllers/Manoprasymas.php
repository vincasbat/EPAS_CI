<?php
class Manoprasymas extends CI_Controller 
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
	$naud_email = $this->session->naud_email;
	
	$dok_id =  $this->input->post('dok_id');
				
	$result['data']=$this->Prasymai_Model->manoprasymas($dok_id);
	$result['kiti']=$this->Prasymai_Model->kitus($dok_id);
	$result['mokejimas']=$this->Prasymai_Model->mokejimas($dok_id);
	
		$this->load->view('manoprasymas',$result);
	}
			
			
		public function download() {   
		//https://www.technicalkeeda.com/codeigniter-tutorials/codeigniter-file-download-example
		$fileName = $this->input->get('file');
		if ($fileName) {
	        $file = FCPATH . "assets/uploaded_files/" . $fileName;
	        if (file_exists ( $file )) {
	        $data = file_get_contents ( $file );
	        force_download ( $fileName, $data );
	    } else {
	      $this->session->set_flashdata("nerastasmanopra", "Failas nerastas");
	     redirect ( base_url () . 'index.php/manoprasymai');   //ideti flash, jei nepavyko?
	    }
	   }
	   }//download
	   
	   
	   
	   public function parsisiusti() {   
		$fileName = $this->input->get('file');
		if ($fileName) {
	        $file = FCPATH . "assets/pazymos/" . $fileName;
	        if (file_exists ( $file )) {
	        $data = file_get_contents ( $file );
	        force_download ( $fileName, $data );
	    } else {
	      $this->session->set_flashdata("nerastasdokas", "Failas nerastas");
	     redirect ( base_url () . 'index.php/pradzia');   //ideti flash, jei nepavyko?
	    }
	   }
	   }//download
	
	
	
			
			
}//class
