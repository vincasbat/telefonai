<?php

$host = "";
$user = "";
$passwd = "";
$dbname = "";


$cxn = mysqli_connect($host,$user,$passwd,$dbname)  or die("Klaida! Nepavyko prisijungti prie duomenų bazės");

 
date_default_timezone_set('Europe/Vilnius');

$current_week = strtotime("last sunday + 1 day");    //veikia
$start_week = strtotime("monday midnight",$current_week);
$end_week = strtotime("next sunday",$start_week);
$start_week = date("Y-m-d",$start_week);
$end_week = date("Y-m-d", $end_week);


 
 $chart = array();
 $arow = array();



$i = 0;
while ($i<8)  {  
$start_week = date("Y-m-d",strtotime($start_week. ' - 7 days')); // if ($i==7) {$start =  $start_week; }
$end_week = date("Y-m-d", strtotime($end_week. ' -  7 days'));  //if ($i==0) {$end = $end_week; }  
$i++;

unset($arow); $arow =  array();   $arow[0] = "savait";

$que923 = "SELECT   COUNT(*) sk_skaicius, week(est, 1) sav FROM skambuciai WHERE term IS NOT NULL AND est IS NOT NULL AND rmt NOT LIKE '%@ltcsc.lrvpb.site' AND est >= '$start_week' AND est < '$end_week' AND RIGHT(substring_index(substring_index(lcl, ':', -1), '@', 1),3) = '923' AND DATEDIFF(term,est) = 0  group by sav ORDER BY sav";
 
$result = mysqli_query($cxn, $que923) or die ("Error: ".mysqli_error($cxn));
//$arow[1] = 0;

 while($row = mysqli_fetch_assoc($result)) 
  {	
$arow[0] = $row['sav'] . ' sav';   
  $arow[1] = intval($row['sk_skaicius']);
  }

 if (!isset($arow[1])) $arow[1] = 0;
  
$que986 = "SELECT   COUNT(*) sk_skaicius, week(est, 1) sav FROM skambuciai WHERE term IS NOT NULL AND est IS NOT NULL AND rmt NOT LIKE '%@ltcsc.lrvpb.site' AND est >= '$start_week' AND est < '$end_week' AND RIGHT(substring_index(substring_index(lcl, ':', -1), '@', 1),3) = '986'  AND DATEDIFF(term,est) = 0  group by sav ORDER BY sav";
$result = mysqli_query($cxn, $que986) or die ("Error: ".mysqli_error($cxn));
 //$arow[2] = 0;
while($row = mysqli_fetch_assoc($result)) 
  {	
$arow[0] = $row['sav'] . ' sav';  
       $arow[2] = intval($row['sk_skaicius']);
  }
if (!isset($arow[2])) $arow[2] = 0;
 
$que989 = "SELECT   COUNT(*) sk_skaicius, week(est, 1) sav FROM skambuciai WHERE term IS NOT NULL AND est IS NOT NULL AND rmt NOT LIKE '%@ltcsc.lrvpb.site' AND est >= '$start_week' AND est < '$end_week' AND RIGHT(substring_index(substring_index(lcl, ':', -1), '@', 1),3) = '989'  AND DATEDIFF(term,est) = 0  group by sav ORDER BY sav";
$result = mysqli_query($cxn, $que989) or die ("Error: ".mysqli_error($cxn));
// $arow[3] = 0; 
while($row = mysqli_fetch_assoc($result)) 
  {	
$arow[0] = $row['sav'] . ' sav';  
     $arow[3] = intval($row['sk_skaicius']);
  }
 if (!isset($arow[3])) $arow[3] = 0;

$que990 = "SELECT   COUNT(*) sk_skaicius, week(est, 1) sav FROM skambuciai WHERE term IS NOT NULL AND est IS NOT NULL AND rmt NOT LIKE '%@ltcsc.lrvpb.site' AND est >= '$start_week' AND est < '$end_week' AND RIGHT(substring_index(substring_index(lcl, ':', -1), '@', 1),3) = '990' AND DATEDIFF(term,est) = 0  group by sav ORDER BY sav";
$result = mysqli_query($cxn, $que990) or die ("Error: ".mysqli_error($cxn));
// $arow[4] = 0;
while($row = mysqli_fetch_assoc($result)) 
  {	
$arow[0] = $row['sav'] . ' sav';  
      $arow[4] = intval($row['sk_skaicius']);
  }
if (!isset($arow[4])) $arow[4] = 0;
 

$que991 = "SELECT   COUNT(*) sk_skaicius, week(est, 1) sav FROM skambuciai WHERE term IS NOT NULL AND est IS NOT NULL AND rmt NOT LIKE '%@ltcsc.lrvpb.site' AND est >= '$start_week' AND est < '$end_week' AND RIGHT(substring_index(substring_index(lcl, ':', -1), '@', 1),3) = '991' AND DATEDIFF(term,est) = 0  group by sav ORDER BY sav";
$result = mysqli_query($cxn, $que991) or die ("Error: ".mysqli_error($cxn));

while($row = mysqli_fetch_assoc($result)) 
  {	
	$arow[0] = $row['sav'] . ' sav';  
      $arow[5] = intval($row['sk_skaicius']);
  }
if (!isset($arow[5])) $arow[5] = 0;
array_push($chart, $arow); 


}// while week





  

 $chart = array_reverse($chart);
 
 $ar = [];
 
 $ar[0] = 'Sav.';
 $ar[1] = '923';
 $ar[2] = '986';
 $ar[3] = '989';
 $ar[4] = '990';
 $ar[5] = '991';

array_unshift($chart,  $ar);
 

mysqli_close($cxn);
echo json_encode($chart); 





?>
















