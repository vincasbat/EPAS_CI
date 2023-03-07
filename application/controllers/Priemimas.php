<?php
class Priemimas extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Priemimas_Model');
	 $this->load->library('zip');
	 $this->load->library('session');
	}
	
	
	
	
	public function index()
	{
	$this->load->view('priemimas');
	}
		
	public function get_dokai()
	{
	//$result=$this->Priemimas_Model->gauti();
	echo json_encode($this->Priemimas_Model->gauti());
	}	
	
	
	public function zip() 
	{
	$id=$this->input->get('dokid');  
	
	$prasymas = $this->Priemimas_Model->prasymas($id);
	if (isset($prasymas)) {
	$pastabos = $prasymas->pastabos;
	$naud_email = $prasymas->naud_email;
	$dok_kelias = $prasymas->dok_kelias;
	$ip = $prasymas->ip;
	} else {
	$pastabos = "";
	$naud_email = "";
	$ip = "";
	$dok_kelias = "";
	}
	
	$pareiskejas =   $this->Priemimas_Model->pareiskejas($naud_email);
	if (isset($pareiskejas)) {
	$par = $pareiskejas->pareiskejas;
	$par_duom = $pareiskejas->par_duom;
	} else {
	$par = "";
	$par = "";
	}
	
	
	
	$mokejimas =   $this->Priemimas_Model->mokejimas($id);
	if (isset($mokejimas)) {
	$moketojas = $mokejimas->moketojas;
	$suma = $mokejimas->suma;  
	$data = $mokejimas->mok_data;
	if($data<'2015.01.01') $suma .= ' LT'; else $suma .= ' EUR';
	$mok = "Mokėjimmas per EPAS: " . $moketojas . ' ' . $suma . ' ' . $data . "\r\n\r\n";
	}  else {
	$moketojas = "";
	$suma = "";
	$data = "";
	$mok = "";
	}
	
	
	$file_names = array();


	$failai = glob(FCPATH.'/assets/dnl/*'); 
	foreach($failai as $file){   
	    if(is_file($file))
	    unlink($file); 
	}
	
	$myfile = fopen(FCPATH."/assets/dnl/pastabos.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $ip."\r\n\r\n");
	fwrite($myfile, $par."      ");
	fwrite($myfile, $par_duom."\r\n\r\n");
	fwrite($myfile, $mok);
	fwrite($myfile, $pastabos);
	fclose($myfile);
	
	
	
	
	$this->zip->read_file(FCPATH."/assets/dnl/pastabos.txt");
	$kelias = FCPATH."/assets/uploaded_files/".$dok_kelias;
	$this->zip->read_file($kelias);
	
	
	
	$kitifailai = $this->Priemimas_Model->kiti($id);   
	
	
	if (isset($kitifailai)) {
		foreach ($kitifailai as $kel)
		{   
		$visas_kelias = FCPATH. '/assets/uploaded_files/'.  $kel['dok_kelias'];
		
		 $this->zip->read_file($visas_kelias);
		}
	} //if
		

	$filename = $id . ".zip";
        $this->zip->download($filename);
	
		
	}//zip
	
	
	
	
	
	public function word() 
	{
	$id=$this->input->get('dokid');  
	
	$prasymas = $this->Priemimas_Model->prasymas($id);
	if (isset($prasymas)) {
	$pastabos = $prasymas->pastabos;
	$naud_email = $prasymas->naud_email;
	$ip = $prasymas->ip;
	} else {
	$pastabos = "";
	$naud_email = "";
	$ip = "";
	}
	
	$pareiskejas =   $this->Priemimas_Model->pareiskejas($naud_email);
	if (isset($pareiskejas)) {
	$par = $pareiskejas->pareiskejas;
	$par_duom = $pareiskejas->par_duom;
	} else {
	$par = "";
	$par = "";
	}
	
	
	
	
	
	$mokejimas =   $this->Priemimas_Model->mokejimas($id);
	if (isset($mokejimas)) {
	$moketojas = $mokejimas->moketojas;
	$suma = $mokejimas->suma;  
	$data = $mokejimas->mok_data;
	if($data<'2015.01.01') $suma .= ' LT'; else $suma .= ' EUR';
	}  else {
	$moketojas = "";
	$suma = "";
	$data = "";
	}
	
	
	
	
	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	
	$phpWord->setDefaultParagraphStyle(
    array(
        'align'      => 'left',
        'spaceBefore' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(1),
        'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(1),
        'spacing'    => 10,
        )
    );
	
	
	
	$section = $phpWord->addSection();
	$header = $section->addHeader();
	$textrunh = $header->addTextRun();
	$textrunh->addText('  ');
	$textrunh->addImage(FCPATH.'/assets/img/epas.png', array('wrappingStyle' => 'inline', 'width'=>40, 'height'=>20));
	$textrunh->addText('    Elektroninių paslaugų sistema');
	$section->addLine(['weight' => 1, 'width' => 480, 'height' => 0]);
	
	
	$fontStyle = new \PhpOffice\PhpWord\Style\Font();
	$fontStyle->setBold(false);
	$fontStyle->setName('Arial');
	$fontStyle->setSize(8);
	
	
	
	

	$footer = $section->addFooter();
	
 $textrunf = $footer->addTextRun();
 $textrunf->addText('Kalvarijų g. 3, LT-09310, Vilnius, kodas 188708943, tel. (8 5) 278 02 90, faks. (8 5) 275 0723, el. paštas info@vpb.gov.lt', $fontStyle);
 

	//$textrun = $section->addTextRun();
	$table = $section->addTable();
	$table->addRow();  $table->addCell(1500)->addText("Prašymo Nr. "); $table->addCell(8000)->addText($id);
	$table->addRow();  $table->addCell(1500)->addText("PNO Nr. "); $table->addCell(8000)->addText($ip, ['bold' => true]);
	$table->addRow();  $table->addCell(1500)->addText("Pareiškėjas"); $table->addCell(8000)->addText($par . ',  ' .  $par_duom);
	$table->addRow();  $table->addCell(1500)->addText("Mokėtojas"); $table->addCell(8000)->addText("$moketojas");
	$table->addRow();  $table->addCell(1500)->addText("Suma"); $table->addCell(8000)->addText($suma);
	$table->addRow();  $table->addCell(1500)->addText("Data");  $table->addCell(8000)->addText($data);

	
	 $section->addTextBreak(2);


$section = $phpWord->addSection(['breakType' => 'continuous', 'colsNum' => 2]);




	function cmp($a, $b)
	{
	$am = explode(":", $a);
	$bm = explode(":", $b);
        return $am[1]>$bm[1];
	}

	function cmp2($a, $b) 	{ return $a->metai > $b->metai;}

	if((substr_count($pastabos, ':')>1) && !strpos($ip, 'CSV')) {
	$pratesimai = explode(" ", $pastabos);
	$dvitaskiai =  substr_count($pratesimai[0], ':');				
	usort($pratesimai, "cmp");

	
	$table = $section->addTable();

	$table->addRow('', array('tblHeader' => true));  
	$table->addCell(800)->addText("Eil. Nr.", ['bold' => true]); $table->addCell(1300)->addText("Patento Nr.", ['bold' => true]); $table->addCell(900)->addText("Metai", ['bold' => true]); $table->addCell(900)->addText("Suma", ['bold' => true]); $table->addCell(800)->addText("Info", ['bold' => true]); 

	for ($i=0; $i<count($pratesimai); $i++)
	{
	 $eil = explode(":", $pratesimai[$i]);

	if (isset($eil[3])) $info = $eil[3]; else $info = "";
	$table->addRow();  
	$table->addCell(500)->addText($i+1); $table->addCell(1500)->addText($eil[0]); $table->addCell(900)->addText($eil[1]); $table->addCell(900)->addText($eil[2]); $table->addCell(900)->addText($info); 
	}//for

	}//if not csv


if((substr_count($pastabos, ':')>1) && strpos($ip, 'CSV')) {

$pratesimai = json_decode($pastabos);
usort($pratesimai, "cmp2");



	$table = $section->addTable();

	$table->addRow('', array('tblHeader' => true));  
	$table->addCell(800)->addText("Eil. Nr.", ['bold' => true]); $table->addCell(1300)->addText("Patento Nr.", ['bold' => true]); $table->addCell(900)->addText("Metai", ['bold' => true]); $table->addCell(900)->addText("Suma", ['bold' => true]); $table->addCell(800)->addText("Info", ['bold' => true]); 


for ($i=0; $i<count($pratesimai); $i++)
{
$eil =  $pratesimai[$i];
if(isset($eil->info)) $info = $eil->info; else  $info = '';
$table->addRow();  
$table->addCell(800)->addText($i+1); $table->addCell(1300)->addText($eil->patnr); $table->addCell(900)->addText($eil->metai); $table->addCell(900)->addText(number_format($eil->suma, 2, '.', '')); $table->addCell(800)->addText($info); 
}//for
}//if csv



 
	

 $section->addTextBreak(1);
 
 /*
	$rows = 10;
	$cols = 5;
	$section->addText('Basic table', ['size' => 16, 'bold' => true]);
	 
	$table = $section->addTable();
	for ($row = 1; $row <= 8; $row++) { $table->addRow();
	    for ($cell = 1; $cell <= 5; $cell++) { $table->addCell(1750)->addText("Row {$row}, Cell {$cell}");
	    }
	}
	 
	$section->addTextBreak(2);
	// Adding Text element with font customized using explicitly created font style object...
	$fontStyle = new \PhpOffice\PhpWord\Style\Font();
	$fontStyle->setBold(false);
	$fontStyle->setName('Arial');
	$fontStyle->setSize(8);
	$myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
	$myTextElement->setFontStyle($fontStyle);
	
*/	
	
	 $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	 
	//$objWriter->save("$id.docx");
	
	//--------------------
	
	
	$filename=$id.'.docx'; //save our document as this file name
	header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	$objWriter->save('php://output');
	
	


	}
	
	
	
	
	
	
	}//class
