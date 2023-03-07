<!DOCTYPE html>
<html>
<head>
<title>EPAS</title>

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


<h3>VPB ELEKTRONINĖS PASLAUGOS</h3>

<br>

<p>Prieš pradėdami naudotis Valstybinio patentų biuro paslaugomis susipažinkite su naudojimosi Valstybinio patentų biuro elektroninėmis paslaugomis <a href='http://www3.lrs.lt/pls/inter3/dokpaieska.showdoc_l?p_id=483462&p_tr2=2' target="_blank" title="Atsidarys naujame lange/kortelėje"> taisyklėmis.</a></p>

<p>Prašymų, kuriuos galima teikti elektroniniu būdu, sąrašas pateiktas   <a href='http://vpb.lrv.lt/lt/veiklos-sritys/elektronines-paslaugos' target="_blank" title="Atsidarys naujame lange/kortelėje"> Valstybinio patentų biuro tinklalapyje.</a></p>

<br />

<h4>Išduoti elektroniniai dokumentai (<?php echo $total; ?>)</h4>

<?php if($this->session->flashdata('nerastasdokas')): ?>

    <div class='alert alert-danger'>  <strong><?php echo $this->session->flashdata('nerastasdokas'); ?></strong> </div> 
    
<?php endif; ?>

<?php
//if(strlen($gr)>2) {echo "<p> Grupė $gr: $nauds. </p>\n";}

//echo $this->session->naud;
//echo $this->session->grupe;
//echo $this->session->naud_email;
?>


<?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?>

<table  class="table table-hover" >
 <thead >
   <tr>
     
     <th>Reg. Nr.</th>
     <th>Data</th>
     <th>Adresatas</th>
     <th>Dok. tipas</th>
     <th>Failas</th>
     <th>PNO Nr.</th>
     <th>Išdavė</th>
     </tr>
  </thead>
  
 <?php  
   $i=0;
  foreach($data as $row)
  {
 echo "<tr>";
  echo "<td>".$row->reg_nr."</td>";  
  echo "<td>$row->data</td>";
  echo "<td><a href='mailto:$row->adresatas'>$row->prasytojas</a></td>";     
  echo "<td>".$row->dokumentas."</td>";
  
  $keliasreal = realpath("./") . "/assets/pazymos/".$row->kelias;
 
  if (file_exists($keliasreal)) {  
  $doc_kelias = base_url() . 'assets/img/pdf.png';   
 $src = "src='$doc_kelias'";
 
$onclick = "";
} else {  
$stop_kelias = base_url() . 'assets/img/stop.png';
$src = "src='$stop_kelias'";
$onclick = "onclick='return false'";
}
  
 $kelias = base_url () . "index.php/manoprasymas/parsisiusti?file=$row->kelias"; 
  
  echo "<td style='text-align:center;'><a href='$kelias' target='_blank'><img $src title='$row->kelias' $onclick class='center'/></a></td>";
  echo "<td>".$row->pno."</td>";
  
  $isd = $this->Registras_Model->isdavejas($row->isdave);
  
  echo "<td>$isd</td>";
  
   
 $i++;
   }
echo "</table>"; 




 ?>
 
 
<?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?>
 
 
 
  <script>
$(document).ready(function(){
   $(".active").removeClass("active");
   $("#pradzia").addClass("active");
});
</script>

</div> <!-- col --> 

 
<?php   $this->load->view('page_footer'); ?>

