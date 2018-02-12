<?php include ("../inc/connect.inc.php");

session_start();
if(isset($_SESSION["email1"]))
{
	$email = $_SESSION["email1"];
}
else
{
	$email = "EXTUSER";
}

date_default_timezone_set('Asia/Kolkata');
$time = time();
$datetime = date("Y-m-d H:i:sa");

$query = "SELECT * from table2 where email='$email'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$fname = $get['fname'];
$lname = $get['lname'];
$user_points = $get['user_points'];

if($_REQUEST['mode'] == "complete_recharge")
{
	$prod_id = mysqli_real_escape_string($con,$_POST['prod_id']);
	$user_phno = mysqli_real_escape_string($con,$_POST['user_phno']);

	if(!(strlen($user_phno) == 10 && is_numeric($user_phno)))
	{
		$result = array('status' => -1, 'msg' => 'Invalid Mobile No.');
		echo json_encode($result);
	}
	else
	{
		$user_name = $fname." ".$lname;

		$query = "SELECT * from zufal_products WHERE prod_id='$prod_id'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$prod_name = $get['prod_name'];
		$zufal_price = $get['prod_zufalprice'];

		$user_newpoints = $user_points - $zufal_price;

		if($user_newpoints>=0)
		{
			mysqli_query($con,"INSERT INTO prod_orders (prod_id,user_email,prod_name,user_name,zufal_price,user_phno,time_bought) 
				VALUES ('$prod_id','$email','$prod_name','$user_name','$zufal_price','$user_phno','$datetime')");

			mysqli_query($con,"UPDATE table2 SET user_points='$user_newpoints' WHERE email='$email'");

			mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time)
			 VALUES ('$email','$user_newpoints','$prod_id','Account debited Rs. $zufal_price on $prod_name for Mobile No. $user_phno','$datetime')");

			mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
				VALUES ('$email','Account debited Rs. $zufal_price on $prod_name for Mobile No. $user_phno','pointslog.php','$datetime','0')");

			$result = array('status' => 1, 'msg' => 'success', 'user_points' => $user_newpoints);
			echo json_encode($result);
		}
		else
		{
			$result = array('status' => 0, 'msg' => 'fail');
			echo json_encode($result);
		}
	}
}
?>