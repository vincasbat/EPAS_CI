<!DOCTYPE html>
<html>
<head>
<title>Mano prašymai</title>

<script>
</script>


<?php $this->load->view('page_header'); ?>

<?php $this->load->view('page_menu'); ?>


<div class="col-md-9">


<h3>MANO PRAŠYMAI (<span id="naudcount"></span>)</h3><br>

<?php if($this->session->flashdata('nerastasmanopra')): ?>

    <div class='alert alert-danger'>  <strong><?php echo $this->session->flashdata('nerastasmanopra'); ?></strong> </div> 
    
<?php endif; ?>


<table  class="table table-hover" >
 <thead >
   <tr>
     
     <th>Nr.</th>
     <th>PNO Nr.</th>
     <th>Pareiškėjas</th>
     <th>Statusas</th>
     <th>Data</th>
     <th></th>
               
    </tr>
  </thead>
  
<?php
 $i=0;
  foreach($data as $row)
  {
  echo "<tr>";
   echo "<td>$row->dok_id</td>";  
  echo "<td>$row->ip</td>";
  echo "<td>$row->prasytojas</td>";
   echo "<td>$row->status_dabar</td>";
    echo "<td>$row->dab_statuso_data</td>";
   
    
echo    "<td > <form style='margin-bottom: 0' name='dok_nr' action='manoprasymas' method='post'     >  <input type='hidden' name='dok_id' value='$row->dok_id'/> <input type='submit' value='...' class='btn'  /> </form> </td></tr>\n";
    
    
    
       $i++;
    }//for
    
echo "</table><br> Viso: <span id='count'>$i</span>";

//echo "<td > <form style='margin-bottom: 0' name='dok_nr' action='details_mano_prasymai.php' method='post' target='did'  onsubmit=".'"'."JavaScript: newWindow = openWin('', 'did', 'width=750,height=600,toolbar=0,location=0,directories=0,status=0,menuBar=0,scrollBars=1,resizable=1'); newWindow.focus()".'"'." >  <input type='hidden' name='dok_id' value='$dok_id'/> <input type='submit' value='...' class='btn' title='Atsidarys naujame lange' /> </form> </td></tr>\n";


?>

 <script>
 document.getElementById("naudcount").innerHTML = document.getElementById("count").innerHTML;
 
$(document).ready(function(){
   $(".active").removeClass("active");
   $("#manopr").addClass("active");
});
</script>





<?php 	 
	echo " </div> <!-- content --> ";
   	$this->load->view('page_footer'); 
?>
	
