<?php
class Priemimas_Model extends CI_Model 
{

function gauti()
	{
	
	
	$query=$this->db->query("SELECT dok_id, dok_formos_kodas, mokestis, dok_kelias, CONCAT(LEFT(naud_vardas, 1), '. ', naud_pavarde) AS pareiskejas,  status_dabar, DATE(status_dabar_date) AS dab_statuso_data, ip, pastabos FROM dokai INNER JOIN naudotojai ON naudotojai.naud_email = dokai.naud_email WHERE status_dabar = 'Gautas'  ORDER BY status_dabar_date");
	return $query->result();
	}
	
	
	function  prasymas($dok_id)
	{
	$query=$this->db->query("SELECT dok_kelias,  pastabos, naud_email, ip FROM dokai WHERE dok_id = $dok_id");
	return $query->row();
	}
	
	
	function  pareiskejas($naud_email)
	{
	$query=$this->db->query("SELECT naud_email, CONCAT(naud_vardas, ' ', naud_pavarde) AS pareiskejas, CONCAT(' ', naud_adr, '; tel. ', naud_telef, '; ', naud_org) AS par_duom FROM naudotojai WHERE naud_email = '$naud_email'");
	return $query->row();
	}
	
	
	function  mokejimas($dok_id)
	{
	$query=$this->db->query("SELECT dok_id, suma, paskirtis, banko_pranesimas, LEFT(mokejimo_data, 10) AS mok_data, moketojas FROM mokejimai WHERE dok_id = $dok_id ORDER BY mok_id desc  LIMIT 0, 100 ");
	return $query->row();
	}
	
	
	function  kiti($dok_id)
	{
	$query=$this->db->query("SELECT dok_kelias FROM kiti_failai WHERE dok_id = $dok_id");
	return $query->result_array();
	}
	
	
	
	
	}//class
	
?>
