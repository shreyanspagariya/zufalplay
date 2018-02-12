<?php 
include ("../../../inc/connect.inc.php"); 
date_default_timezone_set('Asia/Calcutta');
$datetime = date("Y-m-d H:i:sa");

session_start();
$email = $_SESSION["email1"];

$user_id = mysqli_real_escape_string($con,$_POST['userid']);

$query = "SELECT * from table2 WHERE Id='$user_id'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$to_user_email = $get['email'];

$query = "SELECT * from table2 WHERE email='$email'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$fnamex = $get['fname'];

function generateRandomString($length = 9) {
    $characters = '123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$challenge_id = generateRandomString();

$query = "SELECT * from pappupakia_oneonone WHERE challenge_id='$challenge_id'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);

while($numResults!=0)
{
	$challenge_id = generateRandomString();
	$query = "SELECT * from pappupakia_oneonone WHERE challenge_id='$challenge_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
}

mysqli_query($con,"INSERT INTO pappupakia_oneonone (challenge_status,from_user_email,to_user_email,request_time,challenge_id) 
	VALUES ('-1','$email','$to_user_email','$datetime','$challenge_id')");

mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated) VALUES ('$to_user_email','One-on-One Challenge request from $fnamex.',
    'games/one-on-one/pappu-pakia/game.php?u=$challenge_id','$datetime')");

header("Location: ".$g_url."games/one-on-one/pappu-pakia/game.php?u=".$challenge_id);

?>