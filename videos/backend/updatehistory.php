<?php 
include ("../../inc/extuser.inc.php"); 
include ("../../inc/distributor.inc.php");
include ("../../user-behaviour.php");
?>

<?php
date_default_timezone_set("Asia/Kolkata");
$datetime = date("Y-m-d H:i:sa");

//User Behaviour
$tables_affected_list = [];
$tables_list_size = 0;

$watch_id = mysqli_real_escape_string($con,$_POST['watch_id']);

$query = "SELECT * FROM videos_watch_history WHERE watch_id='$watch_id'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$unique_code = $get['video_unique_code'];
$time_started = $get['time_started'];
$is_complete = $get['is_complete'];
$sharer = $get['sharer'];

$query = "SELECT * FROM videos WHERE unique_code='$unique_code'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$title = $get['title'];
$time_sec_length = $get['time_sec_length'];
$genre = $get['genre'];

$zufals_winnable = distribute($con, $time_sec_length, "VIDEO");

//If condition to check if packet arrived a long time before the video got over

$curr_time = time();
$time_started = strtotime($time_started);

$result = array('status' => 1,'msg'=>$curr_time-$time_started);
echo json_encode($result);

if($curr_time - $time_started - $time_sec_length >= -10 && $is_complete==0)
{
	if($email!="")
	{
		mysqli_query($con,"UPDATE table2 SET user_points=user_points+$zufals_winnable WHERE email='$email'");

		//User Behaviour
		$tables_list_size = add_table_to_tables_list("table2", $tables_affected_list, $tables_list_size);

		$query = "SELECT * from table2 where email='$email'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$user_pointsx = $get['user_points'];

		mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
			VALUES ('$email','$user_pointsx','0','Account credited Rs. $zufals_winnable on watching $title','$datetime')");

		mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
					VALUES ('$email','Account credited Rs. $zufals_winnable on watching $title','pointslog.php','$datetime','0')");

		mysqli_query($con,"INSERT INTO recent_activity (user_email,game_id,gameweek,game_score,activity_time) 
							VALUES ('$email','10001','0','$zufals_winnable','$datetime')");

		mysqli_query($con,"UPDATE videos_watch_history SET earnings_viewer='$zufals_winnable' WHERE watch_id='$watch_id'");

		//User Behaviour
		$tables_list_size = add_table_to_tables_list("account_transactions", $tables_affected_list, $tables_list_size);
		$tables_list_size = add_table_to_tables_list("notifications", $tables_affected_list, $tables_list_size);
		$tables_list_size = add_table_to_tables_list("recent_activity", $tables_affected_list, $tables_list_size);
		$tables_list_size = add_table_to_tables_list("videos_watch_history", $tables_affected_list, $tables_list_size);
	}
	mysqli_query($con,"UPDATE videos_watch_history SET is_complete=1 WHERE watch_id='$watch_id'");

	//User Behaviour
	$tables_list_size = add_table_to_tables_list("videos_watch_history", $tables_affected_list, $tables_list_size);

	if($genre!="other")
	{
		mysqli_query($con,"UPDATE videos_genre SET genre_view_count=genre_view_count+1 WHERE genre_name='$genre'");

		//User Behaviour
		$tables_list_size = add_table_to_tables_list("videos_genre", $tables_affected_list, $tables_list_size);
	}

	if($sharer != "")
	{
		$ip_address = spit_ip();

		$query = "SELECT * FROM videos_watch_history WHERE is_money_distributed_to_sharer='1' AND user_email='$ip_address' AND sharer='$sharer' AND video_unique_code='$unique_code'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$numResults_ip = mysqli_num_rows($result);

		$query = "SELECT * FROM videos_watch_history WHERE is_money_distributed_to_sharer='1' AND user_email='$email' AND sharer='$sharer' AND video_unique_code='$unique_code'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$numResults_useraccount = mysqli_num_rows($result);

		if((isset($_SESSION["email1"]) && $sharer == $unique_name) || (isset($_SESSION["email1"]) && $numResults_useraccount != 0) || (!isset($_SESSION["email1"]) && $numResults_ip != 0))
		{
			$query = "UPDATE videos_watch_history SET is_money_distributed_to_sharer='-1' WHERE watch_id='$watch_id'";

			//User Behaviour
			$tables_list_size = add_table_to_tables_list("videos_watch_history", $tables_affected_list, $tables_list_size);

			$result = mysqli_query($con,$query);
		}
		else
		{
			mysqli_query($con,"UPDATE table2 SET user_points=user_points+$zufals_winnable WHERE unique_name='$sharer'");

			$query = "UPDATE videos_watch_history SET is_money_distributed_to_sharer='1', earnings_sharer='$zufals_winnable' WHERE watch_id='$watch_id'";
			$result = mysqli_query($con,$query);

			//User Behaviour
			$tables_list_size = add_table_to_tables_list("table2", $tables_affected_list, $tables_list_size);
			$tables_list_size = add_table_to_tables_list("videos_watch_history", $tables_affected_list, $tables_list_size);

			$query = "SELECT * FROM table2 WHERE unique_name='$sharer'";
			$result = mysqli_query($con,$query);
			$get = mysqli_fetch_assoc($result);
			$user_pointsx = $get['user_points'];
			$emailx = $get['email'];

			mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
				VALUES ('$emailx','$user_pointsx','1730','Account credited Rs. $zufals_winnable on a view on your Share of the Video - $title','$datetime')");

			mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
				VALUES ('$emailx','Account credited Rs. $zufals_winnable on a view on your Share of the Video - $title','pointslog.php','$datetime','0')");

			//User Behaviour
			$tables_list_size = add_table_to_tables_list("account_transactions", $tables_affected_list, $tables_list_size);
			$tables_list_size = add_table_to_tables_list("notifications", $tables_affected_list, $tables_list_size);
		}
	}

	//User Behaviour
	add_tables_list_to_user_behaviour($tables_affected_list, $con, $datetime, $email);

	$result = array('status' => 1,'msg'=>'success');
	echo json_encode($result);
}

?>