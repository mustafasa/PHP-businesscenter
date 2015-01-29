<?php
//add service
header('Content-Type: application/json');
if (isset($_POST['sname'])  ) {
	include ("../mysqli.php");
	$tnid = mysqli_real_escape_string($db_conx, $_POST['tnid']);
	$sname = mysqli_real_escape_string($db_conx, $_POST['sname']);
	$sqid = mysqli_real_escape_string($db_conx, $_POST['sqid']);
	$smob = mysqli_real_escape_string($db_conx, $_POST['smob']);
	$sdate = mysqli_real_escape_string($db_conx, $_POST['sdate']);
	$stype = mysqli_real_escape_string($db_conx, $_POST['stype']);
	$samount = mysqli_real_escape_string($db_conx, $_POST['samount']);
	$regby = mysqli_real_escape_string($db_conx, $_POST['hby']);
	
	
	$scdate = date('Y-m-d', strtotime($sdate));
	
	
	$sql = ("INSERT INTO `prclient`(`name`, `qid`, `contact`, `date`, `amount`,`service`,`status`,`regby`,`tid`) 
       VALUES('$sname','$sqid','$smob','$scdate','$samount','$stype','Pending','$regby','$tnid')")  ;
	   
	   $query = mysqli_query($db_conx, $sql);
	$id =  mysqli_insert_id($db_conx);

	
	$rc['result']="success";
	$rc['results']= $id;
	}

echo json_encode ($rc);
?>