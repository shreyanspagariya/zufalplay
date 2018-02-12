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

$contest_id = 2;

$query = "SELECT * FROM short_contest_leaderboard WHERE user='$email' AND contest_id='$contest_id'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);

if($numResults == 0)
{
	mysqli_query($con,"INSERT INTO short_contest_leaderboard (contest_id, user) VALUES ('$contest_id', '$email')");
}

$query = "SELECT * from short_contest_manager";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$contest_status = $get['contest_status'];

if($contest_status == -1)
{
	header("Location: ".$g_url."contests/short/conteststart.php");
}
else if($contest_status == 0)
{
	header("Location: ".$g_url."contests/short/swap");
}
else if($contest_status == 1)
{
	header("Location: ".$g_url."contests/short/leaderboard.php?id=2");
}

?>