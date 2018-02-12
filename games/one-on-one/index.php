<?php
include ("../../inc/extuser.inc.php"); 
 
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}
?>

<?php
$query = "SELECT * FROM placedbets";
$result = mysqli_query($con,$query);
$live_placed_bets = number_format(mysqli_num_rows($result));

$query = "SELECT * from game_playhistory WHERE game_id='2'";
$result = mysqli_query($con,$query);
$currmatches_handcricket = number_format(mysqli_num_rows($result));

?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Games | One-on-One - Zufalplay</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("../sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8">
		<center>
			<div class='elevatewhite'><hr><h4 align='center'>Games - One on One</h4><h3>Coming Soon...</h3><br></div>
			<?php
				/*$getposts = mysqli_query($con,"SELECT * FROM games WHERE (game_id!='1' AND game_id!='4') AND is_oneonone='1'");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$game_display = $row['game_display'];
					$game_link = $row['game_oneonone_link'];
					$game_gif = $row['game_gif'];
					$max_score = number_format($row['max_score']);
					$max_zufals = $row['max_zufals'];
					$gif_height_percent = $row['gif_height_percent'];
					$gif_width_percent = $row['gif_width_percent'];
					$game_id = $row['game_id'];

					$query = "SELECT * from game_playhistory WHERE game_id='$game_id'";
					$result = mysqli_query($con,$query);
					$number_games = number_format(mysqli_num_rows($result));

					if(isset($_SESSION["email1"]))
					{

						echo "
							<div class='col-md-3 hrwhite'>
								<a href=$g_url"."$game_link data-toggle='tooltip' title='$game_display'>
									<div class='thumbnail'>
										<img src=$g_url"."$game_gif style='height:$gif_height_percent%; width:$gif_width_percent%;'>

										<div style='background: rgba(0,0,0,0.8);'>
											<font size='2'>$number_games</font> 
											<font size='1'>games played</font>
										</div>
										
										<font size='2'>$game_display</font><br>
									</div>
								</a>
							</div>
						";
					}
					else
					{
						echo "
								<div class='col-md-3 hrwhite'>
									<a data-toggle='modal' href='#login-login-modal'>
										<div class='thumbnail'>
											<img src=$g_url"."$game_gif style='height:$gif_height_percent%; width:$gif_width_percent%;'>

											<div style='background: rgba(0,0,0,0.8);'>
												<font size='2'>$number_games</font> 
												<font size='1'>games played</font>
											</div>
											
											<font size='2'>$game_display</font><br>
										</div>
									</a>
								</div>
							";
					}
				}*/
			?>
		</center>
	</div>
	<div class="col-md-2">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="ca-pub-7888738492112143"
		     data-ad-slot="1322728114"
		     data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>
</body>
<br>
<?php include ("../../inc/footer.inc.php"); ?>						
