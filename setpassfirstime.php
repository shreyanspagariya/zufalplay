<?php
include('inc/header.inc.php');

$password = mysqli_real_escape_string($con,$_POST['password']);
$password1 = mysqli_real_escape_string($con,$_POST['password1']);
$go_to_url = $_POST['go_to_url'];

if($password==$password1)
{
	$password=md5($password);
	mysqli_query($con,"UPDATE table2 SET password='$password' WHERE email='$email'");
	header("Location:".$go_to_url);
}
else
{
	header("Location:".$g_url."welcomepassnotmatch.php?go_to_url=".urlencode($go_to_url));
}