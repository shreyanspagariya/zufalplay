<?php
$game_id=$row8['game_id'];
			$time_last_played = $row8['time'];
			if($game_id==1)
			{
			$bet_id = $row8['gameweek'];
		$getposts = mysqli_query($con,"SELECT * FROM placedbets WHERE userid_placedby = '$email1' AND bet_id='$bet_id'");
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
					$mult1str = "X pitched Zufals";
				}
				else
				{
					$mult1="";
					$mult1str="";
				}
				if($option2_points!=0)
				{
					$mult2 = round(1+$option1_points/$option2_points,2);
					$mult2str = "X pitched Zufals";
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
					$str1.=$stake_pointsx;
					if($stake_pointsx==1)
					{
						$str1.=" Zufal";
					}
					else
					{
						$str1.=" Zufals";
					}
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
					$str2.=$stake_pointsx;
					if($stake_pointsx==1)
					{
						$str2.=" Zufal";
					}
					else
					{
						$str2.=" Zufals";
					}
					$str2.="</b>";
					$str2.="<br>";
				}

echo"
	<div class='bet $bgcolor'>
		<div class='col-md-10'><img src='images/predict_ppic2.png' style='border:2px solid #000; padding: 5px;'>&nbsp;&nbsp;&nbsp;
		<b>$stake_points</b></font> Zufal(s) on <font size=2>$option</font></div>
		<h6>".time_elapsed_string($time_placed)."</h6><hr>
		<div class='bet_content'>
			<h4>$betdes</h4>
			<div class='col-md-6'>
					<div class='hrwhite'>
					<p><font size='4'>$option1 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModal$bet_id'>?</a></b>)</font></font></p>
					
						<p><b class='number'>$option1_users</b> user(s) with<br><b class='number'>$option1_points</b> Zufal(s) in favour<br><b class='number'>$mult1</b>$mult1str</p>
					</div>
			</div>
			<div class='col-md-5'>
			<div class='hrwhite'>
				<div class='bet_option'>
					<p><font size='4'>$option2 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModalx$bet_id'>?</a></b>)</font></font></p>
				</div>
				<p><b class='number'>$option2_users</b> user(s) with<br><b class='number'>$option2_points</b> Zufal(s) in favour<br><b class='number'>$mult2</b>$mult2str</p>
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
			else if($game_id==2)
			{
				$gameweek = $row8['gameweek'];
                if($gameweek>=7)
				{
					$zp=5;
				}
				else
				{
					$zp=10;
				}
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='2'");
				$totalpoints=0;
				$total_high_score = 0;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$totalpoints = $totalpoints + $zp;
					$high_score = $row['high_score'];
					$total_high_score = $total_high_score + $high_score;
				}
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='2' ORDER BY high_score DESC");
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
							if($gameweek!=$curr_gameweek)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($gameweek!=$curr_gameweek)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($gameweek!=$curr_gameweek)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND user='$email1' AND game_id='2'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
					$rupees_earned = $row['rupees_earned'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_week='$gameweek' AND game_id='2' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				if($gameweek!=0)
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='images/handcricket_ppic2.png' style='border:2px solid #000; padding: 5px;'>&nbsp;&nbsp;&nbsp;
						<b>$zp</b></font> Zufal(s) on <font size=3><b>Hand Cricket - Gameweek $gameweek</b></font></div>
						<h6>".time_elapsed_string($time_last_played)."</h6><hr>
						<div class='bet_content'>
							<div class='col-md-6'>
							<font size='3'>High Score: <b class='number'>$high_score</b> runs</font>
							</div>
							<div class='col-md-6'>
							<font size='3'>Matches Played: <b class='number'>$numResults</b></font>
							</div>
							<br><br>
							<div class='col-md-6'>
								<font size='3'>Position: <b class='number'>$y</b> of $x users</font>
							</div>
							<div class='col-md-6'>
								<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
							</div>
						</div>
					</div>
					<br>
					";
				}
				else
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='images/handcricket_ppic2.png' style='border:2px solid #000; padding: 5px;'>&nbsp;&nbsp;
						<font size=3><b>Hand Cricket</b></font></div>
						<h6>".time_elapsed_string($time_last_played)."</h6><hr>
						<div class='bet_content'>
							<div class='col-md-6'>
							<font size='3'>High Score: <b class='number'>$high_score</b> runs</font>
							</div>
							<div class='col-md-6'>
							<font size='3'>Matches Played: <b class='number'>$numResults</b></font>
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
			}
			else if($game_id==3)
			{
				$gameweek = $row8['gameweek'];
                if($gameweek>=5)
				{
					$zp=5;
				}
				else
				{
					$zp=10;
				}
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='3'");
				$totalpoints=0;
				$total_high_score = 0;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$totalpoints = $totalpoints + $zp;
					$high_score = $row['high_score'];
					$total_high_score = $total_high_score + $high_score;
				}
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='3' ORDER BY high_score DESC");
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
							if($gameweek!=$curr_gameweek_2048)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($gameweek!=$curr_gameweek_2048)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($gameweek!=$curr_gameweek_2048)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='3' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
					$rupees_earned = $row['rupees_earned'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_week='$gameweek' AND game_id='3' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				if($gameweek!=0)
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='images/2048_ppic.png' style='border:2px solid #000; padding: 5px;'>&nbsp;&nbsp;&nbsp;
						<b>$zp</b></font> Zufal(s) on <font size=3><b>2048 - Gameweek $gameweek</b></font></div>
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
								<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
							</div>
						</div>
					</div>
					<br>
					";
				}
				else
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='images/2048_ppic.png' style='border:2px solid #000; padding: 5px;'>&nbsp;&nbsp;
						<font size=3><b>2048</b></font></div>
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
				
			}
			else if($game_id==4)
			{
				$gameweek = $row8['gameweek'];
				$game_status = 1;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='4'");
				$totalpoints=0;
				$total_high_score = 0;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$totalpoints = $totalpoints + 10;
					$high_score = $row['high_score'];
					$total_high_score = $total_high_score + $high_score;
				}
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='4' ORDER BY high_score DESC");
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
						if($total_high_score!=0)
						{
							$zufalsprofit = ($totalpoints*$high_score)/$total_high_score;
							$zufalsprofit = floor($zufalsprofit);
							$zufalsprofit = $zufalsprofit - 10;
						}
						else
						{
							$zufalsprofit = 0;
						}
						if($zufalsprofit>0)
						{
							$sign="+";
							if($game_status>0)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='4' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='4' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				echo"
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<p><font size='5'><i class='fa fa-trophy'></i></font>&nbsp;&nbsp;&nbsp;&nbsp;<font size=3><b>10</b></font> Zufal(s) on <font size=3><b>Short Contest - 1</b></font></p><hr>
					<div class='bet_content'>
						<div class='col-md-6'>
						<font size='3'>Levels Cleared: <b class='number'>$high_score</b>/100</font>
						</div>
						<div class='col-md-6'>
						<font size='3'>High Score: <b class='number'>$high_score</b></font>
						</div>
						<br><br>
						<div class='col-md-6'>
							<font size='3'>Position: <b class='number'>$y</b> of $x users</font>
						</div>
						<div class='col-md-6'>
							<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
						</div>
					</div>
				</div>
				<br>
				";
				
			}
			else if($game_id==102)
			{
				$challenge_id = $row8['gameweek'];

				$query = "SELECT * from handcricket_oneonone WHERE challenge_id='$challenge_id'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_email = $get['from_user_email'];
				$to_user_email = $get['to_user_email'];
				$from_user_isout = $get['from_user_isout'];
				$to_user_isout = $get['to_user_isout'];
				$from_user_score = $get['from_user_score'];
				$to_user_score = $get['to_user_score'];
				$challenge_status = $get['challenge_status'];

				$query = "SELECT * from table2 where email='$from_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_idx = $get['Id'];
				$from_user_fnamex = $get['fname'];
				$from_user_lnamex = $get['lname'];

				$query = "SELECT * from table2 where email='$to_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$to_user_idx = $get['Id'];
				$to_user_fnamex = $get['fname'];
				$to_user_lnamex = $get['lname'];

				global $zufals_profit;

				if($challenge_status==0)
				{
					$bgcolor="ongoing";
				}
				else
				{
					if($email1==$from_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$from_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($email1==$to_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$to_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($from_user_score==$to_user_score)
					{
						$bgcolor = "tied";
					}
				}
				if($bgcolor=="won")
				{
					$zufals_profit="Zufals Profit: <b class='number'>+2 </b>";
				}
				else if($bgcolor=="lost")
				{
					$zufals_profit="Zufals Profit: <b class='number'>-2 </b>";
				}
				else if($bgcolor=="tied")
				{
					$zufals_profit="Zufals Profit: <b class='number'>0 </b>";
				}
				else
				{
					$zufals_profit="<b>Yet to Play</b>";
				}
				echo"
				<div class='hrwhite'>
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='images/handcricket_ppic2.png' style='border:2px solid #000; padding: 5px;'>&nbsp;&nbsp;&nbsp;
					<font size=3><b>Hand Cricket - One on One</b></font></div>
					<h6>".time_elapsed_string($time_last_played)."</h6><hr>
					<div class='bet_content'>
						<center>
								<a href=".$g_url."profile.php?u=$to_user_idx target='_blank'><b>
								$to_user_fnamex $to_user_lnamex</b></a>

								vs.

								<a href=".$g_url."profile.php?u=$from_user_idx target='_blank'><b>
								$from_user_fnamex $from_user_lnamex</b></a></font><br><br>
								<font size='6'><b>$to_user_score-$from_user_score</b></font><br><br>
								$zufals_profit
						</center>
					</div>
				</div>
				</div>
				<br>";
			}
                        else if($game_id==105)
			{
				$challenge_id = $row8['gameweek'];

				$query = "SELECT * from snake_oneonone WHERE challenge_id='$challenge_id'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_email = $get['from_user_email'];
				$to_user_email = $get['to_user_email'];
				$from_user_isout = $get['from_user_isout'];
				$to_user_isout = $get['to_user_isout'];
				$from_user_score = $get['from_user_score'];
				$to_user_score = $get['to_user_score'];
				$challenge_status = $get['challenge_status'];

				$query = "SELECT * from table2 where email='$from_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_idx = $get['Id'];
				$from_user_fnamex = $get['fname'];
				$from_user_lnamex = $get['lname'];

				$query = "SELECT * from table2 where email='$to_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$to_user_idx = $get['Id'];
				$to_user_fnamex = $get['fname'];
				$to_user_lnamex = $get['lname'];

				global $zufals_profit;

				if($challenge_status==0)
				{
					$bgcolor="ongoing";
				}
				else
				{
					if($email1==$from_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$from_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($email1==$to_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$to_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($from_user_score==$to_user_score)
					{
						$bgcolor = "tied";
					}
				}
				if($bgcolor=="won")
				{
					$zufals_profit="Zufals Profit: <b class='number'>+1 </b>";
				}
				else if($bgcolor=="lost")
				{
					$zufals_profit="Zufals Profit: <b class='number'>-1 </b>";
				}
				else if($bgcolor=="tied")
				{
					$zufals_profit="Zufals Profit: <b class='number'>0 </b>";
				}
				else
				{
					$zufals_profit="<b>Yet to Play</b>";
				}
				echo"
				<div class='hrwhite'>
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/snake.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Snake - One on One</b></font></div>
					<h6>".time_elapsed_string($time_last_played)."</h6><hr>
					<div class='bet_content'>
						<center>
								<a href=".$g_url."profile.php?u=$to_user_idx target='_blank'><b>
								$to_user_fnamex $to_user_lnamex</b></a>

								vs.

								<a href=".$g_url."profile.php?u=$from_user_idx target='_blank'><b>
								$from_user_fnamex $from_user_lnamex</b></a></font><br><br>
								<font size='6'><b>$to_user_score-$from_user_score</b></font><br><br>
								$zufals_profit
						</center>
					</div>
				</div>
				</div>
				<br>";
			}
			else if($game_id==108)
			{
				$challenge_id = $row8['gameweek'];

				$query = "SELECT * from mario_oneonone WHERE challenge_id='$challenge_id'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_email = $get['from_user_email'];
				$to_user_email = $get['to_user_email'];
				$from_user_isout = $get['from_user_isout'];
				$to_user_isout = $get['to_user_isout'];
				$from_user_score = $get['from_user_score'];
				$to_user_score = $get['to_user_score'];
				$challenge_status = $get['challenge_status'];

				$query = "SELECT * from table2 where email='$from_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_idx = $get['Id'];
				$from_user_fnamex = $get['fname'];
				$from_user_lnamex = $get['lname'];

				$query = "SELECT * from table2 where email='$to_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$to_user_idx = $get['Id'];
				$to_user_fnamex = $get['fname'];
				$to_user_lnamex = $get['lname'];

				global $zufals_profit;

				if($challenge_status==0)
				{
					$bgcolor="ongoing";
				}
				else
				{
					if($email1==$from_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$from_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($email1==$to_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$to_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($from_user_score==$to_user_score)
					{
						$bgcolor = "tied";
					}
				}
				if($bgcolor=="won")
				{
					$zufals_profit="Zufals Profit: <b class='number'>+1 </b>";
				}
				else if($bgcolor=="lost")
				{
					$zufals_profit="Zufals Profit: <b class='number'>-1 </b>";
				}
				else if($bgcolor=="tied")
				{
					$zufals_profit="Zufals Profit: <b class='number'>0 </b>";
				}
				else
				{
					$zufals_profit="<b>Yet to Play</b>";
				}
				echo"
				<div class='hrwhite'>
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/mario.png' style='border:2px solid #000; padding: 5px; height:40px; width:37px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Mario - One on One</b></font></div>
					<h6>".time_elapsed_string($time_last_played)."</h6><hr>
					<div class='bet_content'>
						<center>
								<a href=".$g_url."profile.php?u=$to_user_idx target='_blank'><b>
								$to_user_fnamex $to_user_lnamex</b></a>

								vs.

								<a href=".$g_url."profile.php?u=$from_user_idx target='_blank'><b>
								$from_user_fnamex $from_user_lnamex</b></a></font><br><br>
								<font size='6'><b>$to_user_score-$from_user_score</b></font><br><br>
								$zufals_profit
						</center>
					</div>
				</div>
				</div>
				<br>";
			}
			else if($game_id==106)
			{
				$challenge_id = $row8['gameweek'];

				$query = "SELECT * from coil_oneonone WHERE challenge_id='$challenge_id'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_email = $get['from_user_email'];
				$to_user_email = $get['to_user_email'];
				$from_user_isout = $get['from_user_isout'];
				$to_user_isout = $get['to_user_isout'];
				$from_user_score = $get['from_user_score'];
				$to_user_score = $get['to_user_score'];
				$challenge_status = $get['challenge_status'];

				$query = "SELECT * from table2 where email='$from_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_idx = $get['Id'];
				$from_user_fnamex = $get['fname'];
				$from_user_lnamex = $get['lname'];

				$query = "SELECT * from table2 where email='$to_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$to_user_idx = $get['Id'];
				$to_user_fnamex = $get['fname'];
				$to_user_lnamex = $get['lname'];

				global $zufals_profit;

				if($challenge_status==0)
				{
					$bgcolor="ongoing";
				}
				else
				{
					if($email1==$from_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$from_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($email1==$to_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$to_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($from_user_score==$to_user_score)
					{
						$bgcolor = "tied";
					}
				}
				if($bgcolor=="won")
				{
					$zufals_profit="Zufals Profit: <b class='number'>+1 </b>";
				}
				else if($bgcolor=="lost")
				{
					$zufals_profit="Zufals Profit: <b class='number'>-1 </b>";
				}
				else if($bgcolor=="tied")
				{
					$zufals_profit="Zufals Profit: <b class='number'>0 </b>";
				}
				else
				{
					$zufals_profit="<b>Yet to Play</b>";
				}
				echo"
				<div class='hrwhite'>
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/coil.gif' style='border:2px solid #000; padding: 5px; height:40px; width:65px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Coil - One on One</b></font></div>
					<h6>".time_elapsed_string($time_last_played)."</h6><hr>
					<div class='bet_content'>
						<center>
								<a href=".$g_url."profile.php?u=$to_user_idx target='_blank'><b>
								$to_user_fnamex $to_user_lnamex</b></a>

								vs.

								<a href=".$g_url."profile.php?u=$from_user_idx target='_blank'><b>
								$from_user_fnamex $from_user_lnamex</b></a></font><br><br>
								<font size='6'><b>$to_user_score-$from_user_score</b></font><br><br>
								$zufals_profit
						</center>
					</div>
				</div>
				</div>
				<br>";
			}
			else if($game_id==107)
			{
				$challenge_id = $row8['gameweek'];

				$query = "SELECT * from hextris_oneonone WHERE challenge_id='$challenge_id'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_email = $get['from_user_email'];
				$to_user_email = $get['to_user_email'];
				$from_user_isout = $get['from_user_isout'];
				$to_user_isout = $get['to_user_isout'];
				$from_user_score = $get['from_user_score'];
				$to_user_score = $get['to_user_score'];
				$challenge_status = $get['challenge_status'];

				$query = "SELECT * from table2 where email='$from_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_idx = $get['Id'];
				$from_user_fnamex = $get['fname'];
				$from_user_lnamex = $get['lname'];

				$query = "SELECT * from table2 where email='$to_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$to_user_idx = $get['Id'];
				$to_user_fnamex = $get['fname'];
				$to_user_lnamex = $get['lname'];

				global $zufals_profit;

				if($challenge_status==0)
				{
					$bgcolor="ongoing";
				}
				else
				{
					if($email1==$from_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$from_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($email1==$to_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$to_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($from_user_score==$to_user_score)
					{
						$bgcolor = "tied";
					}
				}
				if($bgcolor=="won")
				{
					$zufals_profit="Zufals Profit: <b class='number'>+1 </b>";
				}
				else if($bgcolor=="lost")
				{
					$zufals_profit="Zufals Profit: <b class='number'>-1 </b>";
				}
				else if($bgcolor=="tied")
				{
					$zufals_profit="Zufals Profit: <b class='number'>0 </b>";
				}
				else
				{
					$zufals_profit="<b>Yet to Play</b>";
				}
				echo"
				<div class='hrwhite'>
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/hextris.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Hextris - One on One</b></font></div>
					<h6>".time_elapsed_string($time_last_played)."</h6><hr>
					<div class='bet_content'>
						<center>
								<a href=".$g_url."profile.php?u=$to_user_idx target='_blank'><b>
								$to_user_fnamex $to_user_lnamex</b></a>

								vs.

								<a href=".$g_url."profile.php?u=$from_user_idx target='_blank'><b>
								$from_user_fnamex $from_user_lnamex</b></a></font><br><br>
								<font size='6'><b>$to_user_score-$from_user_score</b></font><br><br>
								$zufals_profit
						</center>
					</div>
				</div>
				</div>
				<br>";
			}
			else if($game_id==109)
			{
				$challenge_id = $row8['gameweek'];

				$query = "SELECT * from pappupakia_oneonone WHERE challenge_id='$challenge_id'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_email = $get['from_user_email'];
				$to_user_email = $get['to_user_email'];
				$from_user_isout = $get['from_user_isout'];
				$to_user_isout = $get['to_user_isout'];
				$from_user_score = $get['from_user_score'];
				$to_user_score = $get['to_user_score'];
				$challenge_status = $get['challenge_status'];

				$query = "SELECT * from table2 where email='$from_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$from_user_idx = $get['Id'];
				$from_user_fnamex = $get['fname'];
				$from_user_lnamex = $get['lname'];

				$query = "SELECT * from table2 where email='$to_user_email'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$to_user_idx = $get['Id'];
				$to_user_fnamex = $get['fname'];
				$to_user_lnamex = $get['lname'];

				global $zufals_profit;

				if($challenge_status==0)
				{
					$bgcolor="ongoing";
				}
				else
				{
					if($email1==$from_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$from_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($email1==$to_user_email && $from_user_score < $to_user_score)
					{
						$bgcolor = "won";
					}
					else if($email1==$to_user_email && $from_user_score > $to_user_score)
					{
						$bgcolor = "lost";
					}
					else if($from_user_score==$to_user_score)
					{
						$bgcolor = "tied";
					}
				}
				if($bgcolor=="won")
				{
					$zufals_profit="Zufals Profit: <b class='number'>+1 </b>";
				}
				else if($bgcolor=="lost")
				{
					$zufals_profit="Zufals Profit: <b class='number'>-1 </b>";
				}
				else if($bgcolor=="tied")
				{
					$zufals_profit="Zufals Profit: <b class='number'>0 </b>";
				}
				else
				{
					$zufals_profit="<b>Yet to Play</b>";
				}
				echo"
				<div class='hrwhite'>
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/pappupakia.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Pappu Pakia - One on One</b></font></div>
					<h6>".time_elapsed_string($time_last_played)."</h6><hr>
					<div class='bet_content'>
						<center>
								<a href=".$g_url."profile.php?u=$to_user_idx target='_blank'><b>
								$to_user_fnamex $to_user_lnamex</b></a>

								vs.

								<a href=".$g_url."profile.php?u=$from_user_idx target='_blank'><b>
								$from_user_fnamex $from_user_lnamex</b></a></font><br><br>
								<font size='6'><b>$to_user_score-$from_user_score</b></font><br><br>
								$zufals_profit
						</center>
					</div>
				</div>
				</div>
				<br>";
			}
                        else if($game_id==5)
			{
				$gameweek = $row8['gameweek'];
				$game_status = 1;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='5' AND is_competition='1' ORDER BY high_score DESC");
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
                                                $zufalsprofit = $row['zufals_profit'];
						if($zufalsprofit>0)
						{
							$sign="+";
							if($game_status>0)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='5' AND is_competition='1' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='5' AND is_competition='1' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				echo"
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/snake.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Snake - Gaming Woche</b></font></div>
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
							<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
						</div>
					</div>
				</div>
				<br>
				";
			}
			else if($game_id==6)
			{
				$gameweek = $row8['gameweek'];
				$game_status = 1;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='6' AND is_competition='1' ORDER BY high_score DESC");
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
                                                $zufalsprofit = $row['zufals_profit'];
						if($zufalsprofit>0)
						{
							$sign="+";
							if($game_status>0)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='6' AND is_competition='1' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='6' AND is_competition='0' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				echo"
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/coil.gif' style='border:2px solid #000; padding: 5px; height:40px; width:65px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Coil - Gaming Woche</b></font></div>
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
							<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
						</div>
					</div>
				</div>
				<br>
				";
			}
			else if($game_id==7)
			{
				$gameweek = $row8['gameweek'];
				$game_status = 1;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='7' AND is_competition='1' ORDER BY high_score DESC");
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
                                                $zufalsprofit = $row['zufals_profit'];
						if($zufalsprofit>0)
						{
							$sign="+";
							if($game_status>0)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='7' AND is_competition='1' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='7' AND is_competition='1' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				echo"
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/hextris.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Hextris - Gaming Woche</b></font></div>
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
							<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
						</div>
					</div>
				</div>
				<br>
				";
			}
			else if($game_id==8)
			{
				$gameweek = $row8['gameweek'];
				$game_status = 1;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='8' AND is_competition='1' ORDER BY high_score DESC");
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
                                                $zufalsprofit = $row['zufals_profit'];
						if($zufalsprofit>0)
						{
							$sign="+";
							if($game_status>0)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='8' AND is_competition='1' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='8' AND is_competition='1' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				echo"
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/mario.png' style='border:2px solid #000; padding: 5px; height:40px; width:37px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Mario - Gaming Woche</b></font></div>
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
							<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
						</div>
					</div>
				</div>
				<br>
				";
			}
			else if($game_id==9)
			{
				$gameweek = $row8['gameweek'];
				$game_status = 1;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='9' AND is_competition='1' ORDER BY high_score DESC");
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
                        $zufalsprofit = $row['zufals_profit'];
						if($zufalsprofit>0)
						{
							$sign="+";
							if($game_status>0)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($game_status>0)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='9' AND is_competition='1' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='9' AND is_competition='1' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				echo"
				<div class='bet $bgcolor' style='padding-bottom: 45px'>
					<div class='col-md-10'><img src='games/gaming-week-1/images/pappupakia.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
					&nbsp;&nbsp;&nbsp;
					<font size=3><b>Pappu Pakia - Gaming Woche</b></font></div>
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
							<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
						</div>
					</div>
				</div>
				<br>
				";
			}
            else if($game_id==1005)
			{
				$gameweek = $row8['gameweek'];
				$curr_gameweek_snake = 0;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='5' AND is_competition='0' ORDER BY high_score DESC");
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
						$zufalsprofit = $row['zufals_profit'];
                        if($zufalsprofit>0)
						{
							$sign="+";
							if($gameweek!=$curr_gameweek_snake)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($gameweek!=$curr_gameweek_snake)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($gameweek!=$curr_gameweek_snake)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='5' AND is_competition='0' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
					$rupees_earned = $row['rupees_earned'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='5' AND is_competition='0' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				if($gameweek!=0)
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/snake.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
						&nbsp;&nbsp;&nbsp;
						<b>5</b></font> Zufal(s) on <font size=3><b>Snake - Gameweek $gameweek</b></font></div>
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
								<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
							</div>
						</div>
					</div>
					<br>
					";
				}
				else
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/snake.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
						&nbsp;&nbsp;
						<font size=3><b>Snake</b></font></div>
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
			}
			else if($game_id==1006)
			{
				$gameweek = $row8['gameweek'];
				$curr_gameweek_coil = 0;

				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='6' AND is_competition='0' ORDER BY high_score DESC");
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
						$zufalsprofit = $row['zufals_profit'];
                        if($zufalsprofit>0)
						{
							$sign="+";
							if($gameweek!=$curr_gameweek_coil)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($gameweek!=$curr_gameweek_coil)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($gameweek!=$curr_gameweek_coil)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='6' AND is_competition='0' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
					$rupees_earned = $row['rupees_earned'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='6' AND is_competition='0' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				if($gameweek!=0)
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/coil.gif' style='border:2px solid #000; padding: 5px; height:40px; width:65px;'>
						&nbsp;&nbsp;&nbsp;
						<b>5</b></font> Zufal(s) on <font size=3><b>Coil - Gameweek $gameweek</b></font></div>
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
								<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
							</div>
						</div>
					</div>
					<br>
					";
				}
				else
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/coil.gif' style='border:2px solid #000; padding: 5px; height:40px; width:65px;'>
						&nbsp;&nbsp;
						<font size=3><b>Coil</b></font></div>
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
			}
			else if($game_id==1007)
			{
				$gameweek = $row8['gameweek'];
				$curr_gameweek_hextris = 0;

				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='7' AND is_competition='0' ORDER BY high_score DESC");
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
						$zufalsprofit = $row['zufals_profit'];
                        if($zufalsprofit>0)
						{
							$sign="+";
							if($gameweek!=$curr_gameweek_hextris)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($gameweek!=$curr_gameweek_hextris)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($gameweek!=$curr_gameweek_hextris)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='7' AND is_competition='0' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
					$rupees_earned = $row['rupees_earned'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='7' AND is_competition='0' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				if($gameweek!=0)
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/hextris.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
						&nbsp;&nbsp;&nbsp;
						<b>5</b></font> Zufal(s) on <font size=3><b>Hextris - Gameweek $gameweek</b></font></div>
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
								<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
							</div>
						</div>
					</div>
					<br>
					";
				}
				else
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/hextris.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
						&nbsp;&nbsp;
						<font size=3><b>Hextris</b></font></div>
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
			}
			else if($game_id==1008)
			{
				$gameweek = $row8['gameweek'];
				$curr_gameweek_mario = 0;

				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='8' AND is_competition='0' ORDER BY high_score DESC");
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
						$zufalsprofit = $row['zufals_profit'];
                        if($zufalsprofit>0)
						{
							$sign="+";
							if($gameweek!=$curr_gameweek_mario)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($gameweek!=$curr_gameweek_mario)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($gameweek!=$curr_gameweek_mario)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='8' AND is_competition='0' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
					$rupees_earned = $row['rupees_earned'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='8' AND is_competition='0' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				if($gameweek!=0)
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/mario.png' style='border:2px solid #000; padding: 5px; height:40px; width:37px;'>
						&nbsp;&nbsp;&nbsp;
						<b>5</b></font> Zufal(s) on <font size=3><b>Mario - Gameweek $gameweek</b></font></div>
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
								<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
							</div>
						</div>
					</div>
					<br>
					";
				}
				else
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/mario.png' style='border:2px solid #000; padding: 5px; height:40px; width:37px;'>
						&nbsp;&nbsp;
						<font size=3><b>Mario</b></font></div>
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
			}
			else if($game_id==1009)
			{
				$gameweek = $row8['gameweek'];
				$curr_gameweek_pappupakia = 0;

				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='9' AND is_competition='0' ORDER BY high_score DESC");
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
						$zufalsprofit = $row['zufals_profit'];
                        if($zufalsprofit>0)
						{
							$sign="+";
							if($gameweek!=$curr_gameweek_pappupakia)
							{
								$bgcolor = "won";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else if($zufalsprofit<0)
						{
							$sign="";
							if($gameweek!=$curr_gameweek_pappupakia)
							{
								$bgcolor = "lost";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						else
						{
							$sign="";
							if($gameweek!=$curr_gameweek_pappupakia)
							{
								$bgcolor = "tied";
							}
							else
							{
								$bgcolor = "ongoing";
							}
						}
						$y=$x;
					}
					$x++;
				}
				$x--;
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='$gameweek' AND game_id='9' AND is_competition='0' AND user='$email1'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
					$rupees_earned = $row['rupees_earned'];
				}	
				$query = "SELECT * from game_playhistory where user_played='$email1' AND game_id='9' AND is_competition='0' AND game_week='$gameweek' AND isout='1' AND play_id!='TRAINGAME'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$numResults=number_format($numResults);
				if($gameweek!=0)
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/pappupakia.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
						&nbsp;&nbsp;&nbsp;
						<b>5</b></font> Zufal(s) on <font size=3><b>Pappu Pakia - Gameweek $gameweek</b></font></div>
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
								<font size='3'>Zufals Profit: <b class='number'>$sign$zufalsprofit</b></font>
							</div>
						</div>
					</div>
					<br>
				";
				}	
				else
				{
					echo"
					<div class='bet $bgcolor' style='padding-bottom: 45px'>
						<div class='col-md-10'><img src='games/gaming-week-1/images/pappupakia.png' style='border:2px solid #000; padding: 5px; height:40px; width:40px;'>
						&nbsp;&nbsp;
						<font size=3><b>Pappu Pakia</b></font></div>
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
			}
	?>
