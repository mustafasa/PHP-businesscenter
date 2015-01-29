<?php 
//get service client name
header('Content-Type: application/json');
include "../mysqli.php";
$user=   preg_replace('#[^0-9_]#i', '', $_POST["statuss"]);
	   $sql2="SELECT * FROM  prclient WHERE id='$user'   ";	
		$query2 = mysqli_query($db_conx, $sql2);
    $productCount =  mysqli_num_rows($query2); 
	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
	$rc	 = $row["name"];

echo json_encode ($rc);
 
?>