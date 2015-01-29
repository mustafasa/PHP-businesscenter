<?php
//add cheque
header('Content-Type: application/json');
if(isset ($_POST['cri'])){
	include "../mysqli.php";
	$regby = $_POST['rname'];
	$cri = mysqli_real_escape_string($db_conx, $_POST['cri']);
	$date = date("y-m-d", strtotime($_POST['dates']));
	$tid = mysqli_real_escape_string($db_conx, $_POST['tid']);
	$sid = mysqli_real_escape_string($db_conx, $_POST['sid']);
	$payee = mysqli_real_escape_string($db_conx, $_POST['payee']);
	$cnumber = mysqli_real_escape_string($db_conx, $_POST['cnumber']);
	$cdate = date("y-m-d", strtotime($_POST['cdate']));
	$amount = mysqli_real_escape_string($db_conx, $_POST['amount']);
	$bank = mysqli_real_escape_string($db_conx, $_POST['bank']);
	$status = mysqli_real_escape_string($db_conx, $_POST['status']);
	$note = mysqli_real_escape_string($db_conx, $_POST['note']);
	
	
	$sql = ("INSERT INTO cheque (regby,cnumber, cdate, bank,payee, ctid, csid, cri ,amount,status,note,date) 
       VALUES('$regby','$cnumber','$cdate','$bank','$payee','$tid','$sid','$cri','$amount','$status','$note','$date')") ;
	
	$query = mysqli_query($db_conx, $sql);

		
    $rc['result']="success";
	    $rc['result2']=$payee;
	$rc['results']= $cnumber;
	
}

echo json_encode ($rc);
?>