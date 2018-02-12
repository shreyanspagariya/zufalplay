<?php include ("./inc/connect.inc.php"); ?>
<?php
$id_token = mysqli_real_escape_string($con,$_POST['id_token']);
$campaign_id = mysqli_real_escape_string($con,$_POST['campaign_id']);

$result = file_get_contents("https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=$id_token", false);

//$result = array('status' => 1, 'msg' => $id_token);
$res1 = json_decode($result, true);
//echo json_encode($res1);

date_default_timezone_set("Asia/Kolkata");
$datetime = date("Y-m-d H:i:sa");

$fname = $res1['given_name'];
$lname = $res1['family_name'];
$google_id = $res1['sub'];
if(array_key_exists("picture",$res1))
{
	$google_picture_url = $res1['picture'];
}
else
{
	$google_picture_url = "https://s.ytimg.com/yts/img/avatar_720-vflYJnzBZ.png";
}
$email = $res1['email'];
$google_locale = $res1['locale'];

$nakedemail = $email;
$nakedemail = str_replace(array('.', ','), '' , $nakedemail);

$query = "SELECT nakedemail FROM table2 where nakedemail='$nakedemail'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);

if($numResults==0)
{
	mysqli_query($con,"INSERT INTO table2 (fname,lname,email,nakedemail,google_id,google_picture_url,google_locale,verified,campaign_id) 
		VALUES ('$fname','$lname','$email','$nakedemail','$google_id','$google_picture_url','$google_locale','1','$campaign_id')");

	$new_user_name = $fname." ".$lname;
	$gameweek = 0;

	mysqli_query($con,"UPDATE campaign_leaderboard SET signups=signups+1 WHERE campaign_id='$campaign_id' AND game_week='$gameweek'");

	$query = "SELECT * FROM campaign_leaderboard WHERE campaign_id='$campaign_id' AND game_week='$gameweek'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$referrer_email = $get["user_email"];

	$query = "SELECT * from table2 where email='$referrer_email'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$user_pointsx = $get['user_points'];
	$addpoints = 2;
	$user_pointsx+=$addpoints;

	mysqli_query($con,"UPDATE campaign_leaderboard SET rupees_earned=rupees_earned+'$addpoints' WHERE campaign_id='$campaign_id' AND game_week='$gameweek'");
	
	mysqli_query($con,"UPDATE table2 SET user_points='$user_pointsx' WHERE email='$referrer_email'");
	
	mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
			VALUES ('$referrer_email','$user_pointsx','$gameweek','Account credited Rs. $addpoints on inviting $new_user_name to Zufalplay.','$datetime')");

	mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
	VALUES ('$referrer_email','Account credited Rs. $addpoints on inviting $new_user_name to Zufalplay.','pointslog.php','$datetime','0')");

	$result = array('status' => 1,'msg'=>'success','user'=>'0');
	echo json_encode($result);
}
else
{
	$query = "SELECT * from table2 WHERE email='$email'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$google_id_before = $get['google_id'];
	$password = $get['password'];

	if($google_id_before=="")
	{
		mysqli_query($con,"UPDATE table2 SET google_id='$google_id', google_picture_url='$google_picture_url', 
			google_locale='$google_locale', verified='1' WHERE email='$email'");
	}
	mysqli_query($con,"UPDATE table2 SET google_picture_url='$google_picture_url' WHERE email='$email'");

	if($password!="")
	{
		$result = array('status' => 1,'msg'=>'success','user'=>'1');
		echo json_encode($result);
	}
	else
	{
		$result = array('status' => 1,'msg'=>'success','user'=>'0');
		echo json_encode($result);
	}
}

session_start();
$_SESSION["email1"] = $email;

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

mysqli_query($con,"UPDATE table2 SET login_count=login_count+1, last_login='$datetime' WHERE email='$email'");
mysqli_query($con,"INSERT INTO login_details (user_email,user_name,login_type,login_time,ip_address) VALUES ('$email','$fname $lname','Google','$datetime','$ip')");

?>