<?php
//add service
header('Content-Type: application/json');
if (isset($_POST['edate'])  ) {
	include ("../mysqli.php");
	$frename='';
	$edate = mysqli_real_escape_string($db_conx, $_POST['edate']);
	$ename = mysqli_real_escape_string($db_conx, $_POST['ename']);
	$eamount = mysqli_real_escape_string($db_conx, $_POST['eamount']);
	$efr = mysqli_real_escape_string($db_conx, $_POST['efr']);
	$bill = mysqli_real_escape_string($db_conx, $_POST['bill']);
	$edesc = mysqli_real_escape_string($db_conx, $_POST['edesc']);
	$hby = mysqli_real_escape_string($db_conx, $_POST['hby']);
	$adminame = mysqli_real_escape_string($db_conx, $_POST['adminame']);
	$edate = date('Y-m-d', strtotime($edate));
	$duedate= date('Y-m-d', strtotime("+$efr months", strtotime($edate)));
	if($efr>0){
		if($efr==1){
			$frename="Monthly";
			}
			else if($efr==3){
				$frename="Quarterly";
				}
				   else if($efr==6){
				  $frename="Half Yearly";
				    }
				else if($efr==12){
				$frename="Yearly";
				}
	$sql = ("INSERT INTO `expense`(`date`, `ename`, `amount`, `frequency`, `desc`,`hby`,`duedate`,`status`,`frename`) 
                           VALUES('$edate','$ename','$eamount','$efr','$edesc','$hby','$duedate','Activated','$frename')")  ;
	   
	   $query = mysqli_query($db_conx, $sql);
	   

	
	$rc['result']="success";
	
	}
else{
	$sql = ("INSERT INTO `expensepaid`(`date`, `ename`, `amount`, `desc`,`hby`,`uby`,`bill`) 
                           VALUES('$edate','$ename','$eamount','$edesc','$hby','$adminame','$bill')")  ;
	   
	   $query = mysqli_query($db_conx, $sql);
	   
	   	$rc['result']="success";
		
	
	}
}
echo json_encode ($rc);
?>