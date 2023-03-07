<?php
include "conf.php";
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$con = mysqli_connect($host,$user,$passwd,$dbname)     or die ("Klaida! Nepavyko prisijungti prie duomenų bazės");
mysqli_query($con,"DELETE FROM skambuciai WHERE id=".$id);  $con->close();
echo "Ištrinta";
exit;
?>
