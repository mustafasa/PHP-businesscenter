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
//update expense
$rs='';
if (isset($_POST['ename'])  ) {
	include ("mysqli.php");
	$id = mysqli_real_escape_string($db_conx, $_POST['id']);
	$ename = mysqli_real_escape_string($db_conx, $_POST['ename']);
	$amount = mysqli_real_escape_string($db_conx, $_POST['amount']);
	$desc = mysqli_real_escape_string($db_conx, $_POST['desc']);
	$hby = mysqli_real_escape_string($db_conx, $_POST['hby']);
	$efr = mysqli_real_escape_string($db_conx, $_POST['efr']);
	$statuss = mysqli_real_escape_string($db_conx, $_POST['statuss']);
	$duedate = mysqli_real_escape_string($db_conx, $_POST['duedate']);
	
	if($efr==1){
			$freqname="Monthly";
			}
			else if($efr==3){
				$freqname="Quarterly";
				}
				   else if($efr==6){
				  $freqname="Half Yearly";
				    }
				else if($efr==12){
				$freqname="Yearly";
				}

	
	$duedate = date('Y-m-d', strtotime($duedate));
		;
	
	
	$sql = "UPDATE  expense SET ename='$ename', amount='$amount', frequency='$efr' , frename='$freqname' ,frename='$freqname',hby='$hby',duedate='$duedate', status='$statuss'
       WHERE id='$id'" ;
	   
	   $query = mysqli_query($db_conx, $sql);
	   
	header("location: exdetail.php?id=$id&su=Update SuccessFull");


}
	?>
    
<?php
//This get detail of pr client
	
if (isset($_POST['pid'])) {
	$id=preg_replace('#[^0-9]#i', '', $_POST['pid']);
	include ("mysqli.php");
$sql2 ="SELECT * FROM  expense WHERE id='$id'  ";
$query2 = mysqli_query($db_conx, $sql2);
	$productCount2 =  mysqli_num_rows($query2);


	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
		
	$id=$row['id'];
	$date = date('d-m-Y', strtotime($row['date']));
	$ename = $row['ename'];
	$amount =$row['amount'];
	$desc =$row['desc'];
	$hby = $row['hby'];
	$status = $row['status'];
	$frename =$row['frename'];
	$frq =$row['frequency'];
	$duedate =date('d-m-Y', strtotime($row['duedate']));
	
	$rs='<tr>
	<td width="400" height="50">Register Date: <strong>'.$date.'</strong></td>
	<td >Expense Name: <strong><input id="ename" name="ename" type="text" value="'.$ename.'" ></strong></td>
	<td >Amount: <strong><input id="amount" name="amount" type="text" value='.$amount.' ></strong></td>
			 </tr>	 
		
			  <tr>
  <td width="400" height="50">Description: <strong><input id="desc" name="desc"   type="text" value="'.$desc.' " ></strong></td>
  <td>Handlng by: <strong><input id="hby" name="hby" type="text" size="14"  value="'.$hby.'" ></strong></td>
  <td>Frequency: <strong><select id="efr" name="efr" >
              <option value="'.$frq.'" selected="selected" >'.$frename.'</option>
                   <option value="1">Monthly</option>
              <option value="3">Quarterly</option>
               <option value="6">Half Yearly</option>
                <option value="12">yearly</option>
            </select></strong></td>
             </tr>
  
          	 <tr>
  <td width="400" height="50">Status: <strong> '.$status.'  </strong></td>
  <td>Status: <select id="statuss" name="statuss" >
  <option  value="'.$status.'">'.$status.'</option>
  <option value="Activated">Activate</option>
  <option value="DeActivated">DeActivate</option>

  </select></td>
  <td>Due Date:<strong><input id="duedate" name="duedate" type="text" size="12" class="sdate" value= '.$duedate.'  readonly ></strong></td>

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


</script>
  
</head>
<body>

<div id="wrap"  align="center" >
<?php include_once("header.php"); ?>
 <?php include_once("menu.php"); ?>
 <div id="middle" align="center" class="scroll" style="background-color:#2E5E79;" >
<!--this div for detail of tenant-->
<div >
 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:500px; width:1300px; margin-left:10px;  float:left "><div class="divheader" align="left">&nbsp;Expense Detail </div><form action="" method="post" id="signupForm"> <table align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
<thead> <th align="left" colspan="3"  height="30px">&nbsp;&nbsp; Edit</th></thead>

   <?php echo $rs;?>
 </table></form></div>
 <!--this end detail of client-->
 
 
 </div>

 
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>