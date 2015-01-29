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
<?php //get cheque list
$rc='';
$ic='' ;
$sql ="SELECT * FROM  cheque where cri = 'Recieved' ";
$query = mysqli_query($db_conx, $sql);
$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
	$rc .='
  <tr  data-id='.$row['id'].' class="nextt_btn">
    <td >'.date('d-m-Y', strtotime($row['date'])).'</td>
	<td >'.$row['payee'].'</td>
	<td >'.$row['cnumber'].'</td>
	<td >'.date('d-m-Y', strtotime($row['cdate'])).'</td>
	<td >'.$row['amount'].'</td>
	<td id="cc">'.$row['status'].'</td>
		<td  >'.$row['note'].'</td>
			<td  >'.$row['ctid'].'</td>
			<td >'.$row['csid'].'</td>
  </tr>
 
' ;
}}
$sql ="SELECT * FROM  cheque where cri = 'Issued' ";
$query = mysqli_query($db_conx, $sql);
$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
	$ic .='
  <tr  data-id='.$row['id'].' class="nextt_btn">
    <td >'.date('d-m-Y', strtotime($row['date'])).'</td>
	<td >'.$row['payee'].'</td>
	<td >'.$row['cnumber'].'</td>
	<td >'.date('d-m-Y', strtotime($row['cdate'])).'</td>
	<td >'.$row['amount'].'</td>
	<td >'.$row['status'].'</td>
		<td >'.$row['note'].'</td>
			<td >'.$row['ctid'].'</td>
			<td >'.$row['csid'].'</td>
  </tr>
 
' ;
}}
?>
<?php //get receive due cheque list
$cr='';
$sql ="SELECT * FROM  cheque where cri = 'Recieved' and status in('Pending','on Hold') and cdate <= CURDATE() order by cdate desc ";
$query = mysqli_query($db_conx, $sql);
$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
$status=$row['status'];

	$cr .='
  <tr  data-id='.$row['id'].' class="nextt_btn">
   	<td >'.$row['payee'].'</td>
	 <td >'.$row['bank'].'</td>
	<td >'.$row['cnumber'].'</td>
	<td >'. date('d-m-Y', strtotime($row['cdate'])).'</td>
	<td >'.$row['amount'].'</td>
	<td >'.$status.'</td> 
		<td >'.$row['note'].'</td>
	  </tr>' ;
}}
?>
<?php //receive amount
$tamount='';
$sql ="SELECT sum(amount) FROM  cheque where cri = 'Recieved' and status in('Pending','on Hold') and cdate <= CURDATE() order by cdate desc ";
$query = mysqli_query($db_conx, $sql);
$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
	$ramount = number_format($row['sum(amount)'],2) ;
}}
?>
<?php //get issue due cheque list
$ci='';
$sqli ="SELECT * FROM  cheque where cri = 'Issued' and status in('Pending','on Hold') and cdate <= CURDATE() order by cdate desc ";
$queryi = mysqli_query($db_conx, $sqli);
$productCounti =  mysqli_num_rows($queryi); 
if ($productCounti > 0) {
while ($row = $queryi->fetch_assoc()) { 
	$ci .='
  <tr  data-id='.$row['id'].' class="nextt_btn">
   	<td >'.$row['payee'].'</td>
	 <td >'.$row['bank'].'</td>
	<td >'.$row['cnumber'].'</td>
	<td >'. date('d-m-Y', strtotime($row['cdate'])).'</td>
	<td >'.$row['amount'].'</td>
	<td >'.$row['status'].'</td>
		<td >'.$row['note'].'</td>
	  </tr>' ;
}}
?>
<?php //issue amount
$iamount='';
$sql ="SELECT sum(amount) FROM  cheque where cri = 'Issued' and status in('Pending','on Hold') and cdate <= CURDATE() order by cdate desc ";
$query = mysqli_query($db_conx, $sql);
$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
	$iamount = number_format($row['sum(amount)'],2) ;
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
  $(function() {
    var tabs= $( "#tabs" ).tabs({
      
    }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
	tabs.find( ".ui-tabs-nav" )
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
  });
	// validate signup form on keyup and submit
$().ready(function() {

$.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9()$&.\-\s]+$/i.test(value);
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
		},
		messages: {
			dates: {required:"Please Select date"},
			payee: {required:"Please Enter Name/Company"},
			cnumber:{required:"Enter Cheque Number",number:"Invaid Number"},
			cdate: {required:"Please Select date"},
			amount:{required:"Enter Amount"},
			bank: {required:"Please Enter Bank Name"},
		},
		
			submitHandler: function(form) {
				$('#loading').show();
                   $.ajax({
                        
                              type:"post",
                              url:"ajax/chequea.php",
                              data:$('#signupForm').serialize(),
                              dataType: 'json',
    success: function(response)
{
	
	 if(response.result=="success") {
		 $('#loading').hide();
		  y = response.results;
		  a=response.result2;
		 $('#res').html(y);
		 	 $('#res2').html(a);
		$('#signupForm')[0].reset();
			
$( "#dialog-message" ).dialog({
      modal: true,
     buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
		  location.reload();
        }
      }
     
    });        }
	else{
		
		}
		

	
},
error: function(response){
	alert("unsuccess") 	}
       

                    });
          }

	
		

	});


});
//date picker
   $(function() {
    $( ".sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true}).datepicker("setDate", new Date());;
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
	  $("#sid").keyup(function(){
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
	 //on click cheque detail
	 $(document).ready(function(){
  $(".nextt_btn").on("click",function(e) {
  e.preventDefault(); // cancel the link
  var id = $(this).data('id');
window.location.href = "cdetail.php?pid="+id+"&su=";
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

 .error{color:red}
  .nextt_btn{ cursor:pointer;}
  </style>
</head>
<body>   

<div id="wrap"  align="center" >
<?php include_once("header.php"); ?>
 <?php include_once("menu.php"); ?>
 <div id="middle" align="left" >
<div id="tabs" >
  <ul>

  <li><a href="#dashboard" >Dashboard</a></li>
  <li ><a href="#middle1s">Add  Cheque</a></li>
   <li ><a href="#rcheque">All Recieved Cheques</a></li>
    <li><a href="#icheque">All Issued Cheques</a></li>
   
  </ul>
  <div id="dashboard" class="middle12 scroll">
   <h5 style="color:#2E5E79;">&nbsp;&nbsp;&nbsp;Cheque Received due until Today</h5>
  <table  border="0" style="table-layout: fixed; width:1125px;">
 <thead>
  <tr>
  
  <th width="70">Name/Company</th>
    <th width="40">Bank</th>
  <th width="50">Cheque#</th>
  <th width="55">Cheque Date</th>
  <th width="50">Amount</th>
  <th width="20">Status</th>
  <th width="30">Note</th>

   
    </tr>
    </thead>
   
    <tbody>  <?php echo $cr; ?>
</tbody> <thead><th colspan="7" align="center">Total Amount:&nbsp; <?php echo $ramount; ?></th></thead>
</table>
  <h5 style="color:#2E5E79;">&nbsp;&nbsp;&nbsp;Cheque Issued due until Today</h5>
  <table   border="0" style="table-layout: fixed;width:1125px;">
 <thead>
  <tr>
  
  <th width="70">Name/Company</th>
    <th width="40">Bank</th>
  <th width="50">Cheque#</th>
  <th width="55">Cheque Date</th>
  <th width="50">Amount</th>
  <th width="20">Status</th>
  <th width="30">Note</th>

   
    </tr>
    </thead>
   
    <tbody>  <?php echo $ci; ?>
    
</tbody><thead><th colspan="7" align="center">Total Amount:&nbsp; <?php echo $iamount; ?></th></thead>
</table>
  </div>
  <div id="middle1s">
    <h2 style="color:#2E5E79">Add Cheque</h2>
 <form  id="signupForm" action="" method="post">
	<fieldset>
		<legend>Cheque Form</legend>
        	<p>
            
			<input align="left" name="rname"type="hidden" id="rname" size="5"  readonly="readonly" value="<?php echo $name; ?>"/>
            </p>
            <p>
			<label for="cri">Select</label>
			<select name="cri" id="cri">
            <option value="Recieved">Recieved</option>
            <option value="Issued">Issued</option>
            </select>
		</p>
        	<p>
			<label for="dates">Date</label>
			<input id="dates" class="sdate"name="dates" type="text" readonly="readonly" size="10"/>
		</p>
        <p><label for="tid">If any Tenant ID</label>
			<input id="tid" name="tid" type="text"  size="5" />
            <label for="sid">OR Service ID</label>
            <input id="sid" name="sid" type="text"  size="5" />
		</p>
        	<p>
			<label for="lastname">Name/Company</label>
			<input id="payee" name="payee" type="text" />
            </p>
	
		<p>
			<label for="lastname">Cheque#</label>
			<input id="cnumber" name="cnumber" type="text" />
            <label for="password">Cheque Date</label>
			<input id="cdate" class="sdate"name="cdate" type="text" readonly="readonly" size="10"/>
            </p>
	
		<p>
			<label for="amount">Amount</label>
			<input id="amount" name="amount" type="text" />
		</p>
<input name="status" value='Pending' type="hidden"  />
		<p>
			<label for="agree">Bank Name</label>
		<input id="bank" name="bank" type="text" />
		</p>
        <p>
			<label for="agree">Note</label>
		<input id="note" name="note" type="text" />
		</p>
	
		
		<p>
			<input class="submit csw" type="submit" value="Submit"/><span id='loading' style=' margin-left:25px; display:none'>Adding Cheque <img src='img/loading.gif'/></span>
		</p>
	</fieldset>
</form>
  </div>
     <script>
$(document).ready( function () {
    $('#table').DataTable();
} );
 
</script>
  <div id="rcheque" class="middle12">
  <h2 style="color:#2E5E79">Receive Cheques</h2>
  <table id="table"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="25" height="5">Date<span>&nbsp;</span></th>
  <th width="70">Name/Company<span>&nbsp;</span></th>
  <th width="50">Cheque#<span>&nbsp;</span></th>
  <th width="55">Cheque Date<span>&nbsp;</span></th>
  <th width="50">Amount<span>&nbsp;</span></th>
  <th width="20">Status<span>&nbsp;</span></th>
  <th width="30">Note<span>&nbsp;</span></th>
  <th width="20">TID<span>&nbsp;</span></th>
  <th width="20">SID<span>&nbsp;</span></th>
   
    </tr>
    </thead>
    <tbody> <?php echo $rc; ?>
</tbody></table>
 	</div>
       <script>
$(document).ready( function () {
    $('#table2').DataTable();
} );
 
</script>
  <div id="icheque" class="middle12"> 
  <h2 style="color:#2E5E79">Issued Cheques</h2>
  <table id="table2"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="25" height="5">Date<span>&nbsp;</span></th>
  <th width="70">Name/Company<span>&nbsp;</span></th>
  <th width="50">Cheque#<span>&nbsp;</span></th>
  <th width="55">Cheque Date<span>&nbsp;</span></th>
  <th width="50">Amount<span>&nbsp;</span></th>
  <th width="20">Status<span>&nbsp;</span></th>
  <th width="30">Note<span>&nbsp;</span></th>
  <th width="20">TID<span>&nbsp;</span></th>
  <th width="20">SID<span>&nbsp;</span></th>
   
    </tr>
    </thead>
    <tbody> <?php echo $ic; ?>
</tbody></table>
  </div>
</div>
<div id="dialog-message" title="Successfull" style="display:none;"><span id="res2" style="color:Red; font-size:18px;"></span>
<p style="color:#3f7227; background-color:#d9e4ac; padding:10px 5px">Cheque <strong><span id="res" style="color:Red; font-size:18px;"></span></strong> Was Added successfully!!!</p>

 
</div>

  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>