
<!DOCTYPE html>
<html>
<head><title>Skambučių statistika</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="./style/styles.css">
<link rel="shortcut icon" href="favicon.ico">

<script src="./vue.js"></script>

 <script src="daypilot/daypilot-all.min.js" type="text/javascript"></script>
 <script type="text/javascript" src="./jquery-1.11.1.min.js"></script>
<script src="./vue.js"></script>
<script src="./js/main.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	
	  google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

       </script>



<style type="text/css">

table.blueTable {
  border: 0px solid #1C6EA4;
  background-color: #D0E4F5;
  width: 80%;
  text-align: left;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 0px solid #FFFFFF;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 13px;
}
table.blueTable tr:nth-child(even) {
  background: #E6F1F5;
}


table.blueTable tbody tr {
   background: #D0E4F5;
}



table.blueTable thead {
  background: #1C6EA4;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 2px solid white;
}
table.blueTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}







#nav a  {
display: block;
}
</style>


</head>
<body onload='main()'>



<div id="container">
   <div id="header">

<?php      
include("header.inc");
include "./get/conf.php";

$cxn = mysqli_connect($host,$user,$passwd,$dbname)  or die("Failed to connect to MySQL: " . mysqli_error());


?>
</div>
<div id='nav' style="float:left;">

</div>
<div id='content'>
<h4>Pagalbos skambučių statistika</h4><br> 

<?php

date_default_timezone_set('Europe/Vilnius');
$current_week = strtotime("today + 1 day");
$start_week = strtotime("monday midnight",$current_week);
$end_week = strtotime("next sunday",$start_week);
$start_week = date("Y-m-d",$start_week);
$end_week = date("Y-m-d", $end_week);
$i = 0;
echo "<table style='width:100%;' class='blueTable' >\n";
echo "<thead><tr><th>Savaitė</th><th>Pradžia</th><th>Pabaiga</th><th> Vid. laukimo laikas </th><th> Vid. trukmė </th><th> Atsiliepti </th><th> Bendra trukmė </th><th> Neatsiliepti </th></tr></thead>";
while ($i<8)  {
$start_week = date("Y-m-d",strtotime($start_week. ' - 7 days'));
$end_week = date("Y-m-d", strtotime($end_week. ' -  7 days'));

$qr = "SELECT COUNT(*) sk_skaicius FROM skambuciai WHERE term IS NOT NULL AND est IS NOT NULL AND rmt NOT LIKE '%@ltcsc.lrvpb.site' AND est >= '$start_week' AND est < '$end_week' AND DATEDIFF(term,est) = 0 ";    

$result = mysqli_query($cxn, $qr) or die ("Error: ".mysqli_error($cxn));
$row = mysqli_fetch_row($result);
$sk_skaicius = $row['0'];
mysqli_free_result($result);

$qr = "SELECT COUNT(*) mis FROM skambuciai WHERE missed IS NOT NULL AND rmt not LIKE '%@ltcsc.lrvpb.site' AND missed >= '$start_week' AND missed < '$end_week'  AND 

(
      (( WEEKDAY(missed) = 0 OR WEEKDAY(missed) = 2 ) AND TIME(missed) BETWEEN '08:00:00' AND '17:00:00') OR

      (( WEEKDAY(missed) = 1 OR WEEKDAY(missed) = 3) AND TIME(missed) BETWEEN '08:00:00' AND '18:00:00') OR

      ((WEEKDAY(missed) = 4) AND TIME(missed) BETWEEN '08:00:00' AND '15:45:00')

)";   
$result = mysqli_query($cxn, $qr) or die ("Error: ".mysqli_error($cxn));
$row = mysqli_fetch_row($result);
$mis = $row['0'];
mysqli_free_result($result);

//AVG(est - ic)
$qr = "SELECT SEC_TO_TIME(FLOOR(AVG(TIME_TO_SEC(TIMEDIFF(est,ic))))) vid_laukti FROM skambuciai WHERE term IS NOT NULL AND ic is not null and est is not null and rmt not LIKE '%@ltcsc.lrvpb.site' AND TIMEDIFF(est,ic) < '02:00:00' AND DATEDIFF(est,ic) = 0  AND est >= '$start_week' AND est < '$end_week' ";   
$result = mysqli_query($cxn, $qr) or die ("Error: ".mysqli_error($cxn));
$row = mysqli_fetch_row($result);
$vid_laukti = $row['0'];
mysqli_free_result($result);

//AVG(term - est),
$qr = "SELECT  SEC_TO_TIME(FLOOR(AVG(TIME_TO_SEC(TIMEDIFF(term,est))))) vid_trukme FROM skambuciai WHERE term is not null and est is not null and rmt not LIKE '%@ltcsc.lrvpb.site' AND TIMEDIFF(term,est) < '02:00:00' AND DATEDIFF(term,est) = 0  AND est >= '$start_week' AND est < '$end_week' ";   
$result = mysqli_query($cxn, $qr) or die ("Error: ".mysqli_error($cxn));
$row = mysqli_fetch_row($result);
$vid_trukme = $row['0']; 
mysqli_free_result($result);

//SUM(term - est)
$qr = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(term,est)))) trukme FROM skambuciai WHERE term is not null and est is not null and rmt not LIKE '%@ltcsc.lrvpb.site' AND TIMEDIFF(term,est) < '02:00:00' AND DATEDIFF(term,est) = 0 AND est >= '$start_week' AND est < '$end_week' ";   
$result = mysqli_query($cxn, $qr) or die ("Error: ".mysqli_error($cxn));
$row = mysqli_fetch_row($result);
$trukme = $row['0'];  
mysqli_free_result($result);
$wdate = new DateTime($start_week);  $week = $wdate->format("W");
echo "<tr><td>$week</td><td>$start_week</td><td>$end_week</td><td> $vid_laukti </td><td> $vid_trukme  </td><td> $sk_skaicius </td><td> $trukme </td><td> $mis </td></tr>\n";


$i++;
}
echo "</table><br />\n";


?>

 

<div id='vueapp'>

<h5 style='color: grey;'>Naujausi skambučiai  </h5>  

<!--  <button @click="expo(skambuciai)">CSV</button>   -->
<csv-component label="CSV" :arr="skambuciai" failas="naujausi.csv"></csv-component>
<button @click="getVisi()">Visi CSV</button>

 <br><br>


<div style="width:100%; height:160px; overflow:auto;">
<!-- https://stackoverflow.com/questions/14834198/table-scroll-with-html-and-css -->
<table class='blueTable' style='width:100%;'><thead>
   <tr>
     <th>Eil. Nr.</th>
     <th>Laikas</th>
     <th>Skambino</th>
     <th>Atsiliepė </th>
     <th>Trukmė</th>
   </tr></thead>    
    
<tr v-for="skmb in skambuciai"  >
     <td>  {{skmb.row_number}}</td>
     <td> {{skmb.laikas }}</td>
     <td>{{skmb.skambino }}</td>
    <td>{{skmb.atsake}}</td>
  <td>{{skmb.trukme}}  </td>
  </tr>
 </table>			</div>
 </br>    
</div>

 <script>

 

 
 var app = new Vue({        
  el: '#vueapp',  		
 

  data: {
      
      skambuciai: []
	  
  },
  mounted: function () {      //created
    this.getNaudotojai();
	
  },

  methods: {
    getNaudotojai: function(){
        axios.get('get_skambuciai.php')
        .then(function (response) {
            console.log(response.data);
            app.skambuciai = response.data;

        })
        .catch(function (error) {
            console.log(error);
        });
    },
	
	 expo: function(arrData) {  
	let csvContent = "data:text/csv;charset=utf-8,";		
	csvContent += [
        Object.keys(arrData[0]).join(";"),
        ...arrData.map(item => Object.values(item).join(";"))
      ]
        .join("\n")
        .replace(/(^\[)|(\]$)/gm, "");  
	const data = encodeURI(csvContent);

	const link = document.createElement("a");
	      link.setAttribute("href", data);
	      link.setAttribute("download", "visi.csv");
	      link.click();
    },//expo
	
	
	getVisi: function(){
        axios.get('get_skambuciai.php?visi=taip')
        .then(function (response) {			
 	app.expo(response.data);
			          
        })
        .catch(function (error) {
            console.log(error);
        });
    }
	
  
  }//methods




});   



</script>




<br>


<div style="float:left; width: 160px;">
    <div id="nav2"></div>

	<img src="imgs/vincasoft5.png"   style="margin-top: 20px;"/>
</div>

<div style="margin-left: 160px;">
  <div id="rez"> </div>
</div>







<table class="blueTable">
<thead>
  <tr>
    <th ></th>
    <th  id="sav_data">Savaitė</th>
    <th  id="men_data">Mėnuo</th>
  </tr>
</thead>
  <tr>
    <td></td>
    <td id="ats_per_s_sk">Atsiliepta per savaitę</td>
    <td id="ats_per_m_sk">Atsiliepta per mėnesį</td>
  </tr>
  <tr>
    <td >      </td>
    <td >
						<canvas id="ats_per_sav" width="280" height="105">
							Your browser does not support HTML5 Canvas.
						</canvas>
    </td>
    <td >
						<canvas id="ats_per_men" width="280" height="105">
							Your browser does not support HTML5 Canvas.
						</canvas>

  </td>
  </tr>
  
<tr><td >      </td>
<td >
	<span id="sav_tr"></span><br><span id="sav_vtr"></span><br><span id="sav_ne"></span>					
</td>
<td >
	<span id="men_tr"></span><br><span id="men_vtr"></span><br><span id="men_ne"></span>
  </td>
  </tr>



 

</table>
<br>
<p id="year">  </p>
  <p id="last">  </p>
 
<div id="curve_chart" style="width: 800px; height: 500px;"></div>


<div id='ne'>

<h5 style='color: grey;'>Neatsiliepti skambučiai  </h5> <!-- <button @click="expo2(neatsiliepti)">CSV</button> -->
<csv-component label="CSV" :arr="neatsiliepti" failas="neatsiliepti.csv"></csv-component>
<br><br>

<div style="width:100%; height:160px; overflow:auto;">
<table class='blueTable' style='width:100%;'><thead>
   <tr>
     <th>Eil. Nr.</th>
     <th>Neatsiliepta</th>
     <th>Skambino</th>
        <th></th>
   </tr></thead>    
  
<tr v-for="(ne, index) in neatsiliepti"  >
     <td>  {{ne.row_number}}</td>
     <td> {{ne.missed }}</td>
     <td>{{ne.skambino }}</td>
    <td> <input type='button' value=' ' @click='deleteRecord(index, ne.id)'>
</td>
   </tr>
 </table></div> </br>    
</div>

<script>
var appne = new Vue({        
  el: '#ne',  		
 

  data: {
      
      neatsiliepti: [],	 
	  
  },
  mounted: function () {      //created
    this.getNe();
	
  },

  methods: {
    getNe: function(){
        axios.get('get/get_ne2.php')
        .then(function (response) {
            console.log(response.data);
            appne.neatsiliepti = response.data;

        })
        .catch(function (error) {
            console.log(error);
        });
    },
	
	deleteRecord: function(index, id){      //     alert(index);  alert(id);  //https://makitweb.com/insert-update-delete-records-from-mysql-with-vue-js/
 
 if ( confirm('Ar tikrai ištrinti?')) 
{
var pas = prompt("Įveskite slaptažodį", "");
var result = MD5(pas);   
if (result == 'ecc3b8c29ae8a5d632ea1e931bb72173') {} else { alert("Neteisingas slaptažodis");  return;}
} else return;
     axios.post('get/del.php', { id: id  })
     .then(function (response) {
       appne.neatsiliepti.splice(index, 1);
		alert(response.data);
     })
     .catch(function (error) {
       console.log(error);
     });
 }//delRec 
	
	
  
  }//methods




});   

</script>


<?php
echo "</div><div id='footer'>\n";
include("footer.inc");
echo "</div>";
mysqli_close($cxn);
?>



</body></html>
 
