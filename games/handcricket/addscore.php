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

$game_id = 2;

$ip_address = spit_ip();

if($_REQUEST['mode'] == "add_score")
{
	$result = array('status' => 0,'msg'=>'');
	$this_score = mysqli_real_escape_string($con,$_POST['this_score']);
	$play_id = mysqli_real_escape_string($con,$_POST['play_id']);
	if($this_score > 6 || $this_score < 1)
	{
		$result = array('status' => 1, 'msg' => 'cheater');
		echo json_encode($result);
	}
	else
	{
		$gen_num = rand(1,6);

		if($gen_num == $this_score)
		{
			$query = "UPDATE game_playhistory SET isout = '1', play_end_time = '$datetime', ip_address='$ip_address' WHERE play_id='$play_id' AND game_id='2'";
			mysqli_query($con,$query); 
			$query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='2'";
			$getposts = mysqli_query($con,$query);
			while($row = mysqli_fetch_assoc($getposts))
			{
				$score = $row['final_score'];
				$zufals_pitched = $row["zufals_pitched"];
			}

			$query = "SELECT * from table2 where email='$email'";
			$result = mysqli_query($con,$query);
			$get = mysqli_fetch_assoc($result);
			$user_pointsx = $get['user_points'];
		    $addpoints = ($score)/37;
		    $addpoints = $zufals_pitched * $addpoints;
		    $addpoints = floor($addpoints * 10000) / 10000; 
			$user_pointsx = $user_pointsx + $addpoints;

			mysqli_query($con,"UPDATE other_funds SET total_amount = total_amount - '$addpoints'");
			
			mysqli_query($con,"UPDATE game_leaderboard SET rupees_earned=rupees_earned+$addpoints-$zufals_pitched WHERE user='$email' AND game_id='2'");

			if($addpoints>0)
			{
				$query = "UPDATE game_playhistory SET earnings='$addpoints' WHERE play_id='$play_id' AND game_id='2'";
				mysqli_query($con,$query);
				mysqli_query($con,"UPDATE table2 SET user_points='$user_pointsx' WHERE email='$email'");
				mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
					VALUES ('$email','$user_pointsx','0','Account credited Rs. $addpoints on scoring $score runs in Handcricket','$datetime')");
			}
			
			mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
				VALUES ('$email','Account credited Rs. $addpoints on scoring $score runs in Handcricket','games/handcricket/','$datetime','0')");

			mysqli_query($con,"INSERT INTO recent_activity (user_email,game_id,gameweek,game_score,activity_time) VALUES ('$email','2','0','$score','$datetime')");
			mysqli_query($con,"UPDATE profile_tempfill SET time='$datetime' WHERE user_email='$email' AND game_id='2' AND gameweek='0'");
			$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE user='$email' AND game_id='2'");
			$high_score=0;
			while($row = mysqli_fetch_assoc($getposts))
			{
				$high_score = $row['high_score'];
			}
			if($score > $high_score)
			{
				mysqli_query($con,"UPDATE game_leaderboard SET high_score='$score' WHERE user='$email' AND game_id='$game_id'");
				$result = array('status' => 1, 'msg' => 'out', 'gen' => $gen_num, 'high' => 1);
				echo json_encode($result);
			}
			else
			{
				$result = array('status' => 1, 'msg' => 'out', 'gen' => $gen_num, 'high' => 0);
				echo json_encode($result);
			}	
		}
		else
		{	
			$query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='2'";
			$getposts = mysqli_query($con,$query);
			while($row = mysqli_fetch_assoc($getposts))
			{
				$current_score = $row['final_score'];
				$current_score += $this_score;
				$isout = $row['isout'];
			}
			if($isout==0)
			{
				$query = "UPDATE game_playhistory SET final_score = '$current_score' WHERE play_id='$play_id' AND game_id='2'";
				mysqli_query($con,$query); 
				$result = array('status' => 1, 'msg' => 'score updated', 'gen' => $gen_num);
				echo json_encode($result);
			}
			else
			{
				mysqli_query($con,"UPDATE game_leaderboard SET high_score='0' WHERE user='$email' AND game_id='$game_id'");
				$result = array('status' => 1, 'msg' => 'cheater');
				echo json_encode($result);
			}
		}
		
	}
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
		$query = "UPDATE game_playhistory SET zufals_pitched='$zufals_pitched' WHERE play_id='$play_id' AND game_id='2'";
		mysqli_query($con,$query); 

		$query = "UPDATE table2 SET user_points='$user_points' WHERE email='$email'";
		mysqli_query($con,$query); 

		mysqli_query($con,"UPDATE other_funds SET total_amount = total_amount + '$zufals_pitched'");

		if($zufals_pitched > 0)
		{
			mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
				VALUES ('$email','$user_points','0','Account debited Rs. $zufals_pitched on pitching in Handcricket','$datetime')");
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