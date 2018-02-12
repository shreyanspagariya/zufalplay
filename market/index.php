<?php include ("../inc/extuser.inc.php"); ?>
<?php 
	if(isset($_SESSION["email1"]))
	{
	  $email = $_SESSION["email1"];
	  top_banner();
	}
	else
	{
	  $email = "EXTUSER";
	  top_banner_extuser();
	}
?>
<head>
	<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Market - Redeem your Earnings @Zufalplay</title>
	<link href="marketstyle.css" rel="stylesheet">
	<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("../inc/sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8">
		<div class='row hrwhite elevatewhite'>
			<center><h4>Recharges</h4></center>
			<?php 
				$getposts = mysqli_query($con,"SELECT * FROM zufal_products");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$prod_id=$row['prod_id'];
					$prod_name = $row['prod_name'];
					$prod_details = $row['prod_details'];
					$image_link = $row['prod_imgloc'];
					$prod_marketprice = $row['prod_marketprice'];
					$prod_zufalprice = $row['prod_zufalprice'];
					$deadline = $row['deadline'];
					$sizeRequired = $row['sizeRequired'];
					$client = $row['client'];
					$is_coupon = $row['is_coupon'];
					$discount_description = $row['discount_description'];
					$width = $row['width'];

					$short_title = substr($prod_name,0,19);
					if(strlen($prod_name)>20)
					{
						$short_title.="...";
					}

					if(isset($_SESSION["email1"]))
					{
						if($user_points >= $prod_zufalprice)
						{
							echo "
								<center>
									<div class='col-md-3 hrwhite'>
									<a data-toggle='modal' href='#purchase_modal$prod_id'>
										<span data-toggle='tooltip' title='$prod_name'>
											<div class=''>
												<img src='$image_link' style='height:100%; width:100%;'>
												<font size='2'><b>$short_title - Rs. $prod_marketprice</b></font><br><br>
											</div>
										</span>
									</a>
									</div>
								</center>
								<div class='modal fade' id='purchase_modal$prod_id' tabindex='-1' role='dialog' aria-labelledby='purchase_modal".$prod_id."Label'>
								  <div class='modal-dialog modal-lg' role='document'>
									<div class='modal-content'>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										<h4 class='modal-title' align='center' id='purchase_modal".$prod_id."Label'>$prod_name - Rs. $prod_marketprice</h4>
									  </div>
									  <div class='modal-body row'>
										<div class='col-md-6'>
											<p id='left_info'>
												<div class='form-group input-group col-md-12'>
											        <input type='text' id='phone_no$prod_id' name='phone_no$prod_id' class='form-control' placeholder='Mobile No.'>
											    </div><br>
												Terms & Conditions:<br>
												<ul>
													$prod_details
												</ul>
											</p>
											<p id='recharge_notify$prod_id'></p>
										</div>
										<div class='col-md-6'>
											<center>
												<div class='row'>
													<img src='$image_link' style='height:100%;width:80%;'>
												</div>
												<br>
												<button class='btn btn-primary btn-flat' id='submit_recharge$prod_id' onclick='complete_recharge($prod_id)' value='Add'><b>Get for Rs. $prod_zufalprice</b></button>
											</center>
										</div>
									  </div>
									</div>
								  </div>
								</div>
							";
						}
						else
						{
							echo "
								<center>
									<div class='col-md-3 hrwhite'>
									<a data-toggle='modal' href='#purchase_modal$prod_id'>
										<span data-toggle='tooltip' title='$prod_name'>
											<div class=''>
												<img src='$image_link' style='height:100%; width:100%;'>
												<font size='2'><b>$short_title - Rs. $prod_marketprice</b></font><br><br>
											</div>
										</span>
									</a>
									</div>
								</center>
								<div class='modal fade' id='purchase_modal$prod_id' tabindex='-1' role='dialog' aria-labelledby='purchase_modal".$prod_id."Label'>
								  <div class='modal-dialog modal-lg' role='document'>
									<div class='modal-content'>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										<span class='modal-title' align='center' id='purchase_modal".$prod_id."Label'>
											<center>
												<font size='3'><b>Sorry, you do not have enough money in your account to buy the $prod_name.</b></font>
											</center>
										</span>
									  </div>
									</div>
								  </div>
								</div>
							";
						}
					}
					else
					{
						echo "
							<center>
								<div class='col-md-3 hrwhite'>
								<a data-toggle='modal' href='#login-login-modal'>
									<span data-toggle='tooltip' title='$prod_name'>
										<div class=''>
											<img src='$image_link' style='height:100%;width:100%;'>
											<font size='2'><b>$short_title - Rs. $prod_marketprice</b></font><br><br>
										</div>
									</span>
								</a>
								</div>
							</center>
						";
					}
				}
			?>
	</div>
	<script>
		function complete_recharge(prod_id)
		{
			$("#submit_recharge"+prod_id).hide();
	        $("#phone_no"+prod_id).prop('disabled', true);

			var user_phno = document.getElementById("phone_no"+prod_id).value;
			$.ajax(
	          {
	            url: "<?php echo $g_url;?>market/rechargebackend.php",
	            dataType: "json",
	            type:"POST",
	            async: false,

	            data:
	            {
	              mode:'complete_recharge',
	              prod_id: prod_id,
	              user_phno: user_phno,
	            },

	            success: function(json)
	            {
	              if(json.status==1)
	              {	
	               	$("#recharge_notify"+prod_id).html("<center><font size='4' color='green'><i class='fa fa-check-circle' aria-hidden='true'></i> <b>Recharge Successful</b></center>");
	               	$("#user_points").html(Math.floor(json.user_points*100)/100);
	              }
	              else if(json.status==-1)
	              {
	              	$("#recharge_notify"+prod_id).html("<center><font size='4' color='orange'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>"+json.msg+"</b></center>");
	              	$("#phone_no"+prod_id).prop('disabled', false);
	              	$("#submit_recharge"+prod_id).show();
	              }
	              else
	              {
	                //console.log('Hi');
	              }
	            },
	            
	            error : function()
	            {
	            //console.log("something went wrong");
	            }
	          });
			}
	</script>
	</div>
	<div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
	</div>
</body>
<?php include ("../inc/footer.inc.php"); ?>	