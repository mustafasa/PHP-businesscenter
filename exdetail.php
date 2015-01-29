<?php 
//check for user admin authorization
session_start();
if (!isset($_SESSION["admin"]) || (time() - $_SESSION['login_time']) >3600) {
    header("location: logout.php"); 
    exit();
}

$adminid = preg_replace('#[^0-9]#i', '', $_SESSION["adminid"]); // filter everything but numbers and letters
$admin = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["admin"]); // filter everything but numbers and letters
$adminp =  $_SESSION["adminp"];

include ("mysqli.php");
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and expense=1 LIMIT 1 ";
	$query3 = mysqli_query($db_conx, $sql3);
	$productCount3 =  mysqli_num_rows($query3);
	$muser="";
	while ($row = $query3->fetch_assoc()) { 
$name=ucfirst($row['name']);
$hr = $row['hr'];
$tenant = $row['tenant'];
$inquery = $row['inquery'];
$cheque = $row['cheque'];
$asset = $row['assset'];
$service = $row['service'];
$auser=$row['auser'];
$receipt = $row['receipt'];
$expense=$row['expense'];
$dpass = $row['password'];
}

if ((crypt($adminp ,$dpass ) != $dpass) || ($productCount3==0)){ // evaluate the count
	header("location: logout.php"); 
     exit();
}
$_SESSION['login_time'] = time();
?>
	<?php
	//this update 
	if (isset($_POST['fre'])  ) {
		
		include ("mysqli.php");
		
		$fre = $_POST['fre'];
		$id=preg_replace('#[^0-9]#i', '',  $_POST['id']);
		$dates=  date('Y-m-d', strtotime( $_POST["dates"]));
		$amount= $_POST["amount"];
		$desc=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["desc"]);
		$hby=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["hby"]);
		$ename=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["ename"]);
		$billno=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["billno"]);
		$duedate=  $_POST["ddate"];
		$duedate= date('Y-m-d', strtotime("+$fre months", strtotime($duedate)));
		$sql = ("INSERT INTO `expensepaid`(`date`, `ename`, `amount`, `desc`,`hby`,`uby`,`bill`) 
                           VALUES('$dates','$ename','$amount','$desc','$hby','$name','$billno')")  ;
		$query = mysqli_query($db_conx, $sql);
		
$sql2 = ("UPDATE expense SET duedate='$duedate' WHERE id='$id'")  ;
		$query2 = mysqli_query($db_conx, $sql2);
	
		header("location: exdetail.php?id=.$id.&su=Update SuccessFull");
		}
	?>
	
	<?php
	//This get detail 
	if (isset($_GET['id'])) {
		$pro='';
		$id=preg_replace('#[^0-9]#i', '', $_GET['id']);
		$su= $_GET['su'];
		include ("mysqli.php");
	$sql2 ="SELECT * FROM  expense WHERE id='$id'  ";
	$query2 = mysqli_query($db_conx, $sql2);
		$productCount2 =  mysqli_num_rows($query2);
	
	
		$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
			
			
	$id=$row['id'];
	$date = date('d-m-Y', strtotime($row['date']));
	$ename = $row['ename'];
	$amount =$row['amount'];
	$frequency =$row['frequency'];
	$desc =$row['desc'];
	$hby = $row['hby'];
	$status = $row['status'];
	$frename =$row['frename'];
	$duedate =date('d-m-Y', strtotime($row['duedate']));
	$curdate=date("Y-m-d");
		$rs='<tr >
		<td height="40"><strong>&nbsp;&nbsp;Register Date: </strong>'.$date.'</td>
		<td><strong>Expense Name: </strong>'.$ename.'</td>
		<td><strong>Amount: </strong>'.$amount.'</td>
		</tr>
		<tr>
		<td height="40"><strong>&nbsp;&nbsp;Status: </strong>'.$status.'</td>
		<td><strong>Due Date: </strong>'.$duedate.' </td>
		<td><strong>Description: </strong>'.$desc.' </td>
		</tr>
		<tr >
		<td height="40"><strong>&nbsp;&nbsp;Handling by: </strong>'.$hby.'</td>
		<td><strong>Frequency: </strong>'.$frename.'</td>
		<td><form id="changep" action="" method="post">
		<strong>Bill No.</strong><input id="billno" name="billno" size="15">
		<input id="id" value="'.$id.'" name="id" type="hidden" >
		<input id="fre" value="'.$frequency.'" name="fre" type="hidden" >
		<input id="dates" value="'.$curdate.'" name="dates" type="hidden" >
		<input id="amount" value="'.$amount.'" name="amount" type="hidden" >
		<input id="desc" value="'.$desc.'" name="desc" type="hidden" >
		<input id="ddate" value="'.$duedate.'" name="ddate" type="hidden" >
		<input id="hby" value="'.$hby.'" name="hby" type="hidden" >
			<input id="ename" value="'.$ename.'" name="ename" type="hidden" >
		<input class="submit csw" type="submit" value="Paid"/>
		</form></td>
		</tr>
		<tr><td><form action="eexp.php" method="post"><input name="pid" type="hidden" value='.$id.' />&nbsp;&nbsp;<input class="submit csw" type="submit" value="Edit"/></form></td></tr>
		
			
		
			';	
		}else{
			header("location: index.php");
			}
	
	?>
	

	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Business Center Solution</title>
	<link rel="stylesheet" type="text/css" href="style/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" href="style/jquery-ui.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
	  <script src="jq/jquery-1.11.1.js"></script>
	  <script src="jq/jquery-ui.js"></script>
	  <script src="jq/jquery.validate.js"></script>
	  <script src="jq/jquery.js"></script>
	   <script type="text/javascript" charset="utf8" src="jq/jquery.dataTables.js"></script>
	   <link rel="stylesheet" type="text/css" href="style/jquery.dataTables.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
	  
	
	<style>
	td{font-size:17px;}
	

	
	</style>
	  
	</head>
	<body>
	
	<div id="wrap"  align="center" >
	<?php include_once("header.php"); ?>
	 <?php include_once("menu.php"); ?>
	 <div id="middle" align="center" class="scroll" style="background-color:#2E5E79;" >
	
	 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:500px; width:1300px; margin-left:10px;  float:left ">
	 <div class="divheader" align="left">&nbsp;Expense Update </div>
	 <div>
	 <table align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
	<thead> <th align="left" colspan="3"  height="30px">&nbsp;&nbsp; Detail <input type="button" class="csw" value="Back"  onclick="window.open('../demo/expense.php','_self')" style="margin-left:1150px; cursor:pointer" ></th></thead>
	
	   <?php echo $rs;?>
		<tr><td style="font-size:15px; font-style:normal; font-weight:bold; color:#000099"><?php echo $su ?></td></tr>
	 </table></div>
	

	
	</div>
	  
	<?php include_once("footer.php"); ?>
	</div>
	</body>
	</html>