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
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated' and hr=1 LIMIT 1 ";
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
//Adding emploloyeee
$edate='';
$id='';
$sc='';
if(isset ($_POST['ename'])){
	include "mysqli.php";
	$edate = mysqli_real_escape_string($db_conx, $_POST['edate']);
	$eename = mysqli_real_escape_string($db_conx, $_POST['ename']);
	$enat = mysqli_real_escape_string($db_conx, $_POST['enat']);
	$eemail = mysqli_real_escape_string($db_conx, $_POST['eemail']);
	$epasp = mysqli_real_escape_string($db_conx, $_POST['epasp']);
	$econ = mysqli_real_escape_string($db_conx, $_POST['econ']);
	$eqid = mysqli_real_escape_string($db_conx, $_POST['eqid']);
	$qval = mysqli_real_escape_string($db_conx, $_POST['qval']);
	$dob = mysqli_real_escape_string($db_conx, $_POST['dob']);
	$mstatus = mysqli_real_escape_string($db_conx, $_POST['mstatus']);
	$gender = mysqli_real_escape_string($db_conx, $_POST['gender']);
	$jobt = mysqli_real_escape_string($db_conx, $_POST['jobt']);
	$salary = mysqli_real_escape_string($db_conx, $_POST['salary']);
	$cfrom = mysqli_real_escape_string($db_conx, $_POST['cfrom']);
	$cto = mysqli_real_escape_string($db_conx, $_POST['cto']);
	$account = mysqli_real_escape_string($db_conx, $_POST['account']);
	$bname = mysqli_real_escape_string($db_conx, $_POST['bname']);
	$note = mysqli_real_escape_string($db_conx, $_POST['note']);
	
	$edate=date("y-m-d", strtotime($edate));
	$qval=date("y-m-d", strtotime($qval));
	$dob=date("y-m-d", strtotime($dob));
	$cfrom=date("y-m-d", strtotime($cfrom));
	$cto=date("y-m-d", strtotime($cto));
	
	$sql = ("INSERT INTO hr (edate, ename, enat,eemail, epasp, econ, eqid ,qval,dob,mstatus,gender,jobt,salary,cfrom,cto,account,bname,regby,status,note) 
       VALUES('$edate','$eename','$enat','$eemail','$epasp','$econ','$eqid','$qval','$dob','$mstatus','$gender','$jobt','$salary','$cfrom ','$cto','$account','$bname','$name','Activated','$note')") ;
	
	$query = mysqli_query($db_conx, $sql);
	$eid = mysqli_insert_id($db_conx);
	
	$newname = "$eid.jpg";
	move_uploaded_file( $_FILES['upic']['tmp_name'], "eimg/$newname");
		
$sc= "<script> $(document).ready(function() { $( '#dialog-message' ).dialog({ modal: true, buttons: {   Ok: function() { $( this ).dialog( 'close' );     } } }); }); 

</script>";
}
?>

<?php //current list
include ("mysqli.php");
$rcc='';
$sql ="SELECT * FROM  hr where status='Activated'  ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 

    $id = $row['id'];
	$edate = date('d-m-Y', strtotime($row['edate']));
	$ename =ucfirst($row['ename']);
	$enat =$row['enat'];
	$eemail =$row['eemail'];
	$epasp =$row['epasp'];
	$econ =$row['econ'];
	$eqid =$row['eqid'];
	$qval =date('d-m-Y', strtotime($row['qval']));
	$dob =$row['dob'];
	$mstatus =date('d-m-Y', strtotime($row['mstatus']));
	$gender =$row['gender'];
	$jobt =$row['jobt'];
	$salary =$row['salary'];
	$cfrom =date('d-m-Y', strtotime($row['cfrom']));
	$cto =date('d-m-Y', strtotime($row['cto']));
	$account =$row['account'];
	$bname =$row['bname'];
	$note =$row['note'];
	 $dd= date('l jS \of F Y h:i:s A'); 
	$rcc .='  <tr>
    <td><img src="eimg/'.$id.'.jpg?'.$dd.'" onerror="this.src=\'eimg/er.jpg\';" width="250px" height="200px"  /></td>
    <td><div style="height:200px; width:450px; font-size:15px;"><a href="hrdetail.php?eid='.$id.'" style=" text-decoration: none; "><strong>Employee ID:'.$id.'</strong></a> <br><br><br>'.$ename.'<br><br><strong>Job Title: </strong>'.$jobt.'<br><br><strong>Contact#:</strong> '.$econ.'<br><br><strong>Email:</strong> '.$eemail.'</div></td>
  </tr>  ' ;
}}
?>
<?php //former list
include ("mysqli.php");
$rcd='';
$sql ="SELECT * FROM  hr where status='DeActivated'  ";
$query = mysqli_query($db_conx, $sql);

$productCount =  mysqli_num_rows($query); 
if ($productCount > 0) {
while ($row = $query->fetch_assoc()) { 

    $id = $row['id'];
	$edate = date('d-m-Y', strtotime($row['edate']));
	$ename =ucfirst($row['ename']);
	$enat =$row['enat'];
	$eemail =$row['eemail'];
	$epasp =$row['epasp'];
	$econ =$row['econ'];
	$eqid =$row['eqid'];
	$qval =date('d-m-Y', strtotime($row['qval']));
	$dob =$row['dob'];
	$mstatus =date('d-m-Y', strtotime($row['mstatus']));
	$gender =$row['gender'];
	$jobt =$row['jobt'];
	$salary =$row['salary'];
	$cfrom =date('d-m-Y', strtotime($row['cfrom']));
	$cto =date('d-m-Y', strtotime($row['cto']));
	$account =$row['account'];
	$bname =$row['bname'];
	$note =$row['note'];
	 $dd= date('l jS \of F Y h:i:s A'); 
	$rcd .='  <tr>
    <td><img src="eimg/'.$id.'.jpg?'.$dd.'" onerror="this.src=\'eimg/er.jpg\';" width="250px" height="200px"  /></td>
    <td><div style="height:200px; width:450px; font-size:15px;"><a href="hrdetail.php?eid='.$id.'" style=" text-decoration: none; "><strong>Employee ID:'.$id.'</strong></a> <br><br><br>'.$ename.'<br><br><strong>Job Title: </strong>'.$jobt.'<br><br><strong>Contact#:</strong> '.$econ.'<br><br><strong>Email:</strong> '.$eemail.'</div></td>
  </tr>  ' ;
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
 //for tabs
  $(function() {
    var tabs= $( "#tabs" ).tabs({
      
    }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
	tabs.find( ".ui-tabs-nav" )
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
  });
  //datepicekr
   $(function() {
    $( ".sdate" ).datepicker({dateFormat: 'dd-mm-yy', changeMonth: true,changeYear: true ,yearRange: '1900:2100:' + new Date().getFullYear()}).datepicker("setDate", new Date());
   });
   //contract datepicker
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
   //validatation form
   $(document).ready(function() {
	 $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9,.()&\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		
		rules: {
			edate: {required:true},
			ename: {required:true, loginRegex:true ,remote: "ajax/hr.php"},
			enat: {	required:true},
			cname: {loginRegex:true},
			  eemail:{required:true,email:true},		
			epasp:{required:true,loginRegex:true},
			econ:{number:true},
			eqid: {loginRegex:true},
		    qval:{required:function(){return $("#eqid").val() != ""}},		
			dob:{required:true	},
			mstatus:{required:true},
			gender: {required:true},	
			jobt:{required:true,loginRegex:true},
			salary:{number:true},
			account:{number:true},
			bname:{loginRegex:true},
			
		},

		messages: {
			edate: {required:"Select date"},
			ename: {required:"Enter Name", remote: "Employee Already exist"},
			enat: {	required:"Select"},
			  eemail:{required:"Enter Email Address",email:"Invalid Email"},		
			epasp:{required:"Enetr Passport #",loginRegex:true},
			econ:{number:"Invalid Contact #"},
			eqid: {loginRegex:true},
		    qval:{required:"Select date"},		
			dob:{required:"Select date"	},
			mstatus:{required:"Select Status"},
			gender: {required:"Select Gender"},	
			jobt:{required:"Enter Job Position",loginRegex:true},
			salary:{number:"Enter valid Salary"},
			account:{number:"Enter valid acount #"},
			bname:{loginRegex:"Enter Valid bank name"},
		},
		

		
	});


});

	
</script>
     <?php echo $sc; ?>
 <style>
  .ui-tabs-vertical { width: 1318px; height:500px; }
  .ui-tabs-vertical .ui-tabs-nav { float: left; width: 12em; }
  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
  .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
  .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 80em; height:33.7em;}
  input[type=submit],
input[type=button]{
 width: 100px;
 height: 25px;
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
   <li> <form action="hrdetail.php" method="get">
    <input name="eid" placeholder="Employee ID" size="10" /><input name="su" type="hidden"/><input style=" width: 120px;	
 height: 24px;
 width:45px;
 background-color: #2E5E79;
 border: none;
 border-radius: 4px;
 color: white;
"   type="submit" value="Go"  />
      </form></li>
  <li><a href="#middle1s">Add Employee </a></li>
   <li><a href="#middle12">Current Employee</a></li>
     <li><a href="#former">Former Employee</a></li>
   
    
  
  </ul>
  <div id="middle1s">
    <h2 style="color:#2E5E79">Add Employee</h2>
    	<fieldset>
		<legend>Employee Form</legend>
 <form  id="signupForm"  action="" method="post" enctype="multipart/form-data" >

<table width="1097" height="363" border="0">
  <tr>
    <td width="133" align="right"><strong>Date:</strong></td>
    <td width="399"><input  id="edate" size="10" class="sdate" name="edate" readonly="readonly"/></td>
    <td width="126" align="right"><strong>FullName:</strong></td>
    <td width="421"><input  id="ename" size="30" name="ename"/></td>
  </tr>
  <tr>
        <td align="right"><strong>Nationality</strong>:</td>
    <td><select name="enat" id="enat">
  <option value="">-- select one --</option>
  <option value="afghan">Afghan</option>
  <option value="albanian">Albanian</option>
  <option value="algerian">Algerian</option>
  <option value="american">American</option>
  <option value="andorran">Andorran</option>
  <option value="angolan">Angolan</option>
  <option value="antiguans">Antiguans</option>
  <option value="argentinean">Argentinean</option>
  <option value="armenian">Armenian</option>
  <option value="australian">Australian</option>
  <option value="austrian">Austrian</option>
  <option value="azerbaijani">Azerbaijani</option>
  <option value="bahamian">Bahamian</option>
  <option value="bahraini">Bahraini</option>
  <option value="bangladeshi">Bangladeshi</option>
  <option value="barbadian">Barbadian</option>
  <option value="barbudans">Barbudans</option>
  <option value="batswana">Batswana</option>
  <option value="belarusian">Belarusian</option>
  <option value="belgian">Belgian</option>
  <option value="belizean">Belizean</option>
  <option value="beninese">Beninese</option>
  <option value="bhutanese">Bhutanese</option>
  <option value="bolivian">Bolivian</option>
  <option value="bosnian">Bosnian</option>
  <option value="brazilian">Brazilian</option>
  <option value="british">British</option>
  <option value="bruneian">Bruneian</option>
  <option value="bulgarian">Bulgarian</option>
  <option value="burkinabe">Burkinabe</option>
  <option value="burmese">Burmese</option>
  <option value="burundian">Burundian</option>
  <option value="cambodian">Cambodian</option>
  <option value="cameroonian">Cameroonian</option>
  <option value="canadian">Canadian</option>
  <option value="cape verdean">Cape Verdean</option>
  <option value="central african">Central African</option>
  <option value="chadian">Chadian</option>
  <option value="chilean">Chilean</option>
  <option value="chinese">Chinese</option>
  <option value="colombian">Colombian</option>
  <option value="comoran">Comoran</option>
  <option value="congolese">Congolese</option>
  <option value="costa rican">Costa Rican</option>
  <option value="croatian">Croatian</option>
  <option value="cuban">Cuban</option>
  <option value="cypriot">Cypriot</option>
  <option value="czech">Czech</option>
  <option value="danish">Danish</option>
  <option value="djibouti">Djibouti</option>
  <option value="dominican">Dominican</option>
  <option value="dutch">Dutch</option>
  <option value="east timorese">East Timorese</option>
  <option value="ecuadorean">Ecuadorean</option>
  <option value="egyptian">Egyptian</option>
  <option value="emirian">Emirian</option>
  <option value="equatorial guinean">Equatorial Guinean</option>
  <option value="eritrean">Eritrean</option>
  <option value="estonian">Estonian</option>
  <option value="ethiopian">Ethiopian</option>
  <option value="fijian">Fijian</option>
  <option value="filipino">Filipino</option>
  <option value="finnish">Finnish</option>
  <option value="french">French</option>
  <option value="gabonese">Gabonese</option>
  <option value="gambian">Gambian</option>
  <option value="georgian">Georgian</option>
  <option value="german">German</option>
  <option value="ghanaian">Ghanaian</option>
  <option value="greek">Greek</option>
  <option value="grenadian">Grenadian</option>
  <option value="guatemalan">Guatemalan</option>
  <option value="guinea-bissauan">Guinea-Bissauan</option>
  <option value="guinean">Guinean</option>
  <option value="guyanese">Guyanese</option>
  <option value="haitian">Haitian</option>
  <option value="herzegovinian">Herzegovinian</option>
  <option value="honduran">Honduran</option>
  <option value="hungarian">Hungarian</option>
  <option value="icelander">Icelander</option>
  <option value="indian">Indian</option>
  <option value="indonesian">Indonesian</option>
  <option value="iranian">Iranian</option>
  <option value="iraqi">Iraqi</option>
  <option value="irish">Irish</option>
  <option value="italian">Italian</option>
  <option value="ivorian">Ivorian</option>
  <option value="jamaican">Jamaican</option>
  <option value="japanese">Japanese</option>
  <option value="jordanian">Jordanian</option>
  <option value="kazakhstani">Kazakhstani</option>
  <option value="kenyan">Kenyan</option>
  <option value="kittian and nevisian">Kittian and Nevisian</option>
  <option value="kuwaiti">Kuwaiti</option>
  <option value="kyrgyz">Kyrgyz</option>
  <option value="laotian">Laotian</option>
  <option value="latvian">Latvian</option>
  <option value="lebanese">Lebanese</option>
  <option value="liberian">Liberian</option>
  <option value="libyan">Libyan</option>
  <option value="liechtensteiner">Liechtensteiner</option>
  <option value="lithuanian">Lithuanian</option>
  <option value="luxembourger">Luxembourger</option>
  <option value="macedonian">Macedonian</option>
  <option value="malagasy">Malagasy</option>
  <option value="malawian">Malawian</option>
  <option value="malaysian">Malaysian</option>
  <option value="maldivan">Maldivan</option>
  <option value="malian">Malian</option>
  <option value="maltese">Maltese</option>
  <option value="marshallese">Marshallese</option>
  <option value="mauritanian">Mauritanian</option>
  <option value="mauritian">Mauritian</option>
  <option value="mexican">Mexican</option>
  <option value="micronesian">Micronesian</option>
  <option value="moldovan">Moldovan</option>
  <option value="monacan">Monacan</option>
  <option value="mongolian">Mongolian</option>
  <option value="moroccan">Moroccan</option>
  <option value="mosotho">Mosotho</option>
  <option value="motswana">Motswana</option>
  <option value="mozambican">Mozambican</option>
  <option value="namibian">Namibian</option>
  <option value="nauruan">Nauruan</option>
  <option value="nepalese">Nepalese</option>
  <option value="new zealander">New Zealander</option>
  <option value="ni-vanuatu">Ni-Vanuatu</option>
  <option value="nicaraguan">Nicaraguan</option>
  <option value="nigerien">Nigerien</option>
  <option value="north korean">North Korean</option>
  <option value="northern irish">Northern Irish</option>
  <option value="norwegian">Norwegian</option>
  <option value="omani">Omani</option>
  <option value="pakistani">Pakistani</option>
  <option value="palauan">Palauan</option>
  <option value="panamanian">Panamanian</option>
  <option value="papua new guinean">Papua New Guinean</option>
  <option value="paraguayan">Paraguayan</option>
  <option value="peruvian">Peruvian</option>
  <option value="polish">Polish</option>
  <option value="portuguese">Portuguese</option>
  <option value="qatari">Qatari</option>
  <option value="romanian">Romanian</option>
  <option value="russian">Russian</option>
  <option value="rwandan">Rwandan</option>
  <option value="saint lucian">Saint Lucian</option>
  <option value="salvadoran">Salvadoran</option>
  <option value="samoan">Samoan</option>
  <option value="san marinese">San Marinese</option>
  <option value="sao tomean">Sao Tomean</option>
  <option value="saudi">Saudi</option>
  <option value="scottish">Scottish</option>
  <option value="senegalese">Senegalese</option>
  <option value="serbian">Serbian</option>
  <option value="seychellois">Seychellois</option>
  <option value="sierra leonean">Sierra Leonean</option>
  <option value="singaporean">Singaporean</option>
  <option value="slovakian">Slovakian</option>
  <option value="slovenian">Slovenian</option>
  <option value="solomon islander">Solomon Islander</option>
  <option value="somali">Somali</option>
  <option value="south african">South African</option>
  <option value="south korean">South Korean</option>
  <option value="spanish">Spanish</option>
  <option value="sri lankan">Sri Lankan</option>
  <option value="sudanese">Sudanese</option>
  <option value="surinamer">Surinamer</option>
  <option value="swazi">Swazi</option>
  <option value="swedish">Swedish</option>
  <option value="swiss">Swiss</option>
  <option value="syrian">Syrian</option>
  <option value="taiwanese">Taiwanese</option>
  <option value="tajik">Tajik</option>
  <option value="tanzanian">Tanzanian</option>
  <option value="thai">Thai</option>
  <option value="togolese">Togolese</option>
  <option value="tongan">Tongan</option>
  <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
  <option value="tunisian">Tunisian</option>
  <option value="turkish">Turkish</option>
  <option value="tuvaluan">Tuvaluan</option>
  <option value="ugandan">Ugandan</option>
  <option value="ukrainian">Ukrainian</option>
  <option value="uruguayan">Uruguayan</option>
  <option value="uzbekistani">Uzbekistani</option>
  <option value="venezuelan">Venezuelan</option>
  <option value="vietnamese">Vietnamese</option>
  <option value="welsh">Welsh</option>
  <option value="yemenite">Yemenite</option>
  <option value="zambian">Zambian</option>
  <option value="zimbabwean">Zimbabwean</option>
</select></td>
    <td align="right"><strong>Email:</strong></td>
    <td><input  id="eemail" size="20" name="eemail"/></td>
  </tr>
  <tr>
  <td align="right"><strong>Passport#</strong>:</td>
    <td><input  id="epasp" size="20" name="epasp"/></td>
  <td align="right"><strong>Contact#</strong>:</td>
    <td><input  id="econ" size="20" name="econ"/></td>

    
  </tr>
  <tr>
    <td align="right"><strong>QID#</strong>:</td>
    <td><input  id="eqid" size="20" name="eqid"/></td>
    <td align="right"><strong>QID Validy</strong>:</td>
    <td><input  id="qval" size="20" name="qval" class="sdate" readonly="readonly"/></td>
    
  </tr>
  <tr>
    <td align="right"><strong>Date Of Birth</strong>: </td>
    <td><input  id="dob" size="10" class="sdate" name="dob" readonly="readonly"/></td>
    <td align="right"><strong>Marital Status</strong>: </td>
    <td><select name="mstatus" id="mstatus">
     <option  disabled="disabled" selected="selected">Select</option>
    <option value="Single">Single</option>
    <option value="Married">Married</option>
     <option value="Widower">Widower</option>
     <option value="Divorced">Divorced</option>
    </select>
    </td>
  </tr>
  <tr>
  <td align="right"><strong>Gender</strong>:</td>
    <td><select name="gender" id="gender" >
    <option value="">Select</option>
      <option value="Male">Male</option>
       <option value="Female">Female</option>
       </select>
    </td>
    <td align="right"><strong>Upload Pic</strong></td>
    <td><input type="file" name="upic"  id="upic" accept="image/*" ></td>
  </tr>
    <tr>
    <td align="right"><strong>Job Title</strong>: </td>
    <td><input  id="jobt" size="10" name="jobt" /></td>
    <td align="right"><strong>Salary:</strong></td>
    <td><input  id="salary" size="10" name="salary" />
    </td>
  </tr>
      <tr>
    <td align="right"><strong>Contract From:</strong></td>
    <td ><input  id="cfrom" size="10" class="fstart" name="cfrom" readonly="readonly"/></td>
    <td align="right"><strong>Contract To</strong>: </td>
    <td><input  id="cto" size="10" class="fend" name="cto" readonly="readonly" />
    </td>
  </tr>
     <tr>
    <td align="right"><strong>Bank Account#</strong>: </td>
    <td><input  id="account" size="10" name="account" /></td>
    <td align="right"><strong>Bank Name</strong>: </td>
    <td><input  id="bname" size="30" name="bname" />
    </td>
  </tr>
  <tr><td align="right"><strong>Note:</strong></td><td><input  id="note" size="30" name="note" /></td>
    <td align="right"></td><td><input class="submit" type="submit" value="Submit" onclick="return SubmitIfValid();"/></td></tr>
</table>
	</fieldset>

			
	</form>

  </div>
  <script>
$(document).ready( function () {
    $('#ftable').DataTable();
} );
 
</script>
    <div  id="former" class="middle12"   >
  <h2 style="color:#2E5E79">Employee List</h2>
<table id="ftable"  border="0" style="margin-left:10px; width:1120px;">
 <thead>
  <tr>
  <th width="15" height="5">Details</th>
  <th width="50"><span>&nbsp;</span></th>
    </tr>
    </thead>
    <tbody>
     <?php echo $rcd; ?>
   
    </tbody>


</table>
  </div>
    <script>
$(document).ready( function () {
    $('#table').DataTable();
} );
 
</script>
  <div  id="middle12" class="middle12"   >
  <h2 style="color:#2E5E79">Employee List</h2>
<table id="table"  border="0" style="margin-left:10px; width:1120px;">
 <thead>
  <tr>
  <th width="15" height="5">Details</th>
  <th width="50"><span>&nbsp;</span></th>
    </tr>
    </thead>
    <tbody>
     <?php echo $rcc; ?>
   
    </tbody>


</table>
  </div>

  <div id="dialog-message" title="Employee Added Successfully" style="display:none;">
  <p>
    <?php echo $eename; ?>
    <strong><span id="resz" style="color:Red; font-size:18px;"></span></strong> Employee ID <strong><span id="res" style="color:Red; font-size:18px;"><?php echo $eid; ?></span></strong> .For Further Reference 
  </p>
 
 
</div>
</div>

  
<?php include_once("footer.php"); ?>
</div>

</body>
</html>