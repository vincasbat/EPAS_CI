<?php
class Naudotojai_Model extends CI_Model 
{

	function pakeistiemail($senas, $naujas)
	{
	
	$this->db->query("UPDATE atsiliepimai SET naud_email='$naujas' WHERE naud_email='$senas'"); 
	
	$this->db->query("UPDATE dokai SET naud_email='$naujas' WHERE naud_email='$senas'"); 

	$this->db->query("UPDATE dok_statusai SET naud_email='$naujas' WHERE naud_email='$senas'");  

	$this->db->query("UPDATE mokejimai SET naud_email='$naujas' WHERE naud_email='$senas'");  

	$this->db->query("UPDATE naudotojai SET naud_email='$naujas' WHERE naud_email='$senas'"); 

	$this->db->query("UPDATE siunc_registras SET adresatas='$naujas' WHERE adresatas='$senas'"); 
 
	}




	function save_naudotojas($naud_vardas, $naud_pavarde, $naud_passw, $naud_email, $naud_telef, $naud_adr, $naud_org, $naud_grupe)
	{
	$today = date("Y-m-d");
 $query = "INSERT INTO naudotojai (naud_vardas, naud_pavarde, naud_passw, naud_sukurimo_data, naud_email, naud_telef, naud_adr, naud_org, naud_grupe) VALUES
('$naud_vardas','$naud_pavarde',md5('$naud_passw'), '$today', '$naud_email','$naud_telef','$naud_adr','$naud_org', '$naud_grupe')";
 mysqli_query($cxn,$sql);
	$this->db->query($query);
	}  

	
	function displayrecords()
	{
	$query=$this->db->query("SELECT CONCAT(naud_vardas, ' ', naud_pavarde) AS naudotojas, DATE(naud_sukurimo_data) AS data, naud_email,  naud_telef, naud_adr, naud_ak, naud_grupe, grupe, naud_vardas, naud_pavarde, naud_passw, naud_org FROM naudotojai ORDER BY data ");
	return $query->result();
	}
	
	
	function deleterecord($id)
	{
	$this->db->query("delete  from naudotojai where naud_email='".$id."'");
	}
	
	
	
	function displayrecordById($n_email)
	{
	$query=$this->db->query("select * from naudotojai where naud_email='".$n_email."'");
	return $query->result();
	}
	
	
	function updaterecord($naud_vardas,$naud_pavarde,$naud_passw,$naud_telef,$naud_adr,$naud_org,$naud_grupe,$grupe, $n_email)
	{
	$sql = "UPDATE naudotojai SET  naud_vardas='$naud_vardas', naud_pavarde='$naud_pavarde', naud_passw=md5('$naud_passw'),  naud_telef='$naud_telef', naud_adr='$naud_adr', naud_grupe='$naud_grupe', naud_org='$naud_org', grupe='$grupe' WHERE naud_email='$n_email' LIMIT 1";
	$query=$this->db->query($sql);
	}	
	
	
	function get_grupes() { 
       $query=$this->db->query("select grupe from grupes");
	$result = $query->result_array();
       $grupes = []; 
       foreach($result as $r) { 
            $grupes[] = $r['grupe']; 
        } 
      return $grupes; 
    } 
	
	
	function login($email, $passw) { 
	$naud_mail = htmlspecialchars($email);
	$naud_passw = htmlspecialchars($passw);
	
	$res = [];
	$res['ok']= false;
	
	$query=$this->db->query("SELECT COUNT(*) kiek FROM naudotojai WHERE naud_email='$naud_mail'");
	$row = $query->row();
	$k = $row->kiek;

		if (isset($row))
		{
			if( $k != 1) { return $res;}
		}
	
	
	$qr=$this->db->query("SELECT naud_email, CONCAT(naud_vardas, ' ', naud_pavarde) AS pareiskejas, naud_grupe FROM naudotojai WHERE naud_email='$naud_mail' AND naud_passw=md5('$naud_passw')");
	$ro = $qr->row();
	if (isset($ro)) 	
	{
	$res['ok']=true;
	$res['pareiskejas']=$ro->pareiskejas;
	$res['naud_grupe']=$ro->naud_grupe;
	$res['naud_email']=$ro->naud_email;
	return $res;   
	} 
	return $res;
	
	
}//function


}//class

