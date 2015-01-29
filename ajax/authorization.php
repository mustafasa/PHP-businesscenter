<?php
header('Content-Type: application/json');
$rc[]=array();
if(isset ($_POST['user'])){
	include "../mysqli.php"; 
	$user=   mysqli_real_escape_string($db_conx, $_POST['user']);
	$password=  mysqli_real_escape_string($db_conx, $_POST['password']);


	
	// check user is reqgiter
	$sql ="SELECT * FROM  usertable WHERE user='$user' LIMIT 1 ";
	$query = mysqli_query($db_conx, $sql);
    $productCount =  mysqli_num_rows($query); 
	$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	$dpass = $row["password"];
	
      //Check user activation
	  	$sql2 ="SELECT * FROM  usertable WHERE user='$user'  and status='Activated' LIMIT 1 ";
	$query2 = mysqli_query($db_conx, $sql2);
	$productCount2 =  mysqli_num_rows($query2);
$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
	 $id = $row["id"]; 
	
	
	if ((crypt($password ,$dpass ) == $dpass) && ($productCount==1)){//check user n pass
    
		

	    if ((crypt($password ,$dpass) == $dpass) && ($productCount2 == 1)){//check act
		

 session_start();
    $_SESSION['adminid'] = $id;
	 $_SESSION['admin'] = $user;
	  $_SESSION['adminp'] = $password;
	  $_SESSION['login_time'] = time();
	
		
		   $rt="success";
		
		   }

	
	  else{
		  $rt="Account not Activated.Contact Administrator";}
	}
	  
else {
		$rt="Invalid Credential.Contact Administrator";}
	
}
else{
	$rc['error']="error";}
	
    $rc['result']=$rt;
	

echo json_encode ($rc);
?>