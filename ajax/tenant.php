<?php
//adding tenant
header('Content-Type: application/json');
if(isset ($_POST['offno'])){
	include "../mysqli.php";
	$rname = mysqli_real_escape_string($db_conx, $_POST['rname']);
	$floorno = mysqli_real_escape_string($db_conx, $_POST['floorno']);
	$offno = mysqli_real_escape_string($db_conx, $_POST['offno']);
	$compname = mysqli_real_escape_string($db_conx, $_POST['compname']);
	$crno = mysqli_real_escape_string($db_conx, $_POST['crno']);
	$crval = mysqli_real_escape_string($db_conx, $_POST['crval']);
	$munlic = mysqli_real_escape_string($db_conx, $_POST['munlic']);
	$munval = mysqli_real_escape_string($db_conx, $_POST['munval']);
	$comno = mysqli_real_escape_string($db_conx, $_POST['comno']);
	$comval = mysqli_real_escape_string($db_conx, $_POST['comval']);
	$sponsor = mysqli_real_escape_string($db_conx, $_POST['sponsor']);
	$sponsorid = mysqli_real_escape_string($db_conx, $_POST['sponsorid']);
	$conperson = mysqli_real_escape_string($db_conx, $_POST['conperson']);
	$conqid = mysqli_real_escape_string($db_conx, $_POST['conqid']);
	$conmob = mysqli_real_escape_string($db_conx, $_POST['conmob']);
	$conemail = mysqli_real_escape_string($db_conx, $_POST['conemail']);
	$contel = mysqli_real_escape_string($db_conx, $_POST['contel']);
	$cpfrom = mysqli_real_escape_string($db_conx, $_POST['cpfrom']);
	$cpuntill = mysqli_real_escape_string($db_conx, $_POST['cpuntill']);
	$rpm = mysqli_real_escape_string($db_conx, $_POST['rpm']);
	$adamount = mysqli_real_escape_string($db_conx, $_POST['adamount']);
	$status = mysqli_real_escape_string($db_conx, $_POST['status']);
	$remarks = mysqli_real_escape_string($db_conx, $_POST['remarks']);
	
	$crval=date("y-m-d", strtotime($crval));
	$munval=date("y-m-d", strtotime($munval));
	$comval=date("y-m-d", strtotime($comval));
	$cpfrom=date("y-m-d", strtotime($cpfrom));
	$cpuntill=date("y-m-d", strtotime($cpuntill));
	
	$sql = ("INSERT INTO tenant (regby, floorno, offno,compname, crno, crdate, mlic ,mlicdate,comc,comcdate,sname,sqid,conname,conqid,conmob,conemail,contele,cpfrom,cpuntil,rpmonth,advance,status,remarks) 
       VALUES('$rname','$floorno','$offno','$compname','$crno','$crval','$munlic','$munval','$comno','$comval','$sponsor','$sponsorid','$conperson','$conqid ','$conmob','$conemail','$contel','$cpfrom','$cpuntill','$rpm','$adamount','$status ','$remarks')") ;
	
	$query = mysqli_query($db_conx, $sql);

	
	$id = mysqli_insert_id($db_conx);
		
    $rc['result']="success";
	$rc['results']= $id;
	$rc['off']=$offno;
}

echo json_encode ($rc);
?>