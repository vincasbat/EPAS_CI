<!DOCTYPE html>
<html>
<head>
<title>Prašymų administravimas</title>



<script src="<?php echo base_url(); ?>assets/js/vue.js"></script>
<script src="<?php echo base_url(); ?>assets/js/axios.min.js"></script>



<script>

</script>
<?php $this->load->view('page_header'); ?>

<?php $this->load->view('page_menu'); ?>






<div class="col-md-9">






<div id='vueapp'>
<h3>PRAŠYMŲ ADMINISTRAVIMAS ({{prasymai.length}})</h3><br>
<p style='color:red;'>Dėmesio! Paspaudus <span style='font-weight: bold;'>Ištrinti</span> įrašas bus ištrintas iš duomenų bazės ir jo atkurti bus neįmanoma. </p>

 <div id="page-navigation">
    <button class="btn btn-outline-primary" @click=movePages(-1)><</button>&nbsp;&nbsp;
   {{startRow / rowsPerPage + 1}} iš {{Math.floor(prasymai.length / rowsPerPage)+1}}&nbsp;&nbsp;
    <button class="btn btn-outline-primary" @click=movePages(1)>></button>&nbsp;&nbsp;&nbsp;&nbsp;
    <button class="btn btn-outline-primary" @click=select :disabled="startRow!=0">SELECT</button>	
  </div>
<br>
 <div class="alert alert-success   collapse"   id="pranesimas"  >  
    <button type="button" class="close"     >&times;</button>
   <div id="pratur"></div>
  </div>


dok_id selected: {{selected}} <br><span id="msg" style="color:green;"></span>
<table class="table  table-hover" >
  
  <thead >
   <tr>
      <th><a href="#">Prašymo Nr.</a></th>
     <th><a href="#">Prašytojas</a></th>
     <th><a href="#">Data</a></th>
	 <th><a href="#">Statusas</a></th>
     <th><button class="btn btn-outline-danger" @click="arTrinti" style='color:red;'  :disabled="startRow!=0" >&times;</button>     </th>   <!--  :disabled="startRow!=0"  --> 
     
     

   </tr></thead>    
    

<tr v-for="(pra, index) in filteredItems" :key="pra.dok_id"  >

<td>{{pra.dok_id}}  </td>
 
     <td> {{pra.prasytojas}}</td>
 
     <td>{{pra.dab_statuso_data }}</td>
<td> <a :href="'./details_ataskaitos.php?dok_id=' + pra.dok_id "  >{{pra.status_dabar}}</a>    <!--  :???????  --> 
</td>
 
     <td><input type="checkbox" :value="pra.dok_id"  v-model="selected"/> </td>
    
   </tr>
 </table>
 
 </div>   <!--  end vue -->
 
 <script>
 var app = new Vue({       
  el: '#vueapp',  	
data: {
      
      prasymai: [],
   
  selected: [],
startRow: 0,
    rowsPerPage: 100,
},

 mounted: function () {    
    this.getPrasymai();   
 },
  methods: {
    getPrasymai: function(){
        axios.get('<?php echo base_url();?>index.php/prasymai/get_prasymai')
        .then(function (response) {
            console.log(response.data);
            app.prasymai = response.data;

        })
        .catch(function (error) {
            console.log(error);
        });
    },
	
	select: function() {
			this.selected = [];
				for (let i in this.prasymai) {
					this.selected.push(this.prasymai[i].dok_id);
				}
		},
		
		
		
		
		
		trinti: function () {
			//if(!confirm('Ar tikrai ištrinti?'))return;
			



 		$.ajax({
            url: '<?php echo base_url();?>index.php/prasymai/trinti', 
            type: 'post',
            dataType: 'json',
			data: JSON.stringify(this.selected),
            contentType: 'application/json',
            success: function (data) {        
			if(data.rez == 'OK') {     //alert(data.msg);  


let pasirinkti = app.selected;
for (i = 0; i<pasirinkti.length; i++) {
				 for (j = 0; j<app.prasymai.length; j++) {
				  if(pasirinkti[i] == app.prasymai[j].dok_id) 
				  {                                               
			  app.prasymai.splice(j,1);     } 
				  }
}

app.selected =[];



			//$('#msg').html(data.msg);
			$('#pratur').html(data.msg);
			 $('#pranesimas').show(); 
			}//if
            },   //success func  
            
            error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status); alert(xhr.responseText);
        alert(thrownError);
      }
            
                 
        });//ajax

		},//trinti

movePages: function(amount) {
      var newStartRow = this.startRow + (amount * this.rowsPerPage);
      if (newStartRow >= 0 && newStartRow < this.prasymai.length) {
        this.startRow = newStartRow;
      }
    },
    
 select: function(){
   var aa = document.querySelectorAll("input[type=checkbox]");
    for (var i = 0; i < aa.length; i++){
          aa[i].click();
        }
 },
 
 
 arTrinti: function (){
modalConfirm(function(confirm){
  if(confirm){  app.trinti();  return;  }else {  return; }
});
}
 
	
  },//meth
  
 computed: {
  filteredItems: function () {
    return this.prasymai.slice(this.startRow, this.startRow + this.rowsPerPage);
  }
} 
  

 });// vue
 
 
  
$(document).ready(function(){
   $(".active").removeClass("active");
   $("#prasymai").addClass("active");
});



 
 var modalConfirm = function(callback){
  
    $("#mi-modal").modal('show');

  $("#modal-btn-taip").on("click", function(){
    callback(true);
    $("#mi-modal").modal('hide');
  });
  
  $("#modal-btn-ne").on("click", function(){
    callback(false);
    $("#mi-modal").modal('hide');
  });
};



$(function() {
   $(document).on('click', '.close', function() {
       $(this).parent().hide();
   })
});


</script>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">E. paslaugų sistema EPAS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        
      </div>
      
      <div class="modal-body">
        <h5 class="text-danger" id="myModalLabel">Ar tikrai norite ištrinti šiuos prašymus?</h5>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-taip">Taip</button>
        <button type="button" class="btn btn-primary" id="modal-btn-ne">Ne</button>
      </div>
    </div>
  </div>
</div>










<?php




//-------------------------------  
 


 
  
 echo " </div> <!-- content --> ";
 

 
  $this->load->view('page_footer'); 
?>


