<?php 
//get compname from tennat
header('Content-Type: application/json');
include "../mysqli.php";
$user=   preg_replace('#[^0-9_]#i', '', $_POST["status"]);
	   $sql2="SELECT * FROM  tenant WHERE id='$user'   ";	
		$query2 = mysqli_query($db_conx, $sql2);
    $productCount =  mysqli_num_rows($query2); 
	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
	$rc	 = $row["compname"];

echo json_encode ($rc);
 
?>