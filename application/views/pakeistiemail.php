<!DOCTYPE html>
<html>
<head>
<title>Mokėjimai</title>

<?php $this->load->view('page_header'); ?>

<?php $this->load->view('page_menu'); ?>


 <div class="col-sm-9">

<h3>PAKEISTI NAUDOTOJO EL. P. ADRESĄ</h3><br>

<?php if($this->session->flashdata('emailpakeistas')): ?>

    <div class='alert alert-success w-50'>  <strong><?php echo $this->session->flashdata('emailpakeistas'); ?></strong> </div>
    
<?php endif; ?>


 

<form  action='pakeistiemail'  method='POST'>
<div class="form-group">
<label for='senas' class='mr-sm-2'>Senas el. paštas </label> 
<input type='text' class='form-control w-50' name='senas' size='50' value=''   />
</div>

<div class="form-group">
<label for='naujas' class='mr-sm-2'>Naujas el. paštas  </label> 
<input type='text' class='form-control w-50' name='naujas' size='50' value=''   /> 
</div>
<input type='submit' class="btn btn-outline-primary" name='Upl'  value='Pakeisti'  />
</form>







   </div> 
   
   <script>
$(document).ready(function(){
   $(".active").removeClass("active");
   $("#pakeistielp").addClass("active");
});
</script>
   
   
  
  <?php
  $this->load->view('page_footer'); 
?>
