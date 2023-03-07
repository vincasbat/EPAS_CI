<?php
class Registras_Model extends CI_Model 
{

function get_totalbynaud($adresatas)
{
$query = $this->db->query("SELECT reg_nr FROM siunc_registras where adresatas = '$adresatas'  ");
	return $query->num_rows();
}


function displayrecordspaged($adresatas, $limit, $start)
	{
	$query=$this->db->query("SELECT reg_ai, reg_nr, data, adresatas, CONCAT(LEFT(naud_vardas, 1), '. ', naud_pavarde) prasytojas, dokumentas, kelias,  pno, isdave  FROM siunc_registras, naudotojai where siunc_registras.adresatas=naudotojai.naud_email AND adresatas = '$adresatas'  ORDER by reg_ai desc LIMIT $start, $limit");
	return $query->result();
	}



function displayrecords()
	{
	$query=$this->db->query("SELECT reg_ai, reg_nr, data, adresatas, CONCAT(LEFT(naud_vardas, 1), '. ', naud_pavarde) prasytojas, dokumentas, kelias,  pno, isdave  FROM siunc_registras, naudotojai where siunc_registras.adresatas=naudotojai.naud_email  ORDER by reg_ai desc LIMIT 500");
	return $query->result();
	}
	
function deleterecord($id)
	{
	$this->db->query("DELETE FROM siunc_registras WHERE reg_ai = $id");
	}
	
	
	function getpath($id)
	{
	 $query=$this->db->query("select kelias from siunc_registras WHERE reg_ai = $id");
     if($query->num_rows() > 0) { 
     $row = $query->row();
	return $row->kelias;
	} else return "Nerasta";
	}
	
	
function displayrecords_where($where)
	{
	$query=$this->db->query("SELECT reg_ai, reg_nr, data, adresatas, CONCAT(LEFT(naud_vardas, 1), '. ', naud_pavarde) prasytojas, dokumentas, kelias, pno, isdave FROM siunc_registras, naudotojai where siunc_registras.adresatas=naudotojai.naud_email " . $where . " order by reg_ai desc LIMIT 400");
	
	return $query->result();
	}
	
	
	function maksregai() { 
	       $query=$this->db->query("SELECT MAX(reg_ai) AS maks FROM siunc_registras");
		if($query->num_rows() > 0) { 
	     $row = $query->row();
		return $row->maks;
	} else return "Klaida";
        } 
        
        
       
        function save_registras($reg_nr,$data,$pasirinktas,$tipas,$file,$ip_trimmed, $naud_el_pastas)
	{
	 $query = "INSERT INTO `siunc_registras` (`reg_nr`, `data`, `adresatas`, `dokumentas`, `kelias`,  `pno`, `isdave`) VALUES ('$reg_nr','$data','$pasirinktas','$tipas','$file','$ip_trimmed', '$naud_el_pastas')";
	 $this->db->query($query);
	}  
	
	
	
	//$this->Registras_Model->save_registras_suparasu($reg_nr,$data,$email,$doktipas,$filename,$pno, $naud_el_pastas, $signingToken);
	
	// $sql = "INSERT INTO `siunc_registras`(`reg_nr`, `data`, `adresatas`, `dokumentas`, `kelias`, `dok_id`, `pno`, `isdave`, `token`) VALUES ('$reg_nr','$data','$email','$doktipas','$filename','$prasymas','$pno', '$naud_el_pastas', '$signingToken')";

        
         function save_registras_suparasu($reg_nr,$data,$pasirinktas,$tipas,$file,$ip_trimmed, $naud_el_pastas, $signingToken)
	{
	 $query = "INSERT INTO `siunc_registras` (`reg_nr`, `data`, `adresatas`, `dokumentas`, `kelias`,  `pno`, `isdave`, `token`) VALUES ('$reg_nr','$data','$pasirinktas','$tipas','$file','$ip_trimmed', '$naud_el_pastas', '$signingToken')";
	 $this->db->query($query);
	}  
        
        
	
	
	
	function isdavejai() { 
	       $query=$this->db->query("select CONCAT(naud_pavarde, ' ', naud_vardas) isdavejas, naud_email from naudotojai WHERE naud_grupe <> 'par' order by naud_pavarde");
		return $query->result();
           } 
	
	
	function adresatai() { 
       $query=$this->db->query("select CONCAT(naud_pavarde, ' ', naud_vardas) adresatas, naud_email from naudotojai order by naud_pavarde");
	return $query->result();
        
    } 
    
    
    function isdavejas($id) { 
      $query=$this->db->query("select CONCAT(LEFT(naud_vardas, 1), '. ', naud_pavarde) AS isdav  from naudotojai WHERE naud_email = '$id'");
     if($query->num_rows() > 0) { 
     $row = $query->row();
	return $row->isdav;
	} else return "Nerasta";
     } 
    
    
    
    function dok_pagal_tokena($token) 
    {
  $sql = "SELECT kelias, adresatas, LEFT(naud_vardas, 1) as vardas, naud_pavarde, pno, reg_nr FROM siunc_registras, naudotojai WHERE adresatas = naudotojai.naud_email AND token = '$token'";
    $query=$this->db->query($sql);
	return $query->row();
    }  
    
    
    function get_registras($start,   $end ) {
    
	//pagal eksperta
	$query=$this->db->query("SELECT count(*) as isdokai, CONCAT(LEFT(naud_vardas, 1), '. ', naud_pavarde) AS isdavejas   FROM siunc_registras INNER JOIN naudotojai ON siunc_registras.isdave = naudotojai.naud_email WHERE  data >= '$start' AND data <= '$end' GROUP BY isdavejas  ORDER BY isdokai desc");

	$resulteksp = $query->result();

$n=1;
$dokai = array();
   foreach ($resulteksp as $row)
{
       foreach($row as $field => $value)
	{
	  $dokai[$n][$field]=$value;
	}
	$n++;
}
   
$resp = array();
$count = 0;
$kiti = 0;

$n_dokai = sizeof($dokai);
for ($i=1;$i<=$n_dokai;$i++) {

	if($count>5) {
	$kiti = $kiti + intval($dokai[$i]['isdokai']);
	
                 } 
	else 
	{
		$resp[$count] = array('donors' => intval($dokai[$i]['isdokai']), 'location'=> $dokai[$i]['isdavejas'] );

	}
$count++;
}//for
if($count>5) {
$resp[6] = array('donors' => $kiti, 'location' => 'Kiti' );
}


//pagal adreasata
$query=$this->db->query("SELECT count(*) as isdokai, CONCAT(LEFT(naud_vardas, 1), '. ', naud_pavarde) AS gavejas   FROM siunc_registras INNER JOIN naudotojai ON siunc_registras.adresatas = naudotojai.naud_email WHERE  data >= '$start' AND data <= '$end' GROUP BY gavejas ORDER by isdokai DESC");
unset($dokai);
$dokai = array();   

	$resultadr = $query->result();

$n=1;
   foreach ($resultadr as $row)
{
       foreach($row as $field => $value)
	{
	  $dokai[$n][$field]=$value;
	}
	$n++;
}



$resp2 = array();
$count = 0;
$kiti = 0;

$n_dokai = sizeof($dokai);
for ($i=1;$i<=$n_dokai;$i++) {

	if($count>5) {
	$kiti = $kiti + intval($dokai[$i]['isdokai']);
	
                 } 
	else 
	{
		$resp2[$count] = array('donors' => intval($dokai[$i]['isdokai']), 'location'=> $dokai[$i]['gavejas'] );

	}
$count++;
}//for
if($count>5) {
$resp2[6] = array('donors' => $kiti, 'location' => 'Kiti' );
}



$items = array();
$items['isdavejai'] = $resp;
$items['gavejai'] = $resp2;

$chartdata = array();
$chartdata['ChartData'] = $items;

return $chartdata;

    
    
    }//func
    
    
    
    public function get_ataskaitos($start_week, $end_week) {
    $query=$this->db->query("SELECT COUNT(*) AS isduota FROM siunc_registras WHERE data >= '$start_week' AND data <= '$end_week' ");
    return $query->result();
    }//func
    
    
    
	
	
	
	
	

}//class
