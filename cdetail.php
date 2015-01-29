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
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and cheque=1 LIMIT 1 ";
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
	$id=preg_replace('#[^0-9]#i', '',  $_POST['id']);
	
	$sql = ("UPDATE cheque SET status='$update' WHERE id='$id'")  ;
	$query = mysqli_query($db_conx, $sql);
	
	header("location: cdetail.php?pid=.$id.&su=Update SuccessFull");
	}
?>

<?php
//This get detail of Tenant
if (isset($_GET['pid'])) {
	$pro='';
	$id=preg_replace('#[^0-9]#i', '', $_GET['pid']);
	$su= $_GET['su'];
	include ("mysqli.php");
$sql2 ="SELECT * FROM  cheque WHERE id='$id'  ";
$query2 = mysqli_query($db_conx, $sql2);
	$productCount2 =  mysqli_num_rows($query2);


	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
		
		
	$cnumber = $row['cnumber'];
	$cdate =date('d-m-Y', strtotime($row['cdate']));
	$bank =$row['bank'];
	$ctid =$row['ctid'];
	$cri =$row['cri'];
	$amount =$row['amount'];
	$status =$row['status'];
	$payee =$row['payee'];
	$note =$row['note'];
	$date =date('d-m-Y', strtotime($row['date']));
	$csid =$row['csid'];
	$regby =$row['regby'];
	
	

	$rs='<tr >
     <td width="400" >Register date.<strong>: '.$date.'</strong></td>	
	 <td width="400" height="40">Cheque#<strong>:'.$cnumber.'</strong></td>
	 <td width="400">Cheque Type<strong>: '.$cri.'</strong></td>
		</tr>
		
		<tr>
		<td width="400">Cheque date.<strong>: '.$cdate.'</strong></td>
		<td width="250" height="40">Amount<strong>:'.$amount.'</strong></td>
		 <td width="400">Name/Company: <strong>: '.$payee.'</strong></td>
		
		</tr>
		
		<tr>
		<td width="150">Tenant ID:<strong>: '.$ctid.'</strong></td>
		<td  width="250">Service ID:<strong>: '.$csid.'</strong></td>
	    <td height="40">Bank Name: <strong>' .$bank.'</strong></td>
		</tr>
		
		<tr>
		<td width="250" height="40">Register by<strong>:'.$regby.'</strong></td>
		<td width="150">Note<strong>: '.$note.'</strong></td>
		<td width="250">Status<strong>:'.$status.'</strong></td>
		
		
		</tr>
					
		<tr>
		<td ><form action="" method="post">
			Update: <select name="update" id="update" >
<option value="Pending ">Pending</option>
<option value="Cleared">Cleared</option>
<option value="Cancelled">Cancelled</option>
<option value="On Hold">On Hold</option>
<input type="hidden" name="id" value='.$id.' />
</select><input class="submit csw"  type="submit" value="Go"/></form></td><td><form action="echeque.php" method="post"><input name="pid" type="hidden" value='.$id.' /><input class="submit csw" type="submit" value="Edit"/></form></td>

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

 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:505px; width:1300px; margin-left:10px;  float:left ">
 <div class="divheader" align="left">&nbsp;Cheque Details </div>
 <table align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
<thead> <th align="left" colspan="3"  height="30px">&nbsp;&nbsp; Detail<input type="button" class="csw" value="Back"  onclick="window.open('cheque.php','_self')" style="margin-left:1150px; cursor:pointer;" ></th></thead>

   <?php echo $rs;?>
    <tr><td style="font-size:15px; font-style:normal; font-weight:bold; color:#000099"><?php echo $su ?></td></tr>
 </table></div>
 

</div>
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>