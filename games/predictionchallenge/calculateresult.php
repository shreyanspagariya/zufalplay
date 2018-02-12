<?php include ("./inc/header.inc.php"); ?>
<?php 

date_default_timezone_set("Asia/Kolkata");
$datetime = date("Y-m-d H:i:sa");

$bet_id = mysqli_real_escape_string($con,$_POST['betid']);
$bet_pseudo_id = $bet_id + 179245;
if($_POST['options']=="option1" || $_POST['options']=="option2")
{
	if($_POST['options']=="option1")
	{
		$bet_option = 1;
	}
	else if($_POST['options']=="option2")
	{
		$bet_option = 2;
	}

$x=1;
mysqli_query($con,"UPDATE bets SET bet_result_status='$x' WHERE betid='$bet_id'");

$lostpoints = 0;
$winpoints = 0;
$getposts = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$bet_id'");
while($row = mysqli_fetch_assoc($getposts))
{
	$user_bet_option = $row['bet_option'];
	$userid_placedby = $row['userid_placedby'];
	$stake_points = $row['stake_points'];
	if($user_bet_option != $bet_option)
	{
		$bet_status = -1;
		$lostpoints = $lostpoints + $stake_points;
	}
	else
	{
		$bet_status = 1;
		$winpoints = $winpoints + $stake_points;
	}
	mysqli_query($con,"UPDATE placedbets SET bet_status='$bet_status' WHERE bet_id='$bet_id' and userid_placedby='$userid_placedby'");
}
$getposts = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$bet_id'");
while($row = mysqli_fetch_assoc($getposts))
{
	$bet_status = $row['bet_status'];
	$stake_points = $row['stake_points'];
	$userid_placedby = $row['userid_placedby'];
	if($bet_status==1)
	{
		$getposts2 = mysqli_query($con,"SELECT * FROM table2 WHERE email='$userid_placedby'");
		while($row2 = mysqli_fetch_assoc($getposts2))
		{
			$user_points = $row2['user_points'];
			if($winpoints != 0)
			{
				$addpoints = $stake_points  * ($lostpoints + $winpoints) / $winpoints;
                //$addpoints = floor($addpoints);
				$user_points = $user_points + $addpoints;
				mysqli_query($con,"UPDATE table2 SET user_points='$user_points' WHERE email='$userid_placedby'");
				mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) VALUES ('$userid_placedby','$user_points','$bet_pseudo_id','Account credited Rs. $addpoints on challenge $bet_pseudo_id','$datetime')");
			}
		}
	}
	mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated) VALUES ('$userid_placedby','Challenge $bet_pseudo_id result declared.','games/predictionchallenge/challenge.php?u=$bet_pseudo_id','$datetime')");
}
header("Location: ".$g_g_url);
}
else if($_POST['options']=="option3")
{
	$getposts = mysqli_query($con,"SELECT * FROM bets WHERE betid = '$bet_id'");
	while($row = mysqli_fetch_assoc($getposts))
	{
		$bet_result_status = 1;
		mysqli_query($con,"UPDATE bets SET bet_result_status='$bet_result_status' WHERE betid='$bet_id'");
	}
	header("Location: ".$g_g_url);
}
else if($_POST['options']=="option4")
{
	$x=1;
	mysqli_query($con,"UPDATE bets SET bet_result_status='$x' WHERE betid='$bet_id'");
	$getposts = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$bet_id'");
	while($row = mysqli_fetch_assoc($getposts))
	{
		$userid_placedby = $row['userid_placedby'];
		$bet_status = 2;
		mysqli_query($con,"UPDATE placedbets SET bet_status='$bet_status' WHERE bet_id='$bet_id' and userid_placedby='$userid_placedby'");
	}
	
	$getposts = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$bet_id'");
	while($row = mysqli_fetch_assoc($getposts))
	{
		$bet_status = $row['bet_status'];
		$stake_points = $row['stake_points'];
		$userid_placedby = $row['userid_placedby'];
		if($bet_status==2)
		{
			$getposts2 = mysqli_query($con,"SELECT * FROM table2 WHERE email='$userid_placedby'");
			while($row2 = mysqli_fetch_assoc($getposts2))
			{
				$user_points = $row2['user_points'];
				$user_points = $user_points + $stake_points;
				mysqli_query($con,"UPDATE table2 SET user_points='$user_points' WHERE email='$userid_placedby'");
				mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) VALUES ('$userid_placedby','$user_points','$bet_pseudo_id','Account credited Rs. $stake_points on challenge $bet_pseudo_id','$datetime')");
			}
		}
		mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated) VALUES ('$userid_placedby','Challenge $bet_pseudo_id result declared.','games/predictionchallenge/challenge.php?u=$bet_pseudo_id','$datetime')");
	}
	header("Location: ".$g_g_url);
}
?>