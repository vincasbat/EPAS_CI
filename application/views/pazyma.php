<!DOCTYPE html>

<html>

<head>

<title>Pažyma</title>
	
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
<style>
           
            @page {
                margin: 100px 25px 100px 80px;
            }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 70px;

                font-family:DejaVu Sans, sans-serif;
                font-size:large;
                text-align: center;
                line-height: 35px;
                 border-bottom-style: solid;
                 border-bottom-width: 1px;
                 padding-bottom:40px;
            }

            footer {
                position: fixed; 
                bottom: -80px; 
                left: 0px; 
                right: 0px;
                height: 70px; 

                /** Extra personal styles **/
               border-top-style: solid;
               border-top-width: 1px;
              font-family:DejaVu Sans, sans-serif;
                font-size:x-small;
                text-align: center;
                line-height: 35px;
            }
            
           
            main { font-family: DejaVu Sans, sans-serif; 
             font-size:small;
            }
            
            
 td 
{
   
    vertical-align: top;
}
            
            
        </style>	
	
	
	
	 

</head>

<body>
 <header>
 <?php
 $path = FCPATH . 'assets/img/epas.png';   
 $dat = file_get_contents($path); 
 $base64 = 'data:image/png;base64,' . base64_encode($dat);    //<img src="data:image/png;base64,iVBORw
 
 ?>
 
 <img src="<?php echo $base64?>" width="100" height="50"/><br>
 Valstybinio patentų biuro  elektroninių paslaugų sistema

</header>

<footer>
   Kalvarijų g. 3, LT-09310, Vilnius, tel. (8 5) 278 02 90, faks. (8 5) 275 0723, el. paštas info@vpb.gov.lt
     
</footer>


 <main>

<br><br><br>
<h2>PAŽYMA</h2>

<?php
$n=0;


 if(strlen($data->dok_kelias)>5) $n++;
  


foreach($kiti as $row)
  {
  $n++;
  }

$pastabos = str_replace(',', ', ',$data->pastabos);

echo "<table style='width:100%;'><tr><td>Prašymo Nr.</td><td> <b>$data->dok_id</b></td></tr>";   
echo "<tr><td style='width:25%;'>PNO Nr.</td><td> <b>$data->ip</b></td></tr>";
echo "<tr><td>Pareiškėjas (-a)</td><td> $data->prasytojas</td></tr>";
echo "<tr><td>El. pašto adresas&nbsp;</td><td> $data->naud_email</td></tr>";
if($n>0)  echo "<tr><td>Pateikta dokumentų</td><td>$n</td></tr>";
echo "<tr><td>Prašymas gautas</td><td> $data->dab_statuso_data</td></tr>";
echo "<tr><td>Pastabos</td><td> $pastabos</td></tr>";


echo "</table>\n";



if( isset($mokejimas->suma))  {

$pask = $this->Mokejimai_Model->deco($mokejimas->paskirtis);
$moketojas = $this->Mokejimai_Model->deco($mokejimas->moketojas);
echo "<p><b>Mokėjimas per Elektroninius valdžios vartus </b></p>\n";
echo "<table width='100%'>";
echo "<tr><td style='width:25%;'>Suma  </td><td> $mokejimas->suma </td></tr>";
echo "<tr><td>Paskirtis  </td><td>$pask</td></tr>";
echo "<tr><td>Banko pranešimas  </td><td> $mokejimas->banko_pranesimas </td></tr>";
echo "<tr><td>Data  </td><td> $mokejimas->mok_data </td></tr>";
echo "<tr><td>Mokėtojas  </td><td> $moketojas </td></tr>";
echo "</table><br />\n";
}

?>
 </main>
</body>

</html>
