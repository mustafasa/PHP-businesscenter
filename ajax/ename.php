<?php 
//get name from hr
header('Content-Type: application/json');
include "../mysqli.php";
$user=   preg_replace('#[^0-9_]#i', '', $_POST["status"]);
	   $sql2="SELECT * FROM  hr WHERE id='$user'   ";	
		$query2 = mysqli_query($db_conx, $sql2);
    $productCount =  mysqli_num_rows($query2); 
	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
	$rc	 = $row["ename"];

echo json_encode ($rc);
 
?>