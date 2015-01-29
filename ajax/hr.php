<?php
//check employee already exist
include ("../mysqli.php");
$request = $_REQUEST['ename'];
$sql3 = "SELECT * FROM hr WHERE ename ='$request' ";
$query3 = mysqli_query($db_conx, $sql3);
$productCount3 =  mysqli_num_rows($query3);

if ($productCount3 == 0){
$valid = 'true';}
else{
$valid = 'false';
}
echo $valid;
?>
