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
//add asset
if(isset ($_POST['aname'])){
	include "mysqli.php";
	$aname = mysqli_real_escape_string($db_conx, $_POST['aname']);
	$offno = mysqli_real_escape_string($db_conx, $_POST['offno']);
	$pdate = mysqli_real_escape_string($db_conx, $_POST['pdate']);
	$gdate = mysqli_real_escape_string($db_conx, $_POST['gdate']);
	$comment = mysqli_real_escape_string($db_conx, $_POST['comment']);
	$regby = mysqli_real_escape_string($db_conx, $_POST['regby']);


	
	$pdate=date("y-m-d", strtotime($pdate));
	$gdate=date("y-m-d", strtotime($gdate));

	
$sql = ("INSERT INTO asset (names,offno,pdate,gdate,comment,regby) 
       VALUES('$aname','$offno','$pdate','$gdate','$comment','$regby')") ;
	

	
	if (!mysqli_query($db_conx,$sql))
  {
  echo("Error description: " . mysqli_error($db_conx));
  }	
}
?>
<?php
//get list of asset
    include ("mysqli.php");
$rc='';
$sql ="SELECT * FROM  asset ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); // count the output amount
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
$id = $row['id'];
$names = $row['names'];
	$offno = $row['offno'];
	$pdate = date('d-m-Y', strtotime($row['pdate']));
	$gdate =date('d-m-Y', strtotime($row['gdate']));
	$comment = $row['comment'];
	$regby =$row['regby'];
	
		$rc .='
  <tr data-id='.$id.' class="nextt_btn" style=" cursor:pointer" >
    <td >'.$id.'</td>
	 <td >'.$names.'</td>
	<td >'.$offno.'</td>
	<td >'.$pdate.'</td>
	<td >'.$gdate.'</td>
	<td >'.$regby.'</td>
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
	tabs.find( ".ui-tabs-nav" )
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
  });
  //datepicker
   $(function() {
    $( ".sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true});
	
	
   });
  //validatation form
   $(document).ready(function() {
	 $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9,.()&\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		rules: {
			aname: {required:true,loginRegex:true},
			offno: {number: true },
			pdate: {required: true	},
			gdate: {required: true},
			comment:{loginRegex:true},
			},
		messages: {
			aname: {required:"Enter Asset Name",loginRegex:'Invalid Asset Name'},
			pdate: {required:"Please Select date" },
			gdate: {required:"Please Select date" },
	        },
	});

});
function SubmitIfValid()
{
    if(!$("#signupForm").valid()) return false;  
    return true;
}
 //on click cheque detail
	 $(document).ready(function(){
  $(".nextt_btn").on("click",function(e) {
  e.preventDefault(); // cancel the link
  var id = $(this).data('id');
window.location.href = "asdetail.php?id="+id+"&su=";
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
  <li ><a href="#middle12">Asset List</a></li>
  <li><a href="#middle1s">Add Asset </a></li>
    
    
  
  </ul>
  <div id="middle1s">
    <h2 style="color:#2E5E79">Add Asset</h2>
 <form  id="signupForm"  action="" method="post">
	<fieldset>
		<legend>Asset Form</legend>

		<p>
			<label for="an">Asset Name:</label>
			<input id="aname" name="aname"  />
		</p>
		<p>
			<label for="ofn">Office #:</label>
			<input id="offno" name="offno" type="text"  size="10px" />
            <p>
			<label for="pdate">Purchase Date:</label>
			<input id="pdate" name="pdate" class="sdate" type="text"  size="10px"  readonly="readonly"/>
		</p>
	
		<p>
			<label for="gdate">Guarantee/Warranty Expiry:</label>
			<input id="gdate" name="gdate" class="sdate" type="text" size="10px" readonly="readonly" />
		</p>

	

		<p>
			<label for="comment">Description:</label>
		<input id="comment" name="comment" type="text" />
		</p>
      
	
		<input type="hidden" name="regby" value='<?php echo $name; ?>' />
		<p>
			<input class="submit" type="submit" value="Submit"/>
		</p>
	</fieldset>
</form>
  </div>
  
  <div  id="middle12" class="middle12" >
  <h2 style="color:#2E5E79">Asset List</h2>
  <table id="table"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="25" height="5">ID<span>&nbsp;</span></th>
  <th width="70">Asset Name<span>&nbsp;</span></th>
  <th width="70">Office #<span>&nbsp;</span></th>
  <th width="50">Purchse<span>&nbsp;</span></th>
  <th width="50">G/W Date<span>&nbsp;</span></th>
  <th width="40">Reg by<span>&nbsp;</span></th>
  <th width="80">Comments<span>&nbsp;</span></th>
   
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