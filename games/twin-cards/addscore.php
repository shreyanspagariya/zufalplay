<?php 
include ("../../inc/connect.inc.php"); 
date_default_timezone_set('Asia/Calcutta');
$datetime = date("Y-m-d H:i:sa");

session_start();
if(isset($_SESSION["email1"]))
{
	$email = $_SESSION["email1"];
}
else
{
	$email = "EXTUSER";
}

$game_id = 16;
$gameweek = 0;

$ip_address = spit_ip();

if($_REQUEST['mode'] == "add_score")
{
	$play_id = mysqli_real_escape_string($con,$_POST['play_id']);

	$query = "SELECT * FROM twin_cards_states WHERE play_id='$play_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$game_result = $get['result'];

	$is_competition = 0;

	$query = "SELECT * FROM games WHERE game_id = '$game_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$game_display = $get["game_display"];
	$game_link = $get["game_link"];
	$game_profile_id = 1000 + $game_id;
	$game_code = $get["game_code"];

	mysqli_query($con,"UPDATE game_playhistory SET play_end_time = '$datetime', ip_address='$ip_address' WHERE play_id = '$play_id' AND game_id='$game_id'");

	$query = "SELECT * FROM game_playhistory WHERE play_id = '$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$isout = $get['isout'];
	$zufals_pitched = $get["zufals_pitched"];
	
	if($isout == 0)
	{
		date_default_timezone_set('Asia/Kolkata');
		$datetime = date("Y-m-d H:i:sa");

		if($email!="EXTUSER")
		{
			$query = "SELECT * from table2 where email='$email'";
			$result = mysqli_query($con,$query);
			$get = mysqli_fetch_assoc($result);
			$user_pointsx = $get['user_points'];
			if($game_result == "WON")
			{
				$addpoints = $zufals_pitched*2;
				mysqli_query($con,"UPDATE game_leaderboard SET high_score=high_score+1 WHERE user='$email' AND game_id='$game_id' AND is_competition='$is_competition'");
			}
			else if($game_result == "DRAW")
			{
				$addpoints = $zufals_pitched;
			}
			else
			{
				$addpoints = 0;
			}
			$user_pointsx+=$addpoints;

			mysqli_query($con,"UPDATE other_funds SET total_amount = total_amount - '$addpoints'");

			mysqli_query($con,"UPDATE game_leaderboard SET rupees_earned=rupees_earned+$addpoints-$zufals_pitched WHERE user='$email' AND game_id='16'");

			if($addpoints>0)
			{
				mysqli_query($con,"UPDATE game_playhistory SET earnings='$addpoints' WHERE play_id = '$play_id' AND game_id='$game_id'");
				mysqli_query($con,"UPDATE table2 SET user_points='$user_pointsx' WHERE email='$email'");
				mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
					VALUES ('$email','$user_pointsx','$gameweek','Account credited Rs. $addpoints on winning Twin Cards','$datetime')");
			}
			mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
			VALUES ('$email','Account credited Rs. $addpoints on winning Twin Cards','$game_link','$datetime','0')");
		}

		mysqli_query($con,"UPDATE game_playhistory SET isout = '1' WHERE play_id = '$play_id' AND game_id='$game_id' AND is_competition='$is_competition'"); 
		mysqli_query($con,"INSERT INTO recent_activity (user_email,game_id,gameweek,game_score,activity_time) VALUES ('$email','$game_profile_id','0','0','$datetime')");		
		mysqli_query($con,"UPDATE profile_tempfill SET time='$datetime' WHERE user_email='$email' AND game_id='$game_profile_id' AND gameweek='$gameweek'");
	}

	$result = array('status' => 1, 'msg' => 'success', 'result' => $game_result);
	echo json_encode($result);
}
else if($_REQUEST['mode'] == "pitch_zufals")
{
	$zufals_pitched = mysqli_real_escape_string($con,$_POST['zufals_pitched']);
	$play_id = mysqli_real_escape_string($con,$_POST['play_id']);

	$query = "SELECT * from table2 where email='$email'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$user_points = $get['user_points'];
	$user_points = $user_points - $zufals_pitched;

	if($zufals_pitched < 0)
	{
		$result = array('status' => -1);
		echo json_encode($result);
	}
    else if(0 <= $user_points)
	{
		$query = "UPDATE game_playhistory SET zufals_pitched='$zufals_pitched' WHERE play_id='$play_id' AND game_id='16'";
		mysqli_query($con,$query); 

		$query = "UPDATE table2 SET user_points='$user_points' WHERE email='$email'";
		mysqli_query($con,$query); 

		mysqli_query($con,"UPDATE other_funds SET total_amount = total_amount + '$zufals_pitched'");

		if($zufals_pitched > 0)
		{
			mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
				VALUES ('$email','$user_points','0','Account debited Rs. $zufals_pitched on pitching in Twin Cards','$datetime')");
		}

		$result = array('status' => 1, 'user_points' => $user_points, 'notif_text' => "Account debited Rs. ".$zufals_pitched.". Game Commencing...");
		echo json_encode($result);
	}
	else
	{
		$result = array('status' => 0);
		echo json_encode($result);
	}
}
?>