<?php

define('REQUEST_GET', false);
define('REQUEST_POST', true);


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
	
	$result['adresatai']=$this->Registras_Model->adresatai();
	$this->load->view('suparasu', $result);
	}
	
	
	
	public function upload() 
	{
		//session:
		//$this->session->naud 
		//$this->session->grupe 
		//$this->session->naud_email
	
	$config['upload_path'] = FCPATH .'/assets/dtbs/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2200;
       
        $this->load->library('upload', $config);
        
        $pasirinktas = $this->input->post('pareiskejai');
        $tipas = $this->input->post('tipas');
               
        $annot = intval($this->input->post('annot'));  
	if(is_numeric($annot)) {
	if($annot<1)$annot = 1;
	if($annot>100)$annot = 1;
	} else $annot = 1;

        
        $ip = $this->input->post('ip');
        $ip = filter_var($ip, FILTER_SANITIZE_STRING);   
	$ip = trim($ip);
        
		

switch (@$_SESSION['grupe'])  //$this->session->grupe
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
 //header("Location: nera_teisiu.php");
  exit();
break;
}  //switch 


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

 
 $data = date("YmdHis");
 $ip_trimmed = str_replace(' ', '', $ip);
 $file_vardas = $pasirinktas . "_" . $ip_trimmed . "_" . $data . "_"  . $tipas . "_" . $skyrius .".pdf";
 
 		$destination = FCPATH .'/assets/dtbs/' . $file_vardas;
	        $temp_file = $_FILES['dokai']['tmp_name'];
			$res =  move_uploaded_file($temp_file,$destination);
			if   ($res)  {
			
							//	Pasirasymas:
	$file['name'] = $file_vardas; 
	$path =  FCPATH .'/assets/dtbs/'. $file_vardas;
	$file['digest'] = sha1_file($path);
	$file['url'] = base_url() . 'assets/dtbs/'. $file_vardas;
	$array = array( 'file' => $file  );
	$action = 'upload';
	$uploadResponse = $this->request($this->getApiUrlByAction($action), $array, REQUEST_POST);
		if ($uploadResponse['status'] != 'ok') {
	    	echo "File could not be uploaded. Please ensure that file URL is accessible from the internet:<br />";
	 	echo  $file['url'];
	    	exit();
		}
	
	$action = 'upload/status/' . $uploadResponse['token'];
	$statusResponse = '';
	
	$token_uploadResponse = array('token' => $uploadResponse['token']);
	while ($statusResponse === '' || $statusResponse['status'] == 'pending') {
	    $statusResponse = $this->request($this->getApiUrlByAction($action), $token_uploadResponse, REQUEST_GET);
	    sleep(2);
	}


	if (empty($statusResponse) || $statusResponse['status'] != 'uploaded') {
	    echo "Gateway API could not download the file. Please ensure that file URL is accessible from the internet.";
	    exit();
	}


	unset($file);
	$signers = array();
	$files = array();
	
	$file['token'] = $uploadResponse['token'];
	array_push($files, $file); // For 'pdf' type only one file is supported.

	$f = explode(".",  $file_vardas);
	$signingName = $f[0];    //Failo vardas (israsas, agreement..)   

	$signerUID = $this->session->naud_email; //'51001091072';  //arba asmens kodas? 
	$signer['id'] = $signerUID;

	$pieces = explode(" ", $this->session->naud);  
	
	//Registravimas:
 	$filename = $file_vardas;
	$fv = explode ('_', $filename); 
	$prasymas = $fv[0];                   //kai isduodamas dokumentas, cia bus prasytojo el pastas!!!!!
	$mas = explode ('.', $fv[4]);
	$skyrius=$mas[0];
	$extention=$mas[1];   //pdf, adoc,....
	$pno = $fv[1];
	$data = $fv[2];
	$doktipas = $fv[3];  //PAZ, KIT, LIUD, ISR	
	
	$max = $this->Registras_Model->maksregai();   
			$max++;
	if ($max < 100000) $maxz = "".$max;
	if ($max < 10000) $maxz = "0".$max;
	if ($max < 1000) $maxz = "00".$max;
	if ($max < 100) $maxz = "000".$max;
	if ($max < 10) $maxz = "0000".$max;
	$reg_nr = "EPAS-".$skyrius."-".$maxz;
	
	$action = 'signing/create';
	
	$reg_data = date('Y-m-d\TH:i:s');
	
	$naud_el_pastas =  $this->session->naud_email;
	
	$arr = array(

	'pdflt'=> array (  
		'level'=> 'pades-t',    'annotation' =>   array('page' => $annot) 
		),
		
	'postback_url' => $postbackUrl,
	'type' => 'pdflt',       
	'name' => 'Dokumento pasirašymas',
	'files' => array(
	    array(
		'token' =>   $uploadResponse['token']
         )
        ),
        
        'signers' => array(
    array(
        'id' =>  $naud_el_pastas,  
        'name' => $pieces[0],
	
        'surname' => end($pieces),
        'phone' => '',  
        'code' => '',  
        'position' => 'Ekspertas',
        'signing_purpose' => 'signature',  
	'signing_location' => 'Vilnius',
        'pdflt' => array(  	
             'reason' => 'Registracijos Nr. '.$reg_nr, 
             'registration' => array(
                'date' =>  $reg_data.'Z',  
                'number' => $reg_nr            
			),
		'annotation' => $annot > 1 ? array('text' => 'Išrašą patvirtino: ' . $this->session->naud . '\nData: ' . $reg_data . '\nRegistracijos Nr. ' .$reg_nr , 'page' => $annot) : NULL
   
           )//pdflt
        )//signers[0]
    )// signers
);  //$arr 
	
	
	$createResponse = $this->request($this->getApiUrlByAction($action), $arr, REQUEST_POST);

	if ($createResponse['status'] != 'ok') {
	    echo "Pasirašymas negalimas. <br /><br /><br /><br /><br /><br />";
	    exit();
	}
		
	$signingUrl = trim($apiUrl, '/') . "/signing/" . $createResponse['token'] . '?access_token=' . $createResponse['signers'][$signerUID];
	$signingToken = $createResponse['token'];
	
	$email = $prasymas;  //adresato el.pastas
	
	
	//Dar irasti tokena:
	
	$this->Registras_Model->save_registras_suparasu($reg_nr,$data,$email,$doktipas,$filename,$pno, $naud_el_pastas, $signingToken);
	
	// $sql = "INSERT INTO `siunc_registras`(`reg_nr`, `data`, `adresatas`, `dokumentas`, `kelias`, `dok_id`, `pno`, `isdave`, `token`) VALUES ('$reg_nr','$data','$email','$doktipas','$filename','$prasymas','$pno', '$naud_el_pastas', '$signingToken')";
	
	redirect("suparasu/parasas?if=$signingUrl"); // iframe
	//redirect("parasas?if=$signingUrl"); // iframe
	
		
	//echo "<iframe src='$signingUrl' height='1000' width='800' style='border:0px'>\n";  
	//echo   "<p>Your browser does not support iframes.</p>\n";
	//echo "</iframe>'\n";
	
	//session:
		//$this->session->naud 
		//$this->session->grupe 
		//$this->session->naud_email		
			
			// redirect(site_url(strtolower(__CLASS__)));
			//redirect('paraso_forma????');
			
			}//if res
 
 		else
 
		  {
		 $this->session->set_flashdata('klaida', 'Nepavyko įkelti dokumento'); 
		 redirect(site_url(strtolower(__CLASS__)));
		 }
		 
	 
	}//upload
	
	
	
	
	public function parasas() 
	{
	
	$result['langas']=$this->input->get('if');
	$this->load->view('parasas', $result);
	
	}//end parasas
	
	
	
	
	
	
	
	
	function getApiUrlByAction($action)
	{
	    global $apiUrl, $accessToken;
	    
	    return trim($apiUrl, '/') . '/api/' .  $action . '.json?access_token='.$accessToken;
	}





	
	function request($requestUrl, $fields = array(), $post = REQUEST_POST) {

	//function request($requestUrl, $fields = [], $post = REQUEST_POST) {
	    
	    $fields = http_build_query($fields);
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $requestUrl);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 180);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);      
	    if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		$requestHeaders = array(
		    'Content-Type: application/x-www-form-urlencoded; ',
		    'Content-Length: ' . strlen($fields),
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
	    }
	    $response = curl_exec($ch);
	    $result = json_decode($response, true);
	    if ($result ===  null) {
		$path =  FCPATH . 'assets/error.log';
		var_dump($response);
		file_put_contents($path, $response);
		echo "\nGOT NULL RESULT. Actual response: $path\n";
		echo curl_error($ch);
	    }
	    curl_close($ch);
	    return $result;
	}//func request
	
	
	
	}//class
	
	?>
