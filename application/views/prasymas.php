<!DOCTYPE html>
<html>
<head>
<title>Prašymas</title>
<script>
function marke (event) {
      event.target.style.backgroundColor = 'green'; 
      }
</script>

<?php $this->load->view('page_header'); ?>



<?php $this->load->view('page_menu'); ?>


<div class="col-md-9">

<?php
echo "<h3>PRAŠYMAS NR. $data->dok_id </h3>\n";

$dok_id = $data->dok_id;

echo "<table class='table'><tr>\n";

echo "<td>$data->prasytojas</td>";
echo "<td>PNO Nr. <b>$data->ip</b></td></tr><tr>";
echo "<td>$data->dab_statuso_data</td>";
echo "<td>$data->pastabos</td></tr></table><br>\n";



    if (strlen($data->dok_kelias) > 5) {            
$link = base_url () . "index.php/prasymas/download?file=$data->dok_kelias";
$file_ext = pathinfo($data->dok_kelias, PATHINFO_EXTENSION);
switch ($file_ext) {
    case "pdf":
        $src = base_url() . 'assets/img/pdf.png';
        break;
    case "zip":
         $src = base_url() . 'assets/img/zip.png';
        break;
         case "doc":
         $src = base_url() . 'assets/img/word.png';
        break;
    case "docx":
         $src = base_url() . 'assets/img/word.png';
        break;
}

echo "<a href='$link' ><img src='$src'  title='$data->dok_kelias'  onclick='marke(event);' oncontextmenu='marke(event);'   /></a>&nbsp;&nbsp;\n";






foreach($kiti as $row)
  {
 
$link = base_url () . "index.php/prasymas/download?file=$row->dok_kelias";
$file_ext = pathinfo($row->dok_kelias, PATHINFO_EXTENSION);
switch ($file_ext) {
    case "pdf":
        $src = base_url() . 'assets/img/pdf.png';
        break;
    case "zip":
         $src = base_url() . 'assets/img/zip.png';
        break;
         case "doc":
         $src = base_url() . 'assets/img/word.png';
        break;
    case "docx":
         $src = base_url() . 'assets/img/word.png';
        break;
}

echo "<a href='$link' ><img src='$src'  title='$row->dok_kelias'   onclick='marke(event);' oncontextmenu='marke(event);'  /></a>&nbsp;&nbsp;\n";
}
}//if

if((substr_count($data->pastabos, ':')>1) && !strpos($data->ip, 'CSV')) {
$pratesimai = explode(" ", $data->pastabos);
$dvitaskiai =  substr_count($pratesimai[0], ':');				
if($dvitaskiai == 2) $span = 2; else $span = 3;  				
echo "<p><b>Patentų galiojimo pratęsimai</b> </p>";
echo "<table class='table' >\n";
if($dvitaskiai == 2)
echo "<tr><th></th><th>Patento Nr.</th><th>Metai</th><th>Suma</th></tr>";
else
echo "<tr><th></th><th>Patento Nr.</th><th>Metai</th><th>Suma</th><th>Info</th></tr>";
for ($i=0; $i<count($pratesimai); $i++)
{
$eil = explode(":", $pratesimai[$i]);
if($dvitaskiai == 2)
echo "<tr><td>" . ($i+1) . "</td><td>". $eil[0] ."</td><td>". $eil[1] ."</td><td>". $eil[2] ."</td></tr>";
else
echo "<tr><td>" . ($i+1) . "</td><td>". $eil[0] ."</td><td>". $eil[1] ."</td><td>". $eil[2] ."</td><td>". $eil[3] ."</td></tr>";

}
echo "</table><br />\n"; 

}//if ne csv

if((substr_count($data->pastabos, ':')>1) && strpos($data->ip, 'CSV')) {
$pratesimai = json_decode($data->pastabos);
echo "<p><b>Patentų galiojimo pratęsimai</b> </p>";
echo "<table class='table'>\n";
echo "<tr><th></th><th>Patento Nr.</th><th>Metai</th><th>Suma</th><th>Info</th></tr>";
for ($i=0; $i<count($pratesimai); $i++)
{
$eil =  $pratesimai[$i];
if(isset($eil->info)) $info = $eil->info; else  $info = '';
echo "<tr><td>" . ($i+1) . "</td><td>". $eil->patnr ."</td><td>". $eil->metai ."</td><td>". number_format($eil->suma, 2, '.', '') ."</td><td>". $info ."</td></tr>";
}
echo "</table><br />\n"; 
}//if csv


if( isset($mokejimas->suma))  {

$pask = $this->Mokejimai_Model->deco($mokejimas->paskirtis);
  $mok = $this->Mokejimai_Model->deco($mokejimas->moketojas);
  

echo "<p><b>Mokėjimas per Elektroninius valdžios vartus </b></p>\n";
echo "<table class='table'>";
echo "<tr><td>Suma  </td><td> $mokejimas->suma </td></tr>";
echo "<tr><td>Paskirtis  </td><td> $pask </td></tr>";
echo "<tr><td>Banko pranešimas  </td><td> $mokejimas->banko_pranesimas </td></tr>";
echo "<tr><td>Data  </td><td> $mokejimas->mok_data </td></tr>";
echo "<tr><td>Mokėtojas  </td><td> $mok </td></tr>";
echo "</table><br />\n";
}





 echo " </div> <!-- content --> ";
 
  $this->load->view('page_footer'); 
?>
	
