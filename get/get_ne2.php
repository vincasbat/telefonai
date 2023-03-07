<?php

$host = "";
$user = "";
$passwd = "";
$dbname = "";


  $cxn = mysqli_connect($host,$user,$passwd,$dbname)  or die("Klaida! Nepavyko prisijungti prie duomenų bazės");

 
$sq = "set @rownum := 0";
$res = mysqli_query($cxn, $sq) or die ("Error: ".mysqli_error($con));


$sql = "SELECT @rownum := @rownum + 1 as row_number,  id, ic, substring_index(substring_index(rmt, ':', -1), '@', 1) skambino, missed  FROM skambuciai WHERE missed IS NOT NULL AND rmt not LIKE '%@ltcsc.lrvpb.site' 

AND 

(
      (( WEEKDAY(missed) = 0 OR WEEKDAY(missed) = 2 ) AND TIME(missed) BETWEEN '08:00:00' AND '17:00:00') OR

      (( WEEKDAY(missed) = 1 OR WEEKDAY(missed) = 3) AND TIME(missed) BETWEEN '08:00:00' AND '18:00:00') OR

      ((WEEKDAY(missed) = 4) AND TIME(missed) BETWEEN '08:00:00' AND '15:45:00')

)

ORDER BY missed DESC LIMIT 500";


$result = mysqli_query($cxn, $sql) or die ("Error: ".mysqli_error($con));


if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}


     echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
     echo ']';
 

$cxn->close();




?>
