<?php include ("../inc/header.inc.php"); ?>
<?php
	date_default_timezone_set("Asia/Kolkata");
	$datetime = date("Y-m-d H:i:sa");

	$prod_id = mysqli_real_escape_string($con,$_POST['prodid']);
	$user_name = $fname." ".$lname;

	$query = "SELECT * from zufal_products WHERE prod_id='$prod_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$prod_name = $get['prod_name'];
	$zufal_price = $get['prod_zufalprice'];
	$client = $get['client'];

	$user_newpoints = $user_points - $zufal_price;

	if($user_newpoints>=0)
	{
		mysqli_query($con,"INSERT INTO prod_orders (prod_id,user_email,prod_name,user_name,zufal_price) 
			VALUES ('$prod_id','$email','$prod_name','$user_name','$zufal_price')");

		mysqli_query($con,"UPDATE table2 SET user_points='$user_newpoints' WHERE email='$email'");

		mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time)
		 VALUES ('$email','$user_newpoints','$prod_id','Account debited $zufal_price Zufal(s) on purchasing $prod_name ($client)','$datetime')");

		$query = "SELECT * FROM coupons WHERE is_assigned='0' AND prod_id='$prod_id' LIMIT 1";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$coupon_code = $get['coupon_code'];

		mysqli_query($con,"UPDATE coupons SET is_assigned='1', user_assigned_to='$email', time_assigned='$datetime' WHERE coupon_code='$coupon_code'");

		$_SESSION["coupon_code"] = $coupon_code;

		header("Location:couponshow.php?cc=".$coupon_code);
	}
?>