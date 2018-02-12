<?php 
include ("../../inc/connect.inc.php");
//include ("scorevalidate.php");
include ("../../inc/distributor.inc.php");

$gameweek = 0;
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

if($_REQUEST['mode'] == "submit_score")
{
	$this_score = mysqli_real_escape_string($con,$_POST['this_score']);
	$encrypted_score = mysqli_real_escape_string($con,$_POST['encrypted_score']);
	$play_id = mysqli_real_escape_string($con,$_POST['play_id']);
	$game_id = mysqli_real_escape_string($con,$_POST['game_id']);
	$is_competition = mysqli_real_escape_string($con,$_POST['is_competition']);

	$query = "SELECT * FROM games WHERE game_id = '$game_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$game_display = $get["game_display"];
	$game_link = $get["game_link"];
	$game_profile_id = $game_id;
	if($game_id == 3)
	{
		$game_profile_id = $game_profile_id - 1000;
	}
	$game_code = $get["game_code"];

	$time_0 = $time;
	$md5_0 = md5($time_0 ^ $this_score);
	$time_1 = $time - 1;
	$md5_1 = md5($time_1 ^ $this_score);
	$time_2 = $time - 2;
	$md5_2 = md5($time_2 ^ $this_score);
	$time_3 = $time - 3;
	$md5_3 = md5($time_3 ^ $this_score);
	$time_4 = $time - 4;
	$md5_4 = md5($time_4 ^ $this_score);
	$time_5 = $time - 5;
	$md5_5 = md5($time_5 ^ $this_score);

	mysqli_query($con,"UPDATE game_playhistory SET play_end_time = '$datetime' WHERE play_id = '$play_id' AND game_id='$game_id'");

	$query = "SELECT * FROM game_playhistory WHERE play_id = '$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$isout = $get['isout'];
	$start_time = $get["time_played"];
	$end_time = $get["play_end_time"];
	$play_time = strtotime($end_time) - strtotime($start_time); 
	
	//if(($min_time = scorevalidate($this_score, $play_time, $game_id, $con, $email, $start_time, $end_time, $play_id, $game_code)) && $isout == 0 && ($md5_0==$encrypted_score || $md5_1==$encrypted_score || $md5_2==$encrypted_score || $md5_3==$encrypted_score))
	{
		date_default_timezone_set('Asia/Kolkata');
		$datetime = date("Y-m-d H:i:sa");

		if($game_id == 13)
		{
			//Managing Levels for Zoko
			mysqli_query($con,"UPDATE game_playhistory SET final_score = '$this_score', isout = '0' WHERE play_id = '$play_id' AND game_id='$game_id' AND is_competition='$is_competition'"); 
		}
		else
		{
			mysqli_query($con,"UPDATE game_playhistory SET final_score = '$this_score', isout = '1' WHERE play_id = '$play_id' AND game_id='$game_id' AND is_competition='$is_competition'"); 
		}

		mysqli_query($con,"INSERT INTO recent_activity (user_email,game_id,gameweek,game_score,activity_time) VALUES ('$email','$game_profile_id','0','$this_score','$datetime')");		
		mysqli_query($con,"UPDATE profile_tempfill SET time='$datetime' WHERE user_email='$email' AND game_id='$game_profile_id' AND gameweek='$gameweek'");
		

		$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE user='$email' AND game_id='$game_id' AND is_competition='$is_competition'");
		$high_score=0;
		while($row = mysqli_fetch_assoc($getposts))
		{
			$high_score = $row['high_score'];
		}
		if($this_score > $high_score)
		{
			mysqli_query($con,"UPDATE game_leaderboard SET high_score='$this_score' WHERE user='$email' AND game_id='$game_id' AND is_competition='$is_competition'");
			$result = array('status' => 1);
			echo json_encode($result);
		}
		else
		{
			$result = array('status' => 1);
			echo json_encode($result);
		}
	}
}
else if($_REQUEST['mode'] == "encrypt_score")
{
	$this_score = mysqli_real_escape_string($con,$_POST['this_score']);
	$encrypted_score = md5($time ^ $this_score);
	$result = array('status' => 1, 'msg' => $encrypted_score);
	echo json_encode($result);
}
else if($_REQUEST['mode'] == "dummy_request")
{
	$result = array('status' => 1, 'msg' => 'Level Complete');
	echo json_encode($result);
}
else if($_REQUEST['mode'] == "train_game")
{
	$this_score = mysqli_real_escape_string($con,$_POST['this_score']);
	$play_id = mysqli_real_escape_string($con,$_POST['play_id']);
	$game_id = mysqli_real_escape_string($con,$_POST['game_id']);
	$is_competition = mysqli_real_escape_string($con,$_POST['is_competition']);

	$query = "SELECT * FROM game_playhistory WHERE play_id = '$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$start_time = $get["time_played"];

	mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id,play_end_time) 
		VALUES ('$email','$this_score','0','1','TRAINGAME','$start_time','$game_id','$datetime')"); 
}
else if($_REQUEST['mode'] == "new_game_polyb")
{
  $game_id = 15;
  $is_competition = 1;
  if($email!="EXTUSER")
  {
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_week='0' AND game_id='$game_id' AND is_competition='$is_competition'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id,is_competition) VALUES ('0','$email','0','0','$game_id','$is_competition')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','$game_id','0','$datetime')");
    }
  }
  function generateRandomString($length = 9) 
  {
      $characters = '123456789';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

  $play_id = generateRandomString()."POLYB";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."POLYB";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id,is_competition) 
    VALUES ('$email','0','0','0','$play_id','$datetime','$game_id','$is_competition')");

  $result = array('status' => 1, 'msg' => $play_id);
  echo json_encode($result);
}
?>