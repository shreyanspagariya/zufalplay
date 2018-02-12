<?php
include ("../../inc/extuser.inc.php");

$getposts = mysqli_query($con,"SELECT * FROM videos WHERE description=''");
while($row = mysqli_fetch_assoc($getposts))
{
	$unique_code = $row["unique_code"];

	$vid = $unique_code;
	$videoDetails = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$vid."&part=contentDetails,statistics,snippet,status&key=AIzaSyCauWoLWHHF9H0PrV1Pq8I9edEqXEJYzZU");

	$res1 = json_decode($videoDetails, true);

	$video_description = $res1['items'][0]['snippet']['description'];
    $video_description_serialized = base64_encode($video_description);

    mysqli_query($con,"UPDATE videos SET description='$video_description_serialized' WHERE unique_code='$unique_code'");
}
?>