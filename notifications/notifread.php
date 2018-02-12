<?php

include("../inc/connect.inc.php"); 
$notif_id = mysqli_real_escape_string($con,$_POST['notif_id']);

mysqli_query($con,"UPDATE notifications SET seen = 1 WHERE notif_id = '$notif_id'");
session_start();
$email = $_SESSION['email1'];
$countunseen = mysqli_query($con,"SELECT seen FROM notifications WHERE to_user = '$email' AND seen = 0");
$result = array('status' => 1,'msg'=>'Notification marked as seen','unseen'=>mysqli_num_rows($countunseen));
echo json_encode($result);

?>