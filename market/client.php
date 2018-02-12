<?php include ("../inc/extuser.inc.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}

if(isset($_GET['client']))
{
	$client = mysqli_real_escape_string($con,$_GET['client']);
	$query = "SELECT * FROM market_clients WHERE client_name='$client'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$client_display = $get['client_display'];
}
?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> <?php echo $client_display;?> - Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<?php include ("header.inc.php"); ?>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8">
		<div style='background:rgba(0,0,0,0.6)'><hr><h4 align='center'><?php echo $client_display;?></h4><hr></div>
			<?php 
				$getposts = mysqli_query($con,"SELECT * FROM zufal_products WHERE client = '$client' ORDER BY RAND()");
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
							if($is_coupon == 1)
							{
								echo "
									<center>
										<div class='col-md-4 hrwhite'>
										<a data-toggle='modal' href='#purchase_modal$prod_id'>
											<span data-toggle='tooltip' title='$prod_name - $discount_description'>
												<div class='thumbnail'>
													<img src='$image_link' style='height:100%;width:100%;'>
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
											<h4 class='modal-title' align='center' id='purchase_modal".$prod_id."Label'>$prod_name</h4>
										  </div>
										  <div class='modal-body row'>
											<div class='col-md-6'>
												<p>
												<b>$prod_name - $client_display</b><br><br>
												Terms & Conditions:<br>
													<ul>
														$prod_details
													</ul>
												</p>
											</div>
											<div class='col-md-6'>
												<form class='' action='getcoupon.php' method='POST'>
													<center>
													<div class='row'>
														<img src='$image_link' style='height:100%;width:80%;'>
													</div>
													<br>
													<button class='btn btn-primary btn-flat' type='submit' value='Add'><b>Get for $prod_zufalprice Zufals</b></button>
													<input name='prodid' value='$prod_id' hidden>
													</center>
												</form>
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
										<div class='col-md-4 hrwhite'>
										<a data-toggle='modal' href='#purchase_modal$prod_id'>
											<span data-toggle='tooltip' title='$prod_name - $discount_description'>
												<div class='thumbnail'>
													<img src='$image_link' style='height:165px;width:".$width."px;'>
													<div style='background: rgba(0,0,0,0.8);'>
														<font size='2'>$short_title - Rs. $prod_marketprice</font> 
													</div>
													<font size='2'>$discount_description</font>
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
												<p>
												<b>$prod_name - $client_display</b><br><br>
												Terms & Conditions:<br>
													<ul>
														$prod_details
													</ul>
												</p>
											</div>
											<div class='col-md-6'>
												<form class='' action='getcoupon.php' method='POST'>
													<center>
													<div class='row'>
														<img src='$image_link' style='height:100%;width:80%;'>
													</div>
													<br>
													<button class='btn btn-primary btn-flat' type='submit' value='Add'><b>Get for $prod_zufalprice Zufals</b></button>
													<input name='prodid' value='$prod_id' hidden>
													</center>
												</form>
											</div>
										  </div>
										</div>
									  </div>
									</div>
								";
							}
						}
						else
						{
							if($is_coupon == 1)
							{
								echo "
									<center>
										<div class='col-md-4 hrwhite'>
										<a data-toggle='modal' href='#purchase_modal$prod_id'>
											<span data-toggle='tooltip' title='$prod_name - $discount_description'>
												<div class='thumbnail'>
													<img src='$image_link' style='height:100%;width:100%;'>
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
													<font size='3'><b>Sorry, you do not have enough Zufals in your account to buy the $prod_name.</b></font>
												</center>
											</span>
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
										<div class='col-md-4 hrwhite'>
										<a data-toggle='modal' href='#purchase_modal$prod_id'>
											<span data-toggle='tooltip' title='$prod_name - $discount_description'>
												<div class='thumbnail'>
													<img src='$image_link' style='height:165px;width:".$width."px;'>
													<div style='background: rgba(0,0,0,0.8);'>
														<font size='2'>$short_title - Rs. $prod_marketprice</font> 
													</div>
													<font size='2'>$discount_description</font>
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
													<font size='3'><b>Sorry, you do not have enough Zufals in your account to buy the $prod_name.</b></font>
												</center>
											</span>
										  </div>
										</div>
									  </div>
									</div>
										";
							}
						}
					}
					else
					{
						if($is_coupon == 1)
						{
							echo "
								<center>
									<div class='col-md-4 hrwhite'>
									<a data-toggle='modal' href='#login-login-modal'>
										<span data-toggle='tooltip' title='$prod_name - $discount_description'>
											<div class='thumbnail'>
												<img src='$image_link' style='height:100%;width:100%;'>
											</div>
										</span>
									</a>
									</div>
								</center>
									";
						}
						else
						{
							echo "
								<center>
									<div class='col-md-4 hrwhite'>
									<a data-toggle='modal' href='#login-login-modal'>
										<span data-toggle='tooltip' title='$prod_name - $discount_description'>
											<div class='thumbnail'>
												<img src='$image_link' style='height:165px;width:".$width."px;'>
												<div style='background: rgba(0,0,0,0.8);'>
													<font size='2'>$short_title - Rs. $prod_marketprice</font> 
												</div>
												<font size='2'>$discount_description</font>
											</div>
										</span>
									</a>
									</div>
								</center>
									";
						}
					}
				}
			?>
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