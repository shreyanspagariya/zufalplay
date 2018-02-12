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

$order_id = mysqli_real_escape_string($con,$_POST['success_order_id']);

mysqli_query($con,"UPDATE prod_orders SET is_complete='1', order_complete_time='$datetime' WHERE order_id='$order_id'");

header("Location: ".$g_url."admin.php");

?>