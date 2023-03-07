<!DOCTYPE html>
<html>
<head>
<title>Be parašo</title>


<script type="text/javascript">


function showProgress(){
//validation:
var countfile = ($('form input:file').length+1);
var input;
var filesize = 0;
var file;
//http://stackoverflow.com/questions/3717793/javascript-file-upload-size-validation
/*
input = document.getElementById('file_1');
if(input.files[0]) {
file = input.files[0];
alert(file.size/1024/1024 + "MB");
}
*/

 var pnoid ="";
var selid="";
var fileid="";  

var pars = document.forms["myForm"]["pareiskejai"].value;
if(pars=='0') {
        //alert('Reikia nurodyti pareiškėją');
        $("#mb").html("<h5 class='text-danger'>Reikia nurodyti pareiškėją</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#realtxt").focus();   });
         return false;
        } 



      

for(i=1; i<countfile; i++) {

  input = null;
file = null;

 pnoid = 'pno_' + i;
 selid = 'sel_' + i;
 fileid = 'file_' + i;

var pno = document.getElementById(pnoid).value;
var numRegex =  /^\d{4,7}$/; //     /^[\d]+$/;     

    if(!numRegex.test(pno)) {
        //alert('Reikia nurodyti PNO numerį');
        //document.getElementById(pnoid).focus();
         $("#mb").html("<h5 class='text-danger'>Reikia nurodyti PNO numerį</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#"+pnoid).focus();   });
        return false;
        }            
 
var sel = document.forms["myForm"][selid].value;
if(sel=='nera') {
        //alert('Reikia nurodyti dokumento tipą');
        //document.getElementById(selid).focus();
        $("#mb").html("<h5 class='text-danger'>Reikia nurodyti dokumento tipą</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#"+selid).focus();   });
        return false;
        } 

if(document.getElementById(fileid).value == "") {
   //alert('Reikia nurodyti failą');
    //    document.getElementById(fileid).focus();
    $("#mb").html("<h5 class='text-danger'>Reikia nurodyti failą</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#"+fileid).focus();   });
        return false;
        } 


input = document.getElementById(fileid);
if(input.files[0]) {
file = input.files[0];
filesize += file.size;
ext = getExtention(file.name);
    if(ext!='pdf') {
    //alert('Turi būti nurodytas PDF failas');
     //       document.getElementById(fileid).focus();
     $("#mb").html("<h5 class='text-danger'>Turi būti nurodytas PDF failas</h5>");	$("#myModal").modal();
        $("#myModal").on('hidden.bs.modal', function(){     $("#"+fileid).focus();   });
            return false;
    }
}


}//for

var fsize = filesize/1024/1024;
fsize = fsize.toFixed(2);

if (filesize/1024/1024>2)
{
//alert('Failai per dideli (' + fsize + ' MB). Visų failų dydis neturi viršyti 2 MB.');
var pran = 'Failai per dideli (' + fsize + ' MB). Visų failų dydis neturi viršyti 2 MB.';
$("#mb").html("<h5 class='text-danger'>"+  pran +"</h5>");	$("#myModal").modal();
return false;
}


      document.getElementById('progress').style.visibility = 'visible';
      return true;
}//enf of function showProgress

function getExtention(fileName) {
  dots = fileName.split(".")
return dots[dots.length-1];
}

function clearForm(oForm)
{  				
var element = document.getElementById("mess");
if (element!=null)  element.parentNode.removeChild(element);

 document.getElementById('progress').style.visibility = 'hidden';
var elements = oForm.elements;
oForm.reset();
var selektas = document.getElementsByName('pareiskejai')[0];
selektas.value = "0";

var selektas2 = document.getElementsByName('sel_1')[0];
selektas2.value = "nera";

  for(i=0; i<elements.length; i++) {
     
  field_type = elements[i].type.toLowerCase();
 
  switch(field_type) {
 
    case "text":
    case "textarea":
    elements[i].value = "";
      break;
case "file":

   break; 
      default:
      break;
  }
    }

  var table = document.getElementById("lent");
    for(var i = table.rows.length - 1; i > 1; i--)
    {   
    table.deleteRow(i);
    }
  document.getElementById("realtxt").focus();  
    
}//end valyti


function pno(name){
var arr = name.split("_");
var nr = arr[1];
var fname = "";

if(document.getElementById("pno_" + nr).value.length < 1) {
fname = document.getElementById("file_" + nr).value.replace(/\.[^/.]+$/, ""); //removes file extention
	if (fname.indexOf("fakepath") > -1)
	{
	fname = fname.substring(12);
	}
document.getElementById("pno_" + nr).value = fname;
}
}

function addField(){
var countfile = ($('form input:file').length)+1;
if(countfile>10) {alert("Daugiau pridėti failų negalima!"); return;}
var newp = document.createElement('p');
var ih = "<input type='file' name='file_" + countfile +  "' size='60'  id='file_"+ countfile +"'  onchange='pno(this.name);'/>";
//alert (ih);
//newp.innerHTML = ih;
//document.getElementById('failai').appendChild(newp);
var sel = document.getElementById('sel_1').cloneNode(true);
sel.setAttribute("id", "sel_"+countfile);
sel.setAttribute("name", "sel_"+countfile);

var pno = document.getElementById('pno_1').cloneNode(true);
pno.setAttribute("id", "pno_"+countfile);
pno.setAttribute("name", "pno_"+countfile);
pno.value = "";

var tableRef = document.getElementById('lent').getElementsByTagName('tbody')[0];
var newRow   = tableRef.insertRow(tableRef.rows.length);

var newCell0  = newRow.insertCell(0);
var newCell1  = newRow.insertCell(1);
var newCell2  = newRow.insertCell(2);



newCell0.appendChild(pno);
newCell1.appendChild(sel);
newCell2.innerHTML = ih;

 pno.focus();
}

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
       document.getElementById("pno_1").focus();
        return false;
    }
}


function clearsearch() {document.getElementById("realtxt").value = "";}

</script>




<?php $this->load->view('page_header'); ?>


<?php $this->load->view('page_menu'); ?>


 <div class="col-md-9">

<h2>DOKUMENTAI BE EL. PARAŠO</h2>

<br />

<?php if($this->session->flashdata('isduota')): ?>
    <div class='alert alert-success'>  <strong><?php echo $this->session->flashdata('isduota'); ?></strong> </div>
<?php endif; ?> 

<?php if($this->session->flashdata('upload_klaida')): ?>
    
    <div class='alert alert-danger'>  <strong><?php echo $this->session->flashdata('upload_klaida'); ?></strong> </div>
<?php endif; ?> 



<form enctype="multipart/form-data" 
        action="beparaso/upload"
        method="POST" 
        onsubmit="return showProgress();"
        name="myForm" 
         style="display: inline;"
         autocomplete="off"
         >
         
 
<div class="form-group">
<label class='mr-sm-2 for='pareiskejai'>Pareiškėjas <span style='color:red;'>*</span></label> <br>
<select class="form-control w-50" id='realitems'  name='pareiskejai'  id='pars' style="display:inline;">
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

<input type='text' id='realtxt' name='srch' onkeyup='javascript:searchSel();' class="form-control w-25"  onblur='clearsearch();' onkeypress='return runScript(event)' style="display:inline;"/>  
</div>

 <input type="hidden" name="MAX_FILE_SIZE" value="9097152" />
<table id="lent" class="table">
<tr style="font-weight:bold;"><td>
PNO Nr. <span style='color:red;'>*</span> 
</td><td>Tipas<span style='color:red;'>*</span> </td>
<td>Failas<span style='color:red;'>*</span>
</td></tr>
<tr><td><input type="text"  name="pno_1" size="10" id="pno_1"  /></td>
<td>
<select  name='sel_1' id='sel_1'>
<option value='nera'> Nurodykite tipą... </option>
<option value='ISR'  > Išrašas </option>
<option value='LIU'  > Liudijimas </option>
<option value='PAZ'  > Pažyma </option>
<option value='SPR'  > Sprendimas </option>
<option value='PRA'  > Pranešimas </option>
<option value='KIT'  > Kita </option>"
</select>
</td>
<td>

<input type="file" name="file_1" size="60"  id="file_1" onchange="pno(this.name);" />

</td></tr>
</table>





  
 <div id="failai"></div>
 
 <input type="hidden" name="myform_key" value="<?php echo md5('labas'); ?>" />

<?php

echo  "<br /><input class='btn btn-outline-primary' type='submit' name='Upload'  value='&nbsp;&nbsp;Įkelti&nbsp;&nbsp;'  />&nbsp;\n";


echo "<div class='spinner-border text-primary' id='progress' style='visibility:hidden;' ></div>";

echo "&nbsp;<input type='button' class='btn btn-outline-primary' name='clear' value='&nbsp;Išvalyti&nbsp;' onclick='clearForm(this.form);' />\n";


?>

</form>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-outline-primary" onclick="addField();" >Pridėti failą</button>

<br /><br />
<p><span style='color:red;'>*</span> &#8211; privalomi laukai.</p>








<script>
setFocus();

$(document).ready(function(){
   $(".active").removeClass("active");
   $("#beparaso").addClass("active");
});
</script>
</div>
<?php

  
  $this->load->view('page_footer'); 
?>

