<?php
//check user availability
include ("../mysqli.php");
$request = $_REQUEST['username'];


$sql3 = "SELECT * FROM usertable WHERE user ='$request'";
$query3 = mysqli_query($db_conx, $sql3);
$productCount3 =  mysqli_num_rows($query3);

if ($productCount3 == 0){
$valid = 'true';}
else{
$valid = 'false';
}
echo $valid;
?>