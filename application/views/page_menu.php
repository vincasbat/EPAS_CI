<div class="container-fluid" style="margin-top:30px">
  <div class="row">
    <div class="col-md-3">
   
<a href="<?php echo base_url();?>index.php/login">Atsijungti</a>  
         
       <div class="vertical-menu mb-3" >
  

  <?php 
  
  if(!isset( $this->session->naud)  ||  !isset($this->session->grupe)  || !isset($this->session->naud_email))

 header('Location: login'); // jei par location kitur

  $naudotojas =  $this->session->naud;
$grupe = $this->session->grupe;
  
   echo "<br><p><span style='color:green;'>$naudotojas </span></p>";
  
 


  
  
  

  
  switch ($grupe) {
    case 'admins':
    ?>
    
<a id="pradzia" href="<?php echo base_url();?>index.php/pradzia">Pradžia</a>
<a id="upload" href="<?php echo base_url();?>index.php/upload">Pateikti prašymą</a>
<a id="manopr" href="<?php echo base_url();?>index.php/manoprasymai">Mano prašymai</a>
<a id="manomok" href="<?php echo base_url();?>index.php/mokejimas">Mano mokėjimai</a>
<a id="skaic" href="<?php echo base_url();?>index.php/skaiciuokle">Metiniai mokesčiai</a>
<a id="naudotojai" href="<?php echo base_url();?>index.php/naudotojai">Naudotojai</a>
<a id="nnaudotojas" href="<?php echo base_url();?>index.php/naudotojai/n_naudotojas">Naujas naudotojas</a>
<a id="pakeistielp" href="<?php echo base_url();?>index.php/naudotojai/pakeistiemail">Pakeisti el. p.</a>
<a id="prasymai" href="<?php echo base_url();?>index.php/prasymai">Prašymai</a>
<a id="registras" href="<?php echo base_url();?>index.php/registras">Registras</a>
<a id="priemimas" href="<?php echo base_url();?>index.php/priemimas">Priėmimas</a>
<a id="ataskaitos" href="<?php echo base_url();?>index.php/isduoti">Ataskaitos</a>
<a id="mokejimai" href="<?php echo base_url();?>index.php/mokejimai">Mokėjimai</a>
<a  id="beparaso" href="<?php echo base_url();?>index.php/beparaso">Be parašo</a>
<a id="suparasu" href="<?php echo base_url();?>index.php/suparasu">Išduoti dokumentą</a>
     <?php 
    
        break;
    case 'pr':
      ?>   
     

<a id="priemimas" href="<?php echo base_url();?>index.php/priemimas">Priėmimas</a>
<a id="ataskaitos" href="<?php echo base_url();?>index.php/isduoti">Ataskaitos</a>
<a id="registras" href="<?php echo base_url();?>index.php/registras">Registras</a>
<a id="mokejimai" href="<?php echo base_url();?>index.php/mokejimai">Mokėjimai</a>
<a  id="beparaso" href="<?php echo base_url();?>index.php/beparaso">Be parašo</a>
<a id="suparasu" href="<?php echo base_url();?>index.php/suparasu">Išduoti dokumentą</a>
     
        
<?php
        break;
    case 'par':
 ?>       
   
   <a id="pradzia" href="<?php echo base_url();?>index.php/pradzia">Pradžia</a>
<a id="upload" href="<?php echo base_url();?>index.php/upload">Pateikti prašymą</a>
<a id="skaic" href="<?php echo base_url();?>index.php/skaiciuokle">Metiniai mokesčiai</a>
<a id="manopr" href="<?php echo base_url();?>index.php/manoprasymai">Mano prašymai</a>
<a id="manomok" href="<?php echo base_url();?>index.php/mokejimas">Mano mokėjimai</a>
<a id="moketi" href="#">Mokėti</a>
        
   <?php     
        break;
        
        
         case 'is':
 ?>       
   
<a id="ataskaitos" href="<?php echo base_url();?>index.php/isduoti">Ataskaitos</a>
<a id="registras" href="<?php echo base_url();?>index.php/registras">Registras</a>
<a id="mokejimai" href="<?php echo base_url();?>index.php/mokejimai">Mokėjimai</a>
<a  id="beparaso" href="<?php echo base_url();?>index.php/beparaso">Be parašo</a>
<a id="suparasu" href="<?php echo base_url();?>index.php/suparasu">Išduoti dokumentą</a>

        
   <?php     
        break;
         
        
        
        
    default:
     header('Location: login'); 
}
  
  

 
  ?>
 




</div>  <!-- vertical-menu -->


      
      <br> <br> <br> <br>
    </div>  <!-- col -->
    
    
    <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title">E. paslaugų sistema EPAS</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id="mb">
          
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Uždaryti</button>
        </div>
        
      </div>
    </div>
  </div>
    


