<?php 
include ("../../inc/connect.inc.php");
session_start();
if(isset($_SESSION["email1"]))
{
	$email = $_SESSION["email1"];
}
else
{
	$email = "EXTUSER";
}

date_default_timezone_set('Asia/Kolkata');
$time = time();
$datetime = date("Y-m-d H:i:sa");

$current_contest_id = 2;

if($_REQUEST['mode'] == "submit_score")
{
	$level_cleared = mysqli_real_escape_string($con,$_POST['level_cleared']);

	$query = "SELECT * from short_contest_playhistory WHERE user_played='$email' AND level_cleared='$level_cleared' AND contest_id='$current_contest_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);

	if($numResults == 0)
	{
		$rupees_earned = 0.4;

		mysqli_query($con,"INSERT INTO short_contest_playhistory (user_played, level_cleared, contest_id, rupees_earned, time_played) 
			VALUES ('$email', '$level_cleared', '$current_contest_id', '$rupees_earned', '$datetime')");

		mysqli_query($con,"UPDATE short_contest_leaderboard SET rupees_earned=rupees_earned+$rupees_earned, levels_cleared = levels_cleared+1 WHERE 
			user='$email' AND contest_id='$current_contest_id'");

		$query = "SELECT * from table2 where email='$email'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$user_pointsx = $get['user_points'];
		$user_pointsx+=$rupees_earned;

		mysqli_query($con,"UPDATE table2 SET user_points='$user_pointsx' WHERE email='$email'");

		mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
			VALUES ('$email','$user_pointsx','$current_contest_id','Account credited Rs. $rupees_earned on clearing Level $level_cleared in Short Contest $current_contest_id','$datetime')");
	
		mysqli_query($con,"INSERT INTO recent_activity (user_email,game_id,gameweek,game_score,activity_time) VALUES ('$email','10','0','$level_cleared','$datetime')");		
		
		mysqli_query($con,"UPDATE profile_tempfill SET time='$datetime' WHERE user_email='$email' AND game_id='10' AND gameweek='$current_contest_id'");

		$query = "SELECT * from short_contest_manager";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$contest_status = $get['contest_status'];

		$result = array('status' => 1, 'user_points' => $user_pointsx, 'notif_text' => 'Account credited Rs. '.$rupees_earned.' on clearing Level '.$level_cleared.' in Short Contest '.$current_contest_id, 'contest_status' => $contest_status);
		echo json_encode($result);
	}
}
?>