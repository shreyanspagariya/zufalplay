<?php 

function scorevalidate($score, $play_time, $game_id, $con, $email, $start_time, $end_time, $play_id, $game_code)
{
	$play_id_uq = $play_id.$game_code;
	$max = -1;
	$min_time = 1000000;
	$i = 0;

	$count_total_games = 0;
	$count_lesser_scores = 0;

	$getposts = mysqli_query($con,"SELECT * FROM game_playhistory WHERE game_id='$game_id' AND id >= 33068 AND isout='1'");
	while($row = mysqli_fetch_assoc($getposts))
	{
		$trained_games[$i]["start_time"] = $row["time_played"];
		$trained_games[$i]["end_time"] = $row["play_end_time"];
		$trained_games[$i]["score"] = $row["final_score"];

		$trained_games[$i]["time_diff"] = strtotime($trained_games[$i]["end_time"]) -  strtotime($trained_games[$i]["start_time"]);

		if($trained_games[$i]["score"] <= $score)
		{
			if($trained_games[$i]["score"] > $max || $trained_games[$i]["score"] == $max && $min_time > $trained_games[$i]["time_diff"])
			{
				$pos = $i;
				$max = $trained_games[$i]["score"];
				$min_time = $trained_games[$i]["time_diff"];
			}
			$count_lesser_scores++;
		}
		$i++;
		$count_total_games++;
	}

	if($play_time < $min_time * 0.8 || $count_lesser_scores == $count_total_games)
	{
		mysqli_query($con,"INSERT INTO failed_game_playhistory (user_played, game_id, final_score, start_time, end_time , play_id) VALUES ('$email','$game_id','$score','$start_time','$end_time','$play_id')");
	}
	//if($play_time >= $min_time * 0.5)
	{
		$result = array('status' => 1, 'type' => "loop1");
		echo json_encode($result);
		
		if($play_time < $min_time)
		{
			return($play_time);
		}
		else
		{
			return($min_time);
		}
	}

	$result = array('status' => 1, 'type' => "Fail");
	echo json_encode($result);

	mysqli_query($con,"INSERT INTO failed_game_playhistory (user_played, game_id, final_score, start_time, end_time , play_id) VALUES ('$email','$game_id','$score','$start_time','$end_time','$play_id')");

	return(0);
}

?>