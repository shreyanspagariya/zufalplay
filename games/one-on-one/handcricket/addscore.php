<?php 
include ("../../../inc/connect.inc.php"); 
date_default_timezone_set('Asia/Calcutta');
$datetime = date("Y-m-d H:i:sa");

session_start();
$email = $_SESSION["email1"];

$challenge_id = mysqli_real_escape_string($con,$_POST['challenge_id']);

$query = "SELECT * from handcricket_oneonone WHERE challenge_id='$challenge_id'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);
$get = mysqli_fetch_assoc($result);
$from_user_email = $get['from_user_email'];
$to_user_email = $get['to_user_email'];
$from_user_isout = $get['from_user_isout'];
$to_user_isout = $get['to_user_isout'];

if($email==$from_user_email)
{
	if($_REQUEST['mode'] == "add_score")
	{
		$result = array('status' => 0,'msg'=>'');
		$this_score = mysqli_real_escape_string($con,$_POST['this_score']);
		$challenge_id = mysqli_real_escape_string($con,$_POST['challenge_id']);
		if($this_score > 6 || $this_score < 1)
		{
			$result = array('status' => 1, 'msg' => 'cheater');
			echo json_encode($result);
		}
		else
		{
			$gen_num = rand(1,6);
			
			if($gen_num == $this_score)
			{
				$query = "UPDATE handcricket_oneonone SET from_user_isout = '1' WHERE challenge_id='$challenge_id'";
				mysqli_query($con,$query);
				if($to_user_isout==1)
				{
					$query = "UPDATE handcricket_oneonone SET challenge_status = '1' WHERE challenge_id='$challenge_id'";
					mysqli_query($con,$query);

					$query = "SELECT * from handcricket_oneonone WHERE challenge_id='$challenge_id'";
					$result = mysqli_query($con,$query);
					$numResults = mysqli_num_rows($result);
					$get = mysqli_fetch_assoc($result);
					$from_user_email = $get['from_user_email'];
					$to_user_email = $get['to_user_email'];
					$from_user_isout = $get['from_user_isout'];
					$to_user_isout = $get['to_user_isout'];
					$from_user_score = $get['from_user_score'];
					$to_user_score = $get['to_user_score'];

					if($from_user_score > $to_user_score)
					{
						mysqli_query($con,"UPDATE table2 SET user_points=user_points+2 WHERE email='$from_user_email'");
						mysqli_query($con,"UPDATE table2 SET user_points=user_points-2 WHERE email='$to_user_email'");

						$query = "SELECT * from table2 WHERE email='$from_user_email'";
						$result = mysqli_query($con,$query);
						$get = mysqli_fetch_assoc($result);
						$from_user_fname = $get['fname'];
						$from_user_points = $get['user_points'];

						$query = "SELECT * from table2 WHERE email='$to_user_email'";
						$result = mysqli_query($con,$query);
						$get = mysqli_fetch_assoc($result);
						$to_user_fname = $get['fname'];
						$to_user_points = $get['user_points'];

						mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
							VALUES ('$from_user_email','$from_user_points','$challenge_id','
								Account credited 2 Zufal(s) on winning the One-on-One Hand Cricket match $from_user_score-$to_user_score against $to_user_fname','$datetime')");

						mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
							VALUES ('$to_user_email','$to_user_points','$challenge_id','
								Account debited 2 Zufal(s) on losing the One-on-One Hand Cricket match $to_user_score-$from_user_score against $from_user_fname','$datetime')");

					}
					else if($to_user_score > $from_user_score)
					{
						mysqli_query($con,"UPDATE table2 SET user_points=user_points-2 WHERE email='$from_user_email'");
						mysqli_query($con,"UPDATE table2 SET user_points=user_points+2 WHERE email='$to_user_email'");

						$query = "SELECT * from table2 WHERE email='$from_user_email'";
						$result = mysqli_query($con,$query);
						$get = mysqli_fetch_assoc($result);
						$from_user_fname = $get['fname'];
						$from_user_points = $get['user_points'];

						$query = "SELECT * from table2 WHERE email='$to_user_email'";
						$result = mysqli_query($con,$query);
						$get = mysqli_fetch_assoc($result);
						$to_user_fname = $get['fname'];
						$to_user_points = $get['user_points'];

						mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
							VALUES ('$from_user_email','$from_user_points','$challenge_id','
								Account debited 2 Zufal(s) on losing the One-on-One Hand Cricket match $from_user_score-$to_user_score against $to_user_fname','$datetime')");

						mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
							VALUES ('$to_user_email','$to_user_points','$challenge_id','
								Account credited 2 Zufal(s) on winning the One-on-One Hand Cricket match $to_user_score-$from_user_score against $from_user_fname','$datetime')");
					}
				}

				$query = "SELECT * from handcricket_oneonone WHERE challenge_id='$challenge_id'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$get = mysqli_fetch_assoc($result);
				$from_user_email = $get['from_user_email'];
				$to_user_email = $get['to_user_email'];
				$from_user_isout = $get['from_user_isout'];
				$to_user_isout = $get['to_user_isout'];
				$from_user_score = $get['from_user_score'];
				$to_user_score = $get['to_user_score'];

				mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated) VALUES ('$to_user_email','Your opponent has finished the match.','games/one-on-one/handcricket/game.php?u=$challenge_id','$datetime')");
				mysqli_query($con,"INSERT INTO recent_activity (user_email,game_id,gameweek,game_score,activity_time) VALUES ('$email','102','$challenge_id','$from_user_score','$datetime')");
				mysqli_query($con,"UPDATE profile_tempfill SET time='$datetime' WHERE user_email='$email' AND game_id='102' AND gameweek='$challenge_id'");
				$result = array('status' => 1, 'msg' => 'out', 'gen' => $gen_num, 'high' => 0);
				echo json_encode($result);
			}
			else
			{	
				$query = "SELECT * FROM handcricket_oneonone WHERE challenge_id='$challenge_id'";
				$getposts = mysqli_query($con,$query);
				while($row = mysqli_fetch_assoc($getposts))
				{
					$from_user_score = $row['from_user_score'];
					$from_user_score += $this_score;
					$from_user_isout = $row['from_user_isout'];
				}
				if($from_user_isout==0)
				{
					$query = "UPDATE handcricket_oneonone SET from_user_score = '$from_user_score' WHERE challenge_id='$challenge_id'";
					mysqli_query($con,$query); 
					$result = array('status' => 1, 'msg' => 'score updated', 'gen' => $gen_num, 'score' => $from_user_score);
					echo json_encode($result);
				}
			}
			
		}
	}
}
else if($email==$to_user_email)
{
	if($_REQUEST['mode'] == "add_score")
	{
		$result = array('status' => 0,'msg'=>'');
		$this_score = mysqli_real_escape_string($con,$_POST['this_score']);
		$challenge_id = mysqli_real_escape_string($con,$_POST['challenge_id']);
		if($this_score > 6 || $this_score < 1)
		{ 
			$result = array('status' => 1, 'msg' => 'cheater');
			echo json_encode($result);
		}
		else
		{
			$gen_num = rand(1,6);
			
			if($gen_num == $this_score)
			{
				$query = "UPDATE handcricket_oneonone SET to_user_isout = '1' WHERE challenge_id='$challenge_id'";
				mysqli_query($con,$query); 
				if($from_user_isout==1)
				{
					$query = "UPDATE handcricket_oneonone SET challenge_status = '1' WHERE challenge_id='$challenge_id'";
					mysqli_query($con,$query);
					$query = "SELECT * from handcricket_oneonone WHERE challenge_id='$challenge_id'";
					$result = mysqli_query($con,$query);
					$numResults = mysqli_num_rows($result);
					$get = mysqli_fetch_assoc($result);
					$from_user_email = $get['from_user_email'];
					$to_user_email = $get['to_user_email'];
					$from_user_isout = $get['from_user_isout'];
					$to_user_isout = $get['to_user_isout'];
					$from_user_score = $get['from_user_score'];
					$to_user_score = $get['to_user_score'];

					if($from_user_score > $to_user_score)
					{
						mysqli_query($con,"UPDATE table2 SET user_points=user_points+2 WHERE email='$from_user_email'");
						mysqli_query($con,"UPDATE table2 SET user_points=user_points-2 WHERE email='$to_user_email'");

						$query = "SELECT * from table2 WHERE email='$from_user_email'";
						$result = mysqli_query($con,$query);
						$get = mysqli_fetch_assoc($result);
						$from_user_fname = $get['fname'];
						$from_user_points = $get['user_points'];

						$query = "SELECT * from table2 WHERE email='$to_user_email'";
						$result = mysqli_query($con,$query);
						$get = mysqli_fetch_assoc($result);
						$to_user_fname = $get['fname'];
						$to_user_points = $get['user_points'];

						mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
							VALUES ('$from_user_email','$from_user_points','$challenge_id','
								Account credited 2 Zufal(s) on winning the One-on-One Hand Cricket match $from_user_score-$to_user_score against $to_user_fname','$datetime')");

						mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
							VALUES ('$to_user_email','$to_user_points','$challenge_id','
								Account debited 2 Zufal(s) on losing the One-on-One Hand Cricket match $to_user_score-$from_user_score against $from_user_fname','$datetime')");

					}
					else if($to_user_score > $from_user_score)
					{
						mysqli_query($con,"UPDATE table2 SET user_points=user_points-2 WHERE email='$from_user_email'");
						mysqli_query($con,"UPDATE table2 SET user_points=user_points+2 WHERE email='$to_user_email'");

						$query = "SELECT * from table2 WHERE email='$from_user_email'";
						$result = mysqli_query($con,$query);
						$get = mysqli_fetch_assoc($result);
						$from_user_fname = $get['fname'];
						$from_user_points = $get['user_points'];

						$query = "SELECT * from table2 WHERE email='$to_user_email'";
						$result = mysqli_query($con,$query);
						$get = mysqli_fetch_assoc($result);
						$to_user_fname = $get['fname'];
						$to_user_points = $get['user_points'];

						mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
							VALUES ('$from_user_email','$from_user_points','$challenge_id','
								Account debited 2 Zufal(s) on losing the One-on-One Hand Cricket match $from_user_score-$to_user_score against $to_user_fname','$datetime')");

						mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
							VALUES ('$to_user_email','$to_user_points','$challenge_id','
								Account credited 2 Zufal(s) on winning the One-on-One Hand Cricket match $to_user_score-$from_user_score against $from_user_fname','$datetime')");
					}
				}

				$query = "SELECT * from handcricket_oneonone WHERE challenge_id='$challenge_id'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);
				$get = mysqli_fetch_assoc($result);
				$from_user_email = $get['from_user_email'];
				$to_user_email = $get['to_user_email'];
				$from_user_isout = $get['from_user_isout'];
				$to_user_isout = $get['to_user_isout'];
				$from_user_score = $get['from_user_score'];
				$to_user_score = $get['to_user_score'];

				mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated) VALUES ('$from_user_email','Your opponent has finished the match.','games/one-on-one/handcricket/game.php?u=$challenge_id','$datetime')");
				mysqli_query($con,"INSERT INTO recent_activity (user_email,game_id,gameweek,game_score,activity_time) VALUES ('$email','102','$challenge_id','$to_user_score','$datetime')");
				mysqli_query($con,"UPDATE profile_tempfill SET time='$datetime' WHERE user_email='$email' AND game_id='102' AND gameweek='$challenge_id'");
				$result = array('status' => 1, 'msg' => 'out', 'gen' => $gen_num, 'high' => 0);
				echo json_encode($result);
			}
			else
			{	
				$query = "SELECT * FROM handcricket_oneonone WHERE challenge_id='$challenge_id'";
				$getposts = mysqli_query($con,$query);
				while($row = mysqli_fetch_assoc($getposts))
				{
					$to_user_score = $row['to_user_score'];
					$to_user_score += $this_score;
					$to_user_isout = $row['to_user_isout'];
				}
				if($to_user_isout==0)
				{
					$query = "UPDATE handcricket_oneonone SET to_user_score = '$to_user_score' WHERE challenge_id='$challenge_id'";
					mysqli_query($con,$query); 
					$result = array('status' => 1, 'msg' => 'score updated', 'gen' => $gen_num, 'score' => $to_user_score);
					echo json_encode($result);
				}
			}
			
		}
	}
}
?>