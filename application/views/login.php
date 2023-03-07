<!DOCTYPE html>
<html>
<head>
<title>Prisijungimas</title>

<?php $this->load->view('page_header'); ?>


<div class="container" style="margin-top:30px">
  <div class="row">
   <div class="col-md-9">
    
     </div> 


 <div class="col-sm-9">
      <h2>PRISIJUNGIMAS</h2>
      <br>
   
     
     
     <?php if($this->session->flashdata('bad_login')): ?>

    <div class='alert alert-danger w-50'>  <strong><?php echo $this->session->flashdata('bad_login'); ?></strong> </div>
    
<?php endif; ?>




     
     
      <form  action="login"   method="POST">
    <div class="form-group">
       <input type="email" class="form-control  w-50" id="em" placeholder="El. pašto adresas" name="naud_email" autocomplete="off">
    </div>
    <div class="form-group">
           <input type="password" class="form-control w-50" id="naud_passw" placeholder="Slaptažodis" name="naud_passw"  autocomplete="off">
    </div>
   
    <button type="submit" class="btn btn-outline-primary" id="prisijungti" name="prisijungti"  value="Prisijungti">Prisijungti</button>
       
  </form>
<br>




      
    </div> <!-- col -->

 


<script>
document.getElementById("em").focus();
</script>
 

 
<?php   $this->load->view('page_footer'); ?>

