<?php
//check office availablity
include ("../mysqli.php");
$request = $_REQUEST['offno'];
$offno= preg_replace('#[^A-Za-z0-9]#i', '', $request);

$sql3 = "SELECT * FROM tenant WHERE offno ='$offno' and status='Occupied'";
$query3 = mysqli_query($db_conx, $sql3);
$productCount3 =  mysqli_num_rows($query3);

if ($productCount3 == 0){
$valid = 'true';}
else{
$valid = 'false';
}
echo $valid;
?>
