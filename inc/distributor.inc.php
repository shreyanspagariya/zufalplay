<?php

function distribute($con, $time_length, $activity)
{
	date_default_timezone_set("Asia/Kolkata");
	$curr_time = time();
	
	$numUsers_online = 0;
	$getnotifs = mysqli_query($con,"SELECT * FROM table2");
	while($notifrow = mysqli_fetch_assoc($getnotifs))
	{
		$last_login = strtotime($notifrow['last_login']);

		$time_diff_sec = $curr_time - $last_login;

		if($time_diff_sec<=60)
		{
			$numUsers_online++;
		}
	}

	if($numUsers_online == 0)
	{
		$numUsers_online = 1;
	}

	$query = "SELECT * from amount_distributor ORDER BY id DESC LIMIT 1";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);

	$amount_distributable_this_hour = $get['amount_distributable_this_hour'];
	$amount_distributor_id = $get["id"];

	$amount_multiplier = $amount_distributable_this_hour / $numUsers_online;

	$amount_per_user_per_hour = 1*$amount_multiplier;

	if($activity == "GAME")
	{
		$amount = 1 * ( ($time_length/3600) * $amount_per_user_per_hour );
	}
	else if($activity == "VIDEO")
	{
		$amount = 1 * ( sqrt($time_length/(3600*60)) * $amount_per_user_per_hour );
	}
	else if($activity == "BLOG")
	{
		$amount = 1 * ( ($time_length/3600) * $amount_per_user_per_hour );
	}
	
	$result = array('amount_distributable_this_hour' => $amount_distributable_this_hour, 'time_length' => $time_length, 'numUsers_online' => $numUsers_online);

	if(isset($_SESSION["email1"]))
	{
		mysqli_query($con,"UPDATE amount_distributor SET amount_left_this_hour = amount_left_this_hour - '$amount' WHERE id = '$amount_distributor_id'");
	}

	$amount = floor($amount * 10000) / 10000;

	return($amount);
}

?>