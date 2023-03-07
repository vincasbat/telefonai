<?php

$host = "localhost";
$user = "yealinkuser";
$passwd = "Laikinas1723";
$dbname = "yealinkDB";

//http://localhost/telefonai/get_count.php?start=2020-01-01&end=2020-03-03
  $cxn = mysqli_connect($host,$user,$passwd,$dbname)  or die("Klaida! Nepavyko prisijungti prie duomenų bazės");

  $start = $_GET['start'];
  $end = $_GET['end'];

$query = "SELECT RIGHT(substring_index(substring_index(lcl, ':', -1), '@', 1),3) atsake, COUNT(*) sk_skaicius FROM skambuciai WHERE term IS NOT NULL AND est IS NOT NULL AND rmt NOT LIKE '%@ltcsc.lrvpb.site' AND est >= '$start' AND est < '$end'  AND DATEDIFF(term,est) = 0  GROUP BY lcl ORDER BY sk_skaicius DESC";   
 
  $result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));
  $c = mysqli_num_rows($result);   // irasu skaicius
  $n=1;
  while($row = mysqli_fetch_assoc($result)) 
  {
	foreach($row as $field => $value)
	{
	  $dokai[$n][$field]=$value;
	}
	$n++;
  }

$resp = array();
$count = 0;

$n_dokai = sizeof($dokai);
for ($i=1;$i<=$n_dokai;$i++) {

	$resp[$count] = array('donors' => intval($dokai[$i]['sk_skaicius']), 'location'=> $dokai[$i]['atsake'] );

	
$count++;
}//for






mysqli_close($cxn);
/*
$response = array();
$response[0] = array(
    'donors' => 48,
    'location'=> 'New York'
);
$response[1] = array(
    'donors' => 60,
    'location'=> 'New Washington'
);
*/



$items = array();
$items['skmbSkaicius'] = $resp;

$chartdata = array();
$chartdata['ChartData'] = $items;


 echo json_encode($chartdata); ;




?>

