<?php include ("./inc/header.inc.php"); ?>
<?php 
$userid_placedby = $email;
if($_POST['options']=="option1")
{
	$bet_option = 1;
}
else
{
	$bet_option = 2;
}
$stake_points = mysqli_real_escape_string($con,$_POST['betpoints']);
$bet_id = mysqli_real_escape_string($con,$_POST['betid']);
$bet_pseudo_id = $bet_id + 179245;

$query = "SELECT * from bets WHERE betid='$bet_id' AND bet_result_status='0'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);

$getposts = mysqli_query($con,"SELECT * FROM table2 WHERE email='$email'");
while($row = mysqli_fetch_assoc($getposts))
{
	$user_points=$row['user_points'];
	$useridx = $row['Id'];
}

if($numResults!=0 && $stake_points > 0 && $user_points-$stake_points>=0)
{
	$getposts = mysqli_query($con,"SELECT * FROM bets WHERE betid='$bet_id'");
	while($row = mysqli_fetch_assoc($getposts))
	{
		if($bet_option==1)
		{
			$option1_users = $row['option1_users'];
			$option1_users = $option1_users + 1;
			$option1_points = $row['option1_points'];
			$option1_points = $option1_points + $stake_points;
			mysqli_query($con, "UPDATE bets SET option1_users = '$option1_users' WHERE betid='$bet_id'");
			mysqli_query($con, "UPDATE bets SET option1_points = '$option1_points' WHERE betid='$bet_id'");
		}
		else
		{
			$option2_users = $row['option2_users'];
			$option2_users = $option2_users + 1;
			$option2_points = $row['option2_points'];
			$option2_points = $option2_points + $stake_points;
			mysqli_query($con, "UPDATE bets SET option2_users = '$option2_users' WHERE betid='$bet_id'");
			mysqli_query($con, "UPDATE bets SET option2_points = '$option2_points' WHERE betid='$bet_id'");
		}
	}

	date_default_timezone_set("Asia/Kolkata");
	$datetime = date("Y-m-d H:i:sa");

	mysqli_query($con,"INSERT INTO placedbets (userid_placedby,bet_option,stake_points,bet_id,time_placed) VALUES ('$userid_placedby','$bet_option','$stake_points','$bet_id','$datetime')");
	mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$userid_placedby','1','$bet_id','$datetime')");
	mysqli_query($con,"INSERT INTO recent_activity (user_email,game_id,gameweek,game_score,activity_time) VALUES ('$userid_placedby','1','$bet_id','$stake_points','$datetime')");

	$getposts = mysqli_query($con,"SELECT * FROM table2 WHERE email='$email'");
	while($row = mysqli_fetch_assoc($getposts))
	{
		$user_points=$row['user_points'];
		$useridx = $row['Id'];
	}
	$user_points = $user_points - $stake_points;
	mysqli_query($con,"UPDATE table2 SET user_points='$user_points' where email='$email'");
	mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) VALUES ('$email','$user_points','$bet_pseudo_id','Account debited Rs. $stake_points on challenge $bet_pseudo_id','$datetime')");
	mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
			VALUES ('$email','Account debited Rs. $stake_points on challenge $bet_pseudo_id','games/predictionchallenge/challenge.php?u=$bet_pseudo_id','$datetime','0')");
}
header("Location: ".$g_g_url);
?>