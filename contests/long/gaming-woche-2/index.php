<?php include ("../../../inc/header.inc.php"); 

include ("../updateovleader.php");
  top_banner();

   	$gameweeku = 2;

	$start = 11;
	$end = 15;

	update_all_leaderboards($con,$start,$end,$gameweeku);
?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Gaming Woche 2 - Zufalplay</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php
	$query = "SELECT * from long_contest_manager";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$contest_end_time = strtotime($get['contest_end_time']);
	$contest_status = $get['contest_status'];

	date_default_timezone_set("Asia/Kolkata");
	$curr_time = time();

	$time_left = $contest_end_time - $curr_time;
?>
<body class="zfp-inner">
	<div class="container">
		<h2 align="center">Gaming Woche 2</h2><hr>
		<div class='col-md-8'>
			 <center><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<ins class="adsbygoogle"
			     style="display:inline-block;width:728px;height:90px"
			     data-ad-client="ca-pub-7888738492112143"
			     data-ad-slot="8311271319"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script></center>
			 <center><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<ins class="adsbygoogle"
			     style="display:inline-block;width:728px;height:90px"
			     data-ad-client="ca-pub-7888738492112143"
			     data-ad-slot="8311271319"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script></center><br>
			<div class="table-responsive elevatewhite hrwhite">
				<table class="table">
					<thead class="tablehead">
				        <tr>
						  <td><center>#</center></td>
				          <td><center>Game</center></td>
				          <td><center>Game Code</center></td>
						  <td><center>Games Played</center></td>
				        </tr>
				    </thead>
				    <tbody>
						<?php
							$x = 0;
							$getposts = mysqli_query($con,"SELECT * FROM games WHERE game_id >= 11 AND game_id <= 15");
							while($row = mysqli_fetch_assoc($getposts))
							{
								$x++;
								$game_display = $row['game_display'];
								$game_link = $row['game_link'];
								$game_gif = $row['game_gif'];
								$max_score = number_format($row['max_score']);
								$max_zufals = $row['max_zufals'];
								$gif_height_percent = $row['gif_height_percent'];
								$gif_width_percent = $row['gif_width_percent'];
								$game_id = $row['game_id'];
								$game_code = $row['game_code'];

								$query = "SELECT * from game_playhistory WHERE game_id='$game_id'";
								$result = mysqli_query($con,$query);
								$currmatches = number_format(mysqli_num_rows($result));

								if($x%2==0)
								{
									echo"
										<tr style='background-color: #D8D8D8'>
											<td><center>$x</center></td>
											<td><a href=$g_url".$game_link."><center><b>$game_display</b></center></a></td>
											<td><center>$game_code</center></td>
											<td><center>$currmatches</center></td>
										</tr>
										</div>
									</div>
									";
								}
								else
								{
									echo"<a href=$g_url".$game_link.">
										<tr style='background-color: #FFFFFF'>
											<td><center>$x</center></td>
											<td><a href=$g_url".$game_link."><center><b>$game_display</b></center></a></td>
											<td><center>$game_code</center></td>
											<td><center>$currmatches</center></td>
										</tr>
										</a>
										</div>
									</div>
									";
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<hr>
			<div class="table-responsive elevatewhite hrwhite">
				<table class="table">
					<thead>
						<tr><th>
							<center><h4><b>Contest Rules</b></h4></center>
						</th></tr>
					</thead>
					<tbody>
					<tr><td>
					<p>
						<ul>
							<li>All games are open for the entire 100 hours of the contest.</li> <br>

							<li>Each game has a unique, independent leaderboard (rankings are based only on high score). </li><br>

							<li>There is no limit to the number of games you can play.</li><br>
							
							<li>Earnings: The leaderboard of each game comprises of an "Earnings" column. This tells you the amount (in Rs.) that will be restored to your account if the contest result is to be declared immediately and uniquely for this particular game.</li> <br>
							<li>As more and more users register and participate in the Gaming Woche, your earnings get updated in real time.</li><br>

							<center><font><b>The overall rankings and distribution of money (at the end of the Gaming Woche), however, will be according to the combined earnings of all 5 games of this contest.</b></font></center>
						</ul>
					</p>
					<br>
					<div style='padding-left:30px'> 
						<i>Play The Chance,<br>Best Wishes,<br>Team Zufalplay.</i>
					</div>
					</td></tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class='col-md-4'>
			<div class='elevatewhite' style="padding:10px;">
				<center>
				<div class='hrwhite' align='center'>
					<font size="4"><b><!--<span id='time'></span>-->Contest has ended. <font color='green'>Results Declared</font></b></font>
				</div>
				<font size="2">All changes to the leaderboard after the end of the contest are due to virtual participation.</font>
				<br>
				</center>
			</div>
			<script>
			function startTimer(duration, display) {
			    var timer = duration, minutes, seconds;
			    setInterval(function () {
			    	hours = parseInt(timer / 3600, 10);
			        minutes = parseInt(timer / 60 - hours*60, 10);
			        seconds = parseInt(timer % 60, 10);

			        hours = hours < 10 ? "0" + hours : hours;
			        minutes = minutes < 10 ? "0" + minutes : minutes;
			        seconds = seconds < 10 ? "0" + seconds : seconds;

			        display.html(hours + " <font size='4'>hrs</font>&nbsp; " + minutes + " <font size='4'>min</font>&nbsp; " + seconds + " <font size='4'>sec</font>");

			        if (--timer < 0) 
			        {
			        	display.text("00" + ":" + "00" + ":" + "00");
			            timer = duration;
			        }
			        if(timer == 0)
			        {
			        	location.reload();
			        }
			    }, 1000);
			}

			jQuery(function ($) {
			    var fiveMinutes = "<?php echo $time_left; ?>",
			        display = $('#time');
			    startTimer(fiveMinutes, display);
			});
			</script>
			<br>
			<div class='elevatewhite'>
				<center>
				<div class='hrwhite' align='center'>
				<a href="../leaderboard.php?u=2"><font size="-3"><b><u>View Overall Leaderboard</u></b></font></a>
				<h4><strong>Leaders</strong></h4>
					<div>
					   <div class="table-responsive">
						  <table class="table table-condensed">
							<thead class='tablehead'>
							<tr>
							  <td><center>Rank</center></td>
							  <td><center>User</center></td>
							  <td><center>Earnings (Rs.)</center></td>
							</tr>
							</thead>
						  <tbody>
						 	<?php
								$x=1;
								$getposts1 = mysqli_query($con,"SELECT * FROM long_contest_leaderboard ORDER BY rupees_earned DESC LIMIT 10");
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
										echo "<tr style='background-color: #D8D8D8'>
										<td><center><b>$x</b></center></td>
										<td><center><b><a href=".$g_url."profile.php?u=$idx target='_blank'>$fnamex $lnamex</b></center></td>
										<td><center><b>$sign$rupees_earned</b></center></td>
										</tr>
										";
									}
									else
									{
										echo "<tr style='background-color: #FFFFFF'>
										<td><center><b>$x</b></center></td>
										<td><center><b><a href=".$g_url."profile.php?u=$idx target='_blank'>$fnamex $lnamex</b></center></td>
										<td><center><b>$sign$rupees_earned</b></center></td>
										</tr>
										";
									}
									$x++;
								}
							?>
						  </tbody>
						</table>
						</div>
					</div>
				</div>
				</center>
			</div>
			<br>
			<div class='elevatewhite' style='padding-top:5px;'>
				<center>
				<h4><strong>Recent Activity</strong></h4>
				<div class='hrwhite' align='center'>
					<div class=''>
					   <div class="table-responsive">
						  <table class="table table-condensed">
							<thead>
							<tr>
							  <th><center>Time</center></th>
							  <th><center>User</center></th>
							  <th><center>Game</center></th>
							  <th><center>Score</center></th>
							</tr>
							</thead>
						  <tbody>
						  <?php
							$getposts = mysqli_query($con,"SELECT * FROM recent_activity WHERE (game_id>='11' AND game_id<='15') ORDER BY activity_time DESC LIMIT 15");
							while($row = mysqli_fetch_assoc($getposts))
							{
								$activity_time = time_elapsed_string($row['activity_time']);
								$user_email = $row['user_email'];
								$query = "SELECT * from table2 where email='$user_email'";
								$result = mysqli_query($con,$query);
								$get = mysqli_fetch_assoc($result);
								$idx = $get['Id'];
								$fnamex = $get['fname'];
								$lnamex = $get['lname'];
								$game_id=$row['game_id'];
								$game_score=number_format($row['game_score']);
								$game_des="";

								$query = "SELECT * from games WHERE game_id='$game_id'";
								$result = mysqli_query($con,$query);
								$get = mysqli_fetch_assoc($result);
								$game_code = $get['game_code'];
								$game_link = $get['game_link'];
								
								echo "<tr>
										<td><font size='2'><center>$activity_time</center></font></td>
										<td><center><a href=".$g_url."profile.php?u=$idx target='_blank'><font size='2'>$fnamex</font></center></td>
										<td><font size='2'><center>$game_code</font></center></td>
										<td><font size='2'><center>$game_score</font></center></td>
									 </tr>
									";
							}
						  ?>
						  </tbody>
						</table>
						</div>
					</div>
				</div>
				</center>
			</div>
		</div>

	</div>
	<br><br><br>
<?php include ("../../../inc/footer.inc.php"); ?>