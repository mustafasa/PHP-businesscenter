<?php
//Check if employee is activate 
header('Content-Type: application/json');
include ("../mysqli.php");
$update = mysqli_real_escape_string($db_conx, $_POST['update']);
$id = mysqli_real_escape_string($db_conx, $_POST['eid']);


if($update=="Activated"){
$sql3 = "SELECT * FROM hr WHERE id ='$id' and status='Activated' ";
$query3 = mysqli_query($db_conx, $sql3);
$productCount3 =  mysqli_num_rows($query3);
   if($productCount3==0){
   $valid = 'false';
   }
   else{
   $valid = 'true';	
	  }
}
else{
$valid = 'true';	
	}
echo $valid;
?>
