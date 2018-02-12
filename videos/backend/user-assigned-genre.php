<?php include ("../../inc/connect.inc.php"); ?>

<?php

$datetime = getDateTimeIST();

session_start();
if(isset($_SESSION["email1"]))
{
	$email_assigning_user = $_SESSION["email1"];
}
else
{
	$email_assigning_user = spit_ip();
}

$genre_name = mysqli_real_escape_string($con,$_POST['genre_name']);
$video_unique_code = mysqli_real_escape_string($con,$_POST['video_unique_code']);

$query = "SELECT * FROM videos_user_assigned_genre WHERE user_email='$email_assigning_user' AND video_unique_code='$video_unique_code'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);

//if($numResults == 0)
if($genre_name != "")
{
	mysqli_query($con,"INSERT INTO videos_user_assigned_genre (user_email, video_unique_code, genre, time_assigned) 
		VALUES ('$email_assigning_user', '$video_unique_code', '$genre_name', '$datetime')");

	$query = "SELECT * FROM videos_genre WHERE genre_name='$genre_name'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$genre_display = $get["genre_display"];

	$user_assigned_genre = $genre_name;

	$query = "SELECT * FROM videos WHERE unique_code='$video_unique_code'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$existing_genre = $get["genre"];

	$author_url = $get["author_url"];

	$query = "SELECT * FROM videos_author_genre WHERE author='$author_url'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$genre = $get["genre"];
	$is_genre_assigned = $get["is_genre_assigned"];
	
	if($is_genre_assigned == 0 && $genre == "other")
	{
		mysqli_query($con,"UPDATE videos_author_genre SET genre='$user_assigned_genre', is_genre_assigned='1', assign_time='$datetime', assigned_by='$email_assigning_user' WHERE author='$author_url'");
	}

	if($user_assigned_genre != $existing_genre)
	{
		$query = "SELECT * FROM videos_user_assigned_genre WHERE video_unique_code='$video_unique_code' AND genre='$user_assigned_genre'";
		$result = mysqli_query($con,$query);
		$numResults_user_assigned_genre = mysqli_num_rows($result);

		$query = "SELECT * FROM videos_user_assigned_genre WHERE video_unique_code='$video_unique_code' AND genre='$existing_genre'";
		$result = mysqli_query($con,$query);
		$numResults_existing_genre = mysqli_num_rows($result);

		if($numResults_user_assigned_genre > $numResults_existing_genre)
		{
			mysqli_query($con,"UPDATE videos SET genre='$user_assigned_genre' WHERE unique_code='$video_unique_code'");
		}
	}

	$result = array('status' => 1, 'msg' => 'success', 'genre_display' => $genre_display);
	echo json_encode($result);
}
else
{
	$result = array('status' => 0, 'msg' => 'genre_missing');
	echo json_encode($result);
}
// else
// {
// 	$result = array('status' => 1, 'msg' => 'already_assigned');
// 	echo json_encode($result);
// }

?>