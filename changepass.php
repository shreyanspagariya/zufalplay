<?php 

/*Including Master Header*/
include ("./inc/connect.inc.php");

session_start();
if(isset($_SESSION["email1"]))
{
	$email = $_SESSION["email1"];
}
else
{
	$email = "EXTUSER";
}

/*Fetching POST variables from settings.php*/
$oldpass = mysqli_real_escape_string($con,$_POST['oldpass']);
$oldpass=md5($oldpass);
$newpass = mysqli_real_escape_string($con,$_POST['newpass']);
$cnfnewpass = mysqli_real_escape_string($con,$_POST['cnfnewpass']);

$query = "SELECT email FROM table2 where email='$email' and password='$oldpass'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);

if($numResults<1) 
{
    $result = array('status' => 1, 'msg' => "<font color='red'><b>Old Password entered is incorrect</b></font>");
	echo json_encode($result);
}
else
{
    if($newpass!=$cnfnewpass)
	{
		$result = array('status' => 1, 'msg' => "<font color='red'><b>'Confirm New Password' does not match with 'New Password'</b></font>");
		echo json_encode($result);
	}
	else
	{
		$newpass=md5($newpass);
		mysqli_query($con,"UPDATE table2 SET password='$newpass' WHERE email='$email'");
		
		$result = array('status' => 1, 'msg' => "<font color='green'><b>Password changed successfully</b></font>");
		echo json_encode($result);
	}
}

?>