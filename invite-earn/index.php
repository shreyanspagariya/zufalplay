<?php include ("../inc/header.inc.php"); ?>
<?php
top_banner();

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if(isset($_SESSION["email1"]))
{
	$gameweek = 0;
	$campaign_id = generateRandomString();

	$query = "SELECT * FROM campaign_leaderboard WHERE user_email='$email'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	if($numResults>0)
	{
		$campaign_id = $get['campaign_id'];
	}

	$query = "SELECT * FROM campaign_leaderboard WHERE user_email='$email' AND game_week='$gameweek'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);

	if($numResults == 0)
	{
		mysqli_query($con,"INSERT INTO campaign_leaderboard (user_email,campaign_id,game_week) VALUES ('$email','$campaign_id','$gameweek')");
	}
}

?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Invite & Earn - Zufalplay</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="zfp-inner">
	<div class="">
		<div class="col-md-2">
			<?php include ("../inc/sidebar.inc.php"); ?>
	    </div>
		<div class="col-md-8">
		<div class="hrwhite">
		    <center>
			<?php
				$query = "SELECT * from campaign_leaderboard WHERE game_week='$gameweek' AND user_email='$email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$campaign_id = $get['campaign_id'];
			?>
			<br><b>Everytime an individual Signs Up on Zufalplay using the below link, your account will credit <font size='4'>Rs. 2.00</font></b><br><br>
			<input type='text' class='elevatewhite' value='<?php echo $g_url;?>?campaign_id=<?php echo $campaign_id; ?>' style="width: 70%; text-align:center" readonly></input>&nbsp;&nbsp;
			</center>
			<br>
			<center><h3>Leaderboard - Invite & Earn</h3><hr></center>
			<div class="table-responsive elevatewhite">
			  <table class="table table-bordered table-condensed">
				<thead>
				<tr>
				  <th>#</th>
				  <th>User</th>
				  <th>Invitees</th>
				  <th>Rupees Earned</th>
				</tr>
			  </thead>
			  <tbody>
				<?php
				$getposts = mysqli_query($con,"SELECT * FROM campaign_leaderboard WHERE game_week='$gameweek'");
				$totalpoints=100;
				$total_signups = 0;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$signups = $row['signups'];
					$total_signups = $total_signups + $signups;
				}
				$getposts = mysqli_query($con,"SELECT * FROM campaign_leaderboard WHERE game_week='$gameweek' ORDER BY signups DESC LIMIT 50");
				$x=1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$user_email = $row['user_email'];
					$query = "SELECT * from table2 where email='$user_email'";
					$result = mysqli_query($con,$query);
					$get = mysqli_fetch_assoc($result);
					$idx = $get['Id'];
					$fnamex = $get['fname'];
					$lnamex = $get['lname'];
					$signups = $row['signups'];
					$rupees_earned = $row['rupees_earned'];
					echo "<tr>
					<td>$x</td>
					<td><a href=".$g_url."profile.php?u=$idx target='_blank'>$fnamex $lnamex</td>
					<td>$signups</td>
					<td>Rs. $rupees_earned</td>
					</tr>
					";
					$x++;
				}
				?>
				</tbody>
			</table>
			</div>
		</div>
		</div>
<div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
	</div>
</body>
<?php include ("../inc/footer.inc.php"); ?>