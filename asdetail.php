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
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and assset=1 LIMIT 1 ";
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
//update employee
$rs='';
if (isset($_POST['offno'])  ) {
	include ("mysqli.php");
	$offno = mysqli_real_escape_string($db_conx, $_POST['offno']);
	$pdate = mysqli_real_escape_string($db_conx, $_POST['pdate']);
	$gdate = mysqli_real_escape_string($db_conx, $_POST['gdate']);
	$names = mysqli_real_escape_string($db_conx, $_POST['names']);
	$comment = mysqli_real_escape_string($db_conx, $_POST['comment']);
	$id= mysqli_real_escape_string($db_conx, $_POST['id']);
	
	$pdate=date("y-m-d", strtotime($pdate));
	$gdate=date("y-m-d", strtotime($gdate));
	
		   		$newname = "$id.jpg";
	move_uploaded_file( $_FILES['upic']['tmp_name'], "eimg/$newname");
	
	$sql = "UPDATE  asset SET offno='$offno', pdate='$pdate', gdate='$gdate', names='$names', comment='$comment', uby='$name'   WHERE id='$id'" ;
	   
	   $query = mysqli_query($db_conx, $sql);
	   

	
	header("location: asdetail.php?id=$id&su=Update SuccessFull");


}
	?>
    
<?php
//This get detail of pr client
	$pro='';
if (isset($_GET['id'])) {
	$su=$_GET['su'];
	$id=preg_replace('#[^0-9]#i', '', $_GET['id']);
	include ("mysqli.php");
$sql2 ="SELECT * FROM  asset WHERE id='$id'  ";
$query2 = mysqli_query($db_conx, $sql2);
	$productCount2 =  mysqli_num_rows($query2);


	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
		
	 $id = $row['id'];
	$names =$row['names'];
	$offno =$row['offno'];
	$pdate =date('d-m-Y', strtotime($row['pdate']));
	$gdate =date('d-m-Y', strtotime($row['gdate']));
	$cont =$row['comment'];
	$regby =$row['regby'];
	
	
	$rs='<tr>
	     <td width="400" height="50">Asset Name: <input id="names" name="names" type="text" value="'.$names.' " ></td>
	     <td >Office# : <input id="offno" name="offno" type="text" value='.$offno.'  ></td>
	     <td>Puchase Date: <input id="pdate" class="sdate" name="pdate" type="text" value='.$pdate.' readonly ></td>
			 </tr>	 
			 
			  <tr>
			  <td>G/W Date: <input id="gdate" class="sdate" name="gdate" type="text" value='.$gdate.' readonly ></td>
              <td width="400" height="50">Registered by: <input id="regby"  name="regby" type="text" value='.$regby.' readonly  ></td>
			  <td height="50">Comment: <input id="comment" size="29" name="comment" type="text" value="'.$cont.'"  ></td>
             </tr>
  
	
             <tr>
  <td><input name="id" value='.$id.' id="id" type="hidden"><input type="button" value="Cancel" onclick="window.open(\'asset.php\',\'_self\')" class="csw"><input style="margin-left:5px;" class="submit csw" type="submit" value="Update"></td>
  <td><span style="color:blue">'.$su.'</span></td>
            </tr>';
		
		}else{
		
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
<script>
  //Date Pciker
   $(function() {
    $( ".sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true,changeYear:true,yearRange: '2000:2100:' });
	
   });
//validatting
$(document).ready(function() {
	 $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9,.()&\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		
		rules: {
			names: {required:true,loginRegex:true},
			offno: {number:true},
			pdate: {required:true},
			gdate:{required:true},
			comment:{loginRegex:true}			
		},

		messages: {
			names: {required:"Enter Asset Name" ,loginRegex:"Invalid Name"},
			offno: {number:"Invalid Office Number"},
			pdate: {required:"Select"},
			gdate:{required:"Select"},		
		    comment:{loginRegex:"Invalid Comment"}		
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
<!--this div for detail of tenant-->
<div >
 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:500px; width:1300px; margin-left:10px;  float:left "><div class="divheader" align="left">&nbsp;Asset  </div><form action="" method="post" id="signupForm" > <table align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
<thead> <th align="left" colspan="5"  height="30">&nbsp;&nbsp; Edit</th></thead>


   <?php echo $rs;?>
 </table></form></div>
 <!--this end detail of client-->
 
 
 </div>

 
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>