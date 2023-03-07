<?php
class Skaiciuokle extends CI_Controller 
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
	$this->load->view('skaiciuokle');
	}
	
	
	public function csv()
	{
	//tikrinti  ar turi teises
	
	$json = file_get_contents('php://input');
	$data = json_decode($json);
	$msg = "";
	$suma  = 0;
	$sarasas = "\r\n";
	$metai = "";
	foreach ($data as $prates) {
	 $suma  += $prates->suma;
	$sum =   number_format($prates->suma, 2, ".", "");
	 $sarasas .= "$prates->patnr\t\t$prates->metai\t$sum  EUR \r\n";
	}
	$suma = number_format($suma, 2, ".", "");
	 
	$dok_id = "";
	$ip = count($data) . " CSV. $suma  EUR.";

	$naud_el_pastas = $this->session->naud_email;

				$from_ip = $_SERVER["REMOTE_ADDR"];
		 					
		 		$dok_id = $this->Prasymai_Model->skaiciuokle($naud_el_pastas,$json,$from_ip,$ip);
		 		
					
	if($dok_id) {

	    $msg =  "Prašymas sėkmingai priimtas. Prašymo numeris $dok_id.";
				



	$v_pav = explode(" ", $this->session->naud);
	$pare = "";
	foreach ($v_pav as $value) {
	    $pare .= " ".$this->sauksm($value); 
	}
	$pare = trim($pare);


		$emess = "Gerb. $pare,\r\n\r\n";
		 $emess .= "Jūsų prašymas dėl pramoninės nuosavybės objektų sąrašo CSV formatu priimtas Valstybinio patentų biuro (VPB) elektroninių paslaugų sistemoje EPAS. Prašymo Nr. $dok_id. \n";
		$emess .= "Mokėtina suma $suma EUR. Pateiktų pratęsimų sąrašas:\r\n";
		$emess .= "$sarasas \r\n";
		$emess .= "Šis laiškas sukurtas automatiškai todėl į jį neatsakykite. \r\n\r\n";
		$emess .= "Pagarbiai\r\n\r\nValstybinio patentų biuro elektroninių paslaugų sistema EPAS\r\n\r\n";
		 $subj = "Gautas dokumentas";
/*
		$extra_header_str  = 'MIME-Version: 1.0' . "\r\n";
		$extra_header_str .= 'From: www@epaslaugos.vpb.lt' . "\r\n"; 
		$extra_header_str .= 'Content-type: text/plain; '  .  '  charset=UTF-8' . "\r\n";
		$extra_header_str .= 'CC: vida.mikutiene@vpb.gov.lt' . "\r\n";
		$extra_header_str .= 'BCC: vincas.batulevicius@vpb.gov.lt' . "\r\n";
		 $mailsend=mail("$naud_el_pastas","$subj","$emess", $extra_header_str);
		 
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
 
	
	
	
	
	 
	
		}  // if $result
			else 
			{
			$msg = "Nepavyko!";
			}




	 
	//$_SESSION['upl_dok_id'] = $dok_id;
	//$_SESSION['visosuma'] = $suma;
	//$_SESSION['pastabos'] = "CSV";

	 
	 
	 
	$atsakymas = array("rez" => "OK", "msg" =>  $msg);
	header('Content-Type: application/json');
	echo json_encode($atsakymas);
	}//csv
	
	
	public function pateikti()
	{
	
	//tikrinti ar prisijunges ir ar turi teise
	
	$ip = $this->input->post('ip');
	$ip = filter_var($ip, FILTER_SANITIZE_STRING); 
	$ip = trim($ip);

					$naud_el_pastas = $this->session->naud_email;
	$dok_id = "";

	$pastabos = $this->input->post('pastabos');
	$pastabos = filter_var($pastabos, FILTER_SANITIZE_STRING);   
	$from_ip = $_SERVER["REMOTE_ADDR"];
	
	$dok_id = $this->Prasymai_Model->skaiciuokle($naud_el_pastas,$pastabos,$from_ip,$ip);
			
	if($dok_id) {

   
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
/*
		$extra_header_str  = 'MIME-Version: 1.0' . "\r\n";
		$extra_header_str .= 'From: www@epaslaugos.vpb.lt' . "\r\n"; 
		$extra_header_str .= 'Content-type: text/plain; '  .  '  charset=UTF-8' . "\r\n";
		$extra_header_str .= 'CC: vida.mikutiene@vpb.gov.lt' . "\r\n";
		$extra_header_str .= 'BCC: vincas.batulevicius@vpb.gov.lt' . "\r\n";
		// $mailsend=mail("$naud_el_pastas","$subj","$emess", $extra_header_str);

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
 




		}  // if $dok_id
			

	//$_SESSION['upl_dok_id'] = $dok_id;

	$atsakymas = array("msg" =>  $dok_id );
	header('Content-Type: application/json');
	echo json_encode($atsakymas);

	}//pateikti
	
	
	
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
