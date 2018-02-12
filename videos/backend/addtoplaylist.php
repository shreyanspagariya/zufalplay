<?php include ("../../inc/header.inc.php"); ?>

<?php

$unique_code = mysqli_real_escape_string($con,$_POST['unique_code']);

$query = "SELECT * FROM videos_playlist WHERE video_unique_code='$unique_code' AND user_email='$email'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);

if($numResults == 0)
{
	mysqli_query($con,"INSERT INTO videos_playlist (video_unique_code,user_email) VALUES ('$unique_code','$email')");
	$result = array('status' => 1,'msg'=>'added');
	echo json_encode($result);
}
else
{
	mysqli_query($con,"DELETE FROM videos_playlist WHERE video_unique_code='$unique_code' AND user_email='$email'");
	$result = array('status' => 1,'msg'=>'removed');
	echo json_encode($result);
}

?>