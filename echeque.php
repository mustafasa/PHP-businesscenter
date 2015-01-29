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
//update pr client
$rs='';
if (isset($_POST['cnumber'])  ) {
	include ("mysqli.php");
	$id = mysqli_real_escape_string($db_conx, $_POST['id']);
	$dates = mysqli_real_escape_string($db_conx, $_POST['dates']);
	$cnumber = mysqli_real_escape_string($db_conx, $_POST['cnumber']);
	$cri = mysqli_real_escape_string($db_conx, $_POST['cri']);
	$cdate = mysqli_real_escape_string($db_conx, $_POST['cdate']);
	$amount = mysqli_real_escape_string($db_conx, $_POST['amount']);
	$payee = mysqli_real_escape_string($db_conx, $_POST['payee']);
	$ctid = mysqli_real_escape_string($db_conx, $_POST['ctid']);
	$csid = mysqli_real_escape_string($db_conx, $_POST['csid']);
	$bank = mysqli_real_escape_string($db_conx, $_POST['bank']);
	$note = mysqli_real_escape_string($db_conx, $_POST['note']);
	$admin = mysqli_real_escape_string($db_conx, $_POST['admin']);

	
	$cdate = date('Y-m-d', strtotime($cdate));
		$dates = date('Y-m-d', strtotime($dates));
	
	
	$sql = "UPDATE  cheque SET cdate='$cdate', cnumber='$cnumber', cri='$cri', date='$dates', amount='$amount',ctid='$ctid',csid='$csid',payee='$payee',bank='$bank',note='$note',uby='$admin'
       WHERE id='$id'" ;
	   
	   $query = mysqli_query($db_conx, $sql);
	   
	header("location: cdetail.php?pid=$id&su=Update SuccessFull");


}
	?>
    
<?php
//This get detail of pr client
	$pro='';
if (isset($_POST['pid'])) {
	$id=preg_replace('#[^0-9]#i', '', $_POST['pid']);
	include ("mysqli.php");
$sql2 ="SELECT * FROM  cheque WHERE id='$id'  ";
$query2 = mysqli_query($db_conx, $sql2);
	$productCount2 =  mysqli_num_rows($query2);


	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
		
	$id = $row['id'];	
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
	
	$rs='<tr>
	<td width="400" height="50">Register Date: <strong><input id="dates" name="dates" class="sdate" value='.$date.' readonly ></strong></td>
	<td >Cheque#: <strong><input id="cnumber" name="cnumber" type="text" value='.$cnumber.' ></strong></td>
	<td>Cheque type: <strong><select name="cri" id="cri" >
             <option value='.$cri.'>'.$cri.'</option>
			 <option value="Recieved">Recieved</option>
			 <option value="Issued">Issued</option></select></strong>
			 </td>
			 </tr>	 
			 
			  <tr>
  <td width="400" height="50">Cheque Date: <strong><input id="cdate" name="cdate" class="sdate" type="text" value='.$cdate.' readonly ></strong></td>
  <td>Amount: <strong><input id="amount" name="amount" type="text" size="14"  value='.$amount.' ></strong></td>
  <td>Name/Company: <strong><input id="payee" name="payee" size="22" type="text" value= "'.$payee.'"  ></strong></td>
             </tr>
  
              <tr>
  <td width="400" height="50">Tenant ID:<strong><input id="ctid" size="2" name="ctid" type="text" value= '.$ctid.'  ></strong></td>
  <td>Service ID:<strong><input id="csid" name="csid" type="text" size="2" value= '.$csid.'  ></strong></td>
  <td >Bank Name: <strong><input id="bank" name="bank" size="20" value="'.$bank.'"  ></strong></td>
              </tr>
  
              <tr>
  <td width="400" height="50">Register by: <strong>'.$regby.'</strong></td><td height="30">Note:<strong><input id="note" name="note" type="text" value="'.$note.'"></strong></td>
  <td>Status:<strong>'.$status.'</strong></td>
             </tr>
  
             <tr>
  <td><input name="id" value='.$id.' type="hidden"><input name="admin" value='.$name.' type="hidden"><input type="button" value="Cancel" onclick="javascript:history.back()" class="csw" ><input style="margin-left:5px;" class="submit csw" type="submit" value="Update"></td>
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
    $( ".sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true});
	
   });
//validatting
$().ready(function() {

$.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9()$&.()\-\s]+$/i.test(value);
    }, "Invalid Format.");
	
	$.validator.addMethod("amount", function(value, element) {
        return this.optional(element) || /^[0-9.\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		rules: {
			dates:{required:true},
			payee:{required:true ,loginRegex:true},
			cnumber:{required:true ,number:true},
			cdate:{required:true},
			amount:{required:true ,amount:true},
			bank:{required:true ,loginRegex:true},
			note:{loginRegex:true},
			csid:{number:true},
			ctid:{number:true}
		},
		messages: {
			dates: {required:"Please Select date"},
			payee: {required:"Please Enter Name/Company"},
			cnumber:{required:"Enter Cheque Number",number:"Invaid Number"},
			cdate: {required:"Please Select date"},
			amount:{required:"Enter Amount"},
			bank: {required:"Please Enter Bank Name"},
			csid:{number:"Invalid number"},
			ctid:{number:"Invalid number"}
		},
		});

});
//check for tenant
 $(document).ready(function(){
	  $("#ctid").keyup(function(){
		  var status=$(this).val();
		   if(status != ''){
		 	      $.ajax({
                              type:"post",
                              url:"ajax/gt.php",
                              data:"status="+status,
							  datatype:"json",
				              success:function(data){ $("#payee").val(data);  
							  $('#payee').css( "background-color","#B3CBD6"  ) 
							 $('#payee').animate({backgroundColor: "#fff",}, 3000);
} 
	                      });                                 
		   }
		   else{
			   $("#sname").val("");
			   }
		  });
	 });
//check for service
 $(document).ready(function(){
	  $("#csid").keyup(function(){
		  var statuss=$(this).val();
		   if(statuss != ''){
		 	      $.ajax({
                              type:"post",
                              url:"ajax/gs.php",
                              data:"statuss="+statuss,
							  datatype:"json",
				              success:function(data){ $("#payee").val(data);
						 $('#payee').css("background-color", "#e5edc4"); 
							 $('#payee').animate({backgroundColor: "#fff",}, 3000);

 
		  
					   }
                                
	                                                       });
		   }
		   else {
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
 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:505px; width:1300px; margin-left:10px;  float:left "><div class="divheader" align="left">&nbsp;Cheque Detail </div><form action="" method="post" id="signupForm"> <table align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
<thead> <th align="left" colspan="3"  height="30px">&nbsp;&nbsp; Edit</th></thead>

   <?php echo $rs;?>
 </table></form></div>
 <!--this end detail of client-->
 
 
 </div>

 
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>