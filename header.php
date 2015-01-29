<?php
if (isset($_POST['pprofile'])  ) {
	$jj= $_POST["pprofile"];
		$newname = "$jj.jpg";
	move_uploaded_file( $_FILES['cpropic']['tmp_name'], "profile/$newname");
};
?>
<div id="header" ><div id="header1" align="left" style="font-weight:bold; font-size:25px;">Company <span style="color:#fff;">Logo</span></div>
<div id="header2"  ><div style="float:left; margin-top:25px; margin-left:2px;"><img border="0" src="profile/<?php echo $name;?>.jpg?<?php echo date('l jS \of F Y h:i:s A'); ?> />" onerror="this.src='profile/er.jpg';" width="32px" height="32px"  /></div>

  <script src="jq/jquery-ui.js"></script>
  <script src="jq/jquery.validate.js"></script>


   
<script>
//for changing pic
$(function(){
		$("#upcis").click(function() {
		$("#cpropic").click();
	});
	
	function readURL(input) {
	
		if (input.files && input.files[0]) {
			var reader = new FileReader();
	
			reader.onload = function (e) {
				$('#propic').attr('src', e.target.result);
			}
	
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	$("#cpropic").change(function(){
		readURL(this);
	});
		});
//for dialoque box
   $(document).ready(function(){
	  $("#configb").on("click",function() { $( "#config" ).dialog({
		  height:400,
			width: 690,
		  modal: true,
		   show: {
        effect: "blind",
        duration: 500
      },
		   buttons: {
        Close: function() {
          $( this ).dialog( "close" );
	
        }
      }
		 
	   });   
		}); 
			}); 
//valiudation			
$(document).ready(function() {
		
	  $.validator.addMethod("loginRegex", function(value, element) {
			return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
		}, "Invalid Format.");
	
		$("#chanepass").validate({
			
			rules: {
				

			
				newpass:{required:true,loginRegex:true,minlength: 6},
				cnewpass:{equalTo: "#newpass"},
				
		opass: {required:true, loginRegex:true , remote: {
        url: "ajax/checkpass.php",
        type: "post",
        data: { chuser: $('#chuser').val(),
          ename: function() {
            return $( "#opass" ).val();
          },
		
        }
      }
			}
			
			},
	
			messages: {
		
				opass: {required:"<br />Please Enter Password", loginRegex:"<br />Inalid password Format" , remote:"<br />Incorrect Password"},
				newpass:{required:"<br />Please Enter Password",loginRegex:"<br />Inalid password Format",minlength: "<br />Atleast Six Character"},
				cnewpass:{equalTo: "<br />Mismatch"}
			},
			submitHandler: function(form) {
                   $.ajax({
                        
                              type:"post",
                              url:"ajax/passchange.php",
                              data:$('#chanepass').serialize(),
                              dataType: 'json',
    success: function(response)
{
	
	 if(response.result=="success") {
		 y = response.results;
		 $('#pchanged').html(y);
   }},
error: function(response){
	alert("unsuccess") 	}
             });
          }
	});
	
	
	});
	
	
</script>
<ul  >

                            <li >Hello <?php echo  array_shift(explode(' ', $name)); ?></li>

                            <li>  <a href="#" id="configb" >Settings</a></li>

                            <li><a href="logout.php">Logout</a></li>

                        </ul></div></div>
<style>

.ui-dialog .ui-dialog-titlebar {
display: none;
}

#upcis .caption { opacity: 0; position: absolute; height:250px; width: 280px; bottom: 59px; left: 14px;  color: #666; background: white; text-align: center; font-weight: 700; } #upcis:hover .caption { opacity: 0.7;cursor:pointer;  } </style>

</style>
  <div id="config" title="My Profile" style="display:none; ;">
  <p>
    <div id="figure" style="float:left;"><form enctype="multipart/form-data" method="post" action="">
    <span id="upcis">
    <img  src="profile/<?php echo $name;?>.jpg" onerror="this.src='profile/er.jpg';" width="280px" height="250px" id="propic" />
    <div class="caption"><br>Upload <br /><img src="img/upload.png" width="100" height="120" /> </div></span>

    <input type="file" id="cpropic" name="cpropic" style="display: none;" accept="image/*" />
    <input type="hidden" name="pprofile" value="<?php echo $name; ?>"  />
   <br /> <input  type="submit" value="Save" style="  width: 60px;
	 height: 25px;
	 background-color: #2E5E79;
	 border: none;
	 border-radius: 4px;
	 color: white;" />
    </form></div>
    <span style=" position:absolute;
    left:50%;
    top:10%;
    bottom:10%;
    border-left:1px solid black;"></span>
    <div style="float:right; margin-right:25px;" ><form enctype="multipart/form-data" method="post" action="" id="chanepass" >
    <br /><table>
    <tr><td height="45">Password</td><td><input id="opass" name="opass" type="password" /><input id="chuser" name="chuser" value="<?php echo $admin; ?>" type="hidden" /></td></tr>
   <tr><td height="45">New Password</td><td><input id="newpass" name="newpass" type="password" /></td></tr>
   <tr><td height="45">Confirm</td><td><input id="cnewpass" name="cnewpass" type="password" /></td></tr>
   <tr><td><Span id="pchanged" style="color:#666633"></Span></td><td  align="right"><input  type="submit" value="Change" style="  width: 70px;
	 height: 25px;
	 background-color: #2E5E79;
	 border: none;
	 border-radius: 4px;
	 color: white;" /></td></tr>
    
    </table>
    </form></div>
  </p>
 
 
</div>