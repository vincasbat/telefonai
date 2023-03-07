<?php

$host = "localhost";
$user = "yealinkuser";
$passwd = "Laikinas1723";
$dbname = "yealinkDB";



$con = mysqli_connect($host,$user,$passwd,$dbname)     or die("Klaida! Nepavyko prisijungti prie duomenų bazės");


if (isset($_GET['visi']) && $_GET['visi'] == 'taip') $limit = ''; else $limit = ' LIMIT 200';





$sq = "set @rownum := 0";
$res = mysqli_query($con, $sq) or die ("Error: ".mysqli_error($con));

$sql = "SELECT @rownum := @rownum + 1 as row_number,  TIMEDIFF(term, est) trukme, est laikas, RIGHT(substring_index(substring_index(lcl, ':', -1), '@', 1),3) atsake, substring_index(substring_index(rmt, ':', -1), '@', 1) skambino  FROM skambuciai WHERE term is not null and est is not null and rmt not LIKE '%@ltcsc.lrvpb.site' AND TIMEDIFF(term,est) < '02:00:00' AND DATEDIFF(term,est) = 0  ORDER BY est desc " . $limit;

/*   
set @rownum := 0;
select name,
      @rownum := @rownum + 1 as row_number
from your_table
order by name;
*/



$result = mysqli_query($con, $sql) or die ("Error: ".mysqli_error($con));

//$c = mysqli_num_rows($result);  

if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}


     echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
     echo ']';
 

$con->close();




?>
