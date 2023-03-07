<?php
class Beparaso_Model extends CI_Model 
{

function displayrecordById($n_email)
	{
	$query=$this->db->query("select * from naudotojai where naud_email='".$n_email."'");
	return $query->result();
	}



}

