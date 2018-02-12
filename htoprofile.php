<?php include ("./inc/header.inc.php"); ?>
<?php
$getposts = mysqli_query($con,"SELECT * FROM table2 WHERE email='$email'");
while($row = mysqli_fetch_assoc($getposts))
{
	$userid=$row['Id'];
}
header("Location: profile.php?u=$userid");
?>