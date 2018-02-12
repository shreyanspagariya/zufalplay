<?php 
include ("../../../inc/connect.inc.php"); 
date_default_timezone_set('Asia/Calcutta');
$datetime = date("Y-m-d H:i:sa");

session_start();
$email = $_SESSION["email1"];

if(isset($email) && $email && $email!="") {

$query = "SELECT * from table2 WHERE email='$email'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$fnamex = $get['fname'];

$challenge_id = mysqli_real_escape_string($con,$_GET['challengeida']);

echo $challenge_id;

mysqli_query($con,"UPDATE coil_oneonone SET challenge_status='0' WHERE challenge_id='$challenge_id' AND challenge_status='-1'");

$query = "SELECT * from coil_oneonone WHERE challenge_id='$challenge_id'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$from_user_email = $get['from_user_email'];

mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated) VALUES ('$from_user_email','$fnamex has accepted your challenge request.',
	'games/one-on-one/coil/game.php?u=$challenge_id','$datetime')");

$query = "SELECT * from profile_tempfill WHERE user_email='$from_user_email' AND game_id='106' AND gameweek='$challenge_id'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);
if($numResults==0)
{
	mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$from_user_email','106','$challenge_id','$datetime')");
}

$query = "SELECT * from profile_tempfill WHERE user_email='$email' AND game_id='106' AND gameweek='$challenge_id'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);
if($numResults==0)
{
	mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','106','$challenge_id','$datetime')");
}

header("Location: ".$g_url."games/one-on-one/coil/game.php?u=".$challenge_id);

}

?>

