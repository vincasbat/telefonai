<?php	


$logfile= './log.txt';
$IP = $_SERVER['REMOTE_ADDR'];        //QUERY_STRING
$logdetails= date("F j, Y, g:i a") . ': ' . $_SERVER['REMOTE_ADDR'] . '  : ' . $_SERVER['QUERY_STRING'] . "\r\n";
$fp = fopen($logfile, "a") or die("Unable to open log.txt!");
fwrite($fp, $logdetails);
fclose($fp);

$host = "localhost";
$user = "yealinkuser";
$passwd = "Laikinas1723";
$dbname = "yealinkDB";


$cxn = mysqli_connect($host,$user,$passwd,$dbname)  or die("Failed to connect to MySQL: " . mysqli_error());

$event = $_GET['e'];
if($event=='ic') {
$rmt=$_GET['rmt'];
$lcl=$_GET['lcl'];
$cid=$_GET['cid'];
$mac=$_GET['mac'];
$query = "INSERT INTO skambuciai (cid, mac,	ic,	lcl,	rmt) VALUES ('$cid', '$mac', NOW(), '$lcl', '$rmt')";    
$result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));

 }


 if($event=='est') {
    $cid=$_GET['cid'];
$mac=$_GET['mac'];
    $query = "UPDATE skambuciai SET est=NOW() WHERE cid = '$cid' AND mac = '$mac' ORDER BY id DESC LIMIT 1";    
    $result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));
    
     }

  if($event=='term') {
      $cid=$_GET['cid'];
$mac=$_GET['mac'];
      $query = "UPDATE skambuciai SET term=NOW() WHERE term IS NULL AND mac = '$mac'  ORDER BY id DESC LIMIT 1";    
      $result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));
     
       }

 
if($event=='missed') {
      $cid=$_GET['cid'];
$mac=$_GET['mac'];
      $query = "UPDATE skambuciai SET missed=NOW() WHERE term IS NULL AND mac = '$mac' ORDER BY id DESC LIMIT 1";    
      $result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));
     
       }




mysqli_close($cxn);
?>


