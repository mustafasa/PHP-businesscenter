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
//this update status of client
if (isset($_POST['update'])  ) {
	
	include ("mysqli.php");
	
	$update = mysqli_real_escape_string($db_conx, $_POST['update']);
	$id=mysqli_real_escape_string($db_conx, $_POST['id']);
	
	$sql = ("UPDATE prclient SET status='$update' WHERE id='$id'")  ;
	$query = mysqli_query($db_conx, $sql);
	}
?>
<?php
//this insert progress
if (isset($_POST['sdate'])  ) {
	include ("mysqli.php");
	
	
	$sdate = mysqli_real_escape_string($db_conx, $_POST['sdate']);
	$sdesc = mysqli_real_escape_string($db_conx, $_POST['desc']);
	$sstatus = mysqli_real_escape_string($db_conx, $_POST['sstatus']);
	$id=mysqli_real_escape_string($db_conx, $_POST['id']);
	$uby=mysqli_real_escape_string($db_conx, $_POST['uby']);

	
	
	$scdate = date('Y-m-d', strtotime($sdate));
	
	
	$sql = ("INSERT INTO `prprogress`(`sservice`, `date`, `desc`, `status`, `id`) 
       VALUES('$uby','$scdate','$sdesc','$sstatus','$id')")  ;
	   
	   $query = mysqli_query($db_conx, $sql);
	
	}
?>
<?php
//This get detail of pr cleint
	$su='';
	if (isset($_GET['pid'])) {
		$pro='';
		$id=preg_replace('#[^0-9]#i', '', $_GET['pid']);
		$su= $_GET['su'];
		
		include ("mysqli.php");
	$sql3 ="SELECT * FROM  prclient WHERE id='$id'  ";
	$query3 = mysqli_query($db_conx, $sql3);
		$productCount3 =  mysqli_num_rows($query3);
	
	$sql2 ="SELECT * FROM  prprogress WHERE id='$id' order by date desc  ";
	$query2 = mysqli_query($db_conx, $sql2);
		$productCount2 =  mysqli_num_rows($query2);
		
		while ($row = $query3->fetch_assoc()) {
			$tid = $row['tid'];
			$id = $row['id'];
		$names = $row['name'];
		$qid = $row['qid'];
		$contact =$row['contact'];
		$date = date('d-m-Y', strtotime($row['date']));
		$services = $row['service'];
		$amount =$row['amount'];
		$status = $row['status'];
		$status = $row['status'];
	
		$regby= $row['regby'];
		
		$rs=' <tr><td width="180" height="30">Id#: <strong>'.$id.'</strong></td><td width="200">Name: <strong>'.$names.'</strong></td><td width="200">QID#: <strong>'.$qid.'</strong></td></tr>
	  <tr><td height="40">Contact#: <strong>'.$contact.'</strong></td><td>Date: <strong>'.$date.'</strong></td><td>Service Type: <strong>'.$services.'</strong></td></tr>
	  <tr><td height="40">Status:<strong>'.$status.'</strong></td><td>Handling by:<strong>'.$regby.'</strong></td><td ><form action="" method="post">
				Update: <select name="update" id="update" >
	<option value="Pending ">Pending</option>
	<option value="Completed">Completed</option>
	<option value="Cancelled">Cancelled</option><input type="hidden" name="id" value='.$id.' />
	</select><input class="submit csw" type="submit" value="Go"/></form></td></tr>
	
	<tr><td height="40">TID# <strong>'.$tid.'</strong></td><td >Charges:<strong>'.$amount.'</strong></td><td><form action="eservice.php" method="post"><input name="pid" value='.$id.' type="hidden"><input class="submit csw" type="submit" value="Edit"/><input type="button" class="csw" value="Back"  onclick="window.open(\'services.php\',\'_self\')" style="margin-left:10px; cursor:pointer" ></form></td></tr>';
			}
			
			while ($row = $query2->fetch_assoc()) {
			
			$id = $row['id'];
		$sservice = $row['sservice'];
		$status = $row['status'];
		$sdesc =$row['desc'];
		$date = date('d-m-Y', strtotime($row['date']));
	
		
		$pro .= '<tr><td >'.$status.'</td><td>'.$sdesc.'</td><td >'.$date.'</td></tr>';
		
			}
			
		}else{
			header("location: index.php");
			}
	?>

<?php
//get receipt list
    include ("mysqli.php");
$rcr='';
$sqlr ="SELECT * FROM  receipt where sid=$id ";
$queryr = mysqli_query($db_conx, $sqlr);

$productCountr =  mysqli_num_rows($queryr); // count the output amount
if ($productCountr > 0) {
while ($rowr = $queryr->fetch_assoc()) { 
$idr = $rowr['id'];
$sdate = date('d-m-Y', strtotime($rowr['date']));
$tid = $rowr['tid'];
$sid = $rowr['sid'];
$recfrm =$rowr['recfrm'];
$amount = $rowr['amount'];
$pmethod =$rowr['pmethod'];
$fors = $rowr['fors'];
$regby =$rowr['regby'];
	
		$rcr .='
  <tr  >
    <td >'.$id.'</td>
	 <td >'.$sdate.'</td>
	<td >'.$recfrm.'</td>
	<td >'.$amount.'</td>
	<td >'.$pmethod.'</td>
	<td >'.$fors.'</td>
  
  </tr>
 
' ;}}
	?>
<?php //get cheque list
if (isset($_GET['pid'])) {
$rc='';
$ids=preg_replace('#[^0-9]#i', '', $_GET['pid']);

$sql ="SELECT * FROM  cheque where csid = '$ids' ";
$query = mysqli_query($db_conx, $sql);
$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 


	
	$rc .='
  
  
	<td >'.$row['cri'].'</td>
	<td >'.$row['regby'].'</td>
	<td >'.$row['cnumber'].'</td>
	<td >'.date('d-m-Y', strtotime($row['cdate'])).'</td>
	<td >'.$row['amount'].'</td>
	<td >'.$row['status'].'</td>
		<td >'.$row['note'].'</td>
			
			

  </tr>
 
' ;
}}
}
mysqli_close($db_conx);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Business Center Solution</title>
<link rel="stylesheet" type="text/css" href="style/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" media="print" href="style/serprint.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" href="style/jquery-ui.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
  <script src="jq/jquery-1.11.1.js"></script>
  <script src="jq/jquery-ui.js"></script>
  <script src="jq/jquery.validate.js"></script>
    <script src="jq/jquery.js"></script>
   <script type="text/javascript" charset="utf8" src="jq/jquery.dataTables.js"></script>
   <link rel="stylesheet" type="text/css" href="style/jquery.dataTables.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
   <style>
.dataTables_wrapper {

 width:635px;
 
}
.dataTables_info ,.dataTables_length, .dataTables_filter{
	display:none;}
</style>

<script>
//date picekr
  $(function() {
    $( "#sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true});
	
  });
//form valdiation
$(document).ready(function() {
	
  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9&,.()\-\s]+$/i.test(value);
    }, "Invalid Format .");

	$("#sign").validate({
		
		rules: {
			sdate: {required:true},
			desc: {required:true,loginRegex: true,},
			
	},
		messages: {
			desc: {required:"Enter Valid Descrpition"},
	},
});
});

</script>
</head>
<body>

<div id="wrap"  align="center" >
<?php include_once("header.php"); ?>
 <?php include_once("menu.php"); ?>
 <div id="middle" align="center" class="scroll" style="background-color:#2E5E79;" >
<!--this div for detail of client-->
<div >
 <div id='clientd' class="divcurve sdet" ><div class="divheader">&nbsp; Details</div><table align="left" style="margin-left:10px; " width="100%" height="100%" >
   <?php echo $rs;?>
    <tr><td style="font-size:15px; font-style:normal; font-weight:bold; color:#000099"><?php echo $su ?></td></tr>
 </table></div>
 <!--this end detail of client-->

 <!--this progress of client-->
 <div id='clientp' class=" divcurve border sprog" >
 
 <div class="divheader" align="left">&nbsp; Progress</div>
 <div class="scroll" style="height:200px;">
 <table>
 <thead >
 <tr align="LEFT" style="color:#2E5E79; "><th width="125" >Status</th><th width="290">Description</th><th>Date</th></tr>
</thead>
 <?php echo $pro;?>

 </table></div>
 </div>
 </div>
 <!--this progress end-->
     <script>
$(document).ready( function () {
    $('#table').DataTable();
} );
 
</script>
  <!--this Cheques of client-->
<div id='clientsu' class=" scroll divcurve middle12" style="height:450px;margin-right:10px; width:650px; float:right;" >
  <div class="divheader" align="left">&nbsp; Service Cheque Record</div>
  <table id="table"  border="0" style="table-layout: fixed; width:650px;">
 <thead>
  <tr style="font-size:9px;">
 
   <th width="25">Type<span>&nbsp;</span></th>
  <th width="35">Reg By<span>&nbsp;</span></th>
  <th width="30">Cheque#<span>&nbsp;</span></th>
  <th width="55">Cheque Date<span>&nbsp;</span></th>
  <th width="25">Amount<span>&nbsp;</span></th>
  <th width="25">Status<span>&nbsp;</span></th>
  <th width="30">Note<span>&nbsp;</span></th>

   
    </tr>
    </thead>
    <tbody tyle="font-size:11px;"> <?php echo $rc; ?>
</tbody></table>
 
  </div>
 
 <!--this payment history end-->
 
 <!--this div for update progress-->

   <script>
$(document).ready( function () {
    $('#tabler').DataTable();
} );
 
</script>


 <!--this payment history of client-->
 <div id='clientp' class="scroll divcurve middle12" style="height:450px; width:642px; margin-left:10px;  float:left;  " >

 <div class="divheader" align="left">&nbsp;Service Receipt Record</div>
 <style>

 </style>
 <table id="tabler"  border="0" style="table-layout: fixed; width:640px ">
 <thead>
  <tr style="font-size:9.2px;">
 
   <th width="25">Receipt<span>&nbsp;</span></th>
  <th width="25">Date<span>&nbsp;</span></th>
  <th width="60">Recevied From<span>&nbsp;</span></th>
  <th width="25">Amount<span>&nbsp;</span></th>
  <th width="61">Payment Method<span>&nbsp;</span></th>
  <th width="35">Paid For<span>&nbsp;</span></th>
 

   
    </tr>
    </thead>
    <tbody style="font-size:11px;"> <?php echo $rcr; ?>
</tbody></table>
   </div>
    <div>

  <div id='clientsu' class="divcurve " style="height:200px;margin-left:10px; width:639px; float:left;" >
  <div class="divheader" align="left">&nbsp; Update Progress</div>

<form action="" method="post"  id="sign">
<table align="left" >
 <tr><td>&nbsp;&nbsp;<label >Date</label><input id="sdate" name="sdate" type="text" size="10" readonly="readonly" /></td></tr>
<tr><td colspan="3">&nbsp;&nbsp;<label for="sdesc">Descrpition</label><input id="desc" name="desc" type="text" size="52"  /></td><tr/>			
  <tr><td> &nbsp; <label for="sstatus">Status</label>  <select name="sstatus" id="sstatus" >
<option value="Pending ">Pending</option>
<option value="Cleared ">Cleared</option>
<option value="Rejected">Rejected</option>  
</select></td></tr>          
 <tr><td>  <input type="hidden" name="id" value="<?php echo $id; ?>"  />
          <input type="hidden" name="uby" value="<?php echo $name; ?>"  />
<input name="submit" type="submit" class="csw" value="Submit" /> </td></tr>   
</table>         
</form>			
          
 </div>

<!--this div for update progress end-->

</div>
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>