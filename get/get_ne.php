<?php

$host = "";
$user = "";
$passwd = "";
$dbname = "";


  $cxn = mysqli_connect($host,$user,$passwd,$dbname)  or die("Klaida! Nepavyko prisijungti prie duomenų bazės");

  $start = $_GET['start'];
  $end = $_GET['end'];

$query  = "SELECT COUNT(*) mis FROM skambuciai WHERE missed IS NOT NULL AND rmt not LIKE '%@ltcsc.lrvpb.site' AND missed >= '$start' AND missed < '$end' 

AND 

(
      (( WEEKDAY(missed) = 0 OR WEEKDAY(missed) = 2 ) AND TIME(missed) BETWEEN '08:00:00' AND '17:00:00') OR

      (( WEEKDAY(missed) = 1 OR WEEKDAY(missed) = 3) AND TIME(missed) BETWEEN '08:00:00' AND '18:00:00') OR

      ((WEEKDAY(missed) = 4) AND TIME(missed) BETWEEN '08:00:00' AND '15:45:00')

) "; 

 $result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));
  
 while($row = $result->fetch_assoc()) {
       
 	$mis = $row['mis'];
}


mysqli_close($cxn);


$items = array();
$items['missed'] =$mis;




echo json_encode($items); ;





?>

