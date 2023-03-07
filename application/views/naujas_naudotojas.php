<!DOCTYPE html>
<html>
<head>
<title>Naudotojų duomenų keitimas </title>

<?php $this->load->view('page_header'); ?>



<?php $this->load->view('page_menu'); ?>


 <div class="col-md-9">

 <h3>NAUJAS NAUDOTOJAS</h3><br>
 
 
	<form method="post" autocomplete="off">
	
	
	
	
		<table  class="table">
  <tr>
    <td >Vardas </td>
    <td ><input type="text" name="naud_vardas" value="<?php echo set_value('naud_vardas'); ?>"/></td><td>
    
    <?php  if(form_error('naud_vardas'))
	{ 
	echo "<span style='color:red'>".form_error('naud_vardas')."</span>";
	} 
	?>
    </td>
  </tr>
  
  <tr>
    <td >Pavardė </td>
    <td ><input type="text" name="naud_pavarde" value="<?php echo set_value('naud_pavarde'); ?>"/></td><td>
    
    <?php  if(form_error('naud_pavarde'))
	{ 
	echo "<span style='color:red'>".form_error('naud_pavarde')."</span>";
	} 
	?>
    </td>
  </tr>
  
  
   <tr>
    <td>El. paštas </td>
    <td><input type="text" name="naud_email" value="<?php echo set_value('naud_email'); ?>"/></td><td>
     <?php  if(form_error('naud_email'))
	{ 
	echo "<span style='color:red'>".form_error('naud_email')."</span>";
	} 
	?>
    </td>
  </tr>
  
  
  <tr>
    <td>Slaptažodis </td>
    <td><input type="text" name="naud_passw" value="<?php echo set_value('naud_passw'); ?>"/></td><td>
     <?php  if(form_error('naud_passw'))
	{ 
	echo "<span style='color:red'>".form_error('naud_passw')."</span>";
	} 
	?>
    </td>
  </tr>
  
  
   <tr>
    <td>Pakartoti </td>
    <td><input type="text" name="conf_passw" value="<?php echo set_value('conf_passw'); ?>"/></td><td>
     <?php  if(form_error('conf_passw'))
	{ 
	echo "<span style='color:red'>".form_error('conf_passw')."</span>";
	} 
	?>
    </td>
  </tr>
  
  
  
  
  
  <tr>
    <td>Telefonas </td>
    <td><input type="text" name="naud_telef" value="<?php echo set_value('naud_telef'); ?>"/></td><td>
     <?php  if(form_error('naud_telef'))
	{ 
	echo "<span style='color:red'>".form_error('naud_telef')."</span>";
	} 
	?>
    </td>
  </tr>
  
  <tr>
    <td>Adresas</td>
    <td><input type="text" name="naud_adr" value="<?php echo set_value('naud_adr'); ?>"/></td><td>
     <?php  if(form_error('naud_adr'))
	{ 
	echo "<span style='color:red'>".form_error('naud_adr')."</span>";
	} 
	?>
    </td>
  </tr>
  <tr>
    <td>Organizacija</td>
    <td><input type="text" name="naud_org" value="<?php echo set_value('naud_org'); ?>"/></td><td>
     <?php  if(form_error('naud_org'))
	{ 
	echo "<span style='color:red'>".form_error('naud_org')."</span>";
	} 
	?>
    </td>
  </tr>
  <tr>
    <td>Grupė</td>
    
    <?php 
    $gr = set_value('naud_grupe'); 
    $sel0="";
    if(strlen($gr)<1) $sel0 = " selected";
    ?>
    
    
  <td>   <select name='naud_grupe'>";
<option value="" <?php echo $sel0; ?> >Pasirinkite grupę... </option>    
<option value="par" <?php if ($gr=='par') echo 'selected'; ?>   >PAR </option>
<option value="pz" <?php if ($gr=='pz') echo 'selected'; ?>   >PZ </option>
<option value="pr" <?php if ($gr=='pr') echo 'selected'; ?>   >PR </option>
<option value="is" <?php if ($gr=='is') echo 'selected'; ?>   >IS </option>
<option value="ap" <?php if ($gr=='ap') echo 'selected'; ?>   >AP </option>
<option value="admins" <?php if ($gr=='admins') echo 'selected'; ?>    >ADMINS </option>
         </select>  </td>
         <td>
         
     <?php  if(form_error('naud_grupe'))
	{ 
	echo "<span style='color:red'>".form_error('naud_grupe')."</span>";
	} 
	?>    
         
         
         </td>
    
  </tr>
  
  
    
  
  <tr>
    <td colspan="2" align="center">
	<input class="btn btn-outline-primary" type="submit" name="save" value="Registruoti"/></td> <td>     </td>
  </tr>
</table>
	</form>
	
  </div> <!-- content --> 
  
   <script>
$(document).ready(function(){
   $(".active").removeClass("active");
   $("#nnaudotojas").addClass("active");
});
</script>
 

 
<?php   $this->load->view('page_footer'); ?>
