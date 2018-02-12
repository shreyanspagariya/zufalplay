<?php include ("../inc/header.inc.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}
?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Redeemed Coupons - Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<?php include ("header.inc.php"); ?>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8">
		<div style='background:rgba(0,0,0,0.6)'><hr><h4 align='center'>Redeemed Coupons</h4><hr></div>
		<center>
		<div class="table-responsive">
			<table class="table table-zfp table-bordered">
				<thead>
			        <tr>
					  <th><center>#</center></th>
					  <th><center>Coupon Code</center></th>
					  <th><center>Product</center></th>
					  <th><center>Terms & Conditions</center></th>
			          <th><center>Coupon Discount</center></th>
					  <th><center>Coupon Client</center></th>
			        </tr>
			    </thead>
			    <tbody>
					<?php
						$sl_no = 0;
						$getposts = mysqli_query($con,"SELECT * FROM coupons C, zufal_products Z, market_clients M WHERE C.user_assigned_to = '$email' AND C.is_assigned='1' AND C.client = M.client_name AND Z.prod_id = C.prod_id ORDER BY C.time_assigned DESC");
						while($row = mysqli_fetch_assoc($getposts))
						{
							$sl_no++;
							$coupon_code = $row['coupon_code'];
							$prod_name = $row['prod_name'];
							$prod_details = $row['prod_details'];
							$discount_description = $row['discount_description'];
							$client_display = $row['client_display'];
							$discount = $row['discount'];
							echo "
							<tr>
								<td><center>$sl_no</center></td>
								<td><center>$coupon_code</center></td>
								<td><center>$prod_name</center></td>
								<td>$prod_details</td>
								<td><center>$discount%</center></td>
								<td><center>$client_display</center></td>
							</tr>
							";
						}
					?>
				</tbody>
	    </center>
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