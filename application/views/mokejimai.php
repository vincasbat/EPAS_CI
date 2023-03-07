<!DOCTYPE html>
<html>
<head>
<title>Mokėjimai</title>


<style>

.numlink {
margin: 20px;
}

.curlink {
font-weight: bold;
margin: 20px;
}

.firstlink {
font-weight: bold;
margin: 20px;
}

.lastlink {
font-weight: bold;
margin: 20px;
}

.nextlink {
font-weight: bold;
margin: 20px;
}

.prevlink {
font-weight: bold;
margin: 20px;
}


</style>

<?php $this->load->view('page_header'); ?>
<?php $this->load->view('page_menu'); ?>


<div class="col-md-9">

<h3>MOKĖJIMAI PER EVV (<?php echo $total; ?>)</h3>


  

<?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?>

<table class="table table-hover">
  <thead>
   <tr>
     
     <th>Mok.Nr.</th>
     <th>Prašymo Nr.</th>
     <th>Suma</th>
     <th>Mokėjimo paskirtis</th>
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
  echo "<tr>";
   echo "<td>$row->mok_id</td>";  
  echo "<td>$row->dok_id</td>";
  echo "<td><b>$row->suma</b></td>";
  echo "<td>$row->paskirtis</td>";
  echo "<td>$row->banko_pranesimas<br>$row->mok_data</td>";
  echo "<td>$row->pras<br>$row->moketojas</td>";
  echo "<td>$row->gavejas</td>";
   echo "<td>$row->saskaita</td>";
 
  
  $i++;
  }
  
 echo "</table><br> <br>";
 
 
 
 
 
?>

<?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?>

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
   $("#mokejimai").addClass("active");
});
</script>

<?php

  echo " </div> <!-- content --> ";
  $this->load->view('page_footer'); 
?>

