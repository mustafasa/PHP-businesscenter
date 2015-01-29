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
//get upcoming Expense
include ("mysqli.php");
$rcd='';
$sqld ="SELECT * FROM  expense where duedate <= CURDATE() and duedate > '2010-01-01' and status='Activated'";
$queryd = mysqli_query($db_conx, $sqld);
$productCountd =  mysqli_num_rows($queryd); // count the output amount
if ($productCountd > 0) {
while ($row = $queryd->fetch_assoc()) { 
   $id=$row['id'];
	$date = date('d-m-Y', strtotime($row['date']));
	$ename = $row['ename'];
	$amount =$row['amount'];
	$desc =$row['desc'];
	$hby = $row['hby'];
	$status = $row['status'];
	$frename =$row['frename'];
	$duedate =date('d-m-Y', strtotime($row['duedate']));
    $rcd .='
<tr data-id='.$id.' class="nextt_btn" style=" cursor:pointer" >
    <td >'.$duedate.'</td>
	 <td >'.$ename.'</td>
	<td >'.$amount.'</td>
	<td >'.$status.'</td>
	<td >'.$desc.'</td>
	<td >'.$hby.'</td>
	<td > '.$frename.'</td>
  </tr>
' ;
}}
?>

<?php
//get expense list
include ("mysqli.php");
$rc='';
$sql ="SELECT * FROM  expense ";
$query = mysqli_query($db_conx, $sql);
$productCount =  mysqli_num_rows($query); // count the output amount
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
$id=$row['id'];
	$date = date('d-m-Y', strtotime($row['date']));
	$ename = $row['ename'];
	$amount =$row['amount'];
	$desc =$row['desc'];
	$hby = $row['hby'];
	$status = $row['status'];
	$frename =$row['frename'];
	$duedate =date('d-m-Y', strtotime($row['duedate']));
    $rc .='
<tr data-id='.$id.' class="nextt_btn" style=" cursor:pointer" >
    <td >'.$date.'</td>
	 <td >'.$ename.'</td>
	<td >'.$amount.'</td>
	<td >'.$status.'</td>
	<td > '.$duedate.'</td>
	<td >'.$desc.'</td>
	<td >'.$hby.'</td>
	<td > '.$frename.'</td>
  </tr>
' ;
}}
?>

<?php
//get Expense Transaction
include ("mysqli.php");
$rca='';
$sql ="SELECT * FROM  expensepaid ";
$query = mysqli_query($db_conx, $sql);
$productCount =  mysqli_num_rows($query); // count the output amount
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 

	$date = date('d-m-Y', strtotime($row['date']));
	$ename = $row['ename'];
	$amount =$row['amount'];
	$desc =$row['desc'];
	$hby = $row['hby'];
	$uby = $row['uby'];
	$bill = $row['bill'];
   $rca .='
<tr  >
    <td >'.$date.'</td>
    <td >'.$ename.'</td>
	<td >'.$amount.'</td>
	<td > '.$bill.'</td>
	<td >'.$desc.'</td>
	<td > '.$hby.'</td>
	<td > '.$uby.'</td>
	
  </tr>
 
' ;
}}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Business Center Solution</title>
<link rel="stylesheet" type="text/css" href="style/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" media="print" href="style/print.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" href="style/jquery-ui.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
  <script src="jq/jquery-1.11.1.js"></script>
  <script src="jq/jquery-ui.js"></script>
  <script src="jq/jquery.validate.js"></script>
  <script src="jq/jquery.js"></script>
   <script type="text/javascript" charset="utf8" src="jq/jquery.dataTables.js"></script>
   <link rel="stylesheet" type="text/css" href="style/jquery.dataTables.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
 <script>
 //tabs
  $(function() {
    var tabs= $( "#tabs" ).tabs({
      
    }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
	tabs.find( ".ui-tabs-nav" )
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
  });
  //Date Pciker
   $(function() {
    $( ".sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true}).datepicker("setDate", new Date());;
	
	
   });
   //Editable
   $(document).ready(function(){
  $(".nextt_btn").on("click",function(e) {
  e.preventDefault(); // cancel the link
  var id = $(this).data('id');
window.location.href = "exdetail.php?id="+id+"&su=";
	
  });
  });
	// validate signup form on keyup and submit
	$(document).ready(function() {
	
  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		
		rules: {
			ename: {required: true,loginRegex:true	},
			eamount:{required:true,number: true,},
			efr:{required:true},					
			hby: {loginRegex:true},
			edesc:{loginRegex:true},
			bill:{loginRegex:true}
	     		},

		messages: {
			ename: {required:"Enter Expense name" ,loginRegex:"Expense Name Invalid"},
			eamount: {required:"Enter Amount .",number:"Invalid Amount"},
			efr: {required:"Select Frequency"},
			hby: {loginRegex:"Handler Name Invalid Format"},
			edesc: {loginRegex:"Description Invalid Format"}
			
			},
				submitHandler: function(form) {
					$('#loading').show();
                   $.ajax({  type:"post",
                              url:"ajax/aexpense.php",
                              data:$('#signupForm').serialize(),
                              dataType: 'json',
    success: function(response)
{
 if(response.result=="success") {
	 $('#loading').hide();
		 y = response.results;
		 $('#res').html(y);
$( "#dialog-message" ).dialog({
      modal: true,
	    buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
		  location.reload();
        }
      }
    });        }

},
error: function(response){
	alert("unsuccess") 	}
  });
          }	});
});

$(function() {
	 $("#efr").change(function(){
	var s=$(this).val();
	if(s==0){
		$("#billl").css("display","inline")
		}
		else{
			$("#billl").css("display","none")
			}
});
	});
 </script>
 <style>
  .ui-tabs-vertical { width: 1318px; height:500px; }
  .ui-tabs-vertical .ui-tabs-nav { float: left; width: 12em; }
  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
  .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
  .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 80em; height:33.7em;}
  input[type=submit],
input[type=button]{
 width: 120px;
 padding: 5px;
 height: 25px;
 background-color: #2E5E79;
 border: none;
 border-radius: 4px;
 color: white;
 
 } 
  </style>
</head>
<body>   

<div id="wrap"  align="center" >
<?php include_once("header.php"); ?>
 <?php include_once("menu.php"); ?>
 <div id="middle" align="left" >
<div id="tabs" >
  <ul >
   <li ><a href="#dash">DashBoard</a></li>
  <li ><a href="#middle1s">Add Expense</a></li>
  <li><a href="#former">Expenses Lists</a></li>
  <li><a href="#exts">Expenses Transaction</a></li>
    
  
  </ul>
<div  id="dash" class="middle12" >
  <h2 style="color:#2E5E79">Expense To Be Clear</h2>
  <table id="table5"   border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="40" height="5">Due Date<span>&nbsp;</span></th>
    <th width="60" height="5">Expense Name<span>&nbsp;</span></th>
  <th  width="40">Amount<span>&nbsp;</span></th>
  <th width="30">Status<span>&nbsp;</span></th>
  <th width="50">Desciption<span>&nbsp;</span></th>
  <th width="52">Handling By<span>&nbsp;</span></th>
  <th width="32">Frequency<span>&nbsp;</span></th>
    </tr>
    </thead>
    <tbody>
<?php echo $rcd; ?></tbody></table>
  </div>
     <script>
$(document).ready( function () {
    $('#table5').DataTable();
} );
 
</script>
  <div id="middle1s">
    <form  id="signupForm"  action="" method="post">
	<fieldset>
		<legend>Expense Form</legend>
	<p>
    <span id="ss"></span>
			<label >Date</label>
			<input id="edate" class="sdate" readonly name="edate" size="10" />
		</p>
        	<p>
			<label for="sdate">Expense Name</label>
			<input id="ename" name="ename" type="text" size="20"  />
		</p>
		<p>
			<label for="sname">Amount</label>
			<input id="eamount" name="eamount" size="12" />
		</p>
		<p>
			<label for="sqid">Expense Frequency</label>
			<select id="efr" name="efr" >
              <option value="" selected="selected" disabled="disabled">Select</option>
            <option value="0">One Time</option>
             <option value="1">Monthly</option>
              <option value="3">Quarterly</option>
               <option value="6">Half Yearly</option>
                <option value="12">yearly</option>
            </select> <span  id="billl" style="display:none;"><label for="sqid">Bill No </label><input  name="bill" id="bill" size="12" /></span>
            <p>
			<label for="smob">Expense Description</label>
			<input id="edesc" name="edesc" type="text"  />
		</p>
          <p>
			<label for="smob">Handling by</label>
			<input id="hby" name="hby" type="text"  />
            <input id="adminame" name="adminame" value="<?php echo $name; ?>"type="hidden"  />
		</p>
   
	
		<p>
			<input class="submit" type="submit" value="Submit"/><span id='loading' style=' margin-left:25px; display:none'>Adding Expense <img src='img/loading.gif'/></span>
		</p>
	</fieldset>
</form>
  </div>
  
  <div  id="former" class="middle12" >
  <h2 style="color:#2E5E79">Expense List</h2>
  <table id="table"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="60" height="5">Register Date<span>&nbsp;</span></th>
    <th width="60" height="5">Expense Name<span>&nbsp;</span></th>
  <th  width="40">Amount<span>&nbsp;</span></th>
  <th width="30">Status<span>&nbsp;</span></th>
    <th width="50">Due Date<span>&nbsp;</span></th>
  <th width="50">Desciption<span>&nbsp;</span></th>
  <th width="52">Handling By<span>&nbsp;</span></th>
  <th width="32">Frequency<span>&nbsp;</span></th>
  
    </tr>
    </thead>
    <tbody>
<?php echo $rc; ?></tbody></table>
  </div>
   <script>
$(document).ready( function () {
    $('#table').DataTable();
} );
 
</script>
   <div  id="exts" class="middle12" >
  <h2 style="color:#2E5E79">Expense Paid</h2>
  <table id="table2"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="40" height="5">Payed Date<span>&nbsp;</span></th>
    <th width="60" height="5">Expense Name<span>&nbsp;</span></th>
  <th  width="40">Amount<span>&nbsp;</span></th>
  <th width="50">Bill #<span>&nbsp;</span></th>
  <th width="50">Desciption<span>&nbsp;</span></th>
  <th width="55">Handling By<span>&nbsp;</span></th>
  <th width="50">Registered By<span>&nbsp;</span></th>
    </tr>
    </thead>
    <tbody>
<?php echo $rca; ?></tbody></table>
  </div>
   <script>
$(document).ready( function () {
    $('#table2').DataTable();
} );
 
</script>
  

</div>
<?php include_once("footer.php"); ?>
<div id="dialog-message" title="Tenant Added Successfully" style="display:none;">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"> </span>
    Expense was Added Successfully!!!!!
  </p>
 
 
</div>
</body>
</html>