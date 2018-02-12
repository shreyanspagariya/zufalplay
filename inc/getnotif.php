<?php 

include("connect.inc.php");
include("distributor.inc.php");

session_start();
if(isset($_SESSION["email1"]))
{
	$email = $_SESSION["email1"];
}
else 
{
	if(!empty($_SERVER['HTTP_CLIENT_IP'])) 
	{
	    $ip = $_SERVER['HTTP_CLIENT_IP'];
	} 
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
	{
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} 
	else 
	{
	    $ip = $_SERVER['REMOTE_ADDR'];
	}
	$email = $ip; 	
} 

$is_there_a_new_notif = 0;

date_default_timezone_set("Asia/Kolkata");
$curr_time = time();

$datetime = date("Y-m-d H:i:sa");

mysqli_query($con,"UPDATE table2 SET last_login = '$datetime', total_time_on_site = total_time_on_site + 10 WHERE email='$email'");

$getnotifs = mysqli_query($con,"SELECT * FROM notifications WHERE to_user='$email' AND seen=0 ORDER BY time_generated ASC");
while($notifrow = mysqli_fetch_assoc($getnotifs))
{
	$notif_id = $notifrow['notif_id'];
	$notif_text = $notifrow['notif_text'];
	$notif_href = $notifrow['notif_href'];
	$notif_time = strtotime($notifrow['time_generated']);

	$time_diff_sec = $curr_time - $notif_time;

	if($time_diff_sec<=10)
	{
		mysqli_query($con,"UPDATE notifications SET seen='1' WHERE notif_id='$notif_id'");
		$is_there_a_new_notif = 1;
		break;
	}
}


//Updating Amount multiplier

$numUsers_online = 0;
$getnotifs = mysqli_query($con,"SELECT * FROM table2");
while($notifrow = mysqli_fetch_assoc($getnotifs))
{
	$last_login = strtotime($notifrow['last_login']);

	$time_diff_sec = $curr_time - $last_login;

	if($time_diff_sec<=60)
	{
		$numUsers_online++;
	}
}

//Amount Distributor Update

$time_sec = time();

$query = "SELECT * FROM amount_distributor ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);

$hour_start_time = $get['hour_start_time'];
$amount_left_prev_hour = $get['amount_left_this_hour'];
$amount_distributable_this_hour_x = $get['amount_distributable_this_hour'];

//Find average users online

$average_users_online = 0;
$average_users_online_row_count = 0;
$getposts = mysqli_query($con,"SELECT * FROM amount_distributor ORDER BY id DESC LIMIT 1440");
while($row = mysqli_fetch_assoc($getposts))
{
	$average_users_online = $average_users_online + $row["numUsers_online"];
	$average_users_online_row_count = $average_users_online_row_count + 1;
}

$average_users_online = $average_users_online/$average_users_online_row_count;
$amount_added_this_hour = max((0.10/60)*$average_users_online,(0.10/60)*$numUsers_online);
$amount_distributable_this_hour = $amount_added_this_hour + $amount_left_prev_hour;
$amount_left_this_hour = $amount_distributable_this_hour;

$time_diff = $time_sec - strtotime($hour_start_time);

if($time_diff >= 60)
{
	mysqli_query($con,"INSERT INTO amount_distributor (amount_added_this_hour, amount_distributable_this_hour, amount_left_this_hour, hour_start_time, numUsers_online) 
		VALUES ('$amount_added_this_hour','$amount_distributable_this_hour','$amount_left_this_hour','$datetime','$numUsers_online')");
}

if($numUsers_online == 0)
{
	$numUsers_online = 1;
}
$amount_multiplier = $amount_distributable_this_hour_x / $numUsers_online;

//Counting Read Duration

$read_id = mysqli_real_escape_string($con,$_POST['read_id']);

mysqli_query($con,"UPDATE read_history SET read_duration_sec = read_duration_sec + 10, end_time='$datetime' WHERE read_id = '$read_id'");


//Auto Saving Post Details

$auto_save_post_title = addslashes($_POST['auto_save_post_title']);
$auto_save_post_content = addslashes($_POST['auto_save_post_content']);
$auto_save_post_img_url = mysqli_real_escape_string($con,$_POST['auto_save_post_img_url']);
$auto_save_unique_id = mysqli_real_escape_string($con,$_POST['auto_save_unique_id']);
$auto_save_tag1 = mysqli_real_escape_string($con,$_POST['auto_save_tag1']);
$auto_save_tag2 = mysqli_real_escape_string($con,$_POST['auto_save_tag2']);
$auto_save_tag3 = mysqli_real_escape_string($con,$_POST['auto_save_tag3']);
$auto_save_tag4 = mysqli_real_escape_string($con,$_POST['auto_save_tag4']);
$auto_save_tag5 = mysqli_real_escape_string($con,$_POST['auto_save_tag5']);

mysqli_query($con,"UPDATE blogposts SET 
	post_title='$auto_save_post_title', post_img_url='$auto_save_post_img_url', post_content='$auto_save_post_content',
	tag1='$auto_save_tag1', tag2='$auto_save_tag2', tag3='$auto_save_tag3', tag4='$auto_save_tag4', tag5='$auto_save_tag5' 
	WHERE unique_id='$auto_save_unique_id'");

//Distributing Money to Bloggers

$getposts = mysqli_query($con,"SELECT * FROM read_history WHERE is_money_distributed='0'");
while($row = mysqli_fetch_assoc($getposts))
{
	$unique_id = $row["unique_id"];
	$read_id = $row["read_id"];
	$start_time = $row["start_time"];
	$end_time = $row["end_time"];
	$user_id_read = $row["user_id_read"];

	$read_history_read_duration_sec = strtotime($end_time) - strtotime($start_time);

	if($curr_time - strtotime($end_time) > 60)
	{
		$query = "SELECT * FROM blogposts WHERE unique_id='$unique_id'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$read_duration_sec = $get["read_duration_sec"];
		$blogger_unique_id = $get["blogger_unique_id"];
		$post_title = $get["post_title"];

		/*
		if($read_duration_sec < $read_history_read_duration_sec)
		{
			$read_history_read_duration_sec = $read_duration_sec;
		}
		*/

		$money_tobe_added = distribute($con,$read_duration_sec, "BLOG");

		if($read_history_read_duration_sec == 0)
		{
			$money_tobe_added = 0;
		}

		mysqli_query($con,"UPDATE blogposts SET post_earnings = post_earnings + '$money_tobe_added' WHERE unique_id='$unique_id'");
		mysqli_query($con,"UPDATE table2 SET user_points = user_points + '$money_tobe_added' WHERE unique_name='$blogger_unique_id'");
		if($read_history_read_duration_sec > 0)
		{
			mysqli_query($con,"UPDATE read_history SET is_money_distributed = '1', earnings = '$money_tobe_added' WHERE read_id = '$read_id'");	
		}
		else
		{
			//is_money_distributed = -2 if read duration is 0.
			mysqli_query($con,"UPDATE read_history SET is_money_distributed = '-2', earnings = '$money_tobe_added' WHERE read_id = '$read_id'");
		}

		if($money_tobe_added>0)
		{
			$query = "SELECT * FROM table2 WHERE unique_name='$blogger_unique_id'";
			$result = mysqli_query($con,$query);
			$get = mysqli_fetch_assoc($result);
			$user_pointsx = $get['user_points'];
			$emailx = $get['email'];

			mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
				VALUES ('$emailx','$user_pointsx','1729','Account credited Rs. $money_tobe_added on blogpost - $post_title','$datetime')");

			mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
				VALUES ('$emailx','Account credited Rs. $money_tobe_added on blogpost - $post_title','blogs/myposts.php?type=published_posts','$datetime','0')");
		}
	}
}

if($is_there_a_new_notif == 1)
{
	$result = array('status' => 1,'msg'=>'success', 'notif_text' => $notif_text, 'notif_href' => $notif_href, 'time_diff' => $time_diff_sec, 'other_status' => 2, 'other_msg'=>'success', 'amount_multiplier' => number_format(floor($amount_multiplier*100)/100,2,'.',''));
	echo json_encode($result);
}
else
{
	$result = array('status' => 0, 'other_status' => 2, 'other_msg'=>'success', 'amount_multiplier' => number_format(floor($amount_multiplier*100)/100,2,'.',''));
	echo json_encode($result);
}

?>