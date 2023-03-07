<!DOCTYPE html>
<html>
<head>
<title>Pateikti prašymą </title>

<script src="<?php echo base_url(); ?>assets/js/vue.js"></script>
<script src="<?php echo base_url(); ?>assets/js/axios.min.js"></script>

<script>


function getExtention(fileName) {
  dots = fileName.split(".");
return dots[dots.length-1];
}

function isExtValid(ext) {
    if(!(ext=='pdf' ||  ext=='doc' ||  ext=='docx' || ext=='PDF' ||  ext=='DOC' ||  ext=='DOCX' |  ext=='zip' |  ext=='ZIP' )) {
  //  alert('Galima pateikti tik PDF, ZIP, DOC arba DOCX failus!');
  document.getElementById("pratur").innerHTML = "<strong>Galima pateikti tik PDF, ZIP, DOC arba DOCX failus!</strong>";
		  $('#pranesimas').show();
             return false;
    }
	return true;
}
function mouseOn(x) {x.src = "<?php echo base_url() . 'assets/img/d1.png'; ?>";}      
function mouseOut(x) {x.src = "<?php echo base_url() . 'assets/img/d2.png'; ?>";}
</script>

<style>

.form-group {display:block; margin-bottom:10px;}

  input[type="file"]{
    position: absolute;
    top: -120px;
  }
 div.file-listing{
    width: 600px; margin-bottom:10px;
  }

  span.remove-file{
    color: red;
    cursor: pointer;
    
  }
</style>



<?php $this->load->view('page_header'); ?>

<?php $this->load->view('page_menu'); ?>


<div class="col-md-9">


<h3>PRAŠYMŲ TEIKIMAS</h3>



<ol>  
<li>Nurodykite pramoninės nuosavybės objekto (PNO) paraiškos, registracijos ar patento numerį (-ius) <i>PNO Nr.</i> laukelyje. Jeigu nurodote keletą numerių, juos atskirkite kableliais, pavyzdžiui, 2011 2222, 2012 3333.</li>   
<li>Nurodykite prašymo failus paspaudę mygtuką <i>Pasirinkti...</i>
<li>Jei reikia, į pastabų laukelį įrašykite papildomą informaciją.</li>
    <li>Spauskite mygtuką <i>Siųsti</i>.</li>
	
	<br>
	
	<div id='vueapp'>


<template>
 

<div class="form-group">
      <label>PNO Nr. <span style="color:red;">*</span> </label>
        
		<textarea class="form-control"  v-model="ip" rows="1" cols="60" name="ip" id="ip1" ref="ip"></textarea>
</div>

<div class="form-group">
      <label>Pastabos </label>
        
		<textarea class="form-control" v-model="pastabos" rows="1" cols="60" name="pastabos" ref="pastabos"></textarea>
</div>

<div class="form-group">
      <label>Failai <span style="color:red;">*</span></label>
        <input type="file" id="files"  ref="files" multiple v-on:change="handleFilesUpload()" style='visibility:hidden;' />
</div>

<div class="form-group">
     <button v-on:click="addFiles()" class="btn btn-outline-primary"  style="width:100px;">Pasirinkti...</button>&nbsp;&nbsp;&nbsp;
	 <button  @click="valyti()"  class="btn btn-outline-primary"  style="width:100px;"> Išvalyti </button>
</div>



 <div class="form-group">
<div v-for="(file, key) in files" class="file-listing">
<label><span  class="remove-file" v-on:click="removeFile( key )"><img src="<?php echo base_url() . 'assets/img/d2.png'; ?> "   title="Atsisakyti"  onmouseover="mouseOn(this)" onmouseout="mouseOut(this)"  /></span> &nbsp;&nbsp; </label>{{ file.name }}
 </div>       
</div>

</div>

<div class="form-group">
 
<button  @click.prevent="submitFiles()" type="submit" class="btn btn-outline-primary" style="width:100px;" id="submit" > Siųsti &nbsp;&nbsp;&nbsp;</button>
&nbsp;&nbsp;
<div class='spinner-border text-primary' id='progress' style='visibility:hidden;' ></div>

 <br><br>
 
 <div class="alert alert-warning   collapse"   id="pranesimas"  >  
    <button type="button" class="close"     >&times;</button>
   <div id="pratur"></div>
  </div>
  
 
 
 <span style="color:green;font-size:1.1em;font-weight:bold;" id="rez"></span>
 
</div>  <!-- form-group -->


</template>
<p><span style='color:red;'>*</span> &#8211; privalomi laukai.</p>

</div>

<script>

  

var app = new Vue({        
  el: '#vueapp', 


 data:{
       
    files: [],
	ip : '',
	pastabos : '',
        
    },

  mounted: function () {      
    console.log('mounted');
  },

  methods: {
 addFiles(){								
        this.$refs.files.click();
		document.getElementById('submit').disabled = false;
		 document.getElementById('rez').innerHTML = '';
      },
	  
	  
    submitFiles() {
		
		var numRegex =  /^([0-9a-zA-Z,; ]){4,254}$/; 
		
		if(!numRegex.test(this.ip)) { 
		document.getElementById("pratur").innerHTML = "<strong>Reikia nurodyti PNO Nr.!</strong>";
		  $('#pranesimas').show(); 
		document.getElementById('ip1').focus();
		return; }
	

	if(this.files.length == 0) {
	 document.getElementById("pratur").innerHTML = "<strong>Nepasirinktas joks failas!</strong>";
		  $('#pranesimas').show(); 
		  return;
	  }	
		
		 document.getElementById('progress').style.visibility = 'visible';
 let formData = new FormData();
formData.append('ip', this.ip);
formData.append('pastabos', this.pastabos);

for( var i = 0; i < this.files.length; i++ ){
  let file = this.files[i];
  formData.append('files[' + i + ']', file);
}
   
axios.post('<?php echo base_url();?>index.php/upload/up',
  formData,
  {
    headers: {
        'Content-Type': 'multipart/form-data'
    }
  }
).then(function(response){
  console.log('SUCCESS!!');
   document.getElementById('progress').style.visibility = 'hidden'; 
   document.getElementById('rez').innerHTML = "Failai išsiųsti sėkmingai. Prašymo Nr. " + response.data.msg + ".";
  
  
 app.files = [];
  
})
.catch(function(){
  console.log('FAILURE!!');
 // alert('Nepavyko išsiųsti!');
   document.getElementById("pratur").innerHTML = "<strong>Nepavyko išsiųsti!</strong>";
		  $('#pranesimas').show(); 
  document.getElementById('progress').style.visibility = 'hidden';
});
},

 handleFilesUpload(){
	console.log('File uploadai___');
	let uploadedFiles = this.$refs.files.files;
	
	if((this.files.length + uploadedFiles.length) > 10) 
	
	{
	//alert('Galima pateikti ne daugiau kaip 10 failų!');  
	 document.getElementById("pratur").innerHTML = "<strong>Galima pateikti ne daugiau kaip 10 failų!</strong>";
		  $('#pranesimas').show(); 
	return;
	 }    

for( var i = 0; i < uploadedFiles.length; i++ ){
 
 if(!isExtValid(getExtention(uploadedFiles[i].name)))  return;
  var num  = uploadedFiles[i].size/1024/1024;
 var numstr = num.toFixed(2) + " MB";
  if(num > 10) { 
  //alert("Failo dydis neturi viršyti 10 MB. " + uploadedFiles[i].name + " dydis yra " + numstr);      
  document.getElementById("pratur").innerHTML = "<strong>Failo dydis neturi viršyti 10 MB. " + uploadedFiles[i].name + " dydis yra " + numstr + "!</strong>";
		  $('#pranesimas').show(); 
		  return;
   }
  
}


for( var i = 0; i < uploadedFiles.length; i++ ){
   if (uploadedFiles[i].name.length > 30){ 
  // alert("Failo vardas neturi viršyti 30 ženklų! " + uploadedFiles[i].name + " sudaro " + uploadedFiles[i].name.length +  " ženklai"); 
    document.getElementById("pratur").innerHTML = "<strong>Failo vardas neturi viršyti 30 ženklų! " + uploadedFiles[i].name + " sudaro " + uploadedFiles[i].name.length +  " ženklai!</strong>";
		  $('#pranesimas').show(); 

   
   return; 
   } 
}




for( var i = 0; i < uploadedFiles.length; i++ ){
  this.files.push( uploadedFiles[i] );
} 

      },//handleFilesUpload

removeFile( key ){
this.files.splice( key, 1 );
},

valyti(){   		           
	this.ip = '';
	this.files = [];
	this.pastabos = '';
	document.getElementById('rez').innerHTML = "";
	document.getElementById('ip1').focus();
	document.getElementById("pratur").innerHTML = "";
	$('#pranesimas').hide(); 
}

   
  }, //methods

computed: {

}//computed


});   //vue




$(document).ready(function(){
   $(".active").removeClass("active");
   $("#upload").addClass("active");
   $("#ip1").focus();
   
   	$('#pranesimas').hide();
});
 
$(function() {
   $(document).on('click', '.close', function() {
       $(this).parent().hide();
   })
});

</script>





<p><b>Jeigu už paslaugą mokate ne per Elektroninius valdžios vartus, būtinai nurodykite mokėjimo duomenis prašymuose arba pastabų laukelyje, pavyzdžiui, pavedimo Nr. 58; mokėjimo data 2010-11-15; mokėtojas Vardenis Pavardenis (arba
UAB „Pavadinimas“); mokėjimo paskirtis: už prekių ženklo Nr. 55555 išrašo išdavimą. Atsiimant dokumentus  Valstybiniam patentų biurui būtina pateikti mokamąjį pavedimą su banko žymomis arba kvitą.</b> </p>

<p> Kiekvieno failo dydis neturi viršyti <b> 10 MB</b>, o vardas turi būti ne ilgesnis kaip 20 ženklų. Priimami formatai yra .doc, .docx, .zip ir .pdf.  </p>



<p >Mokėjimo duomenis taip pat galite nurodyti  pridėdami mokėjimo dokumento kopiją .pdf formatu.</p>






</div> <!-- col -->


<?php 
	
	

  $this->load->view('page_footer'); 
	?>
