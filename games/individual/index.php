<?php
include ("../../inc/extuser.inc.php"); 

header("Location:".$g_url."games/");
 
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
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Games | Individual - Zufalplay</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("../../inc/sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8">
		<center>
			<br>
			<div class='row'>
			<div class='col-md-3 hrwhite'>
				<a href="<?php echo $g_url.'games/predictionchallenge';?>">
					<div class=''>
						<img src='../images/predchal.png' style='height:100%;width:100%;'>
						<font size='2'><b>Prediction Challenge</b></font>
						<div style=''>
							<font size='2'><?php echo $live_placed_bets; ?></font> 
							<font size='1'>pitches</font>
						</div>
					</div>
				</a>
			</div>
			<div class='col-md-3 hrwhite'>
				<a href="<?php echo $g_url.'games/handcricket';?>">
					<div class=''>
						<img src='../images/handcricket.png' style='height:100%;width:100%;'>
						<font size='2'><b>Hand Cricket</b></font>
						<div style=''>
							<font size='2'><?php echo $currmatches_handcricket; ?></font> 
							<font size='1'>matches played</font>
						</div>
					</div>
				</a>
			</div>
			<?php
				$count = 0;
				$getposts = mysqli_query($con,"SELECT * FROM games WHERE (game_id!='1' AND game_id!='2' AND game_id!='4' AND game_id!='13')");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$count++;
					$game_display = $row['game_display'];
					$game_link = $row['game_link'];
					$game_gif = $row['game_gif'];
					$max_score = number_format($row['max_score']);
					$max_zufals = $row['max_zufals'];
					$gif_height_percent = $row['gif_height_percent'];
					$gif_width_percent = $row['gif_width_percent'];
					$game_id = $row['game_id'];

					$query = "SELECT * from game_playhistory WHERE game_id='$game_id'";
					$result = mysqli_query($con,$query);
					$currmatches = number_format(mysqli_num_rows($result));

					echo "
						<div class='col-md-3 hrwhite'>
							<a href=$g_url"."$game_link data-toggle='tooltip' title='$game_display'>
								<div class=''>
									<img src=$g_url"."$game_gif style='height:$gif_height_percent%; width:$gif_width_percent%;'>
									<font size='2'><b>$game_display</b></font>
									<div style=''>
										<font size='2'>$currmatches</font> 
										<font size='1'>games played</font>
									</div>
								</div>
							</a>
						</div>
					";
					if($count % 4 == 2)
					{
						echo"
						</div>
						<br>
						<div class='row'>
						";
					}
				}
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
