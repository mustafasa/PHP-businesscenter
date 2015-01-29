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
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and inquery=1 LIMIT 1 ";
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
//add inquiry
if(isset ($_POST['dc'])){
	include "mysqli.php";
	$dc = mysqli_real_escape_string($db_conx, $_POST['dc']);
	$comn = mysqli_real_escape_string($db_conx, $_POST['comn']);
	$cname = mysqli_real_escape_string($db_conx, $_POST['cname']);
	$smob = mysqli_real_escape_string($db_conx, $_POST['smob']);
	$email = mysqli_real_escape_string($db_conx, $_POST['email']);
	$rby = mysqli_real_escape_string($db_conx, $_POST['rby']);
	$comment = mysqli_real_escape_string($db_conx, $_POST['comment']);
	$regby = mysqli_real_escape_string($db_conx, $_POST['regby']);

	
	$dc=date("y-m-d", strtotime($dc));

	
	$sql = ("INSERT INTO inquiry (date, compn, cname,contact, email, rby, comment ,regby) 
       VALUES('$dc','$comn','$cname','$smob','$email','$rby','$comment','$regby')") ;
	
	$query = mysqli_query($db_conx, $sql);
echo "<script>alert('Inquiry was added successfully')</script>	";
}

	?>
    <?php
	//get Inquiry List
    include ("mysqli.php");
$rc='';
$sql ="SELECT * FROM  inquiry ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); // count the output amount
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
$dc = date('d-m-Y', strtotime($row['date']));
$comn = $row['compn'];
	$cname = $row['cname'];
	$smob = $row['contact'];
	$email =$row['email'];
	$rby = $row['rby'];
	$comment = $row['comment'];
	$regby =$row['regby'];
	
		$rc .='
  <tr >
    <td >'.$dc.'</td>
	 <td >'.$comn.'</td>
	<td >'.$cname.'</td>
	<td >'.$smob.'</td>
	<td >'.$email.'</td>
	<td >'.$rby.'</td>
    <td > '.$comment.'</td>
   

  </tr>
 
' ;}}
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
 //for tabs
  $(function() {
    var tabs= $( "#tabs" ).tabs({
      
    }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
	tabs.find( ".ui-tabs-nav" ).sortable({
      axis: "y",
	
      stop: function() {
        tabs.tabs( "refresh" );
      }
    });
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
  });
  //datepicker
   $(function() {
    $( ".sdate" ).datepicker({dateFormat: 'dd-mm-yy'}).datepicker("setDate", new Date());
	
	
   });
   //validatation form
   $(document).ready(function() {
	 $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9,.()&\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		
		rules: {
			dc: {required:true},
			smob: {number: true },
			comn: {	required: true,loginRegex:true	},
			cname: {loginRegex:true},
			  email:{email: true,},		
			rby:{loginRegex:true	},
			comment:{loginRegex:true},
			
		},

		messages: {
			dc: {required:"Select Date"},
			comn: {required:"Enter Company Name" ,loginRegex:"Company Name Invalid"},
			cname:{loginRegex:"Contact Name Invalid"},
			smob:{number:"Contact Number Invalid"},
		},
			

		
	});


});
function SubmitIfValid()
{
    if(!$("#signupForm").valid()) return false;  
    return true;
}
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
 height: 35px;
 background-color: #2E5E79;
 border: none;
 border-radius: 4px;
 color: white;
 
 }
 .error{color:red}
  
  </style>
</head>
<body>   

<div id="wrap"  align="center" >
<?php include_once("header.php"); ?>
 <?php include_once("menu.php"); ?>
 <div id="middle" align="left" >
<div id="tabs" >
  <ul >
  <li><a href="#middle1s">Add Enquiry </a></li>
    <li ><a href="#middle12">Enquiry List</a></li>
    
  
  </ul>
  <div id="middle1s">
    <h2 style="color:#2E5E79">Add Enquiry</h2>
 <form  id="signupForm"  action="" method="post">
	<fieldset>
		<legend>Enquiry Form</legend>
<p>
			<label for="dc">Date:</label>
			<input id="dc" class="sdate" name="dc" size="10" readonly="readonly" />
		</p>
		<p>
			<label for="comn">Company Name:</label>
			<input id="comn" name="comn" />
		</p>
		<p>
			<label for="cname">Client Name:</label>
			<input id="cname" name="cname" type="text" />
            <p>
			<label for="smob">Contact#</label>
			<input id="smob" name="smob" type="text"  />
		</p>
	
		<p>
			<label for="email">Email Address:</label>
			<input id="email" name="email" type="text"  />
		</p>
	<p>
			<label for="rby">Referred by</label>
			<input id="rby" name="rby" type="text"  />
		</p>
	

		<p>
			<label for="comment">Comments:</label>
		<input id="comment" name="comment" type="text" />
		</p>
      
	
		<input type="hidden" name="regby" value='<?php echo $name; ?>' />
		<p>
			<input class="submit" type="submit" value="Submit" onclick="return SubmitIfValid();"/>
		</p>
	</fieldset>
</form>
  </div>
  
  <div  id="middle12" class="middle12" >
  <h2 style="color:#2E5E79">Enquiry List</h2>
  <table id="table"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="30" height="5">Date<span>&nbsp;</span></th>
  <th width="70">Company Name<span>&nbsp;</span></th>
  <th width="70">Client Name<span>&nbsp;</span></th>
  <th width="50">Contact#<span>&nbsp;</span></th>
  <th width="50">Email<span>&nbsp;</span></th>
  <th width="70">Referred by<span>&nbsp;</span></th>
  <th width="50">Comments<span>&nbsp;</span></th>
   
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

</div>

  
<?php include_once("footer.php"); ?>
</div>

</body>
</html>