<?php include ("./inc/header.inc.php"); ?>
<?php 
$getposts = mysqli_query($con,"SELECT * FROM table2 where email='$email'");
while($row = mysqli_fetch_assoc($getposts))
{
	$suggested_fname = $row['fname'];
	$suggested_lname = $row['lname'];
	$suggested_name = ($suggested_fname." ").$suggested_lname;
}
$betdes = mysqli_real_escape_string($con,$_POST['betdes']);
$option1 = mysqli_real_escape_string($con,$_POST['option1']);
$option2 = mysqli_real_escape_string($con,$_POST['option2']);
mysqli_query($con,"INSERT INTO suggestedbets (suggest_des,suggest_option1,suggest_option2,suggested_by) VALUES ('$betdes','$option1','$option2','$suggested_name')");
header("Location: suggestsuccess.php");
?>