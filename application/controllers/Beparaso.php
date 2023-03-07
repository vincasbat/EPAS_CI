<?php
 use PHPMailer\PHPMailer\PHPMailer; 

class Beparaso extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->library('email');
	$this->load->helper(array('form'));
	$this->load->library(array('form_validation'));
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Registras_Model');
	$this->load->library('session');
	date_default_timezone_set('Europe/Vilnius');
	}

	public function index()
	{
	$result['adresatai']=$this->Registras_Model->adresatai();
	$this->load->view('beparaso', $result);
	}
	
	
	
	public function upload() 
	{ 
	$config['upload_path'] = FCPATH .'/assets/pazymos/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 5000;
       
        $this->load->library('upload', $config);
        
        $pasirinktas = $this->input->post('pareiskejai'); 
        $sauksm = $this->sauksm($this->Registras_Model->isdavejas($pasirinktas));
        
        
        $file_count = count($_FILES);
        for ($i=1;$i<=$file_count;$i++) {
        
        $pno_name = "pno_" . $i;
	$tipas_name = "sel_" . $i;
	$file_name = "file_" . $i;
	$tipas = $this->input->post($tipas_name); 
	  
        $ip = $this->input->post($pno_name); 
        $ip = filter_var($ip, FILTER_SANITIZE_STRING); 
	$ip = trim($ip);
	

switch (@$_SESSION['grupe'])
{
case "pr":  
$skyrius = "PR"; 
break;
case "is":
$skyrius = "IS";
break;
case "pz":
$skyrius = "PZ";
break;
case "ap":
$skyrius = "AP"; 
break;
case "admins":
$skyrius = "AD"; 
break;

default:
$skyrius = "";
 header("Location: login");
  exit();
break;
}  //switch 
 
 
 
 $date = date("YmdHis");
 $isduoti = "";
 
 	if (is_uploaded_file($_FILES[$file_name]['tmp_name'])) {
 		$file_count = count($_FILES);
 		$ip_trimmed = str_replace(' ', '', $ip);
		$pasirinktas_be_at = str_replace("@", "_", $pasirinktas);
		$file = $pasirinktas_be_at . "_" . $ip_trimmed . "_" . $date . "_"  . $tipas . "_" . $skyrius .".pdf";
		$isduoti .= $file. ', ';
		
		
		$destination = FCPATH .'/assets/pazymos/' . $file;
	        $temp_file = $_FILES[$file_name]['tmp_name'];
		       
			$result =  move_uploaded_file($temp_file,$destination);
			if   ($result)  
			{
			$max = $this->Registras_Model->maksregai();   
			$max++;
			if ($max < 100000) $maxz = "".$max;
			if ($max < 10000) $maxz = "0".$max;
			if ($max < 1000) $maxz = "00".$max;
			if ($max < 100) $maxz = "000".$max;
			if ($max < 10) $maxz = "0000".$max;
			$reg_nr = "EPAS-".$skyrius."-".$maxz; 
			
			 $naud_el_pastas =  $this->session->naud_email;  				
			
			$this->Registras_Model->save_registras($reg_nr,$date,$pasirinktas,$tipas,$file,$ip_trimmed, $naud_el_pastas);
			
		
			$pdf = new \setasign\Fpdi\Fpdi();
			$data = date("Y-m-d");
			
					$pageCount = $pdf->setSourceFile($destination);
		for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
		    // import a page
		    $templateId = $pdf->importPage($pageNo);

		    $pdf->AddPage();
		    // use the imported page and adjust the page size
		    $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
		if($pageNo == 1) {
		    $pdf->SetFont('Helvetica', '', 8);  //$pdf->SetFont('Arial','B',14);
		    $pdf->SetXY(25, 5);
		    $pdf->Write(8, $data . ' ' . $reg_nr);
			}
		}//for

		//$pdf->Output();
		$pdf->Output('F', $destination);


		
			}//if result
			
	
 	}//if is uploaded file
 	
 	else {             
 	 $this->session->set_flashdata('upload_klaida', "Įkėlimo klaida!"); 
        
        // $this->load->view('beparaso');
        redirect(site_url(strtolower(__CLASS__)));
 	}
 
      
        }//for
        
         //Išsiųsti el. laišką
         
         $emess = "Gerb. $sauksm,\n\n";
        
        
 if($file_count>1)
$emess .= "Pranešame, kad per Valstybinio patentų biuro (VPB) elektroninių paslaugų sistemą EPAS (https://www.epaslaugos.lt/portal/external/services/authentication/v1/?service_id=0901acbe8068fede) Jums išduota  $file_count  PDF dokumentai (-ų). \n";
else
$emess .= "Pranešame, kad per Valstybinio patentų biuro (VPB) elektroninių paslaugų sistemą EPAS (https://www.epaslaugos.lt/portal/external/services/authentication/v1/?service_id=0901acbe8068fede) Jums išduotas PDF dokumentas. \r\n\r\n";

$emess .= "Išsamią informaciją apie VPB elektronines paslaugas rasite tinklalapyje vpb.lrv.lt. \r\n\r\n";
$emess .= "Prašome į šį el. laišką neatsakyti. \r\n\r\n";

$emess .= "Pagarbiai\r\nVALSTYBINIS PATENTŲ BIURAS\r\n\r\n";

$subj = "Valstybinis patentų biuras";
       
   
    
    //codeigniter mail:   veikia
	
	$config['protocol'] = 'smtp';
	$config['smtp_user'] = 'i0080bgq';
	$config['smtp_pass'] = 'ZuWMOq03';
	$config['smtp_host'] = 'outmail.is.lt';
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	
	

	$this->email->initialize($config);
         
       

	$this->email->from('v@vpb.gov.lt', 'VPB');
	$this->email->to($pasirinktas);  
	$this->email->cc('gg@gmail.com'); 
	$this->email->bcc('vin@vpb.gov.lt');

	$this->email->subject($subj);
	$this->email->message($emess);

	if ($this->email->send())
	 $this->session->set_flashdata('isduota', "Išduota $file_count dokumentas (-ai): $isduoti"); 
       else {
        $this->session->set_flashdata('upload_klaida', "Nepavyko išsiųsti laiško!");
       
      echo print_r($this->email->print_debugger(), true); exit();
      }
     
	redirect(site_url(strtolower(__CLASS__)));
    // end codeingiter mail        
           
       
}//upload	
	
	function sauksm ($str)
	{
	$sauks = $str;
	if (preg_match("/as$/", $str))  $sauks = preg_replace("/as$/", "ai", $str);
	if (preg_match("/AS$/", $str))  $sauks = preg_replace("/AS$/", "AI", $str);

	if (preg_match("/is$/", $str))  $sauks = preg_replace("/is$/", "i", $str);
	if (preg_match("/IS$/", $str))  $sauks = preg_replace("/IS$/", "I", $str);

	if (preg_match("/ys$/", $str))  $sauks = preg_replace("/ys$/", "y", $str);
	if (preg_match("/YS$/", $str))  $sauks = preg_replace("/YS$/", "Y", $str);

	if (preg_match("/us$/", $str))  $sauks = preg_replace("/us$/", "au", $str);
	if (preg_match("/US$/", $str))  $sauks = preg_replace("/US$/", "AU", $str);

	if (preg_match("/ė$/", $str))  $sauks = preg_replace("/ė$/", "e", $str);
	if (preg_match("/Ė$/", $str))  $sauks = preg_replace("/Ė$/", "E", $str);

	return $sauks;
	}//sauks
	
	
	
	
}//class
