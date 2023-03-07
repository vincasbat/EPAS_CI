<!DOCTYPE html>
<html>
<head>
<title>Mokėjimai</title>



<style>
.pagination
{
  margin: 20px;
}

.numlink {
margin: 20px;
}

.curlink {
font-weight: bold;
}
</style>


<?php $this->load->view('page_header'); ?>

<?php $this->load->view('page_menu'); ?>


 <div class="col-md-9">


<h3>MANO MOKĖJIMAI PER ELEKTRONINIUS VALDŽIOS VARTUS (<?php echo $total; ?>)</h3><br>


<table  class="table table-hover" >
 <thead>
   <tr>
     
    
     <th>Prašymo Nr.</th>
     <th >Suma</th>
     <th>Paskirtis</th>
     <th>Banko pranešimas/<br>Data</th>
     <th>Prašytojas/<br>Mokėtojas</th>
     <th>Gavėjas</th>
     <th>Gavėjo sąskaita</th>
           
    </tr>
  </thead>
  
<?php
 $i=0;
  foreach($data as $row)
  {
  $pask = $this->Mokejimai_Model->deco($row->paskirtis);
  $mok = $this->Mokejimai_Model->deco($row->moketojas);
  $gav = $this->Mokejimai_Model->deco($row->gavejas);
  
  echo "<tr>";
  
  echo "<td>$row->dok_id</td>";
  echo "<td><b>$row->suma</b></td>";
  echo "<td>$pask</td>";
  echo "<td>$row->banko_pranesimas<br>$row->mok_data</td>";
  echo "<td>$row->pras<br>$mok</td>";
  echo "<td>$gav</td>";
   echo "<td>$row->saskaita</td>";
 
  
  $i++;
  }
  
 echo "</table><br> <br>";
 
?>






<table>
<br /><br />
<tr style="background: white;"><td>1101&nbsp;</td><td>Banko pranešimas apie  sėkmingą paslaugos apmokėjimo operacijos įvykdymą</td></tr>
<tr style="background: white;"><td>1201</td><td>Banko pranešimas apie sėkmingai priimtą, bet dar nepatvirtintą paslaugos apmokėjimo operaciją</td></tr>
<tr style="background: white;"><td style='color: red;'>1901</td><td>Banko pranešimas apie nutrauktą paslaugos apmokėjimą</td></tr>
<tr style="background: white;"><td style='color: red;'>3101</td><td>Užklausos parašas neteisingas</td></tr>
</table>
<script>
$(document).ready(function(){
   $(".active").removeClass("active");
   $("#manomok").addClass("active");
});
</script>

<?php

  echo " </div> <!-- content --> ";
  $this->load->view('page_footer'); 
?>

