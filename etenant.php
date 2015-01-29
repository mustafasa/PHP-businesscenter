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
//update tenenat
$rst='';
$rs='';
if(isset ($_POST['offno'])){
	include "mysqli.php";
	$id = mysqli_real_escape_string($db_conx, $_POST['id']);
	$floorno = mysqli_real_escape_string($db_conx, $_POST['floorno']);
	$offno = mysqli_real_escape_string($db_conx, $_POST['offno']);
	$compname = mysqli_real_escape_string($db_conx, $_POST['compname']);
	$crno = mysqli_real_escape_string($db_conx, $_POST['crno']);
	$crval = mysqli_real_escape_string($db_conx, $_POST['crval']);
	$munlic = mysqli_real_escape_string($db_conx, $_POST['munlic']);
	$munval = mysqli_real_escape_string($db_conx, $_POST['munval']);
	$comno = mysqli_real_escape_string($db_conx, $_POST['comno']);
	$comval = mysqli_real_escape_string($db_conx, $_POST['comval']);
	$sponsor = mysqli_real_escape_string($db_conx, $_POST['sponsor']);
	$sponsorid = mysqli_real_escape_string($db_conx, $_POST['sponsorid']);
	$conperson = mysqli_real_escape_string($db_conx, $_POST['conperson']);
	$conqid = mysqli_real_escape_string($db_conx, $_POST['conqid']);
	$conmob = mysqli_real_escape_string($db_conx, $_POST['conmob']);
	$conemail = mysqli_real_escape_string($db_conx, $_POST['conemail']);
	$contel = mysqli_real_escape_string($db_conx, $_POST['contel']);
	$cpfrom = mysqli_real_escape_string($db_conx, $_POST['cpfrom']);
	$cpuntill = mysqli_real_escape_string($db_conx, $_POST['cpuntill']);
	$rpm = mysqli_real_escape_string($db_conx, $_POST['rpm']);
	$adamount = mysqli_real_escape_string($db_conx, $_POST['adamount']);	
	$remarks = mysqli_real_escape_string($db_conx, $_POST['remarks']);

	
	$crval=date("y-m-d", strtotime($crval));
	$munval=date("y-m-d", strtotime($munval));
	$comval=date("y-m-d", strtotime($comval));
	$cpfrom=date("y-m-d", strtotime($cpfrom));
	$cpuntill=date("y-m-d", strtotime($cpuntill));
	
	$sqle ="UPDATE tenant SET  upby='$name',floorno='$floorno', offno='$offno',compname='$compname', crno='$crno', crdate='$crval', mlic='$munlic' ,mlicdate='$munval',comc='$comno',comcdate='$comval',sname='$sponsor',sqid='$sponsorid',conname='$conperson',conqid='$conqid',conmob='$conmob',conemail='$conemail',contele='$contel',cpfrom='$cpfrom',cpuntil='$cpuntill',rpmonth='$rpm',advance='$adamount',remarks='$remarks' WHERE id='$id'";

$query = mysqli_query($db_conx, $sqle);
header("location: tdetail.php?pid=$id&su=Update SuccessFull");
$rst='Record Updated';
}
	?>
<?php
//This get detail of Tenant
if (isset($_POST['pid'])) {
	$pro='';
	$id=preg_replace('#[^0-9]#i', '', $_POST['pid']);
	include ("mysqli.php");
$sql3 ="SELECT * FROM  tenant WHERE id='$id'  ";
$query3 = mysqli_query($db_conx, $sql3);
	$productCount3 =  mysqli_num_rows($query3);
	
	$row = mysqli_fetch_array($query3, MYSQLI_ASSOC);
		
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
	<td width="400" height="40">Tenant ID<strong>:<input align="left" name="id"type="text" id="id" size="5"  readonly="readonly" value='.$id.'  /></strong></td><td width="400">Floor#.<strong>:<input name="floorno"type="text" id="floorno" size="3" value='.$floorno.' /> </td><td width="400">Office#<input name="offno"type="text" id="offno" size="8" value='.$offno.' /></td>
	
		</tr>
		<tr>
		<td width="250" height="28">Company<input name="compname" type="text" id="compname" size="20" value="'.$compname.'" /></td>
		<td width="250">Status<strong>:'.$status.'<input  name="status"type="hidden" id="status" size="15" value='.$status.' ></strong></td>
		<td width="250">Register by<strong>:'.$rname.'</strong></td>
		</tr>
				<tr>
		<td  height="28">Contract From<strong>:<input class="cstart" name="cpfrom"type="text" id="cpfrom" size="12" readonly value='.$cpfrom.' /></td>
		<td width="150">Contract Untill<strong>:<input class="cend" name="cpuntill"type="text" id="cpuntill" readonly size="12" value='.$cpuntill.' /></td>
		<td width="150">Advance/Deposit:<input  name="adamount"type="text" id="adamount" size="12" value='.$adamount.' /></td>
					</tr>
		<tr>
		<td height="28">Rent Per Month:<input  name="rpm"type="text" id="rpm" size="15" value='.$rpm.' /></td>
		<td  width="250">Remarks.<input  name="remarks"type="text" id="remarks" size="15" value='.$remarks.' ></td>
		</tr>
		
		<tr> <td height="10px"></td></tr>
		
		<thead> <th align="left" colspan="3"  height="28">&nbsp;&nbsp; Contact Detail</th></thead>
		
		<tr>
		<td width="150" height="28">Sponsor Name:<input align="left" name="sponsor"type="text" id="sponsor" size="25	" value="'.$sponsor.' "/></td>
		<td height="40">Contact Person<input align="left" name="conperson"type="text" id="conperson" size="25" value="'.$conperson.'" /></td>
		<td width="150">Contact mobile#.<input align="left" name="conmob"type="text" id="conmob" size="25" value='.$conmob.' /></td>
		</tr>
		
		
		<tr>
		<td width="150" height="28">Sponsor QID:<input name="sponsorid"type="text" id="sponsorid" size="25" value='.$sponsorid.' /></td>
		<td width="150">Contact Email:<input name="conemail"type="text" id="conemail" size="25" value='.$conemail.' /></td>
		<td height="40">Contact Telephone<input align="left" name="contel"type="text" id="contel" size="25	" value='.$contel.' /></td>
	
		</tr>
			<tr>
			<td width="250"height="28">Contact QID<strong>:<input name="conqid"type="text" id="conqid" size="25" value='.$conqid.' /></td>
				</tr>
			<tr> <td height="10px"></td></tr>
		
		<thead> <th align="left" colspan="3"  height="28">&nbsp;&nbsp; Document Detail</th></thead>
		
		<tr>
		<td height="28" width="250">CR#.<input name="crno"type="text" id="crno" size="20" value='.$crno.' />
		<td  width="250">Municipal License#.<input name="munlic"type="text" id="munlic" size="25" value='.$munlic.' /></td>
		<td width="250">Computer Card#.<input name="comno"type="text" id="comno" size="20" value='.$comno.' /></td>
		</tr>
		<tr>
		<td width="250" height="28">CR Validity<input name="crval"type="text" class="cdate" id="crval" size="12" readonly value='.$crval.' /></td>
		<td width="170">Muncipal validity:<input name="munval"type="text" class="cdate" id="munval" size="12" readonly value='.$munval.'  /></td>
		<td width="170">Computer Card validity<input name="comval"type="text"  class="cdate" id="comval" readonly size="12" value='.$comval.' /></td>
		
		</tr>

		<tr>
		
		<td height="28" ><input class="submit csw" type="submit" value="Update"/>
  <input type="button" value="Cancel" onclick="javascript:history.back()" style="margin-left:5px;" class="csw" />
</td>
		</tr>
		';
		

		
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
  <script src="jq/jquery.js"></script>
  <script>
$(document).ready(function() {
	
  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9()*&/.,\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		
		rules: {
				floorno: {required:true,number: true,},
			offno: {required:true,number: true ,remote: {
        url: "ajax/eoffaval.php",
        type: "post",
        data: { id: $('#id').val(),
		status: $('#status').val(),
          offno: function() {
            return $( "#offno" ).val();
          },
		
        }
      }
			},
			
		compname: {	required: true,loginRegex:true	},
			crno:{number:true},crval:{required:function(){return $("#crno").val() != ""}},			
			munlic:{number:true},munval:{required:function(){return $("#munlic").val() != ""}},
			comno:{number: true,},comval:{required:function(){return $("#comno").val() != ""}},
			sponsor: {required: true,	loginRegex:true		},
			sponsorid:{required:true,number: true,},
			conperson: {required: true,loginRegex:true},
			conqid:{required:true,number: true,},
		    conmob:{required:true,number: true,},
			contel:{number: true},
			rpm:{number: true},
			adamount:{number: true},
		    conemail:{required:true,email:true,},
			cpfrom:{required:true},
			cpuntill:{required:true},
			remarks:{loginRegex:true}
			
			
		},

		messages: {
			floorno: {required:"Enter Valid Floor No.",number:"Enter Valid Floor No."},
			offno: {required:"Enter Valid Office No. ",number:"Enter Valid office No.",remote: "Occupied."},
			compname: {required:"Enter Company Name" ,loginRegex:"Company Name Invalid"},
			crno:{number:"</br> Enter Valid CR No."},munlic:{number:"</br> Enter Valid Municipal No."},comno:{number:"</br> Enter Valid Computer No."},
			sponsor: {required: "Please Enter Sponsor Name",loginRegex:"Sponsor Name Invalid"},
			sponsorid: {required:"Enter Valid Sponsor QID.",number:"Enter Valid SponsorQID."},
			conperson:{required:"Enter Contact Name" ,loginRegex:"Contact Name Invalid"},
			conqid: {required:"Enter Valid Contact QID.",number:"Enter Valid ContactQID."},
			conmob: {required:"Enter Valid Contact Mobile.",number:"Enter Valid Conact Mobile."},
			conemail: {required:"Enter Valid Contact Email.",email:"Enter Valid Conact Email."},
	cpfrom: {required:"Select Date.--"},
	cpuntill: {required:"Select Date.--"}
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
 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:500px; width:1300px; margin-left:10px;  float:left "><div class="divheader" align="left">&nbsp;Tenant Details Summary </div><form id="signupForm" action="" method="post"><table align="left" border="0" width="1280px;" style="margin-left:10px; margin-top:15px;" >
<thead> <th align="left" colspan="3"  height="30px">&nbsp;&nbsp; Detail</th></thead>

   <?php echo $rs;?>
    <?php echo $rst;?>
 </table>
 </form></div>
 <!--this end detail of client-->
 
 
 </div>
<script>
//date picker
$(document).on('click', '#cdate', function() {  });
  $(function() {
    $( ".cdate" ).datepicker({
		dateFormat: 'dd-mm-yy',
		 changeMonth: true,
		 changeYear:true,
		 yearRange: '1900:2100:' + new Date().getFullYear()
		});
	
  });
  //contact date picker
   $(function() {
 $( ".cstart" ).datepicker({
 defaultDate: "+1w",
 	dateFormat: 'dd-mm-yy',
 changeMonth: true,
 changeYear:true,
 numberOfMonths: 1,
 onSelect: function( selectedDate ) {
 $( ".cend" ).datepicker( "option", "minDate", selectedDate );
 test();
 }
 });
 $( ".cend" ).datepicker({
 defaultDate: "+1w",
  dateFormat: 'dd-mm-yy',
 changeMonth: true,
 changeYear:true,
 numberOfMonths: 1,
 onSelect: function( selectedDate ) {
 $( ".cstart" ).datepicker( "option", "maxDate", selectedDate );
 }
 });
 });
 function test() {
 $( ".cstart" ).datepicker( "show" );
 }
</script>
 
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>