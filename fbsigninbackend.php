<?php include ("./inc/connect.inc.php"); ?>
<?php
$res1 = $_POST['user'];
$campaign_id =  mysqli_real_escape_string($con,$_POST['campaign_id']);

$fname = $res1['first_name'];
$lname = $res1['last_name'];
$fb_id = $res1['id'];
$fb_picture_url = $res1["picture"]["data"]["url"];

date_default_timezone_set("Asia/Kolkata");
$datetime = date("Y-m-d H:i:sa");

if($fb_id!="")
{
	$query = "SELECT fb_id FROM table2 WHERE fb_id='$fb_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);

	if($numResults>0)
	{
		$query = "SELECT * from table2 WHERE fb_id='$fb_id'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$numResults_email = mysqli_num_rows($result);
		if($numResults_email>0)
		{
			$email = $get['email'];
			$verified = $get['verified'];
			if($verified==1)
			{
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
				mysqli_query($con,"INSERT INTO login_details (user_email,user_name,login_type,login_time,ip_address) VALUES ('$email','$fname $lname','Facebook','$datetime','$ip')");

				$result = array('status' => 1,'msg'=>'success', 'user'=>'1', 'fb'=>'1', 'verified'=>'1');
				echo json_encode($result);
			}
			else
			{
				$result = array('status' => 1,'msg'=>'success', 'user'=>'1', 'fb'=>'1', 'verified'=>'0');
				echo json_encode($result);
			}
		}
		else
		{
			session_start();
			$_SESSION["fb_id"] = $fb_id;
			$_SESSION["fname"] = $fname;
			$_SESSION["lname"] = $lname;
			$_SESSION["fb_picture_url"] = $fb_picture_url;
			$_SESSION["campaign_id"] = $campaign_id;

			$result = array('status' => 1,'msg'=>'success', 'user'=>'0', 'fb'=>'1');
			echo json_encode($result);
		}
	}
	else
	{
		session_start();
		$_SESSION["fb_id"] = $fb_id;
		$_SESSION["fname"] = $fname;
		$_SESSION["lname"] = $lname;
		$_SESSION["fb_picture_url"] = $fb_picture_url;
		$_SESSION["campaign_id"] = $campaign_id;
		
		$result = array('status' => 1,'msg'=>'success', 'user'=>'0', 'fb'=>'0');
		echo json_encode($result);
	}
}

?>