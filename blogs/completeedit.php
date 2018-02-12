<?php
include ("../inc/header.inc.php"); 

date_default_timezone_set('Asia/Kolkata');
$datetime = date("Y-m-d H:i:sa");
 
$post_title = addslashes($_POST['post_title']);
$post_img_url = mysqli_real_escape_string($con,$_POST['post_img_url']);
$post_content = addslashes($_POST['post_content']);

$word_count = str_word_count(strip_tags($post_content));

$read_duration_sec = ($word_count/200)*60;

$unique_id = mysqli_real_escape_string($con,$_POST['unique_id']);

$tag1 = mysqli_real_escape_string($con,$_POST['tag1']);
$tag2 = mysqli_real_escape_string($con,$_POST['tag2']);
$tag3 = mysqli_real_escape_string($con,$_POST['tag3']);
$tag4 = mysqli_real_escape_string($con,$_POST['tag4']);
$tag5 = mysqli_real_escape_string($con,$_POST['tag5']);

$tag[1] = $tag1; $tag[2] = $tag2; $tag[3] = $tag3;
$tag[4] = $tag4; $tag[5] = $tag5;

for($i=1;$i<=5;$i++)
{
	if($tag[$i] != "")
	{
		$query = "SELECT * FROM blogpost_tags WHERE tag_name = '$tag[$i]'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$numResults = mysqli_num_rows($result);

		if($numResults == 0)
		{
			$tag_url = $tag[$i];
			$tag_url = preg_replace("/[^A-Za-z0-9]/", '-', $tag_url);

			for($j=1;$j<=5;$j++)
			{
				$tag_url = str_replace("---", "-", $tag_url);
			}
			for($j=1;$j<=5;$j++)
			{
				$tag_url = str_replace("--", "-", $tag_url);
			}
			mysqli_query($con,"INSERT INTO blogpost_tags (tag_name,tag_url) VALUES ('$tag[$i]','$tag_url')");
		}
	}
}

mysqli_query($con,"UPDATE blogposts SET post_title='$post_title', post_img_url='$post_img_url', post_content='$post_content', is_published='1', tag1='$tag1', tag2='$tag2', tag3='$tag3', tag4='$tag4', tag5='$tag5', read_duration_sec='$read_duration_sec' WHERE unique_id='$unique_id'");

$query = "SELECT * FROM blogposts WHERE unique_id='$unique_id'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$post_url = $get["post_url"]; 

/*
mysqli_real_escape_string is not used above because the 'post_url' field has '-' (dashes). 
Not a safety issue as it has been obtained from the database directly and there's no form of direct user input involved here.
*/

header("Location:".$g_url."blogs/post.php?title=".$post_url."&r=".$unique_id);

?>