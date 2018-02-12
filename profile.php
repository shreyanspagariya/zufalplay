<?php include ("./inc/extuser.inc.php"); ?>
<?php
if(isset($_GET['u']))
{
	$userid1 = mysqli_real_escape_string($con,$_GET['u']);
	$query = "SELECT * from table2 where Id='$userid1'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	
	$unique_name = $get['unique_name'];

	header("Location: ".$g_url."profile.php?id=".$unique_name);
}
else if(isset($_GET['id']))
{
	$userid1 = mysqli_real_escape_string($con,$_GET['id']);
	$query = "SELECT * from table2 where unique_name='$userid1'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	if($numResults>=1)
	{
		$get = mysqli_fetch_assoc($result);
		$email1 = $get['email'];
		$fname = $get['fname'];
		$profile_pic_url1 = $get['google_picture_url'];
		if($profile_pic_url1=="")
		{
			$profile_pic_url1 = $get['fb_picture_url'];
			if($profile_pic_url1=="")
			{
				$profile_pic_url1="http://www.zufalplay.com/images/default_ppic.png";
			}
		}
	}
	else
	{
		echo "User does not exist !";
		exit();
	}
}

	$query = "SELECT * from table2 where email='$email1'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$fname1 = $get['fname'];
	$lname1= $get['lname'];
	$user_points1 = $get['user_points'];
	$last_login1 = $get['last_login'];
	$query = "SELECT email, fname, lname from table2 where email='$email'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$fname = $get['fname'];
	$lname= $get['lname'];
	$ongoing = 0;
	$won = 0;
	$lost = 0;
	$draw = 0;
	$getposts = mysqli_query($con,"SELECT * FROM placedbets WHERE userid_placedby = '$email1'");
	while($row = mysqli_fetch_assoc($getposts))
	{
		$bet_status5 = $row['bet_status'];
		if($bet_status5 == 0)
		{
			$ongoing = $ongoing + 1;
		}
		else if($bet_status5 == 1)
		{
			$won = $won + 1;
		}
		else if($bet_status5 == -1)
		{
			$lost = $lost + 1;
		}
	        else
	        {
	                $draw = $draw + 1;
	        }
	}
	$curr_gameweek = 0;
	$gw = 1;
    if($curr_gameweek>=7)
	{
		$zp=5;
	}
	else
	{
		$zp=10;
	}
	while($gw <= $curr_gameweek)
	{
		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gw' AND game_id='2'");
		$totalpoints=0;
		$total_high_score = 0;
		while($row = mysqli_fetch_assoc($getposts))
		{
			$totalpoints = $totalpoints + $zp;
			$high_score = $row['high_score'];
			$total_high_score = $total_high_score + $high_score;
		}
		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gw' AND user='$email1' AND game_id='2'");
		while($row = mysqli_fetch_assoc($getposts))
		{
			if($gw!=$curr_gameweek)
			{
				$high_score = $row['high_score'];
				if($total_high_score!=0)
				{
					$zufalsprofit = ($totalpoints*$high_score)/$total_high_score;
					$zufalsprofit = floor($zufalsprofit);
					$zufalsprofit = $zufalsprofit - $zp;
				}
				else
				{
					$zufalsprofit = 0;
				}
				if($zufalsprofit>0)
				{
					$sign="+";
					$won=$won+1;
				}
				else if($zufalsprofit<0)
				{
					$sign="";
					$lost=$lost+1;
				}
				else
				{
					$sign="";
					$draw=$draw+1;
				}
			}
			else if($gw==$curr_gameweek)
			{
				$ongoing=$ongoing+1;
			}
		}
		$gw++;
	}
	
	$curr_gameweek_2048 = 0;
	$gw = 1;
    if($curr_gameweek_2048>=5)
	{
		$zp=5;
	}
	else
	{
		$zp=10;
	}
	while($gw <= $curr_gameweek_2048)
	{
		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gw' AND game_id='3'");
		$totalpoints=0;
		$total_high_score = 0;
		while($row = mysqli_fetch_assoc($getposts))
		{
			$totalpoints = $totalpoints + $zp;
			$high_score = $row['high_score'];
			$total_high_score = $total_high_score + $high_score;
		}
		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gw' AND user='$email1' AND game_id='3'");
		while($row = mysqli_fetch_assoc($getposts))
		{
			if($gw!=$curr_gameweek_2048)
			{
				$high_score = $row['high_score'];
				if($total_high_score!=0)
				{
					$zufalsprofit = ($totalpoints*$high_score)/$total_high_score;
					$zufalsprofit = floor($zufalsprofit);
					$zufalsprofit = $zufalsprofit - $zp;
				}
				else
				{
					$zufalsprofit = 0;
				}
				if($zufalsprofit>0)
				{
					$sign="+";
					$won=$won+1;
				}
				else if($zufalsprofit<0)
				{
					$sign="";
					$lost=$lost+1;
				}
				else
				{
					$sign="";
					$draw=$draw+1;
				}
			}
			else if($gw==$curr_gameweek_2048)
			{
				$ongoing=$ongoing+1;
			}
		}
		$gw++;
	}

	$curr_gameweek_snake = 0;
	$gw = 1;
	while($gw <= $curr_gameweek_snake)
	{
		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gw' AND user='$email1' AND game_id='5' AND is_competition='0'");
		while($row = mysqli_fetch_assoc($getposts))
		{
			if($gw!=$curr_gameweek_snake)
			{
				
				$zufalsprofit = $row['zufals_profit'];
				if($zufalsprofit>0)
				{
					$sign="+";
					$won=$won+1;
				}
				else if($zufalsprofit<0)
				{
					$sign="";
					$lost=$lost+1;
				}
				else
				{
					$sign="";
					$draw=$draw+1;
				}
			}
			else if($gw==$curr_gameweek_snake)
			{
				$ongoing=$ongoing+1;
			}
		}
		$gw++;
	}

	$curr_gameweek_mario = 0;
	$gw = 1;
	while($gw <= $curr_gameweek_mario)
	{
		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gw' AND game_id='8' AND is_competition='0' AND user='$email1'");
		while($row = mysqli_fetch_assoc($getposts))
		{
			if($gw!=$curr_gameweek_mario)
			{
				
				$zufalsprofit = $row['zufals_profit'];
				if($zufalsprofit>0)
				{
					$sign="+";
					$won=$won+1;
				}
				else if($zufalsprofit<0)
				{
					$sign="";
					$lost=$lost+1;
				}
				else
				{
					$sign="";
					$draw=$draw+1;
				}
			}
			else if($gw==$curr_gameweek_mario)
			{
				$ongoing=$ongoing+1;
			}
		}
		$gw++;
	}

	$curr_gameweek_coil = 0;
	$gw = 1;
	while($gw <= $curr_gameweek_coil)
	{
		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gw' AND game_id='6' AND is_competition='0' AND user='$email1'");
		while($row = mysqli_fetch_assoc($getposts))
		{
			if($gw!=$curr_gameweek_coil)
			{
				
				$zufalsprofit = $row['zufals_profit'];
				if($zufalsprofit>0)
				{
					$sign="+";
					$won=$won+1;
				}
				else if($zufalsprofit<0)
				{
					$sign="";
					$lost=$lost+1;
				}
				else
				{
					$sign="";
					$draw=$draw+1;
				}
			}
			else if($gw==$curr_gameweek_coil)
			{
				$ongoing=$ongoing+1;
			}
		}
		$gw++;
	}

	$curr_gameweek_hextris = 0;
	$gw = 1;
	while($gw <= $curr_gameweek_hextris)
	{
		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gw' AND game_id='7' AND is_competition='0' AND user='$email1'");
		while($row = mysqli_fetch_assoc($getposts))
		{
			if($gw!=$curr_gameweek_hextris)
			{
				
				$zufalsprofit = $row['zufals_profit'];
				if($zufalsprofit>0)
				{
					$sign="+";
					$won=$won+1;
				}
				else if($zufalsprofit<0)
				{
					$sign="";
					$lost=$lost+1;
				}
				else
				{
					$sign="";
					$draw=$draw+1;
				}
			}
			else if($gw==$curr_gameweek_hextris)
			{
				$ongoing=$ongoing+1;
			}
		}
		$gw++;
	}

	$curr_gameweek_pappupakia = 0;
	$gw = 1;
	while($gw <= $curr_gameweek_snake)
	{
		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gw' AND game_id='9' AND is_competition='0' AND user='$email1'");
		while($row = mysqli_fetch_assoc($getposts))
		{
			if($gw!=$curr_gameweek_pappupakia)
			{
				
				$zufalsprofit = $row['zufals_profit'];
				if($zufalsprofit>0)
				{
					$sign="+";
					$won=$won+1;
				}
				else if($zufalsprofit<0)
				{
					$sign="";
					$lost=$lost+1;
				}
				else
				{
					$sign="";
					$draw=$draw+1;
				}
			}
			else if($gw==$curr_gameweek_pappupakia)
			{
				$ongoing=$ongoing+1;
			}
		}
		$gw++;
	}

	$query = "SELECT * from handcricket_oneonone WHERE (from_user_email='$email1' AND from_user_score>to_user_score) OR 
	(to_user_email='$email1' AND to_user_score>from_user_score)";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$won+=$numResults;

	$query = "SELECT * from handcricket_oneonone WHERE (from_user_email='$email1' AND from_user_score<to_user_score) OR 
	(to_user_email='$email1' AND to_user_score<from_user_score)";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$lost+=$numResults;

	$query = "SELECT * from handcricket_oneonone WHERE (from_user_email='$email1' AND from_user_score=to_user_score) OR 
	(to_user_email='$email1' AND to_user_score=from_user_score)";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$draw+=$numResults;

	$query = "SELECT * from handcricket_oneonone WHERE (from_user_email='$email1' AND challenge_status=0) OR 
	(to_user_email='$email1' AND challenge_status=0)";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$ongoing+=$numResults;
	
	if($user_points1 > 90)
	{
		$battery1 = 4;
	}
	else if($user_points1 > 60)
	{
		$battery1 = 3;
	}
	else if($user_points1 > 40)
	{
		$battery1 = 2;
	}
	else if($user_points1 > 10) 
	{
		$battery1 = 1;
	}
	else
	{
		$battery1 = 0;
	}
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
	<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> <?php echo $fname1." ".$lname1; ?> - Zufalplay</title>
</head>
<body class="zfp-inner">
	<div class="container">
       <br>
        <div class='col-md-1'></div>
		<div class="col-md-4">
			<div class="user_data elevatewhite">
				<br>
				<div align='center'>
					<img src="<?php echo $profile_pic_url1; ?>" style="width: 96px; height: 96px; border: 1px solid white"><br><br>
					<h4><b>First Name:</b> <?php echo $fname1?></h4>
					<h4><b>Last Name:</b> <?php echo $lname1?></h4><br>
					<?php

					date_default_timezone_set("Asia/Kolkata");

					$curr_time = time();
					$notif_time = strtotime($last_login1);
					$time_diff_sec = $curr_time - $notif_time;

					if($time_diff_sec <= 60)
					{
						echo "
						<div class='won'>
						<font size='4'>Online Now</font>
						</div>";
					}
					else
					{
						$time_elapsed_login = time_elapsed_string($last_login1);
						echo "
						<div class='ongoing'>
						<font size='4'>Online $time_elapsed_login</font>
						</div>";
					}

					?>
				</div>
			</div>
			<br>
			<div class="statistics elevatewhite">
				<div class="stats_content" align='center'>
					<h3>Statistics</h3><hr>
					<div class="ongoing">
						<font size="4"><b>Ongoing: </font><font size="5"><?php echo $ongoing;?></b></font>
					</div><br>
					<div class="won">
						<font size="4"><b>Won: </font><font size="5"><?php echo $won;?></b></font>
					</div><br>
					<div class="lost">
						<font size="4"><b>Lost: </font><font size="5"><?php echo $lost;?></b></font>
					</div><br>
					<div class="tied">
						<font size="4"><b>Tied: </font><font size="5"><?php echo $draw;?></b></font>
					</div><br>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="balance elevatewhite" align='center'>
				<font size='8'>Rs.<b> <?php echo number_format(floor($user_points1*100)/100,2,'.',''); ?></b></font><br>
				<font size='2'> remaining in account</font><br><br>
			</div><br>
			<div class="timeline">
	<?php
		$getposts8 = mysqli_query($con,"SELECT * FROM profile_tempfill WHERE user_email = '$email1' ORDER by time DESC LIMIT 25");
		while($row8 = mysqli_fetch_assoc($getposts8))
		{
			$fill_id = $row8['fill_id'];
			$game_id=$row8['game_id'];
			$time_last_played = $row8['time'];

			if($fill_id > 7040 && $game_id == 1)
			{
				if($game_id == 1)
				{
					$bet_id = $row8['gameweek'];
					$getposts = mysqli_query($con,"SELECT * FROM placedbets WHERE userid_placedby = '$email1' AND bet_id='$bet_id' AND bet_id!='373'");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$bet_option = $row['bet_option'];
						$stake_points = $row['stake_points'];
						$bet_status = $row['bet_status'];
						$time_placed = $row['time_placed'];
						$getposts2 = mysqli_query($con,"SELECT * FROM bets WHERE betid='$bet_id'");
						while($row2 = mysqli_fetch_assoc($getposts2))
						{
							$betdes= $row2['betdes'];
							$option1 = $row2['option1'];
							$option2 = $row2['option2'];
							$option1_users = $row2['option1_users'];
							$option2_users = $row2['option2_users'];
							$option1_points = $row2['option1_points'];
							$option2_points = $row2['option2_points'];
							if($option1_points!=0)
							{
								$mult1 = round(1+$option2_points/$option1_points,2);
								$mult1str = "X pitched Rs.";
							}
							else
							{
								$mult1="";
								$mult1str="";
							}
							if($option2_points!=0)
							{
								$mult2 = round(1+$option1_points/$option2_points,2);
								$mult2str = "X pitched Rs.";
							}
							else
							{
								$mult2="";
								$mult2str="";
								
							}
							if($bet_option == 1)
							{
								$option = $row2['option1'];
							}
							else
							{
								$option = $row2['option2'];
							}
							if($bet_status==0) {
								$bgcolor = "ongoing";
							}
							else if($bet_status==-1)	
							{
								$bgcolor = "lost";
							}
							else if($bet_status==1)
							{
								$bgcolor = "won";
							}
			                else
			                {
			                    $bgcolor = "tied";
			                }
							$str1 = "";
							$getposts3 = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$bet_id' AND bet_option='1'");
							while($row3 = mysqli_fetch_assoc($getposts3))
							{
								$emailx=$row3['userid_placedby'];
								$stake_pointsx=$row3['stake_points'];
								$query = "SELECT * from table2 where email='$emailx'";
								$result1 = mysqli_query($con,$query);
								$get1 = mysqli_fetch_assoc($result1);
								$fnamex = $get1['fname'];
								$lnamex = $get1['lname'];
								$Idx = $get1['Id'];
								//$str1 = $str1 + $fname + " " + $lname + "bet" + $stake_pointsx + "\n\n";
								$str1.="<b><a href='profile.php?u=$Idx' target='_blank'>";
								$str1.=$fnamex;
								$str1.=" ";
								$str1.=$lnamex;
								$str1.="</a></b>";
								$str1.=" with ";
								$str1.="<b>";
								if($stake_pointsx==1)
								{
									$str1.="Re. ";
								}
								else
								{
									$str1.=" Rs. ";
								}
								$str1.=$stake_pointsx;
								$str1.="</b>";
								$str1.="<br>";
							}
							$str2="";
							$getposts3 = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$bet_id' AND bet_option='2'");
							while($row3 = mysqli_fetch_assoc($getposts3))
							{
								$emailx=$row3['userid_placedby'];
								$stake_pointsx=$row3['stake_points'];
								$query = "SELECT * from table2 where email='$emailx'";
								$result1 = mysqli_query($con,$query);
								$get1 = mysqli_fetch_assoc($result1);
								$fnamex = $get1['fname'];
								$lnamex = $get1['lname'];
								$Idx = $get1['Id'];
								//$str1 = $str1 + $fname + " " + $lname + "bet" + $stake_pointsx + "\n\n";
								$str2.="<b><a href='profile.php?u=$Idx' target='_blank'>";
								$str2.=$fnamex;
								$str2.=" ";
								$str2.=$lnamex;
								$str2.="</a></b>";
								$str2.=" with ";
								$str2.="<b>";
								if($stake_pointsx==1)
								{
									$str2.="Re. ";
								}
								else
								{
									$str2.="Rs. ";
								}
								$str2.=$stake_pointsx;
								$str2.="</b>";
								$str2.="<br>";
							}

							echo"
								<div class='bet $bgcolor'>
									<div class='col-md-10'><img src='images/predict_ppic2.png' style='border:2px solid #000; padding: 5px;'>&nbsp;&nbsp;&nbsp;
									<b>Rs. $stake_points </b></font>on <font size=2>$option</font></div>
									<h6>".time_elapsed_string($time_placed)."</h6><hr>
									<div class='bet_content' style='padding-left:10px; padding-right:10px; padding-bottom:20px;'>
										$betdes<br><br>
										<div class='col-md-6'>
												<div class='hrwhite'>
												<p>$option1 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModal$bet_id'>?</a></b>)</font></p>
												
													<p><b class='number'>$option1_users</b> user(s) with<br><b class='number'>$option1_points</b> Rs. in favour<br><b class='number'>$mult1</b>$mult1str</p>
												</div>
										</div>
										<div class='col-md-5'>
										<div class='hrwhite'>
											<div class='bet_option'>
												<p>$option2 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModalx$bet_id'>?</a></b>)</font></p>
											</div>
											<p><b class='number'>$option2_users</b> user(s) with<br><b class='number'>$option2_points</b> Rs. in favour<br><b class='number'>$mult2</b>$mult2str</p>
											</div>
										</div>
										<br><br>
									</div>
								</div><br>
								<!-- Modal -->
							<div class='modal fade' id='myModal$bet_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							  <div class='modal-dialog'>
							    <div class='modal-content'>
							      <div class='modal-header'>
							        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							        <h4 class='modal-title' id='myModalLabel' align='center'><font color='black'><b>User(s) in favour of $option1</b></font></h4>
							      </div>
							      <div class='modal-body'>
							        <font color='black' size='3' align='center'>$str1</font> 
							      </div>
							      <div class='modal-footer'>
							        <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
							      </div>
							    </div>
							  </div>
							</div>
							<div class='modal fade' id='myModalx$bet_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							  <div class='modal-dialog'>
							    <div class='modal-content'>
							      <div class='modal-header'>
							        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							        <h4 class='modal-title' id='myModalLabel' align='center'><font color='black'><b>User(s) in favour of $option2</b></font></h4>
							      </div>
							      <div class='modal-body'>
							        <font color='black' size='3' align='center'>$str2</font> 
							      </div>
							      <div class='modal-footer'>
							        <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
							      </div>
							    </div>
							  </div>
							</div>
							";
						}
					}
				}
			}
			else if($fill_id > 7040 && $game_id >= 11 && $game_id <= 15)
			{
				$gameweek = $row8['gameweek'];
				$curr_gameweek_game = 0;
				$is_competition = 1;
				$contest_id = 2;

				$query = "SELECT * from long_contest_manager WHERE contest_id = '$contest_id'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$contest_status = $get['contest_status'];

				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='$game_id' AND is_competition='$is_competition' ORDER BY high_score DESC");
				$x=1;
				$y=1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$user = $row['user'];
					$query = "SELECT * from table2 where email='$user'";
					$result = mysqli_query($con,$query);
					$get = mysqli_fetch_assoc($result);
					$idx = $get['Id'];
					$fnamex = $get['fname'];
					$lnamex = $get['lname'];
					$high_score = $row['high_score'];

					if($user==$email1)
					{
						if($contest_status == 1)
						{
							$bgcolor = "won";
						}
						else if($contest_status == 0)
						{
							$bgcolor = "ongoing";
						}

						$y=$x;
					}
					$x++;
				}
				$x--;

				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='$game_id' AND is_competition='$is_competition' AND user='$email1'");
				$high_score=-1;

				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
					$rupees_earned = $row['rupees_earned'];
				}	

				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='$game_id' AND is_competition='$is_competition' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults = number_format($numResults);

				$query = "SELECT * FROM games WHERE game_id = '$game_id'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);

				$game_display = $get['game_display'];
				$game_link = $get['game_link'];
				$high_score = number_format($high_score);

				echo"
				<div class='bet $bgcolor hrwhite' style='padding-bottom: 45px'>
					<div class='col-md-10'><font size='5'><i class='fa fa-trophy'></i></font>
					&nbsp;&nbsp;
					<font size=3><b><a href=$g_url".$game_link.">$game_display - Gaming Woche 2</a></b></font></div>
					<h6>".time_elapsed_string($time_last_played)."</h6><hr>
					<div class='bet_content'>
						<div class='col-md-6'>
						<font size='3'>High Score: <b class='number'>$high_score</b></font>
						</div>
						<div class='col-md-6'>
						<font size='3'>Games Played: <b class='number'>$numResults</b></font>
						</div>
						<br><br>
						<div class='col-md-6'>
							<font size='3'>Position: <b class='number'>$y</b> of $x users</font>
						</div>
						<div class='col-md-6'>
							<font size='3'>Earnings: <b class='number'>Rs. $rupees_earned</b></font>
						</div>
					</div>
				</div>
				<br>
				";
			}
			else if($fill_id > 7040 && $game_id >= 1011)
			{
				$gameweek = $row8['gameweek'];
				$curr_gameweek_game = 0;
				$is_competition = 0;
				$contest_id = 2;
				$game_game_id = $game_id - 1000;

				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='$game_game_id' AND is_competition='$is_competition' ORDER BY high_score DESC");
				$x=1;
				$y=1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$user = $row['user'];
					$query = "SELECT * from table2 where email='$user'";
					$result = mysqli_query($con,$query);
					$get = mysqli_fetch_assoc($result);
					$idx = $get['Id'];
					$fnamex = $get['fname'];
					$lnamex = $get['lname'];
					$high_score = $row['high_score'];

					if($user==$email1)
					{
						$bgcolor = "ongoing";
						$y=$x;
					}
					$x++;
				}
				$x--;

				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='$game_game_id' AND is_competition='$is_competition' AND user='$email1'");
				$high_score=-1;

				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
					$rupees_earned = $row['rupees_earned'];
				}	

				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='$game_game_id' AND is_competition='$is_competition' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults = number_format($numResults);

				$query = "SELECT * FROM games WHERE game_id = '$game_game_id'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);

				$game_display = $get['game_display'];
				$game_link = $get['game_link'];
				$game_profile_image = $get['game_profile_image'];
				if($game_id!=1017)
				{
					$high_score = number_format($high_score);
				}

				echo"
				<div class='bet $bgcolor hrwhite' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='$game_profile_image' style='border:2px solid #000; height:40px; width:40px;'>
						&nbsp;&nbsp;
					<font size=3><b><a href=$g_url".$game_link.">$game_display</a></b></font></div>
					<h6>".time_elapsed_string($time_last_played)."</h6><hr>
					<div class='bet_content'>
						<div class='col-md-6'>
						<font size='3'>High Score: <b class='number'>$high_score</b></font>
						</div>
						<div class='col-md-6'>
						<font size='3'>Games Played: <b class='number'>$numResults</b></font>
						</div>
						<br><br>
						<div class='col-md-6'>
							<font size='3'>Position: <b class='number'>$y</b> of $x users</font>
						</div>
						<div class='col-md-6'>
							<font size='3'>Earnings: <b class='number'>Rs. $rupees_earned</b></font>
						</div>
					</div>
				</div>
				<br>
				";
			}
			else
			{
				include ("oldprofile.php");
			}
		}
	?>
			</div>
		</div>
	</div>
</body>
<br><br>
<?php include ("./inc/footer.inc.php"); ?>	