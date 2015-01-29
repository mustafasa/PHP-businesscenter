<?php
//check whether enployee already has login id &  check employee existence
header('Content-Type: application/json');
include ("../mysqli.php");
$request = $_REQUEST['eid'];


$sql3 = "SELECT * FROM usertable WHERE eid ='$request'";
$query3 = mysqli_query($db_conx, $sql3);
$productCount3 =  mysqli_num_rows($query3);

$sql = "SELECT * FROM hr  WHERE id ='$request' and status='Activated'";
$query = mysqli_query($db_conx, $sql);
$productCount =  mysqli_num_rows($query);

if ($productCount3 == 0){
	if ($productCount == 1){
$rc = 'true';
	}else{
		$rc='Employee ID Invalid';
		}
}
else{
$rc = 'This Employee is Already Registered';
}
echo json_encode ($rc);
?>