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

<?php //former list
include ("mysqli.php");
$rc='';
$sql ="SELECT * FROM  tenant where status = 'UnOccupied' ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 

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
	
	$rc .='
  <tr  data-id='.$id.' class="nextt_btn" style=" cursor:pointer">
    <td >'.$id.'</td>
	<td >'.$floorno.'</td>
	<td >'.$offno.'</td>
	<td >'.$compname.'</td>
	<td >'.$conperson.'</td>
	<td >'.$conmob.'</td>
		<td >'.$cpfrom.'</td>
			<td >'.$cpuntill.'</td>

  </tr>
 
' ;
}}
else {
	$rc='';
	}
?>

<?php //current list
include ("mysqli.php");
$rcc='';
$sql ="SELECT * FROM  tenant where status = 'Occupied' ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 

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
	
	$rcc .='
  <tr  data-id='.$id.' class="nextt_btn" style=" cursor:pointer">
    <td >'.$id.'</td>
	<td >'.$floorno.'</td>
	<td >'.$offno.'</td>
	<td >'.$compname.'</td>
	<td >'.$conperson.'</td>
	<td >'.$conmob.'</td>
		<td >'.$cpfrom.'</td>
			<td >'.$cpuntill.'</td>

  </tr>
 
' ;
}}
else {
	$rcc='';
	}
?>

<?php //list of tenant are ending dashboard 
include ("mysqli.php");
$rcdas='';
$sql ="SELECT * FROM  tenant where status = 'Occupied' and cpuntil <= CURDATE() ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 

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
	
	$rcdas .='
  <tr  data-id='.$id.' class="nextt_btn" style=" cursor:pointer">
    <td >'.$id.'</td>
	<td >'.$floorno.'</td>
	<td >'.$offno.'</td>
	<td >'.$compname.'</td>
	<td >'.$conperson.'</td>
	<td >'.$conmob.'</td>
		<td >'.$cpfrom.'</td>
			<td >'.$cpuntill.'</td>

  </tr>
 
' ;
}}
else {
	$rcdas='';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="background-color:none"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Business Center Solution</title>
<link rel="stylesheet" type="text/css" href="style/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" media="print" href="style/print.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" href="style/jquery-ui.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
<link rel="stylesheet" type="text/css" href="style/addt.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
  <script src="jq/jquery-1.11.1.js"></script>
  <script src="jq/jquery-ui.js"></script>
  <script src="jq/jquery.validate.js"></script>
  <script src="jq/jquery.js"></script>
   <script type="text/javascript" charset="utf8" src="jq/jquery.dataTables.js"></script>
   <link rel="stylesheet" type="text/css" href="style/jquery.dataTables.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
 <script>
 //for adding animation
   $(document).ready(function(){

$(".next_btn").click(function(){
	var form = $("#signupForm");
	if (form.valid() == true){ //Function runs on NEXT button click
$(this).parent().next().fadeIn('slow');
$(this).parent().css({'display':'none'});
//Adding class active to show steps forward;
$('.active').next().addClass('active');	
		}
});

 
$(".pre_btn").click(function(){ //Function runs on PREVIOUS button click
$(this).parent().prev().fadeIn('slow');
$(this).parent().css({'display':'none'});
//Removing class active to show steps backward;
$('.active:last').removeClass('active');
});
});
//current datepicker
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
 //former datepicker
 $(function() {
 $( ".fstart" ).datepicker({
 defaultDate: "+1w",
 	dateFormat: 'dd-mm-yy',
 changeMonth: true,
 changeYear:true,
 numberOfMonths: 1,
 onSelect: function( selectedDate ) {
 $( ".fend" ).datepicker( "option", "minDate", selectedDate );
 test();
 }
 });
 $( ".fend" ).datepicker({
 defaultDate: "+1w",
  dateFormat: 'dd-mm-yy',
 changeMonth: true,
 changeYear:true,
 numberOfMonths: 1,
 onSelect: function( selectedDate ) {
 $( ".fstart" ).datepicker( "option", "maxDate", selectedDate );
 }
 });
 });
 function test() {
 $( ".fstart" ).datepicker( "show" );
 }
 //tabs function
  $(function() {
    var tabs= $( "#tabs" ).tabs({
      
    }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
	tabs.find( ".ui-tabs-nav" )
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
  });
  //datepicker
   $(function() {
    $( ".date" ).datepicker({dateFormat: 'dd-mm-yy',changeYear:true,changeMonth:true});
	
   }); 
//on click tenant full information   
$(document).ready(function(){
  $(".nextt_btn").on("click",function(e) {
  e.preventDefault(); // cancel the link
  var id = $(this).data('id');
window.location.href = "tdetail.php?pid="+id+"&su=";
	
  });
  });  			
//validation current
$(document).ready(function() {
	
  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		
		rules: {
			floorno: {required:true,number: true,},
			offno: {required:true,number: true ,remote:"ajax/offaval.php"},
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
				submitHandler: function(form) {
					$('#loading').show();
                   $.ajax({
                        
                              type:"post",
                              url:"ajax/tenant.php",
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
		  window.location.href = "tdetail.php?pid="+y+"&su=";
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
//validation former
$(document).ready(function() {
	
  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9,.()&\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#formeradd").validate({
		
		rules: {
			floorno: {required:true,number: true,},
			offno: {required:true,number: true },
			compname: {	required: true,loginRegex:true	},
			conperson: {required: true,loginRegex:true},
			  conmob:{required:true,number: true,},		
		conemail:{required:true,email:true,},
			cpfrom:{required:true},
			cpuntill:{required:true},
			remarks:{	loginRegex:true	},
		},

		messages: {
			floorno: {required:"Enter Valid Floor No.",number:"Enter Valid Floor No."},
			offno: {required:"<br>Enter Valid Office No. ",number:"Enter Valid office No.",remote: "Occupied."},
			compname: {required:"Enter Company Name" ,loginRegex:"Company Name Invalid"},
			conperson:{required:"Enter Contact Name" ,loginRegex:"Contact Name Invalid"},
			conmob: {required:"Enter Valid Contact Mobile.",number:"Enter Valid Conact Mobile."},
			conemail: {required:"Enter Valid Contact Email.",email:"Enter Valid Conact Email."},
	cpfrom: {required:"<br>Select Contract Date from.--"},
	cpuntill: {required:"<br>Select Contract Date to.--"}
		},
				submitHandler: function(form) {
					$('#loadings').show();
                   $.ajax({
                        
                              type:"post",
                              url:"ajax/tenant.php",
                              data:$('#formeradd').serialize(),
                              dataType: 'json',
    success: function(response)
{
	
	 if(response.result=="success") {
		 $('#loadings').hide();
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
//date
$(function() {
    $( ".cdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true,changeYear:true});

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
  
  </style>
</head>
<body>   
  <div id="dialog-message" title="Tenant Added Successfully" style="display:none;">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"> SucessFull</span>
     Tennat ID <strong><span id="res" style="color:Red; font-size:18px;"></span></strong> .For Further Reference 
  </p>
 
 
</div>
<div id="wrap"  align="center" >
<?php include_once("header.php"); ?>
 <?php include_once("menu.php"); ?>
 <div id="middle" align="left" >
 
<div id="tabs" >
  <ul >
  
  <li> <form action="tdetail.php" method="get">
    <input name="pid" placeholder="TID" size="5" /><input name="su" type="hidden"/><input style=" width: 120px;	
 height: 24px;
 width:45px;
 background-color: #2E5E79;
 border: none;
 border-radius: 4px;
 color: white;
"   type="submit" value="Go"  />
      </form></li>
      <li><a href="#dash">DashBoard</a></li>
    <li ><a href="#atenant">Add Tenant</a></li>
  <li><a href="#aftenant">Add Former Tenant</a></li>
        <li><a href="#current">Current Tenants List</a></li>
    <li><a href="#former">Former Tenants List</a></li>
    
  </ul>
         <script>
$(document).ready( function () {
    $('#table4').DataTable();
} );
 
</script>
 <div id="dash" class="middle12"> 
  <h2 style="color:#2E5E79">Tenant Contract Expired  </h2>
  <table id="table4"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="15" height="5">ID#<span>&nbsp;</span></th>
  <th width="50">Floor#<span>&nbsp;</span></th>
  <th width="50">Office#<span>&nbsp;</span></th>
  <th width="50">Company <span>&nbsp;</span></th>
  <th width="50">Contact<span>&nbsp;</span></th>
  <th width="50">Mobile#<span>&nbsp;</span></th>
  <th width="60">Contract Start<span>&nbsp;</span></th>
  <th width="60">Contract End<span>&nbsp;</span></th>
   
    </tr>
    </thead>
    <tbody>
<?php echo $rcdas; ?></tbody></table>
 	</div>
  
  <div id="atenant">
  
    <form  id="signupForm" method="post" action="">
    <!-- progressbar -->
    <ul id="progressbar" >
    <li class="active">Company Info</li>
    <li >Contact Info</li>
    <li>Agreement Info</li>
    
    </ul>
    <input type="hidden" value="Occupied" name="status" />
     
    <!-- fieldsets -->
    <fieldset id="first">
        <h2 class="title" align="center">Company Info</h2>
            <table width="906" height="250px	"border="0" align="center" id="tabl">
      <tr>
        <td width="150"  align="right">Registered by:</td>
        <td width="279"  ><input align="left" name="rname"type="text" id="rname" size="5"  readonly="readonly" value="<?php echo $name; ?>"/></td>
        <td width="111" align="right">Floor No:</td>
        <td width="348"><input name="floorno"type="text" id="floorno" size="3" /></td>
        
      </tr>
        
        
        <tr>
         <td align="right">Office No:</td>
        <td><input name="offno"type="text" id="offno" size="8" /></td>
        <td align="right">Company Name:</td>
        <td><input name="compname"type="text" id="compname" size="20" /></td> 
        
       
        </tr>
    
         <tr>
        <td  align="right" >Commercial Reg #:</td>
        <td><input name="crno"type="text" id="crno" size="20" /></td>
         <td  align="right">Validy:</td>
         <td><input name="crval"type="text" class="cdate" id="crval" readonly="readonly" size="12" /></td>
          </tr>
          
         <tr>
         <td  align="right">Municipal License #:</td>
        <td><input name="munlic"type="text" id="munlic" size="25" /></td>
        <td  align="right">Validy:</td>
        <td><input name="munval"type="text" class="cdate" id="munval" size="12" readonly="readonly"  /></td>
        </tr>
      <input name="remarks"type="hidden"  size="25" />
      <tr>
        <td  align="right" >Computer Card#:</td>
        <td><input name="comno"type="text" id="comno" size="20"  /></td>
        <td  align="right" >Validy:</td>
        <td><input name="comval"type="text"  class="cdate" id="comval" size="12" readonly="readonly" /></td>
         
      </tr>
     
        </table>

            
   <input type="button" name="next" class="next_btn cs" value="Next" style="margin-left:380px;" />

   
        </fieldset>
        
    <fieldset>
    
    <h2 class="title" align="center">Contact Info</h2>
            <table width="877" height="250px	"border="0" align="center" id="tabl">
             <tr>
        <td width="132"  align="right">Sponsor Name:</td>
        <td width="151"  ><input align="left" name="sponsor"type="text" id="sponsor" size="25	" /></td>
        <td width="448"  align="right">Sponsor QID:</td>
        <td width="147"><input name="sponsorid"type="text" id="sponsorid" size="25" /></td>
          </tr>
      <tr>
        <td width="132"  align="right">Contact Person:</td>
        <td width="151"  ><input align="left" name="conperson"type="text" id="conperson" size="25	" /></td>
        <td width="448"  align="right">Contact QID:</td>
        <td width="147"><input name="conqid"type="text" id="conqid" size="25" /></td>
          </tr>
          
            <tr>
        <td  align="right">Contact Mobile#:</td>
        <td   ><input align="left" name="conmob"type="text" id="conmob" size="25	" /></td>
        <td   align="right">Contact Email:</td>
        <td ><input name="conemail"type="text" id="conemail" size="25" /></td>
          </tr>
                  <tr>
        <td  align="right">Contact Telephone#:</td>
        <td   ><input align="left" name="contel"type="text" id="contel" size="25	" /></td>
        </tr>
             
    
      </table>

   <input  type="button" name="previous" class="pre_btn cs" value="Previous" style="margin-left:320px;" />
    <input type="button" name="next" class="next_btn cs" value="Next" />
     
    </fieldset>
    <fieldset>
    <h2 class="title" align="center">Agreement Info</h2>
    <table width="904" height="143"border="0" align="center" id="tabl">
      <tr>
         <td width="152"   align="right" >Contract Period From:</td>
        <td width="265"><input class="cstart" name="cpfrom"type="text" id="cpfrom" size="12" readonly="readonly" /></td>
      <td width="151" align="right">Contract Period To :   </td>
       <td width="318"><input class="cend" name="cpuntill"type="text" id="cpuntill" size="12" readonly="readonly" /></td>
        </tr>
            <tr>
        
        <td  align="right" >Rent per Month:      </td>
        <td ><input  name="rpm"type="text" id="rpm" size="15" /></td>
       
          <td align="right" >Deposit/Advance :</td>
      <td ><input  name="adamount"type="text" id="adamount" size="12" /></td> 
       
        </tr>
        
         
        </table>
        
        <input type="button" class="pre_btn cs" value="Previous" style="margin-left:310px; margin-top:90px;" />
     <input type="submit" class="submit_btn cs" value="Submit" /><span id='loading' style=' margin-left:25px; display:none'>Adding Tenant <img src='img/loading.gif'/></span>
    
   
    </fieldset>

</form>
   
  </div>
  
  <div id="aftenant" >
  <h2 style="color:#2E5E79">Add Former Tenant</h2>
 <form  id="formeradd" method="post" action="">
<input  name="adamount"type="hidden" size="12" />
<input  name="rpm"type="hidden" size="15" />
<input align="left" name="contel"type="hidden" size="25	" />
<input name="conqid"type="hidden" size="25" />
<input name="sponsorid"type="hidden" size="25" />
<input align="left" name="sponsor"type="hidden" size="25	" />
<input name="comno"type="hidden" size="20" />
<input name="comval"type="hidden" size="12" />
<input name="munlic"type="hidden" size="25" />
<input name="munval"type="hidden" size="12"  />
<input name="crno"type="hidden" size="20" />
 <input name="crval"type="hidden" size="12" />


        <input type="hidden" value="UnOccupied" name="status" />
	 <table width="906" height="350px	"border="0" align="center" id="tabl">
      <tr>
        <td width="165"  align="right">Registered by:</td>
        <td width="154"  ><input align="left" name="rname"type="text" id="rnames" size="5"  readonly="readonly" value="<?php echo $name; ?>"/></td>
        <td width="419" align="right">Floor No:</td>
        <td width="150"><input name="floorno"type="text" id="floornos" size="3" /></td>
        
      </tr>
        
        
        <tr>
         <td align="right">Office No:</td>
        <td><input name="offno"type="text" id="offnos" size="8" /></td>
        <td align="right">Company Name:</td>
        <td><input name="compname"type="text" id="compnames" size="20" /></td> 
        
       
        </tr>
    
        <tr>
        <td width="165"  align="right">Contact Person:</td>
        <td width="154"  ><input align="left" name="conperson"type="text" id="conpersons" size="25	" /></td>
       <td  align="right">Remarks:</td>
        <td><input name="remarks"type="text" id="remarks" size="25" /></td>
          </tr>
          
            <tr>
        <td  align="right">Contact Mobile#:</td>
        <td   ><input align="left" name="conmob"type="text" id="conmobs" size="25	" /></td>
        <td   align="right">Contact Email:</td>
        <td ><input name="conemail"type="text" id="conemails" size="25" /></td>
          </tr>
      
   <tr>
         <td width="165"   align="right" >Contract Period From:</td>
        <td width="154"><input class="cstart" name="cpfrom"type="text" id="cpfroms" readonly="readonly" size="12" /></td>
      <td width="419" align="right">Contract Period To :</td>
       <td width="150"><input class="cend" name="cpuntill"type="text" readonly="readonly" id="cpuntills" size="12" /></td>
        </tr>
         <tr>
         
        <td colspan="4" align="center"><input class="cs" type="submit" value="Submit"/><span id='loadings' style=' margin-left:25px; display:none'>Adding Tenant <img src='img/loading.gif'/></span></td>
        </tr>
     
        </table>
	
</form>
  </div>
   <script>
$(document).ready( function () {
    $('#table').DataTable();
} );
 
</script>
  <div id="former" class="middle12"> 
  <h2 style="color:#2E5E79">Former Tenants</h2>
  <table id="table"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="15" height="5">ID#<span>&nbsp;</span></th>
  <th width="50">Floor#<span>&nbsp;</span></th>
  <th width="50">Office#<span>&nbsp;</span></th>
  <th width="50">Company <span>&nbsp;</span></th>
  <th width="50">Contact<span>&nbsp;</span></th>
  <th width="50">Mobile#<span>&nbsp;</span></th>
  <th width="60">Contract Start<span>&nbsp;</span></th>
  <th width="60">Contract End<span>&nbsp;</span></th>
   
    </tr>
    </thead>
    <tbody>
<?php echo $rc; ?></tbody></table>
 	</div>
       <script>
$(document).ready( function () {
    $('#table2').DataTable();
} );
 
</script>
      <div id="current" class="middle12"> 
  <h2 style="color:#2E5E79">Current Tenants</h2>
  <table id="table2"  border="0" style="table-layout: fixed;">
 <thead>
  <tr>
  <th width="15" height="5">ID#<span>&nbsp;</span></th>
  <th width="50">Floor#<span>&nbsp;</span></th>
  <th width="50">Office#<span>&nbsp;</span></th>
  <th width="50">Company<span>&nbsp;</span></th>
  <th width="50">Contact <span>&nbsp;</span></th>
  <th width="50">Mobile#<span>&nbsp;</span></th>
  <th width="60">Contract Start<span>&nbsp;</span></th>
  <th width="60">Contract End<span>&nbsp;</span></th>
   
    </tr>
    </thead>
    <tbody>
<?php echo $rcc; ?></tbody></table>


 	</div>


  

</div>
<?php include_once("footer.php"); ?>
</div>

</body>
</html>