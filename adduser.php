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
//get user acount
    include ("mysqli.php");
$rc='';
$sql ="SELECT usertable.id,usertable.user,usertable.status,usertable.name,usertable.eid,hr.econ,hr.eemail
FROM usertable
JOIN hr
ON usertable.eid=hr.id
 where user not in('admins','superuser') ";
	
$check = mysqli_query($db_conx, $sql);

$count =  mysqli_num_rows($check); // count the output amount
if ($count > 0) {
while ($row = $check->fetch_assoc()) { 
$id = $row['id'];
$user = $row['user'];
$status = $row['status'];
$names = $row['name'];
$eid =$row['eid'];
$contactno=$row['econ'];
$emailid=$row['eemail'];

		
		$rc .='
  <tr data-id='.$id.' class="nextt_btn" style=" cursor:pointer" >
  <td >'.$eid.'</td>
    <td >'.$user.'</td>
	 <td >'.$status.'</td>
	<td >'.$names.'</td>
	<td >'.$contactno.'</td>
		<td >'.$emailid.'</td>
	
  </tr>
 
' ;}}
$sql2="Select * from msg";
$qsql = mysqli_query($db_conx, $sql2);
$row2 = mysqli_fetch_array($qsql, MYSQLI_ASSOC);
$heading = $row2['heading'];
$messagetu = $row2['messagetu'];
$mid = $row2['id'];
	?>
<?php
if (isset($_POST['messagetu'])  ) {
	include ("mysqli.php");
	
	$messagetu = mysqli_real_escape_string($db_conx, $_POST['messagetu']);
	$heading= mysqli_real_escape_string($db_conx,  $_POST['heading']);
		$id= preg_replace('#[^0-9]#i', '',  $_POST['id']);
	
	$sql = ("UPDATE msg SET messagetu='$messagetu',heading='$heading' WHERE id='$id'")  ;
	$query = mysqli_query($db_conx, $sql);
	}
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
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
   <script src="tinymce\js\tinymce\tinymce.min.js"></script>
 <script>
 //tabs
$(function() {
    var tabs= $( "#tabs" ).tabs({
      
    }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
	tabs.find( ".ui-tabs-nav" )
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	
	
  });  
//vasldiation
$(document).ready(function() {
	
  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		
		rules: {
			eid: {required:true,number: true,remote:"ajax/chkemp.php"},
			username: {	required:true,loginRegex:true,remote:"ajax/checkuser.php"},
			password:{required:true,loginRegex:true,minlength: 6},
			confirm_password:{equalTo: "#password"}
			
		},

		messages: {
		eid: {required:"Enter Employee Id",number: "Invalid Id"},
			username: {	required:"Please Enter Username",loginRegex:"Invalid format",remote:"User Name Not Available"},
			password:{required:"Please Enter Password",loginRegex:"Please Enter valid format" ,minlength:"Password Must Be of six Character"},
			confirm_password:{equalTo: "MIsmatch Password"}
		},
				submitHandler: function(form) {
					$('#loading').show();
                   $.ajax({
                        
                              type:"post",
                              url:"ajax/ajaxuser.php",
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
        }
	});
});
//get employee name
$(document).ready(function(){
	  $("#eid").change(function(){
		  var status=$(this).val();
		   if(status != ''){
		 	      $.ajax({
                              type:"post",
                              url:"ajax/ename.php",
                              data:"status="+status,
							  datatype:"json",
				              success:function(data){ $("#ename").val(data);
							    $('#ename').css( "background-color","#B3CBD6"  ) 
							 $('#ename').animate({backgroundColor: "#fff",});
							   }
                                
	                                                       });
		   }
		   else{
			   $("#sname").val("");
			   }
		  });
	 });
 //checkbox solution 
$(document).ready(function(){
		$("#tmenu" ).click(function(){
       if( $(this).is(':checked') ){
	   $('#htmenu').prop('disabled', true);
	   } ;
	   });
	   
$("#iqmenu" ).click(function(){
       if( $(this).is(':checked') ){
	   $('#hiqmenu').prop('disabled', true);
	   } ;
 });
 $("#chmenu" ).click(function(){
       if( $(this).is(':checked') ){
	   $('#hchmenu').prop('disabled', true);
	   } ;
 });
  $("#astmenu" ).click(function(){
       if( $(this).is(':checked') ){
	   $('#hastmenu').prop('disabled', true);
	   } ;
 });
  $("#sermenu" ).click(function(){
       if( $(this).is(':checked') ){
	   $('#hsermenu').prop('disabled', true);
	   } ;
 });
   $("#hrmenu" ).click(function(){
       if( $(this).is(':checked') ){
	   $('#hhrmenu').prop('disabled', true);
	   } ;
 });
    $("#expmenu" ).click(function(){
       if( $(this).is(':checked') ){
	   $('#aexpmenu').prop('disabled', true);
	   } ;
 });
    $("#recptmenu" ).click(function(){
       if( $(this).is(':checked') ){
	   $('#arecptmenu').prop('disabled', true);
	   } ;
 });

		 
		 });	 
//on click user detail
 $(document).ready(function(){
  $(".nextt_btn").on("click",function(e) {
  e.preventDefault(); // cancel the link
  var id = $(this).data('id');
window.location.href = "userdetail.php?id="+id+"&su=";
  });
  });
  //get wyiwyg
  tinymce.init({
    selector: "textarea",
	width : 1120,
	height: 252	
 });
 //backup 
 
 $(function() {
	 $("#backup").click(function(){
		$('#doading').show();
  $.ajax({ url:"ajax/dbbackup.php", datatype:"json",
				              
    success: function(response)
{
	 if(response.result=="success") {
	 $('#doading').hide();
		 $('#bumsg').css("display","inline" );
       }
	
},
error: function(response){
	alert("SomeThing Went wrong Try Again") 	}
       

               });

 });
 });
	 </script>
 <style>
 .ui-tabs-vertical { width: 1318px; height:500px;  }
  .ui-tabs-vertical .ui-tabs-nav { float: left; width: 12em;  }
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
 cursor:pointer;
 
 }
 .error{color:red} 
.dataTables_wrapper {

  width:1010px;
 
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
  <li><a href="#middle1s">Add User</a></li>
    <li ><a href="#middle1ss">Users</a></li>
      <li ><a href="#bup">Backup</a></li>
      <li ><a href="#msgtu">Message to User</a></li>
  </ul>
  <div id="middle1s">
    <h2 style="color:#2E5E79">Add User</h2>
 <form  id="signupForm" method="post" action="">
	<fieldset>
		<legend>Add User Form</legend>
        
		<p>
			<label for="Employee">Employee Id</label>
			<input id="eid" name="eid" type="text" size="4" />
		</p>
		<p>
			<label for="name">Full name</label>
			<input id="ename" name="ename" type="text" readonly="readonly" />
	
		<p>
			<label for="username">Username</label>
			<input id="username" name="username" type="text" />
		</p>
		<p>
			<label for="password">Password</label>
			<input id="password" name="password" type="password" />
		</p>
		<p>
			<label for="confirm_password">Confirm password</label>
			<input id="confirm_password" name="confirm_password" type="password" />
		</p>
<input id="regby" name="regby" type="hidden" value="<?php echo $name;?>" />
		<p>
			<label for="agree">Privileges:</label>
			<input type="checkbox" class="checkbox" id="tmenu" name="tmenu" value="1"  />Tenants
            <input type="checkbox" class="checkbox" id="iqmenu" name="iqmenu" value="1" />Enquiry
            <input type="checkbox" class="checkbox" id="chmenu" name="chmenu" value="1" />Cheque
            <input type="checkbox" class="checkbox" id="astmenu" name="astmenu" value="1" />Asset
            <input type="checkbox" class="checkbox" id="sermenu" name="sermenu" value="1" />PRO Service
            <input type="checkbox" class="checkbox" id="hrmenu" name="hrmenu" value="1" />Human Resource
             <input type="checkbox" class="checkbox" id="expmenu" name="expmenu" value="1" />Expense
            <input type="checkbox" class="checkbox" id="recptmenu" name="recptmenu" value="1" />Receipet
            <!-hidden check boz-!>
            <input type="hidden"  id="htmenu" name="tmenu" value="0" />
            <input type="hidden"  id="hiqmenu" name="iqmenu" value="0" />
            <input type="hidden"  id="hchmenu" name="chmenu" value="0" />
            <input type="hidden"  id="hastmenu" name="astmenu" value="0" />
            <input type="hidden" id="hsermenu" name="sermenu" value="0" />
            <input type="hidden"  id="hhrmenu" name="hrmenu" value="0" />
             <input type="hidden"  id="aexpmenu" name="expmenu" value="0" />
            <input type="hidden"  id="arecptmenu" name="recptmenu" value="0" />
		</p>
	
		
		<p>
			<input class="submit" type="submit"  value="Submit"/><span id='loading' style=' margin-left:25px; display:none'>Adding User <img src='img/loading.gif'/></span>
		</p>
	</fieldset>
</form>
  </div>
  
  <div id="bup">
  <p ><button id="backup" class="csw" style="width:90px; background-image:url(img/backup.png) ; background-repeat:no-repeat; background-position:right; text-align:left; cursor:pointer; "><strong>Backup</strong></button></p>
  <span id='doading' style=' margin-left:4px;display:none; color:#F00 '>Taking Backup Please  Wait.... <img src='img/loading.gif'/></span>
  <p id="bumsg" style="color:#930; display:none;">Backup was Successfully !!!! </p>
  </div>
  
  
  <div id="middle1ss" class="middle12" >
    <table id="table" align="left"  border="0" style="table-layout: fixed; width:1000px;">
 <thead>
  <tr>
  <th width="18">Employee ID<span>&nbsp;</span></th>
  <th width="10" height="5">UserName<span>&nbsp;</span></th>
  <th width="20">Status<span>&nbsp;</span></th>
  <th width="20">Name<span>&nbsp;</span></th>
  <th width="20">Contact#<span>&nbsp;</span></th>
  <th width="40">Email<span>&nbsp;</span></th>
  

   
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
  <div id="msgtu" ><form action="" method="post" >
 <strong>Heading for User </strong>: <input id="heading" value="<?php echo $heading; ?>" name="heading" size="50" /><br /><br />
<strong><label style="vertical-align:top;"> Message: </label></strong> <textarea id="messagetu" name="messagetu" style="width:900px; height:400px;resize: none;"  ><?php echo $messagetu; ?></textarea><br /><br /><input name="id" value="<?php echo $mid; ?>" type="hidden"  /><input type="submit" class="csw" style=" float: right; " value="Submit"  />
  </form></div>
  
  <div id="dialog-message" title="User Added" style="display:none;">
<p style="color:#3f7227; background-color:#d9e4ac; padding:10px 5px">Username <strong><span id="res" style="color:Red; font-size:18px;"></span></strong> Was Created successfully!!!</p>

 
</div>
</div>

  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>