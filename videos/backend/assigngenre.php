<?php include ("../../inc/header.inc.php"); ?>

<?php

date_default_timezone_set("Asia/Kolkata");
$datetime = date("Y-m-d H:i:sa");

$genre_name = mysqli_real_escape_string($con,$_POST['genre_name']);
$author_url = mysqli_real_escape_string($con,$_POST['author_url']);

echo $genre_name." ".$author_url;

mysqli_query($con,"UPDATE videos_author_genre SET genre='$genre_name', assign_time='$datetime', is_genre_assigned='1', assigned_by='$email' WHERE author='$author_url'");

header("Location: ".$g_url."admin.php");

?>