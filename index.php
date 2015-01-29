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
$sql3 ="SELECT * FROM  usertable WHERE id='$adminid' and user='$admin' and status='Activated'  LIMIT 1 ";
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Business Center Solution</title>
<link rel="stylesheet" type="text/css" href="style/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" href="style/jquery-ui.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
  <script src="jq/jquery-1.11.1.js"></script>
  <script src="jq/jquery-ui.js"></script>
  <script>

//auto genertaing tables
$(document).ready(function(){
 
    var counter = 1;
 
    $("#addButton").click(function () {
 
  if(counter>6){
	  
            alert("Only 6 Utility allow");
            return false;
	} 
 
	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'TextBoxDiv' + counter);
 
	newTextBoxDiv.after().html('<label>Extra #'+ counter + ' : </label>' +
	      '<input placeholder="Desciption" type="text" name="desc' + counter + 
	      '" id="desc' + counter + '"  ><input placeholder="Amount" type="text" name="utamount' + counter + 
	      '" id="utamount' + counter + '"  ><select id="utmonthly' + counter + '" name="utmonthly' + counter + '"><option disabled selected >Frequency</option><option value="1" >Monthly</option><option value="5">Quartely</option><option value="10">Half Yearly</option><option value"15">Yearly</option></select><input placeholder="Date"  type="text" name="utdate' + counter + 
	      '" id="utdate' + counter + '" value="" >');
 
	newTextBoxDiv.appendTo("#TextBoxesGroup");
 
 
	counter++;
     });
 
     $("#removeButton").click(function () {
	if(counter==1){
          alert("No more textbox to remove");
          return false;
       }   
 
	counter--;
 
        $("#TextBoxDiv" + counter).remove();
 
     });
});
</script>
  
</head>
<body>

<div id="wrap"  align="center" >
<?php include_once("header.php"); ?>
 <?php include_once("menu.php"); ?>
 <?php $sql2="Select * from msg";
$qsql = mysqli_query($db_conx, $sql2);
$row2 = mysqli_fetch_array($qsql, MYSQLI_ASSOC);
$heading = $row2['heading'];
$messagetu = $row2['messagetu'];
$mid = $row2['id'];?>
 <div id="middle" align="center" >
<div  align="left" style="margin-left:10px; margin-right:1000px; margin-top:15px;border-radius: 10px 100px 0px 0px; width:600px; height:40px;  background:url(img/header-repeat.jpg) repeat-x; float:left;"><div style="color:#CCC; font-size:22px; margin-top:10px; margin-left:15px; "><?php echo $heading;?></div></div>
<div align="left" style="float:left; margin-top:14px; margin-left:10px; width:1300px; height:450px; color:#930" class="scroll" ><?php echo $messagetu; ?></div>
<?php include_once("footer.php"); ?>
</div>
  

</div>
</body>
</html>