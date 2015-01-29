<?php
//adding tenant
header('Content-Type: application/json');
if(isset ($_POST['opass'])){
	include "../mysqli.php";


	$newpass = mysqli_real_escape_string($db_conx, $_POST['newpass']);
	$chuser = mysqli_real_escape_string($db_conx, $_POST['chuser']);
$newpass=crypt($newpass);
	
		$sql = "UPDATE  usertable SET password='$newpass'
       WHERE user='$chuser'" ;
	
	$query = mysqli_query($db_conx, $sql);
	




	  $_SESSION['adminp'] = $newpass;

    $rc['result']="success";
	$rc['results']= "Changed!!!";

}

echo json_encode ($rc);
?>