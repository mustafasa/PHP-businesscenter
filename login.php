<?php
//if logged in by pass to index
session_start();
if (isset($_SESSION["username"])) {
    header("location: index.php"); 
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</title>

<link rel="stylesheet" type="text/css" href="style/lstyle.css" />
<script src="jq/jquery-1.11.1.js" type="text/javascript"></script>
<script type="text/javascript" src="jq/jquery.flippy.min.js"></script>
<script src="jq/jquery-ui.js"></script>
<script>

$(document).on('click','#login' ,function(e){
$("#wait" ).show();
   $.ajax({
                              type:"post",
                              url:"ajax/authorization.php",
                              data:$('#new').serialize(),
                              dataType: 'json',
    success: function(response)
{
	  $("#wait" ).hide();
	  
	 if(response.result=="success") {
		   $('#ans').hide();
		 
	       $( "#wrapper" ).effect( "drop", { direction: 'right'},300);      
setTimeout(function() {
  window.location.href = "index.php";
}, 500);
			
        }

  	else if (response.result) {
	
	 $('#ans').html(response.result)
	 
	 $( "#wrapper" ).effect( "shake");
	 
			
        }
		
	
	
	
},
error: function(response){
	alert("unsuccess") 	}
       

                          });
});

</script>
</head>

<body>
<div id="wrapper">
<div id="flipbox1" class="flipbox">
	<form name="login" class="login-form" id='new' method="post">
	
		<div class="header">
		<h1>Employee Login</h1>
		<span>Please Enter your Credential</span><br />
        
   <span id='wait' style="display:none;" >Authenticating<img src="img/newloading.gif" width="30" height="40"  style=" vertical-align: middle;" /></span>
        <span id='ans' style="color:red"></span>
		</div>
	
		<div class="content">
		<input name="user" type="text" class="input username" placeholder="Username" />
		<div class="user-icon"></div>
		<input name="password" type="password" class="input password" placeholder="Password" />
		<div class="pass-icon"></div>		
		</div>

		<div class="footer">
		<input type="button" name="submit" value="Login" id='login' class="button" />
		
		</div>
	
	</form>

</div>

</div>

<div id="kyahai" style="display:none;"><form name="Registration" class="login-form" id="reg" method="post">
	
		<div class="header">
		<h1>Registration</h1>
		<span>Note:Account will be activated by Administrator	</span>
        <span ID="rst" style="color:red"></span>
		</div>
	
		<div class="content">
		<input name="username" type="text" id='un' class="input username" placeholder="Username" />
		<div class="user-icon"></div>
		<input name="npassword" type="password" class="input password" placeholder="Password" />
		<div class="pass-icon"></div>
        <input name="password" type="password" class="input password" placeholder="Confirm Password" />
			<div class="ll"></div>
		</div>

		<div class="footer">
		<input type="button" name="submit" value="Sign up" id="signup" class="button" />
		<input type="button" id="btn-reverse" name="submit" value="Back" class="register" />
		</div>
	
	</form></div>

<script type="text/javascript" >$(function(){

   $(document).on('click','#btn-reverse' ,function(e){
        $(".flipbox").flippyReverse();
        e.preventDefault();
    });
        
    $(document).on('click','#btn-left',function(e){
        $(".flipbox").flippy({
            color_target: "#204562",
            direction: "left",
            duration: "500",
            verso: $("#kyahai").html()
         });
         e.preventDefault();
    });
});
    </script>
</body>
</html>