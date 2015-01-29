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
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and tenant=1 LIMIT 1 ";
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
	$id=mysqli_real_escape_string($db_conx, $_POST['id']);
	
	$sql = ("UPDATE tenant SET status='$update' WHERE id='$id'")  ;
	$query = mysqli_query($db_conx, $sql);
	}
?>

<?php
//This get detail of Tenant

if (isset($_GET['pid'])) {
	$pro='';
	$id=preg_replace('#[^0-9]#i', '', $_GET['pid']);
	$su= $_GET['su'];
	include ("mysqli.php");
$sql2 ="SELECT * FROM  tenant WHERE id='$id'  ";
$query2 = mysqli_query($db_conx, $sql2);
	$productCount2 =  mysqli_num_rows($query2);


	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
		
		$id = $row['id'];
	$rname = $row['regby'];
	$floorno =$row['floorno'];
	$offno =$row['offno'];
	$compname =$row['compname'];
	$crno =$row['crno'];
	$crval =date('d-m-Y', strtotime($row['crdate']));
	$munlic =$row['mlic'];
	$munval =date('d-m-Y', strtotime($row['mlicdate']));
	$comno =$row['comc'];
	$comval =date('d-m-Y', strtotime($row['comcdate']));
	$sponsor =$row['sname'];
	$sponsorid =$row['sqid'];
	$conperson =$row['conname'];
	$conqid =$row['conqid'];
	$conmob =$row['conmob'];
	$conemail =$row['conemail'];
	$contel =$row['contele'];
	$cpfrom =date('d-m-Y', strtotime($row['cpfrom']));
	$cpuntill =date('d-m-Y', strtotime($row['cpuntil']));
	$rpm =$row['rpmonth'];
	$adamount =$row['advance'];
	$status =$row['status'];
	$remarks =$row['remarks'];
	

	$rs='<tr >
	<td width="400" height="28">Tenant ID:<strong id="ids">'.$id.'</strong></td><td width="400">Floor#.<strong>: '.$floorno.'</strong></td><td width="400">Office#<strong>: '.$offno.'</strong></td>
		</tr>
		
		<tr>
		<td width="250" height="28">Company<strong>:'.$compname.'</strong></td>
		<td width="250">Status<strong>:'.$status.'</strong></td>
		<td width="250">Register by<strong>:'.$rname.'</strong></td>
		</tr>
		
		<tr>
		<td height="28">Contract From<strong>:'.$cpfrom.'</strong></td><td width="150">Contract Untill<strong>: '.$cpuntill.'</strong></td>
	<td width="150">Advance/Deposit:<strong>: '.$adamount.'</strong></td>
		</tr>
		
		<tr>
		<td height="28">Rent Per Month:<strong>'.$rpm.'</strong></td>
		<td  width="250">Remarks.<strong>: '.$remarks.'</strong></td>
		
		</tr>
		<tr> <td height="10px" style="background-color:#fff;"></td></tr>
		
			<thead> <th align="left" colspan="3"  height="28">&nbsp;&nbsp; Contact Detail</th></thead>
			<tr>
			<td width="150">Sponsor Name<strong>: '.$sponsor.'</strong></td>
		<td height="28">Contact Person<strong>:&nbsp;'.$conperson.'</strong></td><td width="150">Contact mobile#.<strong>: '.$conmob.'</strong></td>
	</tr>
	<tr><td width="150" height="28">Sponsor QID:<strong>: '.$sponsorid.'</strong></td><td width="150">Contact Email:<strong>: '.$conemail.'</strong></td><td >Contact Telephone<strong>:'.$contel.'</strong></td>	
		</tr>
					<tr>
	<td width="250"height="40">Contact QID<strong>:'.$conqid.'</strong></td>	

		</tr>

<tr> <td height="10px" style="background-color:#fff;"></td></tr>
		<thead> <th align="left" colspan="3"  height="30px">&nbsp;&nbsp; Document Detail</th></thead>
				
		<tr>
		<td height="28" width="250">CR#.<strong>:'.$crno.' </strong></td>
		<td  width="250">Municipal License#.<strong>:'.$munlic.' </strong></td>
		<td  width="250">Computer Card#.<strong>: '.$comno.'</strong></td>
		</tr>
		<tr>
		<td width="250" height="28">CR Validity<strong>: '.$crval.'</strong></td><td width="170">Muncipal validity<strong>: '.$munval.'</strong></td>
		<td width="170">Computer Card	 validity<strong>: '.$comval.'</strong></td>
		</tr>
		<tr>
		<td ><form action="" method="post" id="chform" name="chform">
			Update: <select name="update" id="update" >
<option value="Occupied">Occupied</option>
<option value="UnOccupied">UnOccupied</option>
<input type="hidden" name="id" id="id" value='.$id.' />
<input type="hidden" name="offno" id="offno" value='.$offno.' />
</select><input class="submit csw" type="submit" value="Go"/></form></td><td><form action="etenant.php" method="post"><input name="pid" type="hidden" value='.$id.' /><input class="submit csw" type="submit" value="Edit"/></form></td>

		</tr>



		';
		

		
	}else{
		header("location: index.php");
		}


?>
<?php
//get receipt list
    include ("mysqli.php");
$rcr='';
$sqlr ="SELECT * FROM  receipt where tid=$id ";
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
$id=preg_replace('#[^0-9]#i', '', $_GET['pid']);

$sql ="SELECT * FROM  cheque where ctid = '$id' ";
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
<link rel="stylesheet" href="style/jquery-ui.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="style/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
    <link rel="stylesheet" type="text/css" media="print" href="style/printde.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" href="style/jquery-ui.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
	  <script src="jq/jquery-1.11.1.js"></script>
	  <script src="jq/jquery-ui.js"></script>
	  <script src="jq/jquery.validate.js"></script>
	  <script src="jq/jquery.js"></script>
	   <script type="text/javascript" charset="utf8" src="jq/jquery.dataTables.js"></script>
	   <link rel="stylesheet" type="text/css" href="style/jquery.dataTables.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
	   <script>
       $(document).ready(function() {
		
	  $.validator.addMethod("loginRegex", function(value, element) {
			return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
		}, "Invalid Format.");
	
		$("#chform").validate({
			
			rules: {
						update: {remote: {
        url: "ajax/offract.php",
        type: "post",
        data: { offno: $('#offno').val(),
		 id: $('#id').val(),
          update: function() {
            return $( "#update" ).val();
          },
		
        }
      }
			}
			
			},
	
			messages: {
	
				update:{remote:"Office Already Occupied"},
		
			},
				
			
	  
	
			
		});
	
	
	});
       
       </script>
<style>
.dataTables_wrapper {

  width:635px;
 
}
.dataTables_info ,.dataTables_length, .dataTables_filter{
	display:none;}
</style>
  
</head>
<body>

<div id="wrap"  align="center" >
<?php include_once("header.php"); ?>
 <?php include_once("menu.php"); ?>
 <div id="middle" align="center" class="scroll hh"  style="background-color:#2E5E79;" >
<!--this div for detail of tenant-->
<div >
 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:540px; width:1300px; margin-left:10px;  float:left "><div class="divheader" align="left">&nbsp;Tenant Details Summary</div><table align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
<thead> <th align="left" colspan="3"  height="30px">&nbsp;&nbsp; Detail<input type="button" class="csw" value="Back"  onclick="window.open('tenantlist.php','_self')" style="margin-left:1150px; cursor:pointer" ></th></thead>

   <?php echo $rs;?>
    <tr><td style="font-size:15px; font-style:normal; font-weight:bold; color:#000099"><?php echo $su ?></td></tr>
 </table></div>
 <!--this end detail of client-->
 
 
 </div>
 <!--this progress end-->
    <script>
$(document).ready( function () {
    $('#table').DataTable();
} );
 
</script>
 <!--this div for cheque-->
 <div>
  <div id='clientsu' class=" scroll divcurve middle12" style="height:450px;margin-left:10px; width:650px; float:left;" >
  <div class="divheader" align="left">&nbsp; Tenant Cheque Record</div>
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
      <script>
$(document).ready( function () {
    $('#tabler').DataTable();
} );
 
</script>

<!--this div for update progress end-->

 <!--this payment history of client-->
 <div id='clientp' class="scroll divcurve middle12" style="height:450px; width:642px; margin-right:10px;  float:right;  " >

 <div class="divheader" align="left">&nbsp;Tenant Receipt Record</div>
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
 
 <!--this payment history end-->
</div>
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>