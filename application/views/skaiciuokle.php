<!DOCTYPE html>
<html>
<head>
<title>Metiniai mokesčiai</title>

<script src="<?php echo base_url(); ?>assets/js/axios.min.js"></script>


<script type="text/javascript" >

function blurr(lau) {lau.style.backgroundColor = ""; }



function pateikti() {  
	//validation:
	
countVisus();
var pal = false;

var lent = document.getElementById("lent");
var countfile = lent.getElementsByTagName("tr").length-1;

for(i=1; i<=countfile; i++) {
 pnoid = 'pno_' + i;
 metaiid = 'metai_'+i;

var pat = document.getElementById(pnoid).value;

if (pat.substr(0, 1) == 'C' || pat.substr(0, 1) == 'c')
{
pal = true;
var test = pat.substr(1); 
if(!isNumeric(test)) 
 {
        //alert('Reikia teisingai nurodyti PAL numerį');
		document.getElementById("pratur").innerHTML = "<strong>Reikia teisingai nurodyti PAL numerį!</strong>";
		  $('#pranesimas').show(); 
		
			document.getElementById(pnoid).style.backgroundColor = "#ffcccc";  
	        document.getElementById(pnoid).focus();
        return false;
        } 
if(test.length < 4) {
  // alert('Reikia teisingai nurodyti PAL numerį');
   document.getElementById("pratur").innerHTML = "<strong>Reikia teisingai nurodyti PAL numerį!</strong>";
		  $('#pranesimas').show(); 
        document.getElementById(pnoid).focus();
		document.getElementById(pnoid).style.backgroundColor = "#ffcccc";
        return false;
        } 

} else {



if(!isNumeric(pat)) 
 {
      //  alert('Reikia teisingai nurodyti patento numerį (be EP, LT)');
	  document.getElementById("pratur").innerHTML = "<strong>Reikia teisingai nurodyti patento numerį (be EP, LT)!</strong>";
		  $('#pranesimas').show(); 
        document.getElementById(pnoid).focus();
		document.getElementById(pnoid).style.backgroundColor = "#ffcccc";
        return false;
        } 
        
var rx =  /^([0-9]){4,7}$/;    
    if(!rx.test(pat))
 {
        //alert('Reikia teisingai nurodyti patento numerį (be EP, LT)');
		 document.getElementById("pratur").innerHTML = "<strong>Reikia teisingai nurodyti patento numerį (be EP, LT)!</strong>";
		  $('#pranesimas').show(); 
        document.getElementById(pnoid).focus();
		document.getElementById(pnoid).style.backgroundColor = "#ffcccc";
        return false;
        } 



if(document.getElementById(pnoid).value.length < 4) {
  // alert('Reikia nurodyti patento numerį');
   document.getElementById("pratur").innerHTML = "<strong>Reikia teisingai nurodyti patento numerį!</strong>";
		  $('#pranesimas').show(); 
        document.getElementById(pnoid).focus();
		document.getElementById(pnoid).style.backgroundColor = "#ffcccc";
        return false;
        } 

        if(document.getElementById(pnoid).value.length > 7) {
   //alert('Reikia teisingai nurodyti patento numerį');
   document.getElementById("pratur").innerHTML = "<strong>Reikia teisingai nurodyti patento numerį!</strong>";
		  $('#pranesimas').show();
        document.getElementById(pnoid).focus();
		document.getElementById(pnoid).style.backgroundColor = "#ffcccc";
        return false;
        } 

}//else

var metai = document.getElementById(metaiid).value;
var metaisk = parseInt(metai);

if( metai== "") {
   //alert('Reikia nurodyti metus');
    document.getElementById("pratur").innerHTML = "<strong>Reikia nurodyti metus!</strong>";
		  $('#pranesimas').show();
        document.getElementById(metaiid).focus();
		document.getElementById(metaiid).style.backgroundColor = "#ffcccc";
        return false;
        } 

if(!isNumeric(metai)) 
 {
       // alert('Reikia teisingai nurodyti metus');
	   document.getElementById("pratur").innerHTML = "<strong>Reikia teisingai nurodyti metus!</strong>";
		  $('#pranesimas').show();
        document.getElementById(metaiid).focus();
		document.getElementById(metaiid).style.backgroundColor = "#ffcccc";
        return false;
        } 

if (pal) {

if ((metaisk < 1) || (metaisk>5)) {
   //alert('PAL metai turi būti nuo 1 iki 5');
   document.getElementById("pratur").innerHTML = "<strong>PAL metai turi būti nuo 1 iki 5!</strong>";
		  $('#pranesimas').show();
        document.getElementById(metaiid).focus();
		document.getElementById(metaiid).style.backgroundColor = "#ffcccc";
        return false;
        } 

} else {

if ((metaisk < 3) || (metaisk>20)) {
  // alert('Metai turi būti nuo 3 iki 20');
    document.getElementById("pratur").innerHTML = "<strong>Metai turi būti nuo 3 iki 20!</strong>";
		  $('#pranesimas').show();
        document.getElementById(metaiid).focus();
		document.getElementById(metaiid).style.backgroundColor = "#ffcccc";
        return false;
        } 
}//else

pal = false;
}  //for   



// end validation
		
document.getElementById('progress').style.visibility = 'visible';
 let formData = new FormData();
formData.append('ip', document.getElementById('ip1').value);  
formData.append('pastabos', document.getElementById('pastabos').value);
formData.append('viso', document.getElementById('viso').value);
axios.post( 'skaiciuokle/pateikti',								
  formData,
  {
    headers: {
        'Content-Type': 'multipart/form-data'
    }
  }
).then(function(response){
  console.log('SUCCESS!!');
   document.getElementById('progress').style.visibility = 'hidden';
   document.getElementById('siunt').disabled = true;
   document.getElementById('rez').innerHTML = "Prašymas priimtas. Už paslaugą galite sumokėti per <a href='moketi.php'>Elektroninius valdžios vartus.</a> Prašymo Nr. " +  response.data.msg + ".";
  
  //Notiflix.Notify.Success('Failai išsiųsti sėkmingai!');  //? nereikia? 
 
   
})
.catch(function(){
  console.log('FAILURE!!');
  //alert('Nepavyko išsiųsti!');
  document.getElementById("pratur").innerHTML = "<strong>Nepavyko išsiųsti!</strong>";
		  $('#pranesimas').show(); 
  document.getElementById('progress').style.visibility = 'hidden';
});
}



function clearForm2(oForm)
{  
var elements = oForm.elements;

   
  oForm.reset();


  for(i=0; i<elements.length; i++) {
     
  field_type = elements[i].type.toLowerCase();
 
  switch(field_type) {
 
    case "text":
    case "textarea":
    elements[i].value = "";
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
setFocus();
document.getElementById('progress').style.visibility = 'hidden';
document.getElementById('rez').innerHTML = "";
document.getElementById('siunt').disabled = false;
document.getElementById("pno_1").style.backgroundColor = "";
document.getElementById("metai_1").style.backgroundColor = "";
document.getElementById('viso').value = "";
$('#pranesimas').hide(); 
}






function isNumeric(n) { 
      return !isNaN(parseInt(n)) && isFinite(n); 
}





function addField(){

    var lent = document.getElementById("lent");
var rowCount = lent.getElementsByTagName("tr").length;

if(rowCount>20) {
	//alert("Daugiau pridėti failų negalima!"); 
	  document.getElementById("pratur").innerHTML = "<strong>Daugiau pridėti failų negalima!</strong>";
		  $('#pranesimas').show(); 
	return;}
var newp = document.createElement('p');

countfile = rowCount;

var pno = document.getElementById('pno_1').cloneNode(true);
pno.setAttribute("id", "pno_"+countfile);
pno.setAttribute("name", "pno_"+countfile);
pno.value = "";

var metai = document.getElementById('metai_1').cloneNode(true);
metai.setAttribute("id", "metai_"+countfile);
metai.setAttribute("name", "metai_"+countfile);
metai.value = "";


var ck = document.getElementById('ck_1').cloneNode(true); 
ck.setAttribute("id", "ck_"+countfile);  
ck.setAttribute("name", "ck_"+countfile);  
ck.checked = false;

var ck2 = document.getElementById('ck2_1').cloneNode(true); 
ck2.setAttribute("id", "ck2_"+countfile);  
ck2.setAttribute("name", "ck2_"+countfile);  
ck2.checked = false;


var suma = document.getElementById('suma_1').cloneNode(true);
suma.setAttribute("id", "suma_"+countfile);
suma.setAttribute("name", "suma_"+countfile);
suma.value = "";

var info = document.getElementById('info_1').cloneNode(true);
info.setAttribute("id", "info_"+countfile);
info.setAttribute("name", "info_"+countfile);
info.value = "";

//var nr = "" + countfile;


var tableRef = document.getElementById('lent').getElementsByTagName('tbody')[0];
var newRow   = tableRef.insertRow(tableRef.rows.length);

var newCell0  = newRow.insertCell(0);
var newCell1  = newRow.insertCell(1);
var newCell2  = newRow.insertCell(2);
var newCell3  = newRow.insertCell(3);
var newCell4  = newRow.insertCell(4);
var newCell5  = newRow.insertCell(5);
var newCell6  = newRow.insertCell(6);
var newCell7  = newRow.insertCell(7);



newCell0.innerHTML=rowCount+"";
newCell1.appendChild(pno);
newCell2.appendChild(metai);
newCell3.appendChild(ck);
newCell4.appendChild(ck2);
newCell5.appendChild(suma);
newCell6.appendChild(info);
//newCell7.innerHTML  ="<button onclick='javascript:deleteRow(this);'  />";  

<?php   $im = base_url() . 'assets/img/d2.png';  ?>
newCell7.innerHTML  ="<img  onclick='javascript:deleteRow(this);' src='<?php echo $im ?>' onmouseover='mouseOn(this)' onmouseout='mouseOut(this)' title='Trinti eilutę' >"; 


 countVisus();
 pno.focus();
 
pno.style.backgroundColor = "";
metai.style.backgroundColor = "";
 
}


function mouseOn(x) {x.src = '<?php echo base_url() . 'assets/img/d1.png'; ?>';}
function mouseOut(x) {x.src = '<?php echo base_url() . 'assets/img/d2.png'; ?>';}



function countVisus(){

var lent = document.getElementById("lent");
var countfile = lent.getElementsByTagName("tr").length;

  visosuma = 0; 
  var mokejimoPaskirtis = "";
  var pnosarasas = "";
for (i = 1; i <= (countfile-1); i++) { 
var  arr =  countMok(i);
visosuma += arr[0]; 
var suma = arr[0];  
var metai = arr[1];  
var pno  = arr[2];  
var info  = arr[3];
	if(mokejimoPaskirtis=="") 
	mokejimoPaskirtis +=  pno + ":" + metai + ":" + suma + ":" + info; 
	//mokejimoPaskirtis +=  metai + ":" + suma;
	else 
	mokejimoPaskirtis +=  " " + pno + ":" + metai + ":" + suma + ":" + info;
	//mokejimoPaskirtis +=  "-" + metai + ":" + suma;
if(pnosarasas=="") pnosarasas += pno; else pnosarasas += ", " + pno; 
}

var viso =  document.getElementById('viso');
viso.value = visosuma.toFixed(2);
var pastabos = document.getElementById('pastabos');
pastabos.value = mokejimoPaskirtis;
var pnoinput = document.getElementById('ip1');
pnoinput.value =  "(" + visosuma.toFixed(2) + " EUR) "+pnosarasas;
}




function countMok(i){
var moketi = 0;
var pno = document.getElementById('pno_'+i);
var metai = document.getElementById('metai_'+i);
var ck = document.getElementById('ck_'+i);
var ck2 = document.getElementById('ck2_'+i);
var suma = document.getElementById('suma_'+i);
var info = document.getElementById('info_'+i);

    switch(metai.value.trim()) {               
        case "3":
           moketi = 81;
            break;
 	case  "03":
           moketi = 81;
            break;
        case "4":
            moketi = 92;
            break;
	case "04":
            moketi = 92;
            break;
        case "5":
            moketi = 115;
            break;
	case "05":
            moketi = 115;
            break;
        case "6":
            moketi = 139;
            break; 
	case "06":
            moketi = 139;
            break; 
        case "7":
            moketi = 162;
            break;  
	case "07":
            moketi = 162;
            break;  
        case "8":
            moketi = 185;
            break;   
	case "08":
            moketi = 185;
            break;  
        case "9":
            moketi = 208;
            break; 
 	case "09":
            moketi = 208;
            break; 
        case "10":
            moketi = 231;
            break; 
        case "11":
            moketi = 289;
            break; 
        case "12":
            moketi = 289;
            break; 
        case "13":
            moketi = 289;
            break; 
        case "14":
            moketi = 289;
            break; 
        case "15":
            moketi = 289;
            break; 
        case "16":
            moketi = 347;
            break; 
        case "17":
            moketi = 347;
            break; 
        case "18":
            moketi = 347;
            break; 
        case "19":
            moketi = 347;
            break; 
        case "20":
            moketi = 347;
            break;    
       
        default: 
        moketi = 0;     
    }



// PAL:
if (pno.value.substr(0, 1) == 'C' || pno.value.substr(0, 1) == 'c') 
{  
moketi = 347;
}


    if(ck.checked) moketi = moketi * 1.5;
    if(ck2.checked) moketi = moketi * 0.5;

suma.value = moketi.toFixed(2);
var sumaMetaiPnoArray = new Array(4);
        sumaMetaiPnoArray[0] = moketi;
        sumaMetaiPnoArray[1] = metai.value.trim();
        sumaMetaiPnoArray[2] = pno.value;
	sumaMetaiPnoArray[3] = info.value;
return sumaMetaiPnoArray;
}



function deleteRow(r) {  
var lent = document.getElementById("lent");
var rowCount = lent.getElementsByTagName("tr").length;
var row = r.parentNode.parentNode;
var rowIdx  = row.rowIndex;
lent.deleteRow(rowIdx);

for (var i = rowIdx; i < (rowCount-1); i++) { 
	for (var c = 0; c < lent.rows[i].cells.length;  c++) {
	if(c==0) { lent.rows[i].cells[c].innerHTML = i;} 
	if(c==1) { lent.rows[i].cells[c].children[0].setAttribute("id", "pno_"+i); 
	lent.rows[i].cells[c].children[0].setAttribute("name", "pno_"+i);
	 } 
	if(c==2) { lent.rows[i].cells[c].children[0].setAttribute("id", "metai_"+i);  
	lent.rows[i].cells[c].children[0].setAttribute("name", "metai_"+i);
	 } 
	if(c==3) { lent.rows[i].cells[c].children[0].setAttribute("id", "ck_"+i);  
	lent.rows[i].cells[c].children[0].setAttribute("name", "ck_"+i);
	 } 
	if(c==4) { lent.rows[i].cells[c].children[0].setAttribute("id", "ck2_"+i);  
	lent.rows[i].cells[c].children[0].setAttribute("name", "ck2_"+i);
	 } 
	if(c==5) { lent.rows[i].cells[c].children[0].setAttribute("id", "suma_"+i);  
	lent.rows[i].cells[c].children[0].setAttribute("name", "suma_"+i);
	 }  
	  if(c==6) { lent.rows[i].cells[c].children[0].setAttribute("id", "info_"+i);  
	lent.rows[i].cells[c].children[0].setAttribute("name", "info_"+i);
	 }   
	 }// for c
       

}//for i

countVisus();

}// end function




  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
           { 
             return false;
           }
         return true;
      }


      function setFocus(){
    document.getElementById("pno_1").focus();
}

</script>








<?php $this->load->view('page_header'); ?>

<?php $this->load->view('page_menu'); ?>


<div class="col-md-9">


<h3>PATENTŲ IR PAPILDOMOS APSAUGOS LIUDIJIMŲ (PAL) GALIOJIMO PRATĘSIMAS</h3>




<form 
        action=""
        method=""
	 name="myForm" 
	style="display: inline;"
	onsubmit="" 
    autocomplete="off" >

<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />


<textarea rows="1" cols="6" name='ip' id='ip1' placeholder="Nereikia pildyti" style="visibility:hidden;"></textarea>

<textarea rows="1" cols="6" id='pastabos' name='pastabos' placeholder="Nereikia pildyti" style="visibility:hidden;"></textarea>



<table id="lent" name="lent" class="table"><tr style="font-weight:bold;"><td></td> 
<td>Patento, PAL Nr. <span style='color:red;'>*</span> </td>
<td>Metai<span style='color:red;'>*</span> </td>
<td>x1,5</td><td>x0,5</td>
<td>Suma </td><td>Info</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
<tr><td>1</td>
<td><input type="text"  name="pno_1" size="10" id="pno_1" onkeydown="blurr(this)" onkeyup="countVisus()" maxlength="8"  /></td>
<td><input type="text" name="metai_1" size="4" id="metai_1"  onkeydown="blurr(this)"  onkeyup="countVisus()" maxlength="2" /></td>
<td><input type="checkbox" name="ck_1"  id="ck_1" onchange="countVisus()" /></td>
<td><input type="checkbox" name="ck2_1"  id="ck2_1" onchange="countVisus()" /></td>
<td><input type="text" name="suma_1" size="10" id="suma_1" disabled /></td>
<td><input type="text" name="info_1" size="5" id="info_1"   onkeyup="countVisus()" maxlength="5" /></td>
<td></td>
</tr>
</table>
</p>





</form>

<button class="btn btn-outline-primary" id="siunt" onclick='pateikti();' > Siųsti</button>




&nbsp;<div class='spinner-border text-primary' id='progress' style='visibility:hidden;' ></div>&nbsp;

  

<button class="btn btn-outline-primary" onclick='addField();' > Pridėti prašymą</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button class="btn btn-outline-primary" onclick='clearForm2(document.forms[0])' > Išvalyti</button>

<div style="float:right;font-weight:bold;">Viso, EUR&nbsp;
<input type="text" id="viso" name="viso" size="8" style="font-weight:bold;"  class="btn btn-outline-primary" />
</div>
<br><br>
 <div class="alert alert-warning  collapse "   id="pranesimas"  >  
    <button type="button" class="close"     >&times;</button>
   <div id="pratur">TEST</div>
  </div>

<p style="color:green;font-weight:bold;" id="rez"></p>





<p><span style='color:red;'>*</span> &#8211; privalomi laukai.</p>


<p>„Info“ lauke galima įrašyti papildomą informaciją, pavyzdžiui, mokėjimo dokumento numerį.</p>
<p>Jei mokėsite per šią sistemą iš karto po prašymų pateikimo, sumos, prašymo numerio ir mokėjimo paskirties laukai bus užpildyti automatiškai. </p>


<p>Jei mokate už papildomos apsaugos liudijimo galiojimą, „Patento, PAL Nr.“ lauke prieš patento numerį įrašykite raidę C, pavyzdžiui, C4512455.</p>
<p><span style='color: red;font-weight: bold;'>Svarbu! </span>Jei mokėsite ne per šią sistemą, o tiesiogiai banko pavedimu, mokėjimo paskirties lauke <b>būtinai</b> nurodykite prašymo numerį taip: EPAS:8456, čia 8456 yra sistemos suteiktas prašymo numeris. </p><br>







<!--   *********************************************************************   -->




<br><br>
<h3>METINIAI MOKESČIAI CSV FORMATU</h3><BR>


<p>Metinių mokesčių duomenis galima  pateikti CSV formatu (patento/PAL numeris;metai;koeficientas;info), pavyzdžiui:</p>
<p>6541258;15;1.0;info<br>
C6541258;5;1.5<br>
6541;15;0.5;LT7000045544</p>
<p>Koeficientas gali būti 1.0, 1.5 arba 0.5. Papildomos informacijos (info) lauke galima įvesti iki 15 ženklų, pavyzdžiui,
 mokėjimo dokumento numerį, žymą ir pan. Didžiausias leidžiamas 
eilučių skaičius yra 200.</p>

<div class="alert alert-warning  collapse "   id="csvpranesimas"  >  
    <button type="button" class="close"     >&times;</button>
   <div id="csvpratur">CSV</div>
  </div>

<div class="row">
<div class="col-sm-7">

    <textarea placeholder="Metiniai mokesčiai CSV formatu" name="csv" class="form-control" id="csv" rows="20" cols="50" maxlength="10000" style="resize:none;" ></textarea>
</div>

<div class="col-sm-5">
<button class="btn btn-outline-primary" id="siusti" onclick="csv()">Siųsti</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-outline-primary" onclick="valyti();">Išvalyti</button>
  <p id="klaidos" style="color:red;"></p><p id="suma" style="color:green;"></p><p id="siuntimas" style="color:green;font-weight: bold;"></p>
</div>
</div>
<br>



<script type="text/javascript" >
//Notiflix.Notify.Init({ timeout:4000, fontSize:'13px', position:'left-bottom', distance:'85px', useIcon:false, messageMaxLength:240});

var SendInfo=[];
var klaidos = "";

function valyti(){
 document.getElementById('csv').value="";  
document.getElementById('siusti').disabled = false;
document.getElementById('csv').focus(); 
$('#klaidos').html("");  
$('#suma').html(""); 
$('#siuntimas').html('');
SendInfo.length = 0;
klaidos = "";
 $('#csvpranesimas').hide();
}

function csv() { 
 SendInfo.length = 0;
 

var lines = $('#csv').val().split('\n');  
var number_of_line = 0;
var suma = 0;
klaidos = "";
var valid = true;
$('#klaidos').html("");

lines.forEach(function(line) {

if(line.length != 0) number_of_line++; else return;
var patentas = line.split(';');
var patnr = patentas[0];
var metai = patentas[1];
var koef = patentas[2];
var info = patentas[3];
var pal = false;
var sum = 0;
var eilute = {};

//validate patnr/palnr
if(patnr.toUpperCase().startsWith('C') )
{
pal = true; 
if (!((patnr.substring(1).length == 7) || (patnr.substring(1).length == 4)) || (isNaN(patnr.substring(1)))) { klaidos+="<br>" + number_of_line +" eilutėje neteisingas PAL numeris " + patnr;  valid = false;}
}//if
else {
if ( !((patnr.length == 7) || (patnr.length == 4)) || (isNaN(patnr) )) { klaidos+="<br>" + number_of_line +" eilutėje neteisingas patento numeris " + patnr;  valid = false;}
//and not pal?
}

if(valid) eilute.patnr = patnr;  


//validate metai
if(pal) {   
if(!['1','2','3','4','5','01','02','03','04','05'].includes(metai)) {klaidos+="<br>" + number_of_line +" eilutėje neteisingi PAL metai " + metai;  valid = false;} else {sum = 347;}
}
else
{    
if(isNaN(metai) || parseInt(metai) < 3 || parseInt(metai) > 20) {klaidos+="<br>" + number_of_line +" eilutėje neteisingi patento metai " + metai;  valid = false;}
sum = getMok(metai);
}

if(valid) eilute.metai = metai; 

//validate koef
if(!['1.0','1.5','0.5'].includes(koef)) { klaidos+="<br>" + number_of_line +" eilutėje neteisingas mokėjimo koeficientas " + koef;  valid = false;}
if(valid) {eilute.koef = koef; suma += sum * Number.parseFloat(koef).toFixed(2);  eilute.suma = sum * Number.parseFloat(koef).toFixed(2);}  else {suma = 0;}

//validate info

if(info && (info.length > 15)) { klaidos+="<br>" + number_of_line +" eilutėje info laukas per ilgas.";  valid = false;}
if(valid) eilute.info = info; 

SendInfo.push(eilute);

console.log('Line is ' + patnr + ' ' + metai + ' ' + koef + ' ' + info);
});



if (number_of_line > 200) {klaidos+="<br>Viršytas didžiausias leidžiamas eilučių skaičius (200)."; valid = false;}
if (number_of_line < 1) {klaidos="<br>Nėra duomenų"; valid = false;}			

if(!valid) {
	//alert('Duomenyse yra klaidų!');
	document.getElementById("csvpratur").innerHTML = "<strong>Duomenyse yra klaidų!</strong>";
		  $('#csvpranesimas').show();
	suma = 0; $('#klaidos').html(klaidos); return; 
	}

$('#suma').html('Suma: ' + suma.toFixed(2) + ' Eur');
document.getElementById('siusti').disabled = true;
$('#siuntimas').html('Siunčiami duomenys...');

$.ajax({
            url: 'skaiciuokle/csv',
            type: 'post',
            dataType: 'json',
			data: JSON.stringify(SendInfo),
            contentType: 'application/json',
            success: function (data) {
               $('#siuntimas').html('Duomenys sėkmingai išsiųsti');
			   $('#siuntimas').html(data.msg);
            }          
        });

}//func csv


function getMok(metai){
var moketi = 0;
    switch(metai) {               
        case "3":
           moketi = 81;
            break;
 	case  "03":
           moketi = 81;
            break;
        case "4":
            moketi = 92;
            break;
	case "04":
            moketi = 92;
            break;
        case "5":
            moketi = 115;
            break;
	case "05":
            moketi = 115;
            break;
        case "6":
            moketi = 139;
            break; 
	case "06":
            moketi = 139;
            break; 
        case "7":
            moketi = 162;
            break;  
	case "07":
            moketi = 162;
            break;  
        case "8":
            moketi = 185;
            break;   
	case "08":
            moketi = 185;
            break;  
        case "9":
            moketi = 208;
            break; 
 	case "09":
            moketi = 208;
            break; 
        case "10":
            moketi = 231;
            break; 
        case "11":
            moketi = 289;
            break; 
        case "12":
            moketi = 289;
            break; 
        case "13":
            moketi = 289;
            break; 
        case "14":
            moketi = 289;
            break; 
        case "15":
            moketi = 289;
            break; 
        case "16":
            moketi = 347;
            break; 
        case "17":
            moketi = 347;
            break; 
        case "18":
            moketi = 347;
            break; 
        case "19":
            moketi = 347;
            break; 
        case "20":
            moketi = 347;
            break;    
       
        default: 
        moketi = 0;     
    }
return moketi;
}

setFocus();


$(document).ready(function(){
   $(".active").removeClass("active");
   $("#skaic").addClass("active");
   $("#pno_1").focus();
});
 
$(function() {
   $(document).on('click', '.close', function() {
       $(this).parent().hide();
   })
});



</script>




<?php 
 echo " </div> <!-- content --> ";
 
  $this->load->view('page_footer'); 
?>




