<?php include ("../inc/extuser.inc.php"); 
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
if(isset($_GET['game']))
{
	$game = mysqli_real_escape_string($con,$_GET['game']);
	$query = "SELECT * from games WHERE game_name='$game'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$game_link = $get['game_link'];
	$game_display = $get['game_display'];
	$game_id = $get['game_id'];
	$gameweek = 0;
	$fb_share_link = $get['fb_share_link'];
	global $g_g_url;
	global $gameweek;
}
?>

<style>
.pushup {
	margin-top:-8px;
}
</style>
<div class="pushup">
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10; border-color: #000; border-width: 1px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
  <div class="container">
  	<div class="col-md-8">
    	<ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_url.$game_link; ?>">Play <?php echo $game_display;?></a></li>
        <li><a href="<?php echo $g_url.'games/leaderboard.php?game='.$game?>">Leaderboard</a></li>
        <li>
          <div style="margin-top:4px;">
            &nbsp;&nbsp;&nbsp;
            <div class="fb-share-button" 
              data-href="<?php echo $fb_share_link;?>" 
              data-layout="button">
            </div>
          </div>
        </li>
      </ul>
  	</div>
  </div>
</footer> 
</div>

<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> <?php echo $game_display;?> | Leaderboard - Zufalplay</title>
</head>

<body class="zfp-inner">
	<div class="">
        <br><br>
		<div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
		<div class="col-md-8">
		<div class="hrwhite">
			<center><h3>Leaderboard - <?php echo $game_display; ?></h3><hr></center>
			<div class="table-responsive elevatewhite">
			  <table class="table table-bordered table-condensed">
				<thead>
				<tr>
				  <th><center>#</center></th>
				  <th>&nbsp;User</th>
				  <th><center>High Score</center></th>
				  <th><center>Games Played</center></th>
				</tr>
			  </thead>
			  <tbody>
				<?php
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week=0 AND game_id='$game_id' AND is_competition='0' ORDER BY high_score DESC");
				$x=1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$user = $row['user'];

					$query = "SELECT * from table2 where email='$user'";
					$result = mysqli_query($con,$query);
					$get = mysqli_fetch_assoc($result);
					$idx = $get['Id'];
					$fnamex = $get['fname'];
					$lnamex = $get['lname'];

					if($game_id!=17)
					{
						$high_score = number_format($row['high_score']);
					}
					else
					{
						$high_score = $row['high_score'];
					}
					$zufals_earned = number_format($row['zufals_earned']);

					$query = "SELECT * FROM game_playhistory WHERE user_played='$user' AND game_week=0 AND game_id='$game_id' AND is_competition='0' AND isout='1' AND play_id!='TRAINGAME'";
					$result = mysqli_query($con,$query);
					$games_played = number_format(mysqli_num_rows($result));

					$sign="";
					if($zufals_earned>0)
					{
						$sign="+";
					}
					echo "<tr>
					<td><center>$x</center></td>
					<td>&nbsp;<a href=".$g_url."profile.php?u=$idx target='_blank'>$fnamex $lnamex</td>
					<td><center>$high_score</center></td>
					<td><center>$games_played</center></td>
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