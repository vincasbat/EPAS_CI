<!DOCTYPE html>
<html>
<head>
<title>Registras</title>




<script>
function valyti() { 
		alert('labas');
	} 




function visitPageeeee(tr){             
if (confirm('Ar tikrai ištrinti?'))
  window.location='registras/delete?reg_ai=' + tr;
}


function visitPage(tr){
modalConfirm(function(confirm){
  if(confirm){
    window.location='registras/delete?reg_ai=' + tr;
  }else{  }
});
}

</script>

<?php 
$this->load->view('page_header'); 
$this->load->view('page_menu'); 
$this->load->model('Registras_Model');
?>


<div class="col-md-9">

<h3>SIUNČIAMŲ DOKUMENTŲ REGISTRAS (<span id="isdcount"></span>)</h3><br>

<?php if($this->session->flashdata('siunc_istrintas')): ?>

         <div class='alert alert-danger'>  <strong><?php echo $this->session->flashdata('siunc_istrintas'); ?></strong> </div>
    
<?php endif; ?>

   
<form action=<?php echo $_SERVER['PHP_SELF']?>   method="POST">

<div class="form-group">
<label for='pno' class='mr-sm-2'>PNO Nr. </label> 
<input type='text' name='pno' class='form-control w-50'  value="<?php echo set_value('pno'); ?>"   />
</div>
  
<?php $dt = set_value('doktipas'); ?>



<div class="form-group">
<label for='regnr' class='mr-sm-2'>Reg. Nr. </label> 
<input type='text' name='regnr' class='form-control w-50'  value="<?php echo set_value('regnr'); ?>"   />
</div>

<div class="form-group">
<label for='nuo' class='mr-sm-2'>Nuo (pvz., 2010-03-04)</label> 
<input type='text' name='nuo' class='form-control w-50'  value="<?php echo set_value('nuo'); ?>"   />
</div>

<div class="form-group">
<label for='iki' class='mr-sm-2'>Iki (pvz., 2020-03-04)</label> 
<input type='text' name='iki' class='form-control w-50'  value="<?php echo set_value('iki'); ?>"   />
</div>

<div class="form-group">
<label for='doktipas' class='mr-sm-2'>Dok. tipas </label> <br>
<select class="form-control w-50"  name='doktipas' >
<option value=''>Bet koks</option>
<option value='ISR'   <?php if ($dt=="ISR") echo " selected"; ?>   > Išrašas </option>
<option value='LIU'   <?php if ($dt=="LIU") echo " selected"; ?>   > Liudijimas </option>
<option value='PAZ'  <?php if ($dt=="PAZ") echo " selected"; ?>   > Pažyma </option>
<option value='SPR' <?php if ($dt=="SPR") echo " selected"; ?>    > Sprendimas </option>
<option value='PRA' <?php if ($dt=="PRA") echo " selected"; ?>   > Pranešimas </option>
<option value='KIT' <?php if ($dt=="KIT") echo " selected"; ?>    > Kita </option>"
</select>
</div>

<div class="form-group">
<label for='isdave' class='mr-sm-2'>Išdavė</label> <br>

<select class="form-control w-50"  name='isdave'   id='pars'>
<option value='0'>Visi</option>
<?php
$isd = set_value('isdave'); 
foreach($isdavejai as $row)    
  {
  echo "<option value='$row->naud_email'";
  if($isd==$row->naud_email) echo " selected";
echo ">$row->isdavejas</option>\n"; 
}
?>
</select>
</div>


<div class="form-group">
<label for='adresatas' class='mr-sm-2'>Adresatas</label> <br>
<select class="form-control w-50"  name='adresatas'>
<option value='0'>Visi</option>
<?php
$adr = set_value('adresatas'); 
foreach($adresatai as $row)
  {
  echo "<option value='$row->naud_email'";
  if($adr==$row->naud_email) echo " selected";
echo ">$row->adresatas</option>\n"; 
}
?>
</select>

</div>




<p style='margin-left: 9.5em;';><input type='submit' class='btn btn-outline-primary' name='submit' value='Atrinkti' > &nbsp; &nbsp; &nbsp; 

<a class='btn btn-outline-primary' href='<?php echo base_url();?>index.php/registras' >Išvalyti</a>

</form>
<br>



<table class="table  table-hover" >
  
  <thead>
   <tr>
     
     <th>Reg. Nr.</th>
     <th>Data</th>
     <th>Adresatas</th>
     <th>Tipas</th>
     <th>Failas</th>
     <th>PNO Nr.</th>
     <th>Išdavė</th>
     <th></th>
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
  
  
   
 
  //echo "<td><a href='updatedata?n_email=".$row->naud_email."' >".$row->naudotojas."</a></td>";
   $keliasreal = realpath("./") . "/assets/pazymos/".$row->kelias;
  $kelias = base_url() . "assets/pazymos/".$row->kelias;
  
  if (file_exists($keliasreal)) {  
  $doc_kelias = base_url() . 'assets/img/pdf.png';
 $src = "src='$doc_kelias'";
$onclick = "";
} else {  
$stop_kelias = base_url() . 'assets/img/stop.png';
$src = "src='$stop_kelias'";
$onclick = "onclick='return false'";
}
  
  
  echo "<td><a href='$kelias' target='_blank'><img $src title='$row->kelias' $onclick class='center'/></a></td>";
  echo "<td>".$row->pno."</td>";
  
  $isd = $this->Registras_Model->isdavejas($row->isdave);
  
  echo "<td>$isd</td>";
  
  // echo "<td>".$row->isdave."</td>";
  
 echo  "<td><button class='btn btn-outline-danger' onclick='visitPage($row->reg_ai);'>&times; </button></td></tr>\n" ;
 
 $i++;
   }
echo "</table><br>"; 

echo "Viso: <span id='count'>$i</span>";
?>

<script>
 document.getElementById("isdcount").innerHTML = document.getElementById("count").innerHTML;
 
  
$(document).ready(function(){
   $(".active").removeClass("active");
   $("#registras").addClass("active");
});

 
 var modalConfirm = function(callback){
  
    $("#mi-modal").modal('show');

  $("#modal-btn-taip").on("click", function(){
    callback(true);
    $("#mi-modal").modal('hide');
  });
  
  $("#modal-btn-ne").on("click", function(){
    callback(false);
    $("#mi-modal").modal('hide');
  });
};



$(function() {
   $(document).on('click', '.close', function() {
       $(this).parent().hide();
   })
});
 </script>
 
 
 <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">E. paslaugų sistema EPAS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        
      </div>
      
      <div class="modal-body">
        <h5 class="text-danger" id="myModalLabel">Ar tikrai norite ištrinti šį dokumentą?</h5>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-taip">Taip</button>
        <button type="button" class="btn btn-primary" id="modal-btn-ne">Ne</button>
      </div>
    </div>
  </div>
</div>

 
 
 <?php


  
 echo " </div> <!-- content --> ";
 

 
  $this->load->view('page_footer'); 
?>

