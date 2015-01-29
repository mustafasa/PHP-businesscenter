<?php
//check editable employee
include ("../mysqli.php");
$chuser = mysqli_real_escape_string($db_conx, $_POST['chuser']);
$opass = mysqli_real_escape_string($db_conx, $_POST['opass']);


	$sql ="SELECT * FROM  usertable WHERE user='$chuser' LIMIT 1 ";
	$query = mysqli_query($db_conx, $sql);
    $productCount =  mysqli_num_rows($query); 
	$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	$dpass = $row["password"];
	
if ((crypt($opass ,$dpass ) == $dpass)){
$valid = 'true';}
else{
$valid = 'false';
}
echo $valid;
?>
