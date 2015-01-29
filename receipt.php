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
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and receipt=1 LIMIT 1 ";
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
//add receipt
if(isset ($_POST['recfrm'])){
	include "mysqli.php";
	$edate = mysqli_real_escape_string($db_conx, $_POST['rdate']);
	$tid = mysqli_real_escape_string($db_conx, $_POST['tid']);
	$sid = mysqli_real_escape_string($db_conx, $_POST['sid']);
	$recfrm = mysqli_real_escape_string($db_conx, $_POST['recfrm']);
	$amount = mysqli_real_escape_string($db_conx, $_POST['amount']);
	$pmethod = mysqli_real_escape_string($db_conx, $_POST['pmethod']);
	$fors = mysqli_real_escape_string($db_conx, $_POST['fors']);
	$regby = mysqli_real_escape_string($db_conx, $_POST['regby']);
	$cdate = mysqli_real_escape_string($db_conx, $_POST['cdate']);
	$bname = mysqli_real_escape_string($db_conx, $_POST['bname']);

	$edate=date("y-m-d", strtotime($edate));
	
	
$sqls = ("INSERT INTO receipt (date,tid,sid,recfrm,amount,pmethod,fors,regby,cdate,bname) 
                    VALUES('$edate','$tid','$sid','$recfrm','$amount','$pmethod','$fors','$regby','$cdate','$bname')") ;
					
 $querya = mysqli_query($db_conx, $sqls);
 
	$ia = mysqli_insert_id($db_conx);

	header("location: rdetail.php?id=$ia"); 
}


?>
<?php
//get list of asset
    include ("mysqli.php");
$rc='';
$sql ="SELECT * FROM  receipt ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); // count the output amount
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
$id = $row['id'];
$sdate = date('d-m-Y', strtotime($row['date']));
$tid = $row['tid'];
$sid = $row['sid'];
$recfrm =$row['recfrm'];
$amount = $row['amount'];
$pmethod =$row['pmethod'];
$fors = $row['fors'];
$regby =$row['regby'];
	
		$rc .='
  <tr data-id='.$id.' class="nextt_btn" style=" cursor:pointer" >
    <td >'.$id.'</td>
	 <td >'.$sdate.'</td>
	<td >'.$recfrm.'</td>
	<td >'.$amount.'</td>
	<td >'.$pmethod.'</td>
	<td >'.$fors.'</td>
    <td > '.$tid.'</td>
	<td >'.$sid.'</td>
    <td > '.$regby.'</td>
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
    $( ".sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true,}).datepicker("setDate", new Date());
	
	
   });
  //validatation form
   $(document).ready(function() {
	 $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9,.()&\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		rules: {
			recfrm: {required:true,loginRegex:true},
			amount: {required:true,number: true },
			pmethod: {required: true},
			fors: {required: true,loginRegex:true},
			
			},
		messages: {
			recfrm: {required:"Enter  Name",loginRegex:'Invalid  Name'},
			amount: {required:"Please Enter Amount",number:"Invalid Amount" },
			pmethod: {required:"Please Select Payment Method" },
			
	        },
	});

});
function SubmitIfValid()
{
    if(!$("#signupForm").valid()) return false;  
    return true;
}
 //on click recept detail
	 $(document).ready(function(){
  $(".nextt_btn").on("click",function(e) {
  e.preventDefault(); // cancel the link
  var id = $(this).data('id');
window.location.href = "rdetail.php?id="+id;
  });
  });
 
  //check for tenant
 $(document).ready(function(){
	  $("#tid").keyup(function(){
		  var status=$(this).val();
		   if(status != ''){
		 	      $.ajax({
                              type:"post",
                              url:"ajax/gt.php",
                              data:"status="+status,
							  datatype:"json",
				              success:function(data){ $("#recfrm").val(data);  
							  $('#recfrm').css( "background-color","#B3CBD6"  ) 
							 $('#recfrm').animate({backgroundColor: "#fff",}, 3000);
} 
	                      });                                 
		   }
		   else{
			   $("#recfrm").val("");
			   }
		  });
	 });
//check for service
 $(document).ready(function(){
	  $("#sid").keyup(function(){
		  var statuss=$(this).val();
		   if(statuss != ''){
		 	      $.ajax({
                              type:"post",
                              url:"ajax/gs.php",
                              data:"statuss="+statuss,
							  datatype:"json",
				              success:function(data){ $("#recfrm").val(data);
						 $('#recfrm').css("background-color", "#e5edc4"); 
							 $('#recfrm').animate({backgroundColor: "#fff",}, 3000);

 
		  
					   }
                                
	                                                       });
		   }
		   else {
			   $("#recfrm").val("");
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
    <li><a href="#middle1s">Add Receipt </a></li>
  <li ><a href="#middle12">Receipt List</a></li>
  </ul>
  <div id="middle1s">
    <h2 style="color:#2E5E79">Add Receipt</h2>
 <form  id="signupForm"  action="" method="post">
	<fieldset>
		<legend>Receipt Form</legend>

		<p>
			<label for="an">Date :</label>
			<input id="rdate" name="rdate"  class="sdate"size="10" readonly />
		</p>
		<p>
			<label for="ofn">If any Tenant ID</label>
			<input id="tid" name="tid" type="text"  size="3px" />
            <label for="ofn"> OR Service ID</label>
			<input id="sid" name="sid" type="text"  size="3px" />
            <p>
			<label for="pdate">Recieved From:</label>
			<input id="recfrm" name="recfrm"  type="text"  size="20px"  />
		</p>
	
		<p>
			<label for="gdate">Amount:</label>
			<input id="amount" name="amount"  type="text" size="15px" />
		</p>

	

		<p>
			<label for="comment">Cash/Cheque No:</label>
		       
      <input id="pmethod" name="pmethod"  type="text" size="25px" />
		</p>
      	<p>
			<label for="gdate">Cheque Dated:</label>
			<input id="cdate" name="cdate"  type="text" size="20px" />
		</p>
         	<p>
			<label for="gdate">Bank Name:</label>
			<input id="bname" name="bname"  type="text" size="20px" />
		</p>
     	<p>
			<label for="gdate">Paid For:</label>
			<input id="fors" name="fors"  type="text" size="25px" />
		</p>
		<input type="hidden" name="regby" value='<?php echo $name; ?>' />
		<p>
			<input class="submit" type="submit" value="Submit"/>
		</p>
	</fieldset>
</form>
  </div>
  
  <div  id="middle12" class="middle12" >
  <h2 style="color:#2E5E79">Receipt List</h2>
  <table id="table"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="30" height="5">Receipt#<span>&nbsp;</span></th>
  <th width="38">Date<span>&nbsp;</span></th>
  <th width="60">Recieved From<span>&nbsp;</span></th>
  <th width="50">Amount<span>&nbsp;</span></th>
  <th width="50">Pay Method<span>&nbsp;</span></th>
  <th width="40">Paid For <span>&nbsp;</span></th>
  <th width="15">TID<span>&nbsp;</span></th>
  <th width="15">SID<span>&nbsp;</span></th>
  <th width="40	">Reg By<span>&nbsp;</span></th>
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