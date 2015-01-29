<?php
//Check editABLE OFF availibilty
header('Content-Type: application/json');
include ("../mysqli.php");
$cri = mysqli_real_escape_string($db_conx, $_POST['offno']);
$id = mysqli_real_escape_string($db_conx, $_POST['id']);
$status = mysqli_real_escape_string($db_conx, $_POST['status']);
$offno= preg_replace('#[^A-Za-z0-9]#i', '', $cri);

if($status=='Occupied'){

$sql3 = "SELECT * FROM tenant WHERE offno ='$offno' and status='Occupied' and id NOT IN ( '$id' ) ";
$query3 = mysqli_query($db_conx, $sql3);
$productCount3 =  mysqli_num_rows($query3);

if ($productCount3 == 0){
$valid = 'true';}
else{
$valid = 'false';
}
}else{
	$valid = 'true';
	}
echo $valid;
?>
