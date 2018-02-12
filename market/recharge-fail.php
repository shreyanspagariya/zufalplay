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

$order_id = mysqli_real_escape_string($con,$_POST['fail_order_id']);
$fail_reason = mysqli_real_escape_string($con,$_POST['fail_reason_order_id']);

$query = "SELECT * from prod_orders where order_id='$order_id'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$is_complete = $get['is_complete'];
$zufal_price = $get['zufal_price'];
$prod_name = $get['prod_name'];
$user_phno = $get['user_phno'];
$orderer_email = $get['user_email'];

$query = "SELECT * from table2 where email='$orderer_email'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$user_points = $get['user_points'];

if($is_complete == 0)
{
	$user_points = $user_points + $zufal_price;

	mysqli_query($con,"UPDATE table2 SET user_points='$user_points' WHERE email='$orderer_email'");

	mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time)
	 VALUES ('$orderer_email','$user_points','$order_id','Rs. $zufal_price refunded to account on failed $prod_name for Mobile No. $user_phno. Reason: $fail_reason','$datetime')");

	mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
		VALUES ('$orderer_email','Rs. $zufal_price refunded to account on failed $prod_name for Mobile No. $user_phno. Reason: $fail_reason','pointslog.php','$datetime','0')");

	mysqli_query($con,"UPDATE prod_orders SET is_complete='-1', order_complete_time='$datetime' WHERE order_id='$order_id'");
}

header("Location: ".$g_url."admin.php");

?>