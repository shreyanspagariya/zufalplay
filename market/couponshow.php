<?php include ("../inc/header.inc.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}

if(isset($_GET['cc']))
{
	if(isset($_SESSION["coupon_code"]))
	{
		$session_coupon_code = $_SESSION["coupon_code"];
	}

	$coupon_code = mysqli_real_escape_string($con,$_GET['cc']);
	$query = "SELECT * FROM coupons WHERE coupon_code = '$coupon_code'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);

	$query = "SELECT * FROM coupons C, market_clients M_C, zufal_products Z WHERE Z.prod_id = C.prod_id AND C.client = M_C.client_name AND C.coupon_code='$coupon_code'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$client_display = $get['client_display'];
	$prod_name = $get['prod_name'];
	$prod_details = $get['prod_details'];
	$order_link = $get['order_link'];
}
?>

<head>
	<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Coupon Code - Zufalplay</title>
	<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<?php include ("header.inc.php"); ?>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>

<?php
if($numResults == 0 || $coupon_code != $session_coupon_code || !isset($_SESSION["coupon_code"]))
{
	?>
	<div class="col-md-8">
		<center>
			<h2>Coupon Code</h2><hr><br>
			<h3>Something Fishy Going on here...</h3><br>
			<h4>(Unusual Activity Detected)</h4>
		</center>
	</div>
	<?php
}
else
{		
	?>
	<div class="col-md-8 hrwhite">
		<center>
			<h2>Coupon Code</h2><hr>
			<input class='trans' type='text' value='<?php echo $coupon_code;?>' style="text-align:center" readonly><br><br>
			Please note down the above coupon code and use it at the counter to avail your discount.<br><br><br>
		</center>
		<div style='background: rgba(0,0,0,0.5); padding:10px;'>
			<hr>
				<b><?php echo $prod_name;?> - <?php echo $client_display;?></b><br><br>
				<?php if($order_link!="")
				echo "
					Order <b><u><a href='$order_link' target='_blank'>Here</a></u></b><br><br>";
				?>
				Terms & Conditions:<br>
				<ul>
					<?php echo $prod_details;?>
				</ul>
			<hr>
		</div>
	</div>
	<?php
}
?>
	</body>
<?php include ("../inc/footer.inc.php"); ?>