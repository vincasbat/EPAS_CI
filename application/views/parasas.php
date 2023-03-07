<!DOCTYPE html>
<html>
<head>
<title>El. parašas </title>

<?php $this->load->view('page_header'); ?>



<?php $this->load->view('page_menu'); ?>


 <div class="col-md-9">
 
 <?php
 
 echo "<iframe src='$langas' height='1000' width='800' style='border:0px'>\n";  
	echo   "<p>Your browser does not support iframes.</p>\n";
	echo "</iframe>'\n";

 ?>
 
 
  </div> <!--  --> 
  
 

 
<?php   $this->load->view('page_footer'); ?>
