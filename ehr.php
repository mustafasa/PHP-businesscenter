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
//update employee
$rs='';
if (isset($_POST['edate'])  ) {
	include ("mysqli.php");
	$edate = mysqli_real_escape_string($db_conx, $_POST['edate']);
	$ename = mysqli_real_escape_string($db_conx, $_POST['ename']);
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
	$id = mysqli_real_escape_string($db_conx, $_POST['id']);
	
	$edate=date("y-m-d", strtotime($edate));
	$qval=date("y-m-d", strtotime($qval));
	$dob=date("y-m-d", strtotime($dob));
	$cfrom=date("y-m-d", strtotime($cfrom));
	$cto=date("y-m-d", strtotime($cto));
	
		   		$newname = "$id.jpg";
	move_uploaded_file( $_FILES['upic']['tmp_name'], "eimg/$newname");
	
	$sql = "UPDATE  hr SET edate='$edate', ename='$ename', enat='$enat', eemail='$eemail', epasp='$epasp',econ='$econ',eqid='$eqid',qval='$qval',dob='$dob',mstatus='$mstatus',gender='$gender',
	jobt='$jobt',salary='$salary',cfrom='$cfrom'
, cto='$cto', account='$account', bname='$bname',note='$note',uby='$name'    WHERE id='$id'" ;
	   
	   $query = mysqli_query($db_conx, $sql);
	   

	
	header("location: hrdetail.php?eid=$id&su=Update SuccessFull");


}
	?>
    
<?php
//This get detail of pr client
	$pro='';
if (isset($_POST['eid'])) {
	$id=preg_replace('#[^0-9]#i', '', $_POST['eid']);
	include ("mysqli.php");
$sql2 ="SELECT * FROM  hr WHERE id='$id'  ";
$query2 = mysqli_query($db_conx, $sql2);
	$productCount2 =  mysqli_num_rows($query2);


	$row = mysqli_fetch_array($query2, MYSQLI_ASSOC);
		
	 $id = $row['id'];
	$edate = date('d-m-Y', strtotime($row['edate']));
	$ename =ucfirst($row['ename']);
	$enat =$row['enat'];
	$eemail =$row['eemail'];
	$epasp =$row['epasp'];
	$econ =$row['econ'];
	$eqid =$row['eqid'];
	$qval =date('d-m-Y', strtotime($row['qval']));
	$dob =date('d-m-Y', strtotime($row['dob']));
	$mstatus =$row['mstatus'];
	$gender =$row['gender'];
	$jobt =$row['jobt'];
	$salary =$row['salary'];
	$cfrom =date('d-m-Y', strtotime($row['cfrom']));
	$cto =date('d-m-Y', strtotime($row['cto']));
	$account =$row['account'];
	$bname =$row['bname'];
	$note =$row['note'];
	$regby =$row['regby'];
	$status =$row['status'];
	$dd= date('l jS \of F Y h:i:s A'); 

	
	$rs='<tr>
	<td  width="200" rowspan="8" style="vertical-align:top" ><span id="htec"><div class="captions"><br>Upload <br /><img src="img/upload.png" width="100" height="120" /> </div><img id="img"  style=" cursor:pointer;" src="eimg/'.$id.'.jpg?'.$dd.'" onerror="this.src=\'eimg/er.jpg\';" width="170px" height="200px" />
	 </span>
	<td><input type="file" id="upic" name="upic"style="display: none; " accept="image/*" />
	<td width="400" height="50">Employee ID: <strong>'.$id.'</strong></td>
	<td >Status: <strong>'.$status.'</strong></td>
	<td>Register By: <strong>'.$regby.'</strong>
			 </td>
			 </tr>	 
			 
			  <tr>
			  <td></td>
              <td width="400" height="50">Register Date: <strong><input id="edate" name="edate" class="sdate" type="text" value='.$edate.' readonly ></strong></td>
  <td>Full Name: <strong><input id="ename" name="ename" type="text" size="20"  value="'.$ename.'" ></strong></td>
  <td>Nationality: <strong><select name="enat" id="enat">
  <option value="'.$enat.'">'.$enat.'</option>
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
</select></strong></td>
             </tr>
  
              <tr>
			  <td></td>
              <td width="400" height="50">Email:<strong><input id="eemail" size="20" name="eemail" type="text" value= '.$eemail.'  ></strong></td>
  <td>Contact #<strong><input id="econ" name="econ" type="text" size="20" value= '.$econ.'  ></strong></td>
  <td >Passport # <strong><input id="epasp" name="epasp" size="20" value='.$epasp.'  ></strong></td>
              </tr>
  
              <tr>
			  <td></td>
              <td width="400" height="50">Qid: <input id="eqid" name="eqid" size="20" value='.$eqid.'  ></td><td height="50">QID Validity :<strong><input id="qval" name="qval" type="text" class="sdate" value='.$qval.' readonly ></strong></td>
  <td>Data OF Birth:<input id="dob" name="dob" type="text" class="sdate" value='.$dob.' readonly ></td>
             </tr>
     <tr>
	 <td></td>
     <td width="400" height="50">Gender: <select name="gender" id="gender" >
       <option value='.$gender.'>'.$gender.'</option>
       <option value="" disabled="disabled">Select</option>
       <option value="Male">Male</option>
       <option value="Female">Female</option>
     </select> </td>
	 <td height="50">Marital Status :<strong><select name="mstatus" id="mstatus">
     <option value='.$mstatus.'>'.$mstatus.'</option>
	<option value="" disabled="disabled">Select</option>
	    <option value="Single">Single</option>
    <option value="Married">Married</option>
     <option value="Widower">Widower</option>
     <option value="Divorced">Divorced</option>
    </select></strong></td>
  <td>Job title:<input id="jobt" name="jobt" type="text"  value="'.$jobt.'"  ></td>
             </tr>
			   <tr>
			   <td></td>
               <td width="400" height="50">Salary: <input id="salary" name="salary" size="10" value='.$salary.'  ></td>
			   <td height="50">Contract From :<strong><input id="cfrom" name="cfrom" type="text" class="cstart" value='.$cfrom.' readonly ></strong></td>
  <td>Contract To:<input id="cto" name="cto" type="text" class="cend" value='.$cto.' readonly ></td>
             </tr>
			      <tr>
				  <td></td>
                  <td width="400" height="50">Bank Account# <strong><input id="account" size="15" name="account" type="text" value='.$account.'  ></strong></td>
  <td>Bank Name<strong><input id="bname" name="bname" type="text" size="15" value= "'.$bname.'"  ></strong></td>
  <td >Note: <strong><input id="note" name="note" size="20" value="'.$note.'"  ></strong></td>
              </tr>
             <tr>
             <td></td>
  <td><input name="id" value='.$id.' id="id" type="hidden"><input name="uby" value='.$name.' type="hidden"><input type="button" value="Cancel" onclick="javascript:history.back()" class="csw"><input style="margin-left:5px;" class="submit csw" type="submit" value="Update"></td>
            </tr>';
		
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
<script>
//upload boz on image click
$(function(){
	$("#htec").click(function() {
    $("#upic").click();
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#upic").change(function(){
    readURL(this);
});
	});
  //Date Pciker
   $(function() {
    $( ".sdate" ).datepicker({dateFormat: 'dd-mm-yy',changeMonth:true,changeYear:true,yearRange: '1900:2100:' });
	
   });
//validatting
$(document).ready(function() {
	 $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9,.()&\-\s]+$/i.test(value);
    }, "Invalid Format.");

	$("#signupForm").validate({
		
		rules: {
			edate: {required:true},
			ename: {required:true, loginRegex:true , remote: {
        url: "ajax/employee.php",
        type: "post",
        data: { id: $('#id').val(),
          ename: function() {
            return $( "#ename" ).val();
          },
		
        }
      }
			},
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
//date picker
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
 <style>
 #htec .captions { opacity: 0; position: fixed; height:200px; width: 170px;   color: #666; background: white; text-align: center; font-weight: 700; }#htec:hover .captions { opacity: 0.7;cursor:pointer;  }
 </style> 
</head>
<body>

<div id="wrap"  align="center" >
<?php include_once("header.php"); ?>
 <?php include_once("menu.php"); ?>
 <div id="middle" align="center" class="scroll" style="background-color:#2E5E79;" >
<!--this div for detail of tenant-->
<div >
 <div id='clientd' class="divcurve scroll CSSTableGenerator" style="height:500px; width:1300px; margin-left:10px;  float:left "><div class="divheader" align="left">&nbsp;Employee  </div><form action="" method="post" id="signupForm" enctype="multipart/form-data"> <table align="left" width="1280px;" style="margin-left:10px; margin-top:15px;" >
<thead> <th align="left" colspan="5"  height="30">&nbsp;&nbsp; Edit</th></thead>


   <?php echo $rs;?>
 </table></form></div>
 <!--this end detail of client-->
 
 
 </div>

 
  
<?php include_once("footer.php"); ?>
</div>
</body>
</html>