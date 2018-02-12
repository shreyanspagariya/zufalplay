<?php include ("../../inc/connect.inc.php");

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
$user_points = $get['user_points'];

if($_REQUEST['mode'] == "complete_donation")
{
	$unique_id = mysqli_real_escape_string($con,$_POST['unique_id']);
	$donation_amount = mysqli_real_escape_string($con,$_POST['donation_amount']);

	$query = "SELECT * from donate_posts WHERE unique_id='$unique_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$post_title = $get['post_title'];
	$post_url = $get['post_url'];

	$landing_url = "donate/details.php?title=".$post_url."&d=".$unique_id;

	$user_newpoints = $user_points - $donation_amount;

	if($donation_amount <= 0)
	{
		$result = array('status' => -1, 'msg' => 'fail');
		echo json_encode($result);
	}
	else if($user_newpoints>=0)
	{
		mysqli_query($con,"INSERT INTO donations (user_email, unique_id, amount_donated, time_donated) VALUES ('$email', '$unique_id', '$donation_amount', '$datetime')");

		mysqli_query($con,"UPDATE donate_posts SET collection=collection+'$donation_amount' WHERE unique_id='$unique_id'");

		mysqli_query($con,"UPDATE table2 SET user_points='$user_newpoints' WHERE email='$email'");

		mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time)
		 VALUES ('$email','$user_newpoints','$unique_id','Account debited Rs. $donation_amount on donating to $post_title','$datetime')");

		mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
			VALUES ('$email','Account debited Rs. $donation_amount on donating to $post_title','$landing_url','$datetime','0')");

		$result = array('status' => 1, 'msg' => 'success', 'user_points' => $user_newpoints);
		echo json_encode($result);
	}
	else
	{
		$result = array('status' => 0, 'msg' => 'fail');
		echo json_encode($result);
	}
}
?>