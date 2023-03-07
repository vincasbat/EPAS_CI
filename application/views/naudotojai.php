<!DOCTYPE html>
<html>
<head>
<title>Naudotojų administravimas</title>



<?php $this->load->view('page_header'); ?>

<?php $this->load->view('page_menu'); ?>


 <div class="col-md-9">




<h3>NAUDOTOJAI (<span id="naudcount"></span>)</h3><br>



<?php if($this->session->flashdata('msg')): ?>

    <p><?php echo $this->session->flashdata('msg'); ?></p>
    
<?php endif; ?>

<?php if($this->session->flashdata('del')): ?>

   
     <div class='alert alert-danger w-50'>  <strong><?php echo $this->session->flashdata('del'); ?></strong> </div>
    
<?php endif; ?>



<table  class="table table-hover" >
  
  <thead>
   <tr style="color:#007bff;">
     
     <th>Naudotojas</th>
     <th>Data</th>
     <th>El. paštas</th>
     <th>Telefonas</th>
     <th>Grupė</th>
     <th></th>
    </tr>
  </thead>
  
  
  <?php   
  $i=0;
  foreach($data as $row)
  {
  echo "<tr>";
  // echo "<td>"."<button onclick='alert(Date())' > &gt; </button>"."</td>";  
  echo "<td><a href='naudotojai/updatedata?n_email=".$row->naud_email."' >".$row->naudotojas."</a></td>";
  echo "<td>".$row->data."</td>";
  echo "<td>".$row->naud_email."</td>";
  
  
  echo "<td>".$row->naud_telef."</td>";
  echo "<td>".$row->naud_grupe."</td>";
 ?>
  
  
  <td><button class="btn btn-outline-danger" onclick="visitPage('<?php echo $row->naud_email?>' );">&times;</button></td></tr>
  
  <?php
 
  $i++;
  }
  
 echo "</table><br> Viso: <span id='count'>$i</span>";
 
 ?>
 <br>
 
 <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">E. paslaugų sistema EPAS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        
      </div>
      
      <div class="modal-body">
        <h5 class="text-danger" id="myModalLabel">Ar tikrai norite ištrinti naudotoją?</h5>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-taip">Taip</button>
        <button type="button" class="btn btn-primary" id="modal-btn-ne">Ne</button>
      </div>
    </div>
  </div>
</div>




 <script>
 
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


function visitPage(tr){
modalConfirm(function(confirm){
  if(confirm){
    window.location='naudotojai/delete?naud_email=' + tr;
  }else{  }
});
}

 
 
 document.getElementById("naudcount").innerHTML = document.getElementById("count").innerHTML;

$(document).ready(function(){
   $(".active").removeClass("active");
   $("#naudotojai").addClass("active");
});
</script>
 
 
 
 <?php

 
  
  
 echo " </div> <!-- content --> ";
 

 
  $this->load->view('page_footer'); 
?>


