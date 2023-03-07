<!DOCTYPE html>
<html>
<head>
<title>Naudotojų duomenų keitimas </title>

<?php $this->load->view('page_header'); ?>



<?php $this->load->view('page_menu'); ?>


 <div class="col-md-9">


<h3>NAUDOTOJO DUOMENŲ KEITIMAS </h3><br>



 <?php
 
 
  $i=1;
  foreach($data as $row)
  {
  ?>
	<form method="post">
	
	
	<?php //echo validation_errors(); 
	?>
	
	
	
		<table class="table">
  <tr>
    <td> Vardas </td>
    <td><input type="text" name="naud_vardas" value="<?php echo $row->naud_vardas; ?>"/></td><td>
    
    <?php  if(form_error('naud_vardas'))
	{ 
	echo "<span style='color:red'>".form_error('naud_vardas')."</span>";
	} 
	?>
    </td>
  </tr>
  <tr>
    <td width="180">Pavardė </td>
    <td width="230"><input type="text" name="naud_pavarde" value="<?php echo $row->naud_pavarde; ?>"/></td><td>
    
    <?php  if(form_error('naud_pavarde'))
	{ 
	echo "<span style='color:red'>".form_error('naud_pavarde')."</span>";
	} 
	?>
    </td>
  </tr>
  
  
  
  <tr>
    <td>Slaptažodis </td>
    <td><input type="text" name="naud_passw" value=""/></td><td>
     <?php  if(form_error('naud_passw'))
	{ 
	echo "<span style='color:red'>".form_error('naud_passw')."</span>";
	} 
	?>
    </td>
  </tr>
  
  <tr>
    <td>Telefonas </td>
    <td><input type="text" name="naud_telef" value="<?php echo $row->naud_telef; ?>"/></td><td>
     <?php  if(form_error('naud_telef'))
	{ 
	echo "<span style='color:red'>".form_error('naud_telef')."</span>";
	} 
	?>
    </td>
  </tr>
  
  <tr>
    <td>Adresas</td>
    <td><input type="text" name="naud_adr" value="<?php echo $row->naud_adr; ?>"/></td><td>
     <?php  if(form_error('naud_adr'))
	{ 
	echo "<span style='color:red'>".form_error('naud_adr')."</span>";
	} 
	?>
    </td>
  </tr>
  <tr>
    <td>Organizacija</td>
    <td><input type="text" name="naud_org" value="<?php echo $row->naud_org; ?>"/></td><td>
     <?php  if(form_error('naud_org'))
	{ 
	echo "<span style='color:red'>".form_error('naud_org')."</span>";
	} 
	?>
    </td>
  </tr>
  <tr>
    <td>Grupė</td>
    
    
  <td>   <select name='naud_grupe'>";
    
<option value="par"  <?php if ($row->naud_grupe=="par") echo " selected"; ?> >PAR </option>
<option value="pz" <?php if ($row->naud_grupe=="pz") echo " selected"; ?> >PZ </option>
<option value="pr" <?php if ($row->naud_grupe=="pr") echo " selected"; ?> >PR </option>
<option value="is" <?php if ($row->naud_grupe=="is") echo " selected"; ?> >IS </option>
<option value="ap" <?php if ($row->naud_grupe=="ap") echo " selected"; ?> >AP </option>
<option value="admins" <?php if ($row->naud_grupe=="admins") echo " selected"; ?>  >ADMINS </option>
         </select>  </td>
         <td></td>
    
  </tr>
  <tr>
    <td>Grupė 2</td>
    
    <td>   
    
 
    
<select  name='grupe' size='1' maxlength='30' id='grs'>";
<option value=''></option>
<?php
foreach($gr as $gru)
  {
echo "<option value='$gru'";
if ($row->grupe==$gru) echo " selected ";
echo ">$gru</option>";
	}
?>
</select>
</td>
    <td></td>
  </tr>
  
    
  
  <tr>
    <td colspan="2">
	<input class="btn btn-outline-primary"  type="submit" name="update" value="Keisti"/></td> <td>     </td>
  </tr>
</table>
	</form>
	
	</div>
	<?php } 

  $this->load->view('page_footer'); 
	?>
	
	
	
	
