<?php
	function update_all_leaderboards($con,$start,$end,$contest_id)
	{
		$money_per_user_per_game = 1.75;
		for($game_id = $start; $game_id <= $end; $game_id++)
		{

			$getposts = mysqli_query($con,"SELECT * FROM long_contest_leaderboard WHERE contest_id='$contest_id'");
			while($row = mysqli_fetch_assoc($getposts))
			{
				$user = $row["user"];

				$query = "SELECT * from game_leaderboard WHERE game_id='$game_id' AND is_competition='1' AND user='$user' AND game_week='0'";
				$result = mysqli_query($con,$query);
				$numResults = mysqli_num_rows($result);

				if($numResults == 0)
				{
					mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id,is_competition) VALUES ('0','$user','0','0','$game_id','1')");
				}
			}

			$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week=0 AND game_id='$game_id' AND is_competition='1' ORDER BY high_score DESC");
			$total_score = 0;
			$total_money = 0;
			while($row = mysqli_fetch_assoc($getposts))
			{
				$total_score = $total_score + $row["high_score"];
				$total_money = $total_money + $money_per_user_per_game;
			}

			$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week=0 AND game_id='$game_id' AND is_competition='1' ORDER BY high_score DESC");
			while($row = mysqli_fetch_assoc($getposts))
			{
				if($total_score!=0)
				{
					$rupees_earned = ($total_money*$row["high_score"])/$total_score;
				}
				$user = $row["user"];
				mysqli_query($con,"UPDATE game_leaderboard SET rupees_earned = '$rupees_earned' WHERE game_id='$game_id' AND is_competition='1' AND user='$user' 
					AND game_week='0'");

				if($game_id == $start)
				{
					mysqli_query($con,"UPDATE long_contest_leaderboard SET rupees_earned = '$rupees_earned' WHERE user='$user' AND contest_id = '$contest_id'");
				}
				else
				{
					mysqli_query($con,"UPDATE long_contest_leaderboard SET rupees_earned = rupees_earned + '$rupees_earned' WHERE user='$user' AND contest_id = '$contest_id'");
				}
			}
		}
	}
?>