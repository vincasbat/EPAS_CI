<!DOCTYPE html>
<html>
<head>
<title>Su parašu</title>

<script type="text/javascript">
function showProgress(){
     
      
 var pars = document.forms["myForm"]["pareiskejai"].value;
if(pars=='0') {
      //  alert('Reikia nurodyti pareiškėją');
       // document.getElementById('realtxt').focus();
        $("#mb").html("<h5 class='text-danger'>Reikia nurodyti pareiškėją</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#realtxt").focus();   });
        return false;
        }      
      
 var pno = document.getElementById('pno').value;
var numRegex =  /^\d{4,7}$/; //     /^[\d]+$/;     

    if(!numRegex.test(pno)) {
      //  alert('Reikia nurodyti PNO numerį');
         $("#mb").html("<h5 class='text-danger'>Reikia nurodyti PNO numerį</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#pno").focus();   });
        
      //  document.getElementById('pno').focus();
        return false;
        }   
        
        
        var sel = document.forms["myForm"]['tipas'].value;
if(sel=='nera') {
       // alert('Reikia nurodyti dokumento tipą');
       // document.getElementById('sel_1').focus();
       $("#mb").html("<h5 class='text-danger'>Reikia nurodyti dokumento tipą</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#sel_1").focus();   });
        
        return false;
        }    
        
        
        if(document.getElementById('failas').value == "") {
//alert('Reikia nurodyti failą');
   //     document.getElementById('failas').focus();
    $("#mb").html("<h5 class='text-danger'>Reikia nurodyti dokumento failą</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#failas").focus();   });
   return false;
        } 
   
   
  var file;
  var filesize; 
  var fsize;
  var input = document.getElementById('failas');
if(input.files[0]) {
file = input.files[0];
filesize = file.size;
fsize = filesize/1024/1024;
fsize = fsize.toFixed(2);
ext = getExtention(file.name);
    if(ext!='pdf') {
  //  alert('Turi būti nurodytas PDF failas');
    //        document.getElementById('failas').focus();
        $("#mb").html("<h5 class='text-danger'>Turi būti nurodytas PDF failas</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#failas").focus();   });     
             return false;
    }
    
    
     if (filesize/1024/1024>2) {  
    // alert('Failas per didelis (' + fsize + ' MB). Failo dydis neturi viršyti 2 MB.');
     var pran = 'Failas per didelis (' + fsize + ' MB). Failo dydis neturi viršyti 2 MB.';
     $("#mb").html("<h5 class='text-danger'>"  + pran + "</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#failas").focus();   });
	return false;
       }
}




      
      
      
       document.getElementById('progress').style.visibility = 'visible';
      return true;
}


function getExtention(fileName) {
  dots = fileName.split(".")
return dots[dots.length-1];
}




function clearForm(oForm)
{  
 document.getElementById('progress').style.visibility = 'hidden';

var elements = oForm.elements;
oForm.reset();
var selektas = document.getElementsByName('pareiskejai')[0];
selektas.value = "0";

var selektas2 = document.getElementsByName('tipas')[0];
selektas2.value = "nera";

  for(i=0; i<elements.length; i++) {
     
  field_type = elements[i].type.toLowerCase();
 
  switch(field_type) {
 
    case "text":
    case "textarea":
    elements[i].value = "";
      break;
    
      default:
      break;
  }//switch
    }//for
document.getElementById("ann").value = 1;
setFocus();
}//func




function searchSel() 
    {
      var input = document.getElementById('realtxt').value.toLowerCase();
       
          len = input.length;
          output = document.getElementById('realitems').options;
      for(var i=0; i<output.length; i++)
         // if (output[i].text.toLowerCase().indexOf(input) != -1 )
            if (output[i].text.toLowerCase().startsWith(input))
          {
          output[i].selected = true;
              break;
          } else output[0].selected = true;
      if (input == '')
        output[0].selected = true;
    }


function setFocus(){
    document.getElementById("realtxt").focus();
}

function runScript(e) {
    if (e.keyCode == 13) {
       document.getElementById("pno").focus();
        return false;
    }
}


function wpno(){
var fname = "";
if(document.getElementById("pno").value.length < 1) {
fname = document.getElementById("failas").value.replace(/[^0-9]/g,''); //lieka tik skaitmenys
document.getElementById("pno").value = fname;
}
}



 function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;
        return true;
    }  

function clearsearch() {document.getElementById("realtxt").value = "";}
</script>

<style>


</style>


<?php $this->load->view('page_header'); ?>



<?php $this->load->view('page_menu'); ?>


<div class="col-md-9">

<h3>DOKUMENTAI SU EL. PARAŠU </h3><BR>

<div style='text-align: left'>

<?php if($this->session->flashdata('klaida')): ?>
  
   <div class='alert alert-danger'>  <strong><?php echo $this->session->flashdata('klaida'); ?></strong> </div> 
     
<?php endif; ?>

<form enctype="multipart/form-data" 
        action="suparasu/upload"
        method="POST" 
        onsubmit="return showProgress();"
        name="myForm" 
         style="display: inline;"
         autocomplete="off"
         >
         
     
       
<div class="form-group">
<label for='pareiskejai' class='mr-sm-2'>Pareiškėjas <span style='color:red;'>*</span></label> <br>
<select class="form-control w-50" id='realitems' name='pareiskejai' style="display:inline;" >
<option value='0'>Pasirinkite pareiškėją...</option>


<?php
foreach($adresatai as $row)
  {
  echo "<option value='$row->naud_email'";
 echo ">$row->adresatas</option>\n"; 
}

?>
</select> 
 

 <img src="<?php echo base_url(); ?>/assets/img/srch.png" style='vertical-align:middle;' /> 
 
 <input type='text' id='realtxt' name='srch' onkeyup='javascript:searchSel();' class="form-control w-25" style="display:inline;" onblur='clearsearch();' onkeypress='return runScript(event)'/>  
</div>

<div class="form-group">
<label  for='ip'>PNO Nr. <span style='color:red;'>*</span> (pvz., 6154)  </label> 
<input id='pno' type="text" class='form-control w-50' autocomplete="off" name="ip" size="10" value="" />
</div>

 <input type="hidden" name="MAX_FILE_SIZE" value="9097152" />
 
 <div class="form-group">
 <p><label  for='tipas'>Dokumento tipas <span style='color:red;'>*</span> </label>
 <select class="form-control w-50" name='tipas' id='sel_1'>
<option value='nera'> Nurodykite tipą... </option>
<option value='ISR'  > Išrašas </option>
<option value='LIU'  > Liudijimas </option>
<option value='PAZ'  > Pažyma </option>
<option value='SPR'  > Sprendimas </option>
<option value='PRA'  > Pranešimas </option>
<option value='KIT'  > Kita </option>"
</select>
</div>
 
 
<div class="form-group">
<label for='annot'>El. p. vieta <span style='color:red;'>*</span> </label> 
<input  id='ann' type="text" name="annot" size="3" autocomplete="off" title="Puslapio, kuriame bus el. parašas, numeris" onkeypress="javascript:return isNumber(event)" value="1" />&nbsp; &nbsp; 
</div>


<div class="form-group">
 <label for='dokai'>Failas <span style='color:red;'>*</span></label> 
<input class="form-control w-50" id="failas" type="file" name="dokai" size="60" onchange="wpno();" />
 </div>
 <input type="hidden" name="myform_key" value="<?php echo md5('labas'); ?>" />



   <input type='submit' class='btn btn-outline-primary' name='Upload'  value='Įkelti'  />&nbsp
   
  
<div class='spinner-border text-primary' id='progress' style='visibility:hidden;' ></div>

&nbsp;<input type='button' name='clear' class='btn btn-outline-primary' value='Išvalyti' onclick='clearForm(this.form);' />


</form></div>

<br><p><span style='color:red;'>*</span> &#8211; privalomi laukai.</p>


 </div>
 
<script>
setFocus();
$(document).ready(function(){
   $(".active").removeClass("active");
   $("#suparasu").addClass("active");
});
</script>

<?php
$this->load->view('page_footer'); 
?>
	
	
