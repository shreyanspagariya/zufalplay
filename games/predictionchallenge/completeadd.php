<?php include ("./inc/header.inc.php"); ?>
<?php 
$betdes = mysqli_real_escape_string($con,$_POST['betdes']);

str_replace("'","''",$betdes);

$option1 = mysqli_real_escape_string($con,$_POST['option1']);
$option2 = mysqli_real_escape_string($con,$_POST['option2']);

$date_time = mysqli_real_escape_string($con,$_POST['date_time']);

mysqli_query($con,"INSERT INTO bets (betdes,option1,option2,start_time) VALUES ('$betdes','$option1','$option2','$date_time')");
header("Location: add.php");
?>