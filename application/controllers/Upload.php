<?php
class Upload extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Prasymai_Model');
	$this->load->library('session');
	$this->load->library('email');
	}
	
		
	
	public function index()
	{
	
	$this->load->view('upload');
	
	}//index
	
	
	public function up()
	{
	sleep(1);
	
	$naud_el_pastas = $this->session->naud_email;
	
	        $config['max_size'] = 1200;
               $this->load->library('upload', $config);
	$dest = FCPATH .'/assets/uploaded_files/';
				   
	$dir_metai_men = date("YM");
			if(!is_dir($dest.$dir_metai_men))     
			{
			   mkdir($dest.$dir_metai_men);
			}

 	$countfiles = count($_FILES['files']['name']);
  	$ad_day_time = date("dHis");
			
  $dok_id = 0;
 for($i=0;$i<$countfiles;$i++){
   
			$file = preg_replace('/[^a-z0-9. ]/i', '', $_FILES['files']['name'][$i]); 
			
			$len = strlen($file);
			if($len>30){ $file =  substr($file, $len - 30 );   }
    			$path = $dir_metai_men."/".$ad_day_time.$file;    
			$destination=$dest.$path;     				 
		       $temp_file = $_FILES['files']['tmp_name'][$i];
			     $result =  move_uploaded_file($temp_file,$destination);
			if   ($result)  
			{
			if($i==0)  { //pirmas failas
				
			$ip = $this->input->post('ip');
			$ip = filter_var($ip, FILTER_SANITIZE_STRING);
			$ip = trim($ip);
			$ip = str_replace(",", ", ", $ip);
			$pastabos = $this->input->post('pastabos');
			$pastabos = filter_var($pastabos, FILTER_SANITIZE_STRING);       
			$from_ip = $_SERVER["REMOTE_ADDR"];    //??????               
			$dok_id = $this->Prasymai_Model->up($path,$pastabos,$naud_el_pastas,$from_ip,$ip); //$dok_id = mysqli_insert_id($cxn);
			$this->Prasymai_Model->status($dok_id,$naud_el_pastas);
			
			

			


	$v_pav = explode(" ", $this->session->naud);
	$pare = "";
	foreach ($v_pav as $value) {
	    $pare .= " ".$this->sauksm($value); 
	}
	$pare = trim($pare);


		$emess = "Gerb. $pare,\r\n\r\n";
		 $emess .= "Jūsų prašymas dėl pramoninės nuosavybės objekto, kurio paraiškos, registracijos ar patento Nr. $ip, priimtas Valstybinio patentų biuro (VPB) elektroninių paslaugų sistemoje EPAS. Prašymo Nr. $dok_id. \n";
		 $emess .= "Prašymo vykdymo eigą galite sekti prisijungę prie VPB e.paslaugų sistemos EPAS skyrelyje „Mano prašymai“. ";
		 $emess .= "Jei turite klausimų,";
		 $emess .= " rašykite adresu vida.mikutiene@vpb.gov.lt arba skambinkite telefonu (8 5) 2780286.\r\n\r\n";     //?????
		$emess .= "Pagarbiai\r\n\r\nValstybinio patentų biuro elektroninių paslaugų sistema EPAS\r\n\r\n";
		$emess .= "Šis laiškas sukurtas automatiškai todėl į jį neatsakykite.";
		 $subj = "Gautas dokumentas";

	/*	$extra_header_str  = 'MIME-Version: 1.0' . "\r\n";
		$extra_header_str .= 'From: www@epaslaugos.vpb.lt' . "\r\n"; 
		$extra_header_str .= 'Content-type: text/plain; '  .  '  charset=UTF-8' . "\r\n";
		$extra_header_str .= 'CC: vida.mikutiene@vpb.gov.lt' . "\r\n";
		$extra_header_str .= 'BCC: vincas.batulevicius@vpb.gov.lt' . "\r\n";
	//$mailsend=mail("$naud_el_pastas","$subj","$emess",extra_header_str);	
	
	*/			
		
		
		
	 //codeigniter mail:   veikia
	
	$config['protocol'] = 'smtp';
	$config['smtp_user'] = 'i0080bgq';
	$config['smtp_pass'] = 'ZuWMOq03';
	$config['smtp_host'] = 'outmail.is.lt';
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	
	

	$this->email->initialize($config);
         
       

	$this->email->from('vincas.batulevicius@vpb.gov.lt', 'VPB');  //www@epaslaugos.vpb.lt ????
	$this->email->to($naud_el_pastas);  
	$this->email->cc('vincasbat@gmail.com');  //vida.mikutiene@vpb.gov.lt
	$this->email->bcc('vincas.batulevicius@vpb.gov.lt');

	$this->email->subject($subj);
	$this->email->message($emess);

	if (!$this->email->send())      {       
      echo print_r($this->email->print_debugger(), true); exit();
    }
     
	
    // end codeingiter mail        
 	
		
		
		
		
		
		
		
		
		
		
		
		
		
				
				
			} //if pirmas failas
			
			else {//kiti failai
				
				
				$this->Prasymai_Model->kiti($path,$dok_id);
					   
					 
				}	//else kiti failai
				
				
			
				
				
			}//if result
			else {  //nepavyko
				
				
			}
   
  
 }//for
 
 
  
//$_SESSION['upl_dok_id'] = $dok_id;

$ats = array("msg" => $dok_id);
header('Content-Type: application/json');
echo json_encode($ats);

	}//up
	
	
	
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
