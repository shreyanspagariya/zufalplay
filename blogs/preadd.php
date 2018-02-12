<?php
include ("../inc/header.inc.php"); 

function generateRandomString($length = 10) 
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789abcdefghijklmnopqrstuvwxyz-';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$unique_id = generateRandomString();
$query = "SELECT * FROM blogposts WHERE unique_id='$unique_id'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);

while($numResults!=0)
{
	$unique_id = generateRandomString();
	$query = "SELECT * FROM blogposts WHERE unique_id='$unique_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
}

mysqli_query($con,"INSERT INTO blogposts (unique_id,blogger_unique_id) VALUES ('$unique_id','$unique_name')");

header("Location: ".$g_url."blogs/add.php?id=".$unique_id);
?>