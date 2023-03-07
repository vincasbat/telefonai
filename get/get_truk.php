<?php

$host = "";
$user = "";
$passwd = "";
$dbname = "";


  $cxn = mysqli_connect($host,$user,$passwd,$dbname)  or die("Klaida! Nepavyko prisijungti prie duomenų bazės");

  $start = $_GET['start'];
  $end = $_GET['end'];

$query =  "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(term,est)))) trukme FROM skambuciai WHERE term is not null and est is not null and rmt not LIKE '%@ltcsc.lrvpb.site' AND TIMEDIFF(term,est) < '02:00:00' AND DATEDIFF(term,est) = 0 AND est >= '$start' AND est < '$end'  AND DATEDIFF(term,est) = 0  ";   


 $result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));
  
 while($row = $result->fetch_assoc()) {
       
 	$truk = $row['trukme'];
}


mysqli_close($cxn);


$items = array();
$items['trukme'] =$truk;


 echo json_encode($items); ;




?>

