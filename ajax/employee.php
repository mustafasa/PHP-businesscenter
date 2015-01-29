<?php
//check editable employee
include ("../mysqli.php");
$ename = mysqli_real_escape_string($db_conx, $_POST['ename']);
$id = mysqli_real_escape_string($db_conx, $_POST['id']);


$sql3 = "SELECT * FROM hr WHERE ename ='$ename'  and id NOT IN ( '$id' ) ";
$query3 = mysqli_query($db_conx, $sql3);
$productCount3 =  mysqli_num_rows($query3);

if ($productCount3 == 0){
$valid = 'true';}
else{
$valid = 'false';
}
echo $valid;
?>
