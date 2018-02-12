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

date_default_timezone_set("Asia/Kolkata");
$datetime = date("Y-m-d H:i:sa");

$contest_id = 2;

$query = "SELECT * from long_contest_manager WHERE contest_id='$contest_id'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$contest_status = $get['contest_status'];

if($contest_status == 1)
{
	header("Location: ".$g_url."contests/long/gaming-woche-2");
}
else
{
	$query = "SELECT * FROM long_contest_leaderboard WHERE user='$email' AND contest_id='$contest_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);

	if($numResults == 0)
	{
		mysqli_query($con,"INSERT INTO long_contest_leaderboard (contest_id, user, time_registered) VALUES ('$contest_id', '$email', '$datetime')");
	}

	$start = 11;
	$end = 15;

	for($game_id = $start; $game_id <= $end; $game_id++)
	{
		$user = $email;

		$query = "SELECT * from game_leaderboard WHERE game_id='$game_id' AND is_competition='1' AND user='$user' AND game_week='0'";
		$result = mysqli_query($con,$query);
		$numResults = mysqli_num_rows($result);

		if($numResults == 0)
		{
			mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id,is_competition) VALUES ('0','$user','0','0','$game_id','1')");
			mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','$game_id','0','$datetime')");
		}
	}

	$query = "SELECT * from long_contest_manager WHERE contest_id='$contest_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$contest_status = $get['contest_status'];

	if($contest_status == -1)
	{
		header("Location: ".$g_url."contests/long/conteststart.php");
	}
	else if($contest_status == 0)
	{
		header("Location: ".$g_url."contests/long/gaming-woche-2");
	}
	else if($contest_status == 1)
	{
		header("Location: ".$g_url."contests/long/gaming-woche-2");
	}
}

?>