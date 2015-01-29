<?php
//add pro activity
header('Content-Type: application/json');
if (isset($_POST['prodate'])  ) {
	include ("../mysqli.php");
	$prodate = mysqli_real_escape_string($db_conx, $_POST['prodate']);
	$prname = mysqli_real_escape_string($db_conx, $_POST['prname']);
	$tleav =  $_POST['tleav'];
	$tret = $_POST['tret'];
	$prodesc = mysqli_real_escape_string($db_conx, $_POST['prodesc']);
	
	
	
	$prodate = date('Y-m-d', strtotime($prodate));
	
	
	$sql = ("INSERT INTO `proact`(`date`, `prname`, `tleav`, `tret`, `prodesc`) 
                          VALUES('$prodate','$prname','$tleav','$tret','$prodesc')")  ;
	   
	   $query = mysqli_query($db_conx, $sql);


	
	$rc['result']="success";

	}

echo json_encode ($rc);
?>