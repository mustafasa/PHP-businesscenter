<?php
header('Content-Type: application/json');
include "../mysqli.php";
	    $eid=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["eid"]);
		$ename= $_POST["ename"];
		$username=  $_POST["username"];
		$passworde= $_POST["password"];
		$password= crypt($_POST["password"]);
		$regby=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["regby"]);
		$tmenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["tmenu"]);
		$iqmenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["iqmenu"]);
		$chmenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["chmenu"]);
		$astmenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["astmenu"]);
		$sermenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["sermenu"]);
		$hrmenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["hrmenu"]);
		$expmenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["expmenu"]);
		$recptmenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["recptmenu"]);

		
		
			$sql = ("INSERT INTO usertable (user,password,status,name,eid,hr,tenant,inquery,cheque,assset,service,expense,receipt) 
       VALUES('$username','$password','Activated','$ename',$eid,$hrmenu,$tmenu,$iqmenu,$chmenu,$astmenu,$sermenu,$expmenu,$recptmenu)") ;
	
	$query = mysqli_query($db_conx, $sql);

	
	$id = mysqli_insert_id($db_conx);

		   $rt="success";
    $rc['result']=$rt;
	$rc['results']=$username;
	

echo json_encode ($rc);
?>