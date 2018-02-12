<?php 
/*Including Master Header*/
include ("./inc/header.inc.php"); 

/*Only Admins can access this page*/
if(!($email == "shreyanspagariya@gmail.com"))		
{
	header("Location: ".$g_url);
}
?>

<?php 
	/*This function has been defined in Master Header*/
	top_banner();	
?>

<head>
	<title>Admin Panel - Zufalplay</title>
</head>

<body class="zfp-inner">
<div class="container">
<div align="center">
	<h2>Admin Panel</h2><hr>
	<?php

		date_default_timezone_set("Asia/Kolkata");
		$datetime = date("Y-m-d H:i:sa");
		$curr_time = time();

		$query = "SELECT * FROM prod_orders WHERE order_id>180 AND is_complete='1'";
		$result = mysqli_query($con,$query);
		$numcoupons = mysqli_num_rows($result);

		$query = "SELECT * FROM prod_orders WHERE order_id>180 AND is_complete='0'";
		$result = mysqli_query($con,$query);
		$num_pending_recharges = mysqli_num_rows($result);

		$numUsers_online = 0;
		$getnotifs = mysqli_query($con,"SELECT * FROM table2");
		while($notifrow = mysqli_fetch_assoc($getnotifs))
		{
			$users_map[$notifrow["email"]] = "NotCounted";

			$last_login = strtotime($notifrow['last_login']);

			$time_diff_sec = $curr_time - $last_login;

			if($time_diff_sec<=60)
			{
				$numUsers_online++;
			}
		}

		$users_map[""] = "NotCounted";
		$dailyActive_users = 0;
		$getposts = mysqli_query($con,"SELECT * FROM login_details ORDER BY login_time DESC");
		while($row = mysqli_fetch_assoc($getposts))
		{
			$last_login = strtotime($row['login_time']);

			$time_diff_sec = $curr_time - $last_login;

			if($time_diff_sec>60*60*24)
			{
				break;
			}
			else
			{
				if(isset($users_map[strtolower($row["user_email"])]) && $users_map[strtolower($row["user_email"])] != "Counted")
				{
					$dailyActive_users++;
					$users_map[strtolower($row["user_email"])] = "Counted";
				}
			}
		}

		/*
		$videos_sec = 0;
		$videos_count = 0;
		$getnotifs = mysqli_query($con,"SELECT * FROM videos_watch_history WHERE is_complete='1' AND time_started > '2016-05-13 00:00:00'");
		while($row = mysqli_fetch_assoc($getnotifs))
		{
			$video_unique_code = $row["video_unique_code"];

			$query = "SELECT * FROM videos WHERE unique_code='$video_unique_code'";
			$result = mysqli_query($con,$query);
			$get = mysqli_fetch_assoc($result);
			$time_sec_length = $get['time_sec_length'];

			if($time_sec_length > 10)
			{
				$videos_sec = $videos_sec + $time_sec_length;
				$videos_count = $videos_count + 1;
			}
		}
		$videos_count = number_format($videos_count);

		$games_sec = 0;
		$games_count = 0;
		$getnotifs = mysqli_query($con,"SELECT * FROM game_playhistory WHERE isout='1' AND time_played > '2016-05-13 00:00:00'");
		while($row = mysqli_fetch_assoc($getnotifs))
		{
			$play_end_time = $row["play_end_time"];
			$time_played = $row["time_played"];

			if($play_end_time < $time_played)
			{
				$games_sec = $games_sec + 60;
			}
			else
			{
				$games_sec = $games_sec + strtotime($play_end_time) - strtotime($time_played);
				
			}
			$games_count = $games_count + 1;
		}
		$games_count = number_format($games_count);

		$query = "SELECT * FROM videos_author_genre WHERE is_genre_assigned='0' AND genre='other'";
		$result = mysqli_query($con,$query);
		$num_pending_authors_tobe_assigned = mysqli_num_rows($result);

		$query = "SELECT * FROM videos_author_genre WHERE is_genre_assigned='0' AND genre='other' ORDER BY RAND() LIMIT 1";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$author_url = $get['author'];
		*/
	?>

	<!--
	<div class="row">
		<div class="elevatewhite" style="padding:10px;">
			<h4>Pending Authors <b>(<?php echo $num_pending_authors_tobe_assigned;?>)</b> - Next in Queue</h4>(Reload page to change author.)<br><br>
			<a href="<?php echo $author_url;?>" target='_blank'><?php echo $author_url;?></a><br><br>
			<form action="videos/backend/assigngenre.php" method="POST">
				<?php
					/*
					$getgenre = mysqli_query($con,"SELECT * FROM videos_genre");
					while($genrerow = mysqli_fetch_assoc($getgenre))
					{
						$genre_name = $genrerow["genre_name"];
						$genre_display = $genrerow["genre_display"];
						echo "<input type='radio' name='genre_name' value=".$genre_name."> ".$genre_display."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					}
					*/
				?>
				<br><br>
				<input name='author_url' value='<?php echo $author_url;?>' hidden>
				<button type="submit">Finalize</button>
			</form>
		</div>
	</div>
	<hr>
	-->
	<div class='row'>
		<!--<div class="col-md-3">
			<div class='elevatewhite'>
				<span style='font-size:64px;'><b><?php echo $numcoupons;?></b></span><br><h4>successful recharges.</h4><br> 
			</div>--> 
			<!--
			<br><br>
			<div class='elevatewhite' style='padding-top:5px; padding-bottom:10px;'>
				<span style='font-size:32px;'><b><?php echo floor($videos_sec/36)/100?></b></span> Hours<br> spent watching <br><span style='font-size:25px;'><b><?php echo $videos_count;?></b></span> videos.
			</div> 
			-->
		<!--</div>-->
		<div class="col-md-3">
			<div class='elevatewhite'>
				<span style='font-size:64px;'><b><?php echo $dailyActive_users;?></b></span><br><h4>daily active users.</h4><br> 
			</div> 
			<!--
			<br><br>
			<div class='elevatewhite' style='padding-top:5px; padding-bottom:10px;'>
				<span style='font-size:32px;'><b><?php echo floor($games_sec/36)/100;?></b></span> Hours<br> spent playing <br><span style='font-size:25px;'><b><?php echo $games_count;?></b></span>  games.
			</div> 
			-->
		</div>
		<div class="col-md-3">
			<div class='elevatewhite'>
				<span style='font-size:64px;'><b><?php echo $numUsers_online;?></b></span><br><h4>users online.</h4><br> 
			</div> 
			<!--
			<br><br>
			<div class='elevatewhite' style='padding-top:5px; padding-bottom:10px;'>
				<span style='font-size:32px;'><b><?php echo floor($games_sec/36)/100;?></b></span> Hours<br> spent playing <br><span style='font-size:25px;'><b><?php echo $games_count;?></b></span>  games.
			</div> 
			-->
		</div>
		<div class="col-md-6">
			<div class='elevatewhite'>
				<center>
				<div class='hrwhite' align='center'>
					<div class=''>
					   <div class="table-responsive">
						  	<table class="table table-condensed">
								<thead>
									<tr>
								  		<th><center>Online Users</center></th>
									</tr>
								</thead>
						  		<tbody>
						  		<?php
									$getnotifs = mysqli_query($con,"SELECT * FROM table2");
									while($notifrow = mysqli_fetch_assoc($getnotifs))
									{
										$last_login = strtotime($notifrow['last_login']);

										$time_diff_sec = $curr_time - $last_login;

										if($time_diff_sec<=60)
										{
											$fnamex = $notifrow['fname'];
											$lnamex = $notifrow['lname'];
											$namex = $fnamex." ".$lnamex;
											$idx = $notifrow['Id'];
											echo "
											<tr><td><a href=".$g_url."profile.php?u=$idx target='_blank'><font size='2'>$namex</font></td></tr>
											";
										}
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
	<hr>
	<div class="col-md-8">
		<div class='elevatewhite'><hr><h4 align='center'>Pending Recharges <b>(<?php echo $num_pending_recharges;?>)</b></h4><hr></div>
		<center>
		<div class="table-responsive elevatewhite hrwhite">
			<table class="table table-bordered">
				<thead>
			        <tr class=''>
			          <th><center>Sl.no.</center></th>
					  <th><center>Request Time</center></th>
					  <th><center>User</center></th>
					  <th><center>Mobile No.</center></th>
					  <th><center>Rs.</center></th>
					  <th><center>Success</center></th>
					  <th><center>Fail</center></th>
			        </tr>
			    </thead>
			    <tbody>
					<?php
						$sl_no = 0;
						$getposts = mysqli_query($con,"SELECT * FROM prod_orders WHERE order_id>180 AND is_complete='0' ORDER BY order_id DESC");
						while($row = mysqli_fetch_assoc($getposts))
						{
							$sl_no++;
							$time_bought = time_elapsed_string($row["time_bought"]);
							$user_email = $row['user_email'];
							$user_phno = $row["user_phno"];
							$zufal_price = $row["zufal_price"];
							$order_id = $row["order_id"];

							$query = "SELECT * from table2 where email='$user_email'";
							$result = mysqli_query($con,$query);
							$get = mysqli_fetch_assoc($result);
							$fnamex = $get['fname'];
							$lnamex = $get['lname'];
							$namex = $fnamex." ".$lnamex;
							$idx = $get['Id'];

							echo "
							<tr class=''>
								<td><center>$sl_no</center></td>
								<td><center>$time_bought</center></td>
								<td><center><a href=".$g_url."profile.php?u=$idx target='_blank'>$namex</center></td>
								<td><center>$user_phno</center></td>
								<td><center>$zufal_price</center></td>
								<td>
									<center>
										<form id='success_$order_id' action='".$g_url."market/recharge-success.php' method='POST'>
											<input id='success_$order_id' name='success_order_id' value='$order_id' hidden>
											<button type='submit' id='button_success_$order_id'>Success</button>
										</form>
									</center>
								</td>
								<td>
									<center>
										<form id='fail_$order_id' action='".$g_url."market/recharge-fail.php' method='POST'>
											<input id='fail_$order_id' name='fail_order_id' value='$order_id' hidden>
											<textarea id='fail_reason_$order_id' name='fail_reason_order_id'></textarea>
											<button type='submit' id='button_fail_$order_id'>Fail</button>
										</form>
									</center>
								</td>
							</tr>
							";
						}
					?>
				</tbody>
			</table>
		</div><hr>
		<div class='elevatewhite'><hr><h4 align='center'>Login History</h4><hr></div>
		<center>
		<div class="table-responsive elevatewhite">
			<table class="table table-bordered">
				<thead>
			        <tr>
			          <th>User</th>
					  <th>Login Time</th>
					  <th>IP Address</th>
			          <th><center>Login Type</center></th>
			        </tr>
			    </thead>
			    <tbody>
					<?php
						$sl_no = 0;
						$getposts = mysqli_query($con,"SELECT * FROM login_details ORDER BY login_time DESC LIMIT 30");
						while($row = mysqli_fetch_assoc($getposts))
						{
							$sl_no++;

							$user_email = $row['user_email'];
							$user_name = $row['user_name'];
							$login_time = time_elapsed_string($row['login_time']);
							$login_type = $row['login_type'];
							$ip_address = $row['ip_address'];

							if($user_email!="")
							{
								echo "
								<tr>
									<td>$user_name</td>
									<td>$login_time</td>
									<td>$ip_address</td>
									<td><center>$login_type</center></td>
								</tr>
								";
							}
						}
					?>
				</tbody>
			</table>
		</div>
	    </center>
	    <div class='elevatewhite'><hr><h4 align='center'>Successful Recharges</b></h4><hr></div>
		<center>
		<div class="table-responsive elevatewhite hrwhite">
			<table class="table table-bordered">
				<thead>
			        <tr class=''>
			          <th><center>Sl.no.</center></th>
					  <th><center>Request Time</center></th>
					  <th><center>User</center></th>
					  <th><center>Mobile No.</center></th>
					  <th><center>Rs.</center></th>
			        </tr>
			    </thead>
			    <tbody>
					<?php
						$sl_no = 0;
						$getposts = mysqli_query($con,"SELECT * FROM prod_orders WHERE order_id>180 AND is_complete='1' ORDER BY order_id DESC LIMIT 10");
						while($row = mysqli_fetch_assoc($getposts))
						{
							$sl_no++;
							$time_bought = time_elapsed_string($row["time_bought"]);
							$user_email = $row['user_email'];
							$user_phno = $row["user_phno"];
							$zufal_price = $row["zufal_price"];

							$query = "SELECT * from table2 where email='$user_email'";
							$result = mysqli_query($con,$query);
							$get = mysqli_fetch_assoc($result);
							$fnamex = $get['fname'];
							$lnamex = $get['lname'];
							$namex = $fnamex." ".$lnamex;
							$idx = $get['Id'];

							echo "
							<tr class=''>
								<td><center>$sl_no</center></td>
								<td><center>$time_bought</center></td>
								<td><center><a href=".$g_url."profile.php?u=$idx target='_blank'>$namex</center></td>
								<td><center>$user_phno</center></td>
								<td><center>$zufal_price</center></td>
							</tr>
							";
						}
					?>
				</tbody>
			</table>
		</div><hr>
	    </center>
	</div>
	<div class="col-md-4">
		<div class='elevatewhite' style='padding-top:10px;'>
				<center>
				<h4><strong>Recent Activity</strong></h4>
				<div class='hrwhite' align='center'>
					<div class=''>
					   <div class="table-responsive">
						  <table class="table table-condensed">
							<thead>
							<tr>
							  <th>Time</th>
							  <th>User</th>
							  <th>Game</th>
							  <th>Score</th>
							</tr>
							</thead>
						  <tbody>
						  <?php
							$getposts = mysqli_query($con,"SELECT * FROM recent_activity ORDER BY activity_time DESC LIMIT 60");
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
								$game_score=$row['game_score'];
								$game_des="";
								if($game_id==1)
								{
									$game_des="PREDCHAL";
								}
								else if($game_id==2)
								{
									$game_des="HANDCRIC";
								}
								else if($game_id==3)
								{
									$game_des="2048";
								}
								else if($game_id==102)
								{
									$game_des="HANDCRIC11";
								}
                                else if($game_id==105)
								{
									$game_des="SNAKE11";
								}
								else if($game_id==106)
								{
									$game_des="COIL11";
								}
								else if($game_id==107)
								{
									$game_des="HEXTRIS11";
								}
								else if($game_id==108)
								{
									$game_des="MARIO11";
								}
								else if($game_id==109)
								{
									$game_des="PAPAK11";
								}
								else if($game_id >=1005 && $game_id <= 2000)
								{
									$game_game_id = $game_id - 1000;

									$query = "SELECT * from games WHERE game_id='$game_game_id'";
									$result = mysqli_query($con,$query);
									$get = mysqli_fetch_assoc($result);
									$game_code = $get['game_code'];
									$game_des = $game_code;
								}
								else if($game_id==10001)
								{
									$game_des="VIDEO";
								}

								if($fnamex=="")
								{
									$fnamex = "EXTUSER";
								}

								if($user_email!="")
								{
									echo "<tr>
										<td><font size='2'>$activity_time</font></td>
										<td><a href=".$g_url."profile.php?u=$idx target='_blank'><font size='2'>$fnamex</font></td>
										<td><font size='2'>$game_des</font></td>
										<td><font size='2'>$game_score</font></td>
									 </tr>
									";
								}
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
</div>
<script>
	function f()
	{
	 	setTimeout(function(){
	 		location.reload();
	 		f();
	 	}, 60000);
	}
	window.onload=f();
</script>
<?php include ("./inc/footer.inc.php"); ?>