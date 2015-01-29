
<?php
$recmenus = '';
$expmenus='';
$hrmenu='';
$tenmenu='';
$enqmenu='';
$chqmenu='';
$astmenu='';
$sermenu='';
$usermenu='';
if($receipt == 1){
     	$recmenus='<li><a href="receipt.php"style="background:url(img/receipt.png) no-repeat center left;  ">&nbsp;&nbsp;Receipt</a></li>';
	    }
if($expense==1){
     	$expmenus='<li><a href="expense.php" style="background:url(img/expense.png) no-repeat center left;  ">&nbsp;&nbsp; Expense</a></li>';
	    }
        if($hr==1){
     	$hrmenu='<li><a href="hr.php"style="background:url(img/tenant.png) no-repeat center left;  ">&nbsp;&nbsp;Human Resource</a></li>';
	    }
	    if($tenant==1){
		$tenmenu='<li><a href="tenantlist.php" style="background:url(img/tenant1.png) no-repeat center left;  ">&nbsp;Tenant</a>';
  		}
        if($inquery==1){
		$enqmenu='<li><a href="inquiry.php"style="background:url(img/inquery.png) no-repeat center left;  ">&nbsp;&nbsp; Enquiry</a></li>';
		}
		if($cheque==1){
		$chqmenu=' <li><a href="cheque.php" style="background:url(img/cheque.png) no-repeat center left;  ">&nbsp;&nbsp;Cheque</a></li>';
		}
		if($asset==1){
		$astmenu=' <li><a href="asset.php" style="background:url(img/asset.png) no-repeat center left;  ">&nbsp;&nbsp; Asset</a></li>';
		}
		if($service==1){
		$sermenu='   <li><a href="services.php" style="background:url(img/service.png) no-repeat center left;  ">&nbsp;&nbsp;PRO Service</a></li>';
		}
		if($auser==1){
		$usermenu='   <li><a   style="background:url(img/user.png) no-repeat  left; " href="adduser.php">&nbsp; User</a></li>';
		}
?>
<div id="menu" >
<ul >
  <li><a href="index.php" style="background:url(img/home.png) no-repeat  left; margin-left:4px; ">&nbsp;&nbsp;Home</a></li>
  <?php echo $tenmenu; ?>
  <?php echo $enqmenu; ?>
  <?php echo $chqmenu; ?>
  <?php echo $astmenu; ?>
  <?php echo $sermenu; ?>
  <?php echo $hrmenu; ?>
  <?php echo $expmenus; ?>
   <?php echo $recmenus; ?>
  <?php echo $usermenu; ?>
  
</ul></div>
