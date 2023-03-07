<?php

    if(isset($_POST['delete'])) {
        
        $selected = $_POST['chkbox']; 
        $selected_count = 0;
        $selected_count = sizeof($selected);
        
$host = "";
$user = "";
$passwd = "";
$dbname = "";


        $cxn = mysqli_connect($host,$user,$passwd,$dbname)
        or die("Klaida! Nepavyko prisijungti prie duomenų bazės");
       

if($selected_count>0) {
       foreach ($selected as $dok_id) {

   
   $query = "DELETE FROM skambuciai WHERE id = $dok_id"; 
   $result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));
   
  
   
}//foreach
}// if count > 0
}//if issset post delete
   mysqli_close($cxn);
   
   
   header("Location: index.php?count=$selected_count");

   ?>   
