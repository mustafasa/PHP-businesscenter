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
//service list
$addact="";
include ("mysqli.php");
$rc='';
$sql ="SELECT * FROM  prclient ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); // count the output amount
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
$tid = $row['tid'];
$id = $row['id'];
	$names = $row['name'];
	$qid = $row['qid'];
	$contact =$row['contact'];
	$date = date('d-m-Y', strtotime($row['date']));
	$services = $row['service'];
	$amount =$row['amount'];
	$status = $row['status'];
	
	$rc .='
  <tr  data-id='.$id.' class="next_btn" style="cursor:pointer">
    <td >'.$id.'</td>
	 <td >'.$tid.'</td>
	<td >'.$names.'</td>
	<td >'.$qid.'</td>
	<td >'.$contact.'</td>
	<td >'.$date.'</td>
    <td > '.$services.'</td>
   <td>'.$amount.'</td>
   <td>'.$status.'</td>
  </tr>
 
' ;
}}

?>
<?php
//pro act
include ("mysqli.php");

$sql ="SELECT * FROM  proact ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); // count the output amount
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 
    $date = date('d-m-Y', strtotime($row['date']));
    $prname = $row['prname'];
	$tleav =date('H:i', strtotime($row['tleav'])); 
	$tret = date('H:i', strtotime($row['tret'])); 
	$prodesc =$row['prodesc'];
	

	
	$addact .='
  <tr  >
    <td >'.$date.'</td>
	 <td >'.$prname.'</td>
	<td >'.$tleav.'</td>
	<td >'.$tret.'</td>
	<td >'.$prodesc.'</td>
	
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
<link rel="stylesheet" type="text/css" href="jq/timepicker/dist/jquery-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="jq/timepicker/assets/css/github.min.css">
  <script src="jq/jquery-1.11.1.js"></script>
  <script src="jq/jquery-ui.js"></script>
  <script src="jq/jquery.validate.js"></script>
  <script src="jq/timepicker/src/clockpicker.js"></script>
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
    $( "#sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true}).datepicker("setDate", new Date());;
	
	
   });
//Editable
 $(document).ready(function(){
  $(".next_btn").on("click",function(e) {
  e.preventDefault(); // cancel the link
  var id = $(this).data('id');
window.location.href = "sdetail.php?pid="+id+"&su=";
	
  });
  });
// validate signup form on keyup and submit
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
				submitHandler: function(form) {
					$('#loading').show();
                   $.ajax({
                        
                              type:"post",
                              url:"ajax/aservice.php",
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
		else if(response.result=="other") {
		
        }
  	else if (response.result) {

        }
		
	
	
	
},
error: function(response){
	alert("unsuccess") 	}
       

                    });
          }

		
	});


});
// validate proadd signup form on keyup and submit
$(document).ready(function() {
	
  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#addproact").validate({
		
		rules: {
			prodate: {	required: true,	},
			prname:{required:true,loginRegex: true,},
			tleav:{required:true},
			tret:{required:true},						
			
	     		},

		messages: {
			sname: {required:"Select Date" },
			prname: {required:"Enter PRO Name",loginRegex:"Enter Valid Name"},
			tleav: {required:"Select Time of Leaving"},
			tret: {required:"Select Time of Returning" },
			},
				submitHandler: function(form) {
					$('#pract').show();
                   $.ajax({
                        
                              type:"post",
                              url:"ajax/adpract.php",
                              data:$('#addproact').serialize(),
                              dataType: 'json',
    success: function(response)
{
	
	 if(response.result=="success") {
		 $('#pract').hide();
$( "#adddialog-message" ).dialog({
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
          }
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
//pro date
$(function() {
    $( ".prodate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true}).datepicker("setDate", new Date());;
	
	
   });
   //time

 </script>
 <style>
  .ui-tabs-vertical { width: 1318px; height:500px; }
  .ui-tabs-vertical .ui-tabs-nav { float: left; width: 12em; }
  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
  .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
  .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 80em; height:33.7em;}
  .submit{
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
   <li> <form action="sdetail.php" method="get">
    <input name="pid" placeholder="SID" size="5" /><input name="su" type="hidden"/><input style=" width: 120px;	
 height: 24px;
 width:45px;
 background-color: #2E5E79;
 border: none;
 border-radius: 4px;
 color: white;
"   type="submit" value="Go"  />
      </form></li>
  <li><a href="#former">Service List </a></li>
   <li><a href="#prolist">PRO Activities</a></li> 
    <li ><a href="#middle1s">Add Service</a></li>
       <li><a href="#addact">Add PRO Activity</a></li>
   
   
  
  </ul>
    <!-- proactivity list-->
  <div  id="prolist" class="middle12" >
  <h2 style="color:#2E5E79">Service List</h2>
  <table id="actable"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th  width="30">Date<span>&nbsp;</span></th>
  <th width="60">PRO Name<span>&nbsp;</span></th>
  <th width="50">Left on<span>&nbsp;</span></th>
  <th width="50">Return on<span>&nbsp;</span></th>
  <th width="100">Description<span>&nbsp;</span></th>

    </tr>
    </thead>
    <tbody>
<?php echo $addact; ?></tbody></table>
  </div>
   <script>
$(document).ready( function () {
    $('#actable').DataTable();
} );
 
</script>
  <!--Add service-->
  <div id="middle1s">
    <form  id="signupForm"  action="" method="post">
	<fieldset>
		<legend>Registration Form</legend>
	<p>
    <span id="ss"></span>
			<label for="ten">Tenant ID.If any</label>
			<input id="tnid" name="tnid" size="5" />
		</p>
        	<p>
			<label for="sdate">Date</label>
			<input id="sdate" name="sdate" type="text" size="10" readonly="readonly" />
		</p>
		<p>
			<label for="sname">Name/Company</label>
			<input id="sname" name="sname" />
		</p>
		<p>
			<label for="sqid">QID#</label>
			<input id="sqid" name="sqid" type="text" />
            <p>
			<label for="smob">Contact#</label>
			<input id="smob" name="smob" type="text"  />
		</p>
          <p>
			<label for="smob">Handling by</label>
			<input id="hby" name="hby" type="text"  />
		</p>
	
	
		<p>

		<label for="stype">Service Type</label>
			 <select name="stype" id="stype" >
            
<option value="Computer Card">Computer Card</option>
<option value="Civil Defence approval">Civil Defence approval</option>
<option value="Company Registration(CR)">Company Registration(CR)</option>
 <option value="Fingerprint">Fingerprint</option>
<option value="Medical">Medical</option>
<option value="Municipal Licence">Municipal Licence</option>
<option value="Visas">Visas</option>
</select>
		</p>
	

		<p>
			<label for="samount">Charges:</label>
		<input id="samount" name="samount" type="text" />
		</p>
   
	
		
		<p>
			<input class="submit" type="submit" value="Submit"/><span id='loading' style=' margin-left:25px; display:none'>Adding Services <img src='img/loading.gif'/></span>
		</p>
	</fieldset>
</form>
  </div>
  <!-- service list-->
  <div  id="former" class="middle12" >
  <h2 style="color:#2E5E79">Service List</h2>
  <table id="table"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="25" height="5">ID#<span>&nbsp;</span></th>
    <th width="25" height="5">TID#<span>&nbsp;</span></th>
  <th  width="50">Name<span>&nbsp;</span></th>
  <th width="50">QID#<span>&nbsp;</span></th>
  <th width="50">Contact#<span>&nbsp;</span></th>
  <th width="50">Date<span>&nbsp;</span></th>
  <th width="70">Service Type<span>&nbsp;</span></th>
  <th width="50">Amount<span>&nbsp;</span></th>
   <th width="50">Status<span>&nbsp;</span></th>
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
<!--Add PRo activity-->
   <div id="addact">
    <form  id="addproact"  action="" method="post">
	<fieldset>
		<legend>ADD PRO Activity</legend>
        <p>
			<label for="sname">Date</label>
			<input id="prodate" name="prodate" class="prodate" size="10" />
		</p>
	<p>
  
			<label for="ten">PRO Name:</label>
			<input id="prname" name="prname" size="20" />
		</p>
        	<p>


<div class="container">
    			<label for="sdate">Time Of leaving:</label>
			<input id="tleav" name="tleav" class="form-control"type="text" size="5" readonly="readonly"  />
          </div>
          </p>  
	

		<p>
        <div class="container">
			<label for="sname">Time of Returning:</label>
			<input id="tret" name="tret" size="5" readonly="readonly" />
             </div>
		</p>
		
  		<p>
			<label for="sname" style="vertical-align:top;">Description:</label>
			<textarea id="prodesc" name="prodesc" style="width: 600px;"></textarea>
		</p>
   
	
		
		<p>
			<input class="submit" type="submit" value="Submit"/><span id='pract' style=' margin-left:25px; display:none'>Adding PRO Activity <img src='img/loading.gif'/></span>
		</p>
	</fieldset>
</form>
  </div>
<script>
$(function(){
var input = $('#tleav');
input.clockpicker({
    autoclose: true,
});
});
$(function(){
var input = $('#tret');
input.clockpicker({
    autoclose: true,
	default: 'now'
});

});
</script>

  

</div>
<?php include_once("footer.php"); ?>

<div id="dialog-message" title="Service Added Successfully" style="display:none;">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"> SuccessFull</span>
     Service ID <strong><span id="res" style="color:Red; font-size:18px;"></span></strong> .For Further Reference 
  </p>
 
 
</div>
<div id="adddialog-message" title="Activity Added Successfully" style="display:none;">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"> </span>
    SuccessFully Added PRO Activity
  </p>
</div>

</body>
</html>