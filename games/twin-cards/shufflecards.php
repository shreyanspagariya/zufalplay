<?php 
include ("../../inc/connect.inc.php"); 
date_default_timezone_set('Asia/Calcutta');
$datetime = date("Y-m-d H:i:sa");

session_start();
if(isset($_SESSION["email1"]))
{
	$email = $_SESSION["email1"];
}
else
{
	$email = "EXTUSER";
}

$game_id = 16;
$gameweek = 0;

$arr_universal_set = 
array(
	"001","002","003","004","005","006","007","008","009","010","011","012","013",
	"101","102","103","104","105","106","107","108","109","110","111","112","113",
	"201","202","203","204","205","206","207","208","209","210","211","212","213",
	"301","302","303","304","305","306","307","308","309","310","311","312","313"
	);

function is_same_cards($card1, $card2)
{
	$card1_val = $card1[1].$card1[2];
	$card2_val = $card2[1].$card2[2];

	return($card1_val == $card2_val); 
}

if($_REQUEST['mode'] == "shuffle_cards_first")
{
	//Shuffle Cards Backend and store in Database. Send to Frontend also

	$play_id = mysqli_real_escape_string($con,$_POST['play_id']);

	$arr_deck_main = 
	array(
		"001","002","003","004","005","006","007","008","009","010","011","012","013",
		"101","102","103","104","105","106","107","108","109","110","111","112","113",
		"201","202","203","204","205","206","207","208","209","210","211","212","213",
		"301","302","303","304","305","306","307","308","309","310","311","312","313"
		);

	shuffle($arr_deck_main);

	$arr_deck_player1 = array_slice($arr_deck_main, 0, 26);
	$arr_deck_player2 = array_slice($arr_deck_main, 26);

	$arr_deck_player1_serialized = serialize($arr_deck_player1);
	$arr_deck_player2_serialized = serialize($arr_deck_player2);

	$query = "INSERT INTO twin_cards_states (player1_cards, player2_cards, play_id) VALUES ('$arr_deck_player1_serialized', '$arr_deck_player2_serialized', '$play_id')";

	mysqli_query($con,$query);

	$result = array('status' => 1, 'msg' => 'success', 'arr_deck_player1' => $arr_deck_player1, 'arr_deck_player2' => $arr_deck_player2);
	echo json_encode($result);
}
else if($_REQUEST['mode'] == "shuffle_cards_between")
{
	$play_id = mysqli_real_escape_string($con,$_POST['play_id']);

	$query = "SELECT * FROM twin_cards_states WHERE play_id='$play_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$arr_deck_player1 = unserialize($get['player1_cards']);
	$arr_deck_player2 = unserialize($get['player2_cards']);

	$turn = $get['player_first_move'];

	$center_deck_next_top = "999";
	$center_deck_top = "999";
	$is_game_complete = 0;
	$result = "GAME_NOT_OVER";

	while(1)
	{
		if(!$turn)
		{
			if(sizeof($arr_deck_player1) == 0 && sizeof($arr_deck_player2) == 0)
			{
				$is_game_complete = 1;
				$result = "DRAW";
				break;
			}
			else if(sizeof($arr_deck_player1) == 0 && sizeof($arr_deck_player2) > 0)
			{
				$is_game_complete = 1;
				$result = "LOST";
				break;
			}
			else if(sizeof($arr_deck_player1) > 0 && sizeof($arr_deck_player2) == 0)
			{
				$is_game_complete = 1;
				$result = "WON";
				break;
			}
			else if(sizeof($arr_deck_player1) > 0 && sizeof($arr_deck_player2) > 0)
			{
				$center_deck_next_top = $center_deck_top;
				$center_deck_top = array_pop($arr_deck_player1);

				if(is_same_cards($center_deck_top, $center_deck_next_top))
				{
					$arr_deck_player1 = array_diff($arr_universal_set, $arr_deck_player2);
					shuffle($arr_deck_player1);
					break;
				}
			}
		}
		else
		{
			$center_deck_next_top = $center_deck_top;
			$center_deck_top = array_pop($arr_deck_player2);

			if(is_same_cards($center_deck_top, $center_deck_next_top))
			{
				$arr_deck_player2 = array_diff($arr_universal_set, $arr_deck_player1);
				shuffle($arr_deck_player2);
				break;
			}
		}
		//print_r($arr_deck_player1);
		//print_r($arr_deck_player2);
		$turn = !$turn;
	}

	$turn = !$turn;

	$arr_deck_player1_serialized = serialize($arr_deck_player1);
	$arr_deck_player2_serialized = serialize($arr_deck_player2);

	$query = "UPDATE twin_cards_states SET player1_cards='$arr_deck_player1_serialized', player2_cards='$arr_deck_player2_serialized', result='$result', player_first_move='$turn' WHERE play_id='$play_id'";
	mysqli_query($con, $query);

	$result = array('status' => 1, 'msg' => 'success', 'arr_deck_player1' => $arr_deck_player1, 'arr_deck_player2' => $arr_deck_player2);
	echo json_encode($result);
}