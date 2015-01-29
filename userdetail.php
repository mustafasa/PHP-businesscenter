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
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and auser=1 LIMIT 1 ";
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
	//this update status of user
	if (isset($_POST['update'])  ) {
		
		include ("mysqli.php");
		
		$update = mysqli_real_escape_string($db_conx, $_POST['update']);
		$id=preg_replace('#[^0-9]#i', '',  $_POST['id']);
		$tmenuw=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["tmenu"]);
		$jj= $_POST["naam"];
		$iqmenuw=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["iqmenu"]);
		$chmenuw=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["chmenu"]);
		$astmenuw=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["astmenu"]);
		$sermenuw=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["sermenu"]);
		$hrmenuw=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["hrmenu"]);
		$recmenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["recmenu"]);
		$exmenu=  preg_replace('#[^A-Za-z0-9_]#i', '', $_POST["exmenu"]);
		$sql = ("UPDATE usertable SET receipt='$recmenu' , expense='$exmenu',status='$update',hr='$hrmenuw',tenant='$tmenuw',inquery='$iqmenuw',cheque='$chmenuw',assset='$astmenuw',service='$sermenuw' WHERE id='$id'")  ;
		$query = mysqli_query($db_conx, $sql);
		
		$newname = "$jj.jpg";
	move_uploaded_file( $_FILES['upic']['tmp_name'], "profile/$newname");
	
		header("location: userdetail.php?id=.$id.&su=Update SuccessFull");
		}
	?>
	
	<?php
	//This get detail of user
	if (isset($_GET['id'])) {
		$pro='';
		$id=preg_replace('#[^0-9]#i', '', $_GET['id']);
		$su= $_GET['su'];
		include ("mysqli.php");
	$sql2 ="SELECT * FROM  usertable WHERE id='$id' and user NOT IN('admins','super')  ";
	$query2 = mysqli_query($db_conx, $sql2);
		$productCount2 =  mysqli_num_rows($query2);
	
	
		$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
			
			
	$names=ucfirst($row['name']);
	$user=$row['user'];
	$status=ucfirst($row['status']);
	$eid=ucfirst($row['eid']);
	$hrs = $row['hr'];
	$tenants = $row['tenant'];
	$inquerys = $row['inquery'];
	$cheques = $row['cheque'];
	$assets = $row['assset'];
	$services = $row['service'];
	$expenses = $row['expense'];
	$receipts = $row['receipt'];
	$dd= date('l jS \of F Y h:i:s A'); 
	if($receipts==1){
			$receiptss='<input type="checkbox" class="checkbox" id="recmenu" name="recmenu" value="1" checked="checked"  />Receipt  ';
			}
		else{
			$receiptss='<input type="checkbox" class="checkbox" id="recmenu" name="recmenu" value="1" />Receipt  ';
			}	
		if($expenses==1){
			$expensess='<input type="checkbox" class="checkbox" id="exmenu" name="exmenu" value="1" checked="checked"  />Expense  ';
			}
		else{
			$expensess='<input type="checkbox" class="checkbox" id="exmenu" name="exmenu" value="1" />Expense  ';
			}
		if($hrs==1){
			$hres='<input type="checkbox" class="checkbox" id="hrmenu" name="hrmenu" value="1" checked="checked"  />Human Resource  ';
			}
		else{
			$hres='<input type="checkbox" class="checkbox" id="hrmenu" name="hrmenu" value="1" />Human Resource  ';
			}
			
		if($tenants==1){
			$tens='<input type="checkbox" class="checkbox" id="tmenu" name="tmenu" value="1" checked="checked" />Tenants   ';
			}
		else{
			$tens='<input type="checkbox" class="checkbox" id="tmenu" name="tmenu" value="1" />Tenants   ';
			}
			
			if($inquerys==1){
			$inq='<input type="checkbox" class="checkbox" id="iqmenu" name="iqmenu" value="1" checked="checked" />Enquiry  ';
			}
		else{
			$inq='<input type="checkbox" class="checkbox" id="iqmenu" name="iqmenu" value="1" />Enquiry  ';
			}
			
			if($cheques==1){
			$cq='<input type="checkbox" class="checkbox" id="chmenu" name="chmenu" value="1" checked="checked" />Cheque  ';
			}
		else{
			$cq='<input type="checkbox" class="checkbox" id="chmenu" name="chmenu" value="1" />Cheque   ';
			}
			
			if($assets==1){
			$ass='<input type="checkbox" class="checkbox" id="astmenu" name="astmenu" value="1" checked="checked" />Asset ';
			}
		else{
			$ass='<input type="checkbox" class="checkbox" id="astmenu" name="astmenu" value="1" />Asset  ';
			}
			
			if($services==1){
			$serv=' <input type="checkbox" class="checkbox" id="sermenu" name="sermenu" value="1" checked="checked" />PRO Service ';
			}
		else{
			$serv=' <input type="checkbox" class="checkbox" id="sermenu" name="sermenu" value="1" />PRO Service ';
			}
	
		$rs='<tr >
		<td width="200" ><span id="kucbhi"><div class="captionsd"><br>Upload <br /><img src="img/upload.png" width="100" height="120" /> </div><img id="img" name="img" title="Click To change" style=" cursor:pointer;" src="profile/'.$names.'.jpg?'.$dd.'" onerror="this.src=\'profile/er.jpg\';" width="120px" height="150px" />
		</span>
		</td>
		<td width="400" ><br>UserName<strong>: '.$user.'</strong>
		<form action="" method="post" id="ast" name="ast" enctype="multipart/form-data">
		<input type="file" id="upics" name="upic" style="display: none;" accept="image/*" />
		<input type="hidden" name="naam" value="'.$names.'"  />
		<br><strong>Privileges</strong>:&nbsp;'.$tens.''.$hres.''.$inq.'<br><br>'.$cq.''.$ass.''.$serv.''.$expensess.''.$receiptss.'
		<br> <strong><br>Update:</strong> <select name="update" id="update" >
	<option value="Activated">Activate</option>
	<option value="DeActivated">DeActivate</option>
	<input type="hidden" name="id" value='.$id.' />
	<input type="hidden" name="eid" id="eid" value='.$eid.' />
	</select><input class="submit_btn csw" type="submit" value="Go"/></form></td>	
	
		 <td width="400"><br>Employee ID<strong>: '.$eid.'</strong><br><br>Employee Name<strong>:'.$names.'</strong><br><br>Status<strong>: '.$status.'</strong><br><br><input style=" width:125px;" class="submit_btn cs" type="button" id="pc" value="Change Password"/></td>
		</tr >
		
		<tr><td colspan="3"></td></tr>
			
		
			';	
		}else{
			header("location: index.php");
			}
	
	?>
	
	<?php
	//this update password of user
	if (isset($_POST['pass'])  ) {
		
		include ("mysqli.php");
		$id=preg_replace('#[^0-9]#i', '',  $_POST['pasid']);
			$passrd =crypt($_POST['pass']);
		
		$sql = ("UPDATE usertable SET password='$passrd'  WHERE id='$id'")  ;
		$query = mysqli_query($db_conx, $sql);
		
		header("location: userdetail.php?id=.$id.&su=Update SuccessFull");
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
	   <script>
	   //change pic on upload and clickable on iamage
	$(function(){
		$("#kucbhi").click(function() {
		$("#upics").click();
	});
	
	function readURL(input) {
	
		if (input.files && input.files[0]) {
			var reader = new FileReader();
	
			reader.onload = function (e) {
				$('#img').attr('src', e.target.result);
			}
	
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	$("#upics").change(function(){
		readURL(this);
	});
		});
	   //dialagbox
	   $(document).ready(function(){
	  $("#pc").on("click",function() { $( "#dialog-message" ).dialog({
		  height:230,
			width: 450,
		  modal: true,
				   buttons: {
        Close: function() {
          $( this ).dialog( "close" );
	
        }
      }
		 

	   });   
		}); 
			}); 
			
			//vasldiation passwrod
	$(document).ready(function() {
		
	  $.validator.addMethod("loginRegex", function(value, element) {
			return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
		}, "Invalid Format.");
	
		$("#changep").validate({
			
			rules: {
				pass:{required:true,loginRegex:true,minlength: 6},
				cpass:{equalTo: "#pass"}
			},
	
			messages: {
		
			
				pass:{required:"Please Enter Password",loginRegex:"Inalid password Format",minlength: "Atleast Six Character"},
				cpass:{equalTo: "Mismatch"}
			},
				
					 
	  
	
			
		});
	
	
	});
	
	//validation form
	$(document).ready(function() {
		
	  $.validator.addMethod("loginRegex", function(value, element) {
			return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
		}, "Invalid Format.");
	
		$("#ast").validate({
			
			rules: {
						update: {remote: {
        url: "ajax/useract.php",
        type: "post",
        data: { eid: $('#eid').val(),
          update: function() {
            return $( "#update" ).val();
          },
		
        }
      }
			}
			
			},
	
			messages: {
	
				update:{remote:"Activate Employee From HR"},
		
			},
				
			
	  
	
			
		});
	
	
	});
	   </script>
	<style>
	#kyaki  td{font-size:17px;}
	
	.cs {
	 width: 120px;
	 height: 30px;
	 background-color: #2E5E79;
	 border: none;
	 border-radius: 4px;
	 color: white;
	
	 
	 }
	#kucbhi .captionsd { opacity: 0; position: fixed; height:150px; width: 120px;   color: #666; background: white; text-align: center; font-weight: 700; } #kucbhi:hover .captionsd { opacity: 0.7;cursor:pointer;  } </style>

	</style>
	  
	</head>
	<body>
	
	<div id="wrap"  align="center" >
	<?php include_once("header.php"); ?>
	 <?php include_once("menu.php"); ?>
	 <div id="middle" align="center" class="scroll" style="background-color:#2E5E79;" >
	
	 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:505px; width:1300px; margin-left:10px;  float:left ">
	 <div class="divheader" align="left">&nbsp;User Details </div>
	 <div>
	 <table id="kyaki" align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
	<thead> <th align="left" colspan="3"  height="30px">&nbsp;&nbsp; Detail <input type="button" class="csw" value="Back"  onclick="window.open('adduser.php','_self')" style="margin-left:1150px; cursor:pointer" ></th></thead>
	
	   <?php echo $rs;?>
		<tr><td style="font-size:15px; font-style:normal; font-weight:bold; color:#000099"><?php echo $su ?></td></tr>
	 </table></div>
	
	   <div id="dialog-message" title="Change Password" style="display:none; width:700px;">
	  <p>
		<form action="" method="post" name="changep" id="changep">
		<label> Password </label><input id="pass" name="pass" type="password" />
		 <br /><br /><label> Confirm </label> &nbsp;&nbsp;<input id="cpass" name="cpass" type="password" />
		   <input id="pasid" name="pasid" type="hidden" value= "<?php echo $id ?> "/>
		   <br /><br /><input class="cs" type="submit" />
		</form>
	  </p>
	 
	 
	</div>
	
	</div>
	  
	<?php include_once("footer.php"); ?>
	</div>
	</body>
	</html>