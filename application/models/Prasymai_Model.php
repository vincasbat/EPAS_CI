<?php
class Prasymai_Model extends CI_Model 
{


function skaiciuokle($naud_el_pastas,$pastabos,$from_ip,$ip)
{
$sql = "INSERT INTO dokai (dok_kelias,pastabos, status_dabar, status_dabar_date, naud_email, dok_formos_kodas, from_ip, ip) VALUES ('-','$pastabos', 'Gautas', NOW(), '$naud_el_pastas', 'Nenurodyta', '$from_ip', '$ip')";    
$query=$this->db->query($sql);

$dok_id = $this->db->insert_id();
			
$sql2 = "INSERT INTO dok_statusai (dok_id,statusID,status_date, naud_email) VALUES ($dok_id,'Gautas', NOW(), '$naud_el_pastas')"; 
$query2=$this->db->query($sql2);

return $dok_id;			 
}//skaiciuokle


function mokejimas($dok_id)
{
$sql = "SELECT  suma, paskirtis, banko_pranesimas, LEFT(mokejimo_data, 10) AS mok_data, moketojas FROM mokejimai WHERE dok_id = $dok_id  ORDER BY mok_id desc ";
$query=$this->db->query($sql);
 return $query->row();
}



function manoprasymas($dok_id){
$sql = "SELECT CONCAT(naud_vardas, ' ', naud_pavarde) AS prasytojas, DATE(status_dabar_date) AS dab_statuso_data, dok_id, dok_kelias, dokai.naud_email, ip, pastabos FROM dokai, naudotojai WHERE dokai.naud_email = naudotojai.naud_email  AND dok_id = $dok_id ";
$query=$this->db->query($sql);
 return $query->row();
}

function kitus($dok_id)
 {
 $sql = "SELECT file_id, dok_kelias FROM kiti_failai WHERE dok_id = $dok_id"; 
 $query=$this->db->query($sql);
 return $query->result(); 
 }

 function displaymyrecords($naud_email)
 {
 $sql = "SELECT CONCAT(naud_vardas, ' ', naud_pavarde) AS prasytojas, dok_id, dok_formos_kodas, mokestis, dok_kelias, dokai.naud_email,  status_dabar, DATE(status_dabar_date) AS dab_statuso_data, ip FROM dokai, naudotojai WHERE dokai.naud_email = naudotojai.naud_email AND dokai.naud_email = '$naud_email'   ORDER BY status_dabar_date desc LIMIT 200"; 
 $query=$this->db->query($sql);
 return $query->result(); 
 }

function up($path,$pastabos,$naud_el_pastas,$from_ip,$ip)
{
$sql = "INSERT INTO dokai (dok_kelias,pastabos, status_dabar, status_dabar_date, naud_email, dok_formos_kodas, from_ip, ip) VALUES ('$path','$pastabos', 'Gautas', NOW(), '$naud_el_pastas', 'Nenurodyta', '$from_ip', '$ip')";
$query=$this->db->query($sql);
return $this->db->insert_id();
}//up


function status($dok_id,$naud_el_pastas)
{
$sql = "INSERT INTO dok_statusai (dok_id,statusID,status_date, naud_email) VALUES ($dok_id,'Gautas', NOW(), '$naud_el_pastas')";  
$query=$this->db->query($sql);
}


function kiti($path,$dok_id) {
$sql = "INSERT INTO kiti_failai (dok_kelias, dok_id) VALUES ('$path', $dok_id)";
$query=$this->db->query($sql);
}



function prasymai() {

$sql = "SELECT CONCAT(naud_vardas, ' ', naud_pavarde) AS prasytojas, dok_id, dok_formos_kodas, mokestis, dok_kelias, dokai.naud_email, status_dabar, DATE(status_dabar_date) AS dab_statuso_data FROM dokai, naudotojai WHERE dokai.naud_email = naudotojai.naud_email ORDER BY status_dabar_date ";    

$query=$this->db->query($sql);

return $query->result_array();

}//func get_prasymai



function trinti($data)
{
if(count($data)>0) {    
			
			
       foreach ($data as $dok_id) {

 
  // $query = "SELECT dok_kelias FROM dokai WHERE dok_id = $dok_id";  
   $query=$this->db->query("select dok_kelias from dokai where dok_id = $dok_id");
   $row = $query->row();
	if (isset($row))  $dok_kelias = $row->dok_kelias;   else  $dok_kelias = "abc";
   
  
   $visas_kelias = realpath("./") . "/assets/uploaded_files/" . $dok_kelias;    
  	
 
// $fkelias = "/var/www/html/ep_ci/newfile.txt";
 //$myfile = fopen($fkelias, "a");  fwrite($myfile, $visas_kelias . "\r\n");  fclose($myfile);
 
  $this->db->query("delete  from dokai WHERE dok_id = $dok_id");  
   
  $this->db->query("delete  from dok_statusai WHERE dok_id = $dok_id");    
  
     
  // $fh = fopen($visas_kelias, 'w');
  // fclose($fh);  
  if(file_exists(  $visas_kelias ) ) unlink("$visas_kelias");    
   unset($visas_kelias);   

    
  
   // kiti failai:    ---------------------------------------------------------------------------------------------------- pr
   //Į masyvą įrašome trinamų failų id ir kelia:
  
   
   $query=$this->db->query("SELECT file_id, dok_kelias FROM kiti_failai WHERE dok_id = $dok_id");
  
  
  $n=1;
  
foreach ($query->result() as $row)
{
   $trinami_dokai[$n]['fid']= $row->file_id;
   $trinami_dokai[$n]['dkelias']= $row->dok_kelias;
    $n++;
}
  $trinami_dokai = [];
   $t_dokai = sizeof($trinami_dokai);
   for ($i=1;$i<=$t_dokai;$i++)
   {
   $file_id = $trinami_dokai[$i]['fid'];
   
   $dok_kelias = $trinami_dokai[$i]['dkelias'];
   $visas_kelias = realpath("./") . "/assets/uploaded_files/" . $dok_kelias; 
  // $fh = fopen($visas_kelias, 'w'); 
//fclose($fh);    
  if(file_exists(  $visas_kelias ) ) unlink("$visas_kelias");   
   } // for trinami visi dokai ir failai
   
   $this->db->query("delete  from kiti_failai WHERE dok_id = $dok_id");  
  
   // kiti failai: --------------------------------------------- pab

 
}//foreach
}// if count > 0

}// trinti






}//class



?>

