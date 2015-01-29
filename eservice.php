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
//update pr client
$rst='';
$rs='';
if (isset($_POST['sname'])  ) {
	include ("mysqli.php");
	$id = mysqli_real_escape_string($db_conx, $_POST['id']);
	$tnid = mysqli_real_escape_string($db_conx, $_POST['tnid']);
	$sname = mysqli_real_escape_string($db_conx, $_POST['sname']);
	$sqid = mysqli_real_escape_string($db_conx, $_POST['sqid']);
	$smob = mysqli_real_escape_string($db_conx, $_POST['smob']);
	$sdate = mysqli_real_escape_string($db_conx, $_POST['sdate']);
	$stype = mysqli_real_escape_string($db_conx, $_POST['stype']);
	$samount = mysqli_real_escape_string($db_conx, $_POST['samount']);
	$regby = mysqli_real_escape_string($db_conx, $_POST['hby']);
	$uby = $user;
	
	
	$scdate = date('Y-m-d', strtotime($sdate));
	
	
	$sql = "UPDATE  prclient SET name='$sname', qid='$sqid', contact='$smob', date='$scdate', amount='$samount',service='$stype',regby='$regby',tid='$tnid',uby='$uby'
       WHERE id='$id'" ;
	   
	   $query = mysqli_query($db_conx, $sql);
	   
	header("location: sdetail.php?pid=$id&su=Update SuccessFull");


}
	?>
    
<?php
//This get detail of pr client
if (isset($_POST['pid'])) {
	$pro='';
	$id=preg_replace('#[^0-9]#i', '', $_POST['pid']);
	include ("mysqli.php");
$sql3 ="SELECT * FROM  prclient WHERE id='$id'  ";
$query3 = mysqli_query($db_conx, $sql3);
	$productCount3 =  mysqli_num_rows($query3);


		while ($row = $query3->fetch_assoc()) {
		$tid = $row['tid'];
		$id = $row['id'];
	$names = $row['name'];
	$qid = $row['qid'];
	$contact =$row['contact'];
	$date = $row['date'];
	$services = $row['service'];
	$amount =$row['amount'];
	$status = $row['status'];
	$regby= $row['regby'];
	
	$rs='<tr><td width="180" height="30">Id#: <strong>'.$id.'</strong></td><td width="200">Name: <strong><input id="sname" name="sname" value="'.$names.'" ></strong></td><td width="200">QID#: <strong><input id="sqid" name="sqid" type="text" value='.$qid.' ></strong></td></tr>
  <tr><td height="30">Contact#: <strong><input id="smob" name="smob" type="text" value='.$contact.'  ></strong></td><td>Date: <strong><input id="sdate" name="sdate" type="text" size="10" readonly value='.$date.' ></strong></td><td>Service Type: <strong> <select name="stype" id="stype" >
             <option value='.$services.'>'.$services.'</option>
			<option value="Computer Card">Computer Card</option>
<option value="Civil Defence approval">Civil Defence approval</option>
<option value="Company Registration(CR)">Company Registration(CR)</option>
 <option value="Fingerprint">Fingerprint</option>
<option value="Medical">Medical</option>
<option value="Municipal Licence">Municipal Licence</option>
<option value="Visas">Visas</option>
</select></strong></td></tr>
  <tr><td height="30">Status:<strong>'.$status.'</strong></td><td>Handling by:<strong><input id="hby" name="hby" type="text" value= "'.$regby.'" ></strong></td></tr><tr><td>TID#<strong><input id="tnid" name="tnid" size="5" value='.$tid.' ></strong></td><td height="30">Charges:<strong><input id="samount" name="samount" type="text" value='.$amount.'></strong></td><td><input name="id" value='.$id.' type="hidden"><input type="button" value="Cancel" onclick="javascript:history.back()" class="csw" ><input style="margin-left:5px;" class="submit csw" type="submit" value="Update"></td></tr>';
		}
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
    $( "#sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true});
	
	
   });
//validatting
$(document).ready(function() {
	
  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		
		rules: {
			sname: {	required: true,loginRegex:true	},
			sqid:{required:true,number: true,},
			smob:{required:true,number: true,},
			sdate:{required:true},						
			hby: {required: true,	loginRegex:true		},
			samount:{number:true		}
	     		},

		messages: {
			sname: {required:"Enter Company Name" ,loginRegex:"Company Name Invalid"},
			sqid: {required:"Enter Valid ID .",number:"Enter Valid ID."},
			smob: {required:"Enter Valid Contact Mobile.",number:"Enter Valid Conact Mobile."},
			hby: {required:"Enter Handler Name" ,loginRegex:"Handler Name Invalid"},
			sdate: {required:"Select Date"},
			samount:{number:"Invalid Format"		}
			},
				

		
	});


});
//check for tenant
 $(document).ready(function(){
	  $("#tnid").keyup(function(){
		  var status=$(this).val();
		   if(status != ''){
		 	      $.ajax({
                              type:"post",
                              url:"ajax/gt.php",
                              data:"status="+status,
							  datatype:"json",
				              success:function(data){ $("#sname").val(data);
							    $('#sname').css( "background-color","#B3CBD6"  ) 
							 $('#sname').animate({backgroundColor: "#fff",});
							   }
                                
	                                                       });
		   }
		   else{
			   $("#sname").val("");
			   }
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
 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:505px; width:1300px; margin-left:10px;  float:left "><div class="divheader" align="left">&nbsp;PRO Client </div><form action="" method="post" id="signupForm"> <table align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
<thead> <th align="left" colspan="3"  height="30px">&nbsp;&nbsp; Edit</th></thead>

   <?php echo $rs;?>
    <?php echo $rst;?>
 </table></form></div>
 <!--this end detail of client-->
 
 
 </div>
<script>
$(document).on('click', '#cdate', function() {  });
  $(function() {
    $( ".cdate" ).datepicker({dateFormat: 'dd-mm-yy'});
	
  });
</script>
 
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>