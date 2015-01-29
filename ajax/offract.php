<?php
//Check if office is occupied availibilty
header('Content-Type: application/json');
include ("../mysqli.php");
$update = mysqli_real_escape_string($db_conx, $_POST['update']);
$offno = mysqli_real_escape_string($db_conx, $_POST['offno']);
$id = mysqli_real_escape_string($db_conx, $_POST['id']);


if($update=="Occupied"){
$sql3 = "SELECT * FROM tenant WHERE offno ='$offno' and status='Occupied'  and id NOT IN ( '$id' ) ";
$query3 = mysqli_query($db_conx, $sql3);
$productCount3 =  mysqli_num_rows($query3);
   if($productCount3==0){
   $valid = 'true';
   }
   else{
   $valid = 'false';	
	  }
}
else{
$valid = 'true';	
	}
echo $valid;
?>
