<?php include ("./inc/header.inc.php"); ?>
<?php

top_banner();

?>
<head>
	<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Settings - Zufalplay</title>
</head>
<body class="zfp-inner">
	<div class="">
      	<br><br>
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="changepassword-form elevatewhite" style='padding:10px;'>
				<center>
					<h2>Change Password</h2><hr>
					<div class="row">
						<div class="">
							<div class="col-md-10 input-group">
								<input type="password" class="form-control" placeholder="Old Password" aria-describedby="basic-addon1" id="oldpass" name="oldpass">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="">
							<div class="col-md-10 input-group">
								<input type="password" class="form-control" placeholder="New Password" aria-describedby="basic-addon1" id="newpass" name="newpass">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="">
							<div class="col-md-10 input-group">
								<input type="password" class="form-control" placeholder="Confirm New Password" aria-describedby="basic-addon1" id="cnfnewpass" name="cnfnewpass">
							</div>
						</div>
					</div>
					<br>
					<p id='reply_message'></p>					
					<button class="btn btn-default btn-flat" onclick='change_pass()' value="Save"><b>Save</b></button>
					<br><br>
			   		<script>
			   			function change_pass()
			   			{
			   				var oldpass = document.getElementById("oldpass").value;
			   				var newpass = document.getElementById("newpass").value;
			   				var cnfnewpass = document.getElementById("cnfnewpass").value;
							$.ajax(
					          {
					            url: "<?php echo $g_url;?>changepass.php",
					            dataType: "json",
					            type:"POST",

					            data:
					            {
					              oldpass:oldpass,
					              newpass:newpass,
					              cnfnewpass:cnfnewpass,
					            },

					            success: function(json)
					            {
					              if(json.status==1)
					              {
					               	$("#reply_message").html(json.msg);
					              }
					              else
					              {
					                //console.log('Hi');
					              }
					            },
					            
					            error : function()
					            {
					            	console.log("something went wrong");
					            }
					          });
			   			}
			   		</script>
				</center>
			</div>
		</div>
<div class="col-md-4"></div>
	</div>	
</body>
<?php include ("./inc/footer.inc.php"); ?>
