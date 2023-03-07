<?php

class Suparasu extends CI_Controller 
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
	
	//$result['adresatai']=$this->Registras_Model->adresatai();
	//$this->load->view('suparasu', $result);
	
	//   ----------- conf --------------

	$apiUrl = 'https://gateway.dokobit.com';
	$accessToken = 'dgVD53I4P0zHDqxpXlefxt';
	$postbackUrl = 'https://epaslaugostest.vpb.lt/index.php/signpostback';

	//darbinis:
	//https://gateway.dokobit.com
	//dgVD53I4P0zHDqxpXlefxt

	//testinis:
	//$apiUrl = 'https://gateway-sandbox.isign.io';
	//$accessToken = 'test_KRX7A5NaQ3Tk3NLRHFWJ';

 //   ----------- end conf --------------

$body = file_get_contents('php://input');
$params = json_decode($body, true);



/**
 * Write log
 */
$log = '[' . date('Y-m-d H:i:s') . '] ' . '\n';
$log .= $body . '\n';
$log .= print_r($params, true);
$this->writeLog($log);
 
if ($params['action'] == 'signer_signed') {
    // One of the signers has signed document
    
    // ... you can download signed file 
    // or just use as notification...
    
} elseif ($params['action'] == 'signing_completed') {
    // All signers assigned to signing has signed document

    // $accessToken - API access token
$url = $params['file'] . '?access_token=' . $accessToken;
$token = $params['token'];
$this->writeLog("tokenas: ".$token);
    // Download signed file
   $this-> downloadFile($url, $token);
}

$this->writeLog('End.');



	
	}//end index


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
}



/**
 * Download signed file helper
 * @param string $url
 */
function downloadFile($url, $token) {
    $this->writeLog("Downloading signed file from " . $url);

    // Using curl to download file
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_SSLVERSION, 3);
curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    $error = curl_error($ch);

    // Log errors
    if ($error) {
        $this->writeLog("Error: " . print_r($error, true));
        exit;
    }

    // Save downloaded file
   // $name = 'signed_' . mt_rand() . '.pdf';


// -------  Suzinome failo varda:

 $row =   $this->Registras_Model->dok_pagal_tokena($token);
 
 if (isset($row))
{
        $name = $row->kelias;
        $pno = $row->pno;
        $regnr = $row->reg_nr;
}


//randame skyrių, dok. tipą:  3124_1636389_20150623_ISR_IS.pdf
$masyvas = explode("_",  $name);
$doktip = $masyvas[3];
$doktipas = "dokumentą";
switch ($doktip) {
    case "ISR":
        $doktipas = "išrašą";
        break;
    case "SPR":
        $doktipas = "sprendimą";
        break;
    case "PAZ":
        $doktipas = "pažymą";
        break;
    case "LIU":
        $doktipas = "liudijimą";
        break;
    case "PRA":
        $doktipas = "pranešimą";
        break;
    case "KIT":
        $doktipas = "dokumentą";
        break;
    default:
         $doktipas = "dokumentą";
}



$skyr = end($masyvas);
$skyri =  explode(".",  $skyr);
$skyriu = $skyri[0];
$skyrius = "skyrius";

switch ($skyriu) {
    case "IS":
        $skyrius = "Išradimų skyrius";
        break;
    case "PZ":
        $skyrius = "Prekių ženklų ir dizaino skyrius";
        break;
    case "AP":
        $skyrius = "Apeliacinis skyrius";
        break;
    case "PR":
        $skyrius = "Priėmimo skyrius";
        break;
   
    default:
         $skyrius = "skyrius";
}

$adresatas =  $row->adresatas;
$vardas =   $row->vardas;
$pavarde =   $row->naud_pavarde;
$sauksm = $vardas . '. ' .  $this->sauksm($pavarde);
 




 $this->writeLog("name: ".$name);
    $path =  FCPATH . 'assets/pazymos/' . $name;
    $this->writeLog("Saving file to " . $path);
    file_put_contents($path, $data);
    
curl_close($ch);


//Siunčiame pranešimą adresatui:

	$config['protocol'] = 'smtp';
	$config['smtp_user'] = 'i0080bgq';
	$config['smtp_pass'] = 'ZuWMOq03';
	$config['smtp_host'] = 'outmail.is.lt';
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	
	

	$this->email->initialize($config);



$emess = "Gerb. $sauksm,\n\n";
$emess .= "Pranešame, kad  Valstybinio patentų biuro (VPB) $skyrius per elektroninių paslaugų sistemą EPAS (https://www.epaslaugos.lt/portal/external/services/authentication/v1/?service_id=0901acbe8068fede)  Jums išdavė  $doktipas (registracijos Nr. $regnr, pramoninės nuosavybės objekto Nr. $pno). \r\n\r\n";

$emess .= "Išsamią informaciją apie VPB elektronines paslaugas rasite tinklalapyje www.vpb.lt. \r\n\r\n";
$emess .= "Prašome į šį el. laišką neatsakyti. \r\n\r\n";

$emess .= "Pagarbiai\r\nVALSTYBINIS PATENTŲ BIURAS\r\n\r\n";

$subj = "Valstybinis patentų biuras";


$this->email->from('vincas.batulevicius@vpb.gov.lt', 'VPB');
	$this->email->to($adresatas);  
	$this->email->cc('vincasbat@gmail.com');  //vida.mikutiene@vpb.gov.lt
	$this->email->bcc('vincas.batulevicius@vpb.gov.lt');

	$this->email->subject($subj);
	$this->email->message($emess);

	if ($this->email->send())
	// $this->session->set_flashdata('isduota', "Išduota $file_count dokumentas (-ai): $isduoti"); 
       else {
       // $this->session->set_flashdata('upload_klaida', "Nepavyko išsiųsti laiško!");
       
      echo print_r($this->email->print_debugger(), true); exit();
      }


   
    
}//end function downloadFile 



/**
 * Write log helper
 * @param mixed $data
 */
function writeLog($data) {
    $path =  './postback.log';
    if (is_writable($path)) {
        file_put_contents($path, $data . '\n', FILE_APPEND);
    }
}



	
}//class
