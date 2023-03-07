<?php
class Mokejimai_Model extends CI_Model 
{
		
		
	function displayrecords($limit, $start)
	{
	 
	$query=$this->db->query("SELECT mok_id, dok_id, suma, paskirtis, banko_pranesimas, LEFT(mokejimo_data, 10) AS mok_data, moketojas, CONCAT(LEFT(naud_vardas, 1), '. ', naud_pavarde) AS pras, gavejas, banko_pranesimas, saskaita  FROM mokejimai, naudotojai where mokejimai.naud_email = naudotojai.naud_email ORDER BY mok_id desc LIMIT $start, $limit");
	return $query->result();
	}
	
	
	public function get_total() 
    {
	$query = $this->db->query("SELECT mok_id  FROM mokejimai, naudotojai where mokejimai.naud_email = naudotojai.naud_email ORDER BY mok_id desc ");
	return $query->num_rows();
    }



public function displaymyrecords($naud_email)
	{
	$query=$this->db->query("SELECT mok_id, dok_id, suma, paskirtis, banko_pranesimas, LEFT(mokejimo_data, 10) AS mok_data, moketojas, CONCAT(LEFT(naud_vardas, 1), '. ', naud_pavarde) AS pras, gavejas, banko_pranesimas, saskaita  FROM mokejimai, naudotojai where mokejimai.naud_email = naudotojai.naud_email AND mokejimai.naud_email = '$naud_email' ORDER BY mok_id desc LIMIT 100");
	return $query->result();
	}
	
	
	public function getmytotal($naud_email){
	$query = $this->db->query("SELECT mok_id  FROM mokejimai, naudotojai where mokejimai.naud_email = naudotojai.naud_email AND mokejimai.naud_email = '$naud_email' LIMIT 100");
	return $query->num_rows();
		}
		
		
		
	public function  deco($str) {
	 $blo = array("Ä–", "Å¾", "Å³", "Ä…","Å¡","ÄŒ","Å²");
	 $ger   = array("Ė", "ž", "ų", "ą","š","Č","Ų");
	 
	 return  str_replace($blo,$ger,$str);
	 
	 }		
	
	
	
}//class







