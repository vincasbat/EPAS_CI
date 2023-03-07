<!DOCTYPE html>
<html>
<head>
<title>Priėmimo skyrius</title>



<script src="<?php echo base_url(); ?>assets/js/vue.js"></script>
<script src="<?php echo base_url(); ?>assets/js/axios.min.js"></script>




<script>

function valyti() { 
		var images = document.getElementsByTagName("img");
		for(var i=0; i<images.length; i++) {
                images[i].style.backgroundColor = images[i].parentElement.style.backgroundColor;
                  }
	} 

</script>

<?php $this->load->view('page_header'); ?>
<?php $this->load->view('page_menu'); 


?>


<div class="col-md-9">



<div id='vueapp'>

<h3>GAUTI PRAŠYMAI ({{dokai.length}})</h3><br>

<?php if($this->session->flashdata('nerastaspra')): ?>
    
        <div class='alert alert-danger'>  <strong><?php echo $this->session->flashdata('nerastaspra'); ?></strong> </div>
    
<?php endif; ?>


<div id="page-navigation">
<button class="btn btn-outline-primary" :disabled="currentPage==1" @click="first">&lt;&lt;</button>
<button class="btn btn-outline-primary"  :disabled="currentPage==1" @click="prevPage">&lt;</button> 
{{currentPage}}   iš {{Math.floor(dokai.length / pageSize)+1}}
<button class="btn btn-outline-primary" :disabled="currentPage==Math.floor(dokai.length / pageSize)+1" @click="nextPage">&gt;</button>
<button class="btn btn-outline-primary" :disabled="currentPage==Math.floor(dokai.length / pageSize)+1" @click="last">&gt;&gt;</button>
</div>
<br>
<table  class="table table-hover" >
 <thead >
   <tr >
     <th>Nr.</th>
     <th>PNO Nr.</th>
     
     <th>ZIP/WORD</th>
     <th>Prašytojas</th>
     <th>Statusas</th>
     <th>Data</th>

   </tr></thead>  <!--  $doc_kelias = <?php base_url() . 'assets/img/pdf.png'; ?>   ;  -->
   
   <tr v-for='dokas in paged'>    
       <td>  <a v-bind:href="'prasymas?dok_id=' + dokas.dok_id">{{dokas.dok_id }}</a>  </td>    
<!--  <td> {{dokas.dok_id }}  </td>  -->

     <td>{{ dokas.ip }}</td>

  <!--  <td><div v-if="dokas.dok_kelias.length < 5"> <a v-bind:href="'pdf2.php?dokid=' + dokas.dok_id" v-bind:target="'_blank'">
        <img v-bind:src="'<?php echo base_url() . 'assets/img/pdf.png' ?>'"   v-on:click="marke" v-on:contextmenu="marke"/></a></div>
    </td>
 -->    
 
  <td><div v-if="dokas.dok_kelias.length < 5"> <a v-bind:href="'priemimas/word?dokid=' + dokas.dok_id">
     <img v-bind:src="'<?php echo base_url() . 'assets/img/word.png' ?>'"  v-on:click="marke" v-on:contextmenu="marke"/></a></div>
     <div v-else>
     <a v-bind:href="'priemimas/zip?dokid=' + dokas.dok_id"><img v-bind:src="'<?php echo base_url() . 'assets/img/zip.png' ?>'" 
  v-bind:title="dokas.pastabos" v-on:click="marke" v-on:contextmenu="marke" /></a></div>
  </td>
     <td>{{ dokas.pareiskejas }}</td>
     <td>{{ dokas.status_dabar }}</td>
     <td>{{ dokas.dab_statuso_data }}</td>
   </tr>
 </table>
 </br>
 
<p>
<button class="btn btn-outline-primary" :disabled="currentPage==1" @click="first">&lt;&lt;</button>
<button class="btn btn-outline-primary"  :disabled="currentPage==1" @click="prevPage">&lt;</button> 
{{currentPage}}   iš {{Math.floor(dokai.length / pageSize)+1}}
<button class="btn btn-outline-primary" :disabled="currentPage==Math.floor(dokai.length / pageSize)+1" @click="nextPage">&gt;</button>
<button class="btn btn-outline-primary" :disabled="currentPage==Math.floor(dokai.length / pageSize)+1" @click="last">&gt;&gt;</button>
</p>
 
</div>




 <script>
var app = new Vue({  
  el: '#vueapp',  
     
  data: {
      
      dokai: [],
     pageSize:25,
  	currentPage:1,
  },
  
  
  
  mounted: function () {
    this.getDokai();
    
  },

  methods: {
  
    imgsbg : function()        { 
		var images = document.getElementsByTagName("img");
		for(var i=0; i<images.length; i++) {
                images[i].style.backgroundColor = images[i].parentElement.style.backgroundColor;
             }
             },
  
  first: function() {this.currentPage = 1;   this.imgsbg();    },
  last: function ()  {this.currentPage =  Math.floor(this.dokai.length / this.pageSize)+1;    this.imgsbg(); },
  
    nextPage:function() {
  if((this.currentPage*this.pageSize) < this.dokai.length) {this.currentPage++;     this.imgsbg(); }
},
prevPage:function() {
  if(this.currentPage > 1) {this.currentPage--;     this.imgsbg(); }
},
  
  
    getDokai: function(){
      axios.get('<?php echo base_url();?>index.php/priemimas/get_dokai')
        .then(function (response) {
            console.log(response.data);
            app.dokai = response.data;
		app.last();
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    marke : function (event) {
      event.target.style.backgroundColor = 'green';  //event.target.parentElement.style.backgroundColor;
    },
    
  
    


  },//methods
  
  
  computed:{
 
  paged:function() {
	return this.dokai.filter((row, index) => {
		let start = (this.currentPage-1)*this.pageSize;
		let end = this.currentPage*this.pageSize;
		if(index >= start && index < end) return true;
	});
}  
 }//computed
  
  
});

$(document).ready(function(){
   $(".active").removeClass("active");
   $("#priemimas").addClass("active");
  });  
</script>

</div>
<?php
 
  $this->load->view('page_footer'); 
?>

