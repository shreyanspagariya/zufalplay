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
if($_REQUEST['mode'] == "pitch_zufals")
{
	$zufals_pitched = mysqli_real_escape_string($con,$_POST['zufals_pitched']);

	$query = "SELECT * from table2 where email='$email'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$user_points = $get['user_points'];

	if($zufals_pitched > $user_points)
	{
		$result = array('status' => 0, 'msg' => "You have Rs. ".$user_points." remaining in your account."." You cannot pitch more money than you have in your account!");
		echo json_encode($result);
	}
	else if($zufals_pitched < 0)
	{
		$result = array('status' => 0, 'msg' => "You cannot pitch in -ve money!");
		echo json_encode($result);
	}
    else if($zufals_pitched == 0)
	{
		$result = array('status' => 0, 'msg' => "You cannot pitch in Rs. 0!");
		echo json_encode($result);
	}
	else if(!is_numeric($zufals_pitched))
	{
		$result = array('status' => 0, 'msg' => "Please enter a positive number!");
		echo json_encode($result);
	}
	else
	{
		$result = array('status' => 1, 'msg' => "success");
		echo json_encode($result);
	}
}
?>