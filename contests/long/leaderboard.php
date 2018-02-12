<?php include ("../../inc/header.inc.php"); 
include ("updateovleader.php");

top_banner();

if(isset($_GET['u']))
{
	$gameweeku = $_GET['u'];

	$start = 11;
	$end = 15;

	update_all_leaderboards($con,$start,$end,$gameweeku);
}
?>

<style>
.pushup {
	margin-top:-8px;
}
</style>

<div class="pushup">
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10">
  <div class="">
  	<div class="col-md-1"></div>
  	<div class="">
    	<ul class="nav navbar-nav">
        <li><a href="<?php echo $g_url."contests/long/gaming-woche-$gameweeku"; ?>">Contest Arena</a></li>
      </ul>
  	</div>
  </div>
</footer> 
</div>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Overall Leaderboard - Gaming Woche 2 | Zufalplay</title>
</head>
<body class="zfp-inner">
	<br>
	<div class="">
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
			<br><center><h3>Leaderboard - Gaming Woche <?php echo $gameweeku;?></h3><hr></center>
			<div class="table-responsive elevatewhite">
			  <table class="table table-bordered table-condensed">
				<thead class="tablehead">
				<tr>
				  <td>#</td>
				  <td><center>User</center></td>
				  <td><center>Earnings (Rs.)</center></td>
				  <?php

				  	for($game_id = $start; $game_id <= $end; $game_id++)
					{
						$getposts = mysqli_query($con,"SELECT * FROM games WHERE game_id='$game_id'");
						while($row = mysqli_fetch_assoc($getposts))
						{
							$game_display = $row['game_display'];
							$game_link = $row['game_link'];
							
							echo"<td><center>$game_display</center></td>";
						}
					}

				  ?>
				</tr>
			  </thead>
			  <tbody>
				<?php
					$x=1;
					$getposts1 = mysqli_query($con,"SELECT * FROM long_contest_leaderboard WHERE contest_id='$gameweeku' ORDER BY rupees_earned DESC");
					while($row1 = mysqli_fetch_assoc($getposts1))
					{
						$user = $row1['user'];
						$rupees_earned = number_format(floor($row1['rupees_earned']*100)/100,2,'.','');

						if($rupees_earned > 0)
						{
							$sign="+";
						}
						else
						{
							$sign="";
						}

						$query = "SELECT * from table2 where email='$user'";
						$result = mysqli_query($con,$query);
						$get = mysqli_fetch_assoc($result);
						$idx = $get['Id'];
						$fnamex = $get['fname'];
						$lnamex = $get['lname'];

						if($x%2==0)
						{
						  	echo "<tr style='background-color:#D8D8D8'>
							<td>$x</td>
							<td><center><a href=".$g_url."profile.php?u=$idx target='_blank'>$fnamex $lnamex</center></td>
							<td><center><b class='number'>$sign$rupees_earned</b></center></td>";
						}
						else
						{
							echo "<tr style='background-color:#FFFFFF'>
							<td>$x</td>
							<td><center><a href=".$g_url."profile.php?u=$idx target='_blank'>$fnamex $lnamex</center></td>
							<td><center><b class='number'>$sign$rupees_earned</b></center></td>";
						}

					  	for($game_id = $start; $game_id <= $end; $game_id++)
						{
							$rupees_earned_game = 0;
							$high_score = 0;
							$query = "SELECT * from game_leaderboard WHERE game_week=0 AND game_id='$game_id' AND is_competition='1' AND user='$user'";
							$result = mysqli_query($con,$query);
							$get = mysqli_fetch_assoc($result);
							$high_score = number_format($get['high_score']);
							$rupees_earned_game = number_format(floor($get['rupees_earned']*100)/100,2,'.','');

							if($rupees_earned_game > 0)
							{
								$sign_game="+";
							}
							else
							{
								$sign_game="";
							}

							echo"
							<td><center><b>$high_score</b><br><font size='2'>$sign_game$rupees_earned_game</font></center></td>
							";
						}
						echo"</tr>";
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

<?php include ("../../inc/footer.inc.php"); ?>