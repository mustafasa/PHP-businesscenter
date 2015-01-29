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
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and service=1 LIMIT 1 ";
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
//this update status of tenant
if (isset($_POST['update'])  ) {
	
	include ("mysqli.php");
	
	$update = mysqli_real_escape_string($db_conx, $_POST['update']);
	$id=preg_replace('#[^0-9]#i', '',  $_POST['eid']);
	
	$sql = ("UPDATE hr SET status='$update' WHERE id='$id'")  ;
	$query = mysqli_query($db_conx, $sql);
	if($update=="DeActivated"){
	$sqla = ("UPDATE usertable SET status='$update' WHERE eid='$id'")  ;
	$queray = mysqli_query($db_conx, $sqla);
	}
	
	header("location: hrdetail.php?eid=.$id.");
	}
?>

<?php
//This get detail of Tenant
if (isset($_GET['eid'])) {
	$pro='';
	$id=preg_replace('#[^0-9]#i', '', $_GET['eid']);
	include ("mysqli.php");
$sql2 ="SELECT * FROM  hr WHERE id='$id'  ";
$query2 = mysqli_query($db_conx, $sql2);
	$productCount2 =  mysqli_num_rows($query2);


	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
		
		
    $id = $row['id'];
	$edate = date('d-m-Y', strtotime($row['edate']));
	$ename =ucfirst($row['ename']);
	$enat =ucfirst($row['enat']);
	$eemail =$row['eemail'];
	$epasp =$row['epasp'];
	$econ =$row['econ'];
	$eqid =$row['eqid'];
	$qval =date('d-m-Y', strtotime($row['qval']));
	$dob =date('d-m-Y', strtotime($row['dob']));
	$mstatus =$row['mstatus'];
	$gender =$row['gender'];
	$jobt =$row['jobt'];
	$salary =$row['salary'];
	$cfrom =date('d-m-Y', strtotime($row['cfrom']));
	$cto =date('d-m-Y', strtotime($row['cto']));
	$account =$row['account'];
	$bname =$row['bname'];
	$note =$row['note'];
	$status =$row['status'];
	$regby =$row['regby'];	
	$dd= date('l jS \of F Y h:i:s A'); 

	$rs='
	
				<tr>
				<td rowspan="8" style="vertical-align:top"><img src="eimg/'.$id.'.jpg?'.$dd.'" onerror="this.src=\'eimg/er.jpg\';" height="200px" width="170px" /></td>
			<td width="250" height="40">Employee ID: <strong>'.$id.'</strong></td>
		<td width="250" height="40">Status: <strong>'.$status.'</strong></td>
		<td width="150">Register By: <strong> '.$regby.'</strong></td>	
		</tr>
	<tr >
     <td width="400" >Register date.<strong>: '.$edate.'</strong></td>	
	 <td width="400" height="40">Full Name<strong>: '.$ename.'</strong></td>
	 <td width="400">Nationality<strong>: '.$enat.'</strong></td>
		</tr>
	
		<tr>
		<td width="400">Email: <strong>: '.$eemail.'</strong></td>
		<td width="250" height="40">Contact# <strong>:'.$econ.'</strong></td>
		 <td width="400">Passport#  <strong>: '.$epasp.'</strong></td>
		</tr>
		
		<tr>
		<td width="150">QID# <strong>: '.$eqid.'</strong></td>
		<td  width="250">QID Validity<strong>: '.$qval.'</strong></td>
	    <td height="40">Date Of Birth <strong>' .$dob.'</strong></td>
		</tr>
		
		<tr>
		<td width="250" height="40">Gender: <strong>'.$gender.'</strong></td>
		<td width="150">Marital Status: <strong> '.$mstatus.'</strong></td>
		<td width="250">Job Title: <strong>'.$jobt.'</strong></td>
		
		
		</tr>
				<tr>
		<td width="250" height="40">Salary: <strong>'.$salary.'</strong></td>
		<td width="150">Contract From: <strong> '.$cfrom.'</strong></td>
		<td width="250">Contract To: <strong>'.$cto.'</strong></td>
		
		</tr>	
		<tr>
		<td width="250" height="40">Bank Account#: <strong>'.$account.'</strong></td>
		<td width="150">Bank Name: <strong> '.$bname.'</strong></td>
		<td width="250">Note: <strong>'.$note.'</strong></td>
		
		</tr>	
	
		<tr>
			
		<td ><form action="" method="post">
			Update: <select name="update" id="update" >
<option value="Activated ">Activate</option>
<option value="DeActivated">DeActivate</option>
<input type="hidden" name="eid" value='.$id.' />
</select><input class="submit csw" type="submit" value="Go"/></form></td><td><form action="ehr.php" method="post"><input name="eid" type="hidden" value='.$id.' /><input class="submit csw" type="submit" value="Edit"/></form></td>

		</tr>
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

 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:508px; width:1300px; margin-left:10px;  float:left ">
 <div class="divheader" align="left">&nbsp;Employee Details </div>
 <table align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
<thead> <th align="left" colspan="4"  height="30px">&nbsp;&nbsp; Detail<input type="button" class="csw" value="Back" onclick="window.open('hr.php','_self')" style=" margin-left:1150px;cursor:pointer" ></th></thead>

   <?php echo $rs;?>
   
 </table></div>
 

</div>
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>