<?php include("./inc/connect.inc.php"); ?>
<?php 

date_default_timezone_set("Asia/Kolkata");
$datetime = date("Y-m-d H:i:sa");

/*Fetching POST variables from index.php*/
$email1 = mysqli_real_escape_string($con,$_POST['email']);
$password1 = mysqli_real_escape_string($con,$_POST['password']);
$fb_picture_url = mysqli_real_escape_string($con,$_POST['fb_picture_url']);
$password2 = md5($password1);


$strSQL = mysqli_query($con,"SELECT email from table2 where email='$email1' and password='$password2'");
$Results = mysqli_fetch_array($strSQL);

if(count($Results)>=1)
{
	$getposts = mysqli_query($con,"SELECT * FROM table2 WHERE email = '$email1'");
	while($row = mysqli_fetch_assoc($getposts))
	{
		$login_count=$row['login_count'];
		$fnamel=$row['fname'];
		$lnamel=$row['lname'];
		$verified=$row['verified'];
	}
	if($verified==1)
	{
		if($fb_picture_url!="")
		{
			$query1 = "UPDATE table2 SET fb_picture_url='$fb_picture_url' WHERE email='$email1'";
			mysqli_query($con,$query1);
		}

		session_start();
		if(isset($_SESSION['fb_id']))
		{
			$query = "UPDATE table2 SET fb_id=".$_SESSION['fb_id']." WHERE email='$email1'";
			mysqli_query($con,$query);
		}
		$namel=$fnamel." ".$lnamel;
		$login_count=$login_count+1;

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

		mysqli_query($con,"UPDATE table2 SET login_count='$login_count', last_login='$datetime' WHERE email='$email1'");
		mysqli_query($con,"INSERT INTO login_details (user_email,user_name,login_type,login_time,ip_address) VALUES ('$email1','$namel','Zufalplay','$datetime','$ip')");
		$_SESSION["email1"] = $email1;
		$result = array('status' => 1, 'msg' => 'Credentials matched');
		echo json_encode($result);
	}
	else
	{
		$result = array('status' => 1, 'msg' => 'not_verified');
		echo json_encode($result);
	}
}
else
{
	$result = array('status' => 0, 'msg' => 'Credentials mismatched');
	echo json_encode($result);
}        
?>