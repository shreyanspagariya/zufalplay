<?php include ("../inc/extuser.inc.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}

if(isset($_GET['type']))
{
	$type = mysqli_real_escape_string($con,$_GET['type']);
	$query = "SELECT * FROM market_type WHERE type_name='$type'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$type_display = $get['type_display'];
}
?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> <?php echo $type_display;?> - Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<?php include ("header.inc.php"); ?>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8">
		<div style='background:rgba(0,0,0,0.6)'><hr><h4 align='center'><?php echo $type_display;?></h4><hr></div>
		<center>
			<?php
				$getposts = mysqli_query($con,"SELECT * FROM market_clients WHERE client_type = '$type' ORDER BY RAND()");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$client = $row['client_name'];
					$title = $row['client_display'];
					$image_link = $row['image_link'];
					$location = $row['client_location'];
					$short_title = substr($title,0,20);

					echo "
						<div class='col-md-4 hrwhite'>
							<a href=$g_url"."market/client.php?client="."$client data-toggle='tooltip' title='$title'>
								<div class='thumbnail'>
									<img src='$image_link' style='height:165px;width:300px;'>
									<div style='background: rgba(0,0,0,0.8);'>
										<font size='1'>Discount Coupons</font>
									</div>
									<font size='2'>$title</font>
								</div>
							</a>
						</div>
					";
				}
			?>
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