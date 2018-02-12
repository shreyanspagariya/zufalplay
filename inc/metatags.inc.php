<?php

$entire_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$after_quesmark = $_SERVER['QUERY_STRING'];
$file_name = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$visit_time = getDateTimeIST();

session_start();
if(isset($_SESSION['email1']))
{
	$visit_user = $_SESSION['email1'];
}
else
{
	$visit_user = spit_ip();
}

mysqli_query($con,"INSERT INTO pages_visited (user_email, page_url, visit_time) VALUES ('$visit_user', '$entire_url', '$visit_time')");

$fb_app_id = "1489957891297107";
$fb_og_url = $entire_url;
$fb_og_image = "http://www.zufalplay.com/images/fb_share_logo.png";
$fb_og_title = "Zufalplay";
$fb_og_type = "article";
$fb_og_description = "Play Games, Watch your favorite Youtube Videos & Write Blogs to earn money. Donate this money to the Poor or take up Mobile Recharges @Zufalplay Market.";
$fb_og_image_height = "200";
$fb_og_image_width = "200";

$videos_url = $g_url."videos/video.php";
$blogs_url = $g_url."blogs/post.php";
$donate_url = $g_url."donate/details.php";

if($file_name == $videos_url)
{
	$fb_og_url = $entire_url;


	$parts = parse_url($entire_url);
	parse_str($parts['query'], $query);
	$url_video_unique_code = $query['v'];

	$fb_og_image = "https://i.ytimg.com/vi/".$url_video_unique_code."/hqdefault.jpg";
	$fb_og_image_height = "630";
	$fb_og_image_width = "1200";


	$fb_og_type = "article";


	$oembed_details = file_get_contents("https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=$url_video_unique_code");	
    $res1 = json_decode($oembed_details, true);

	$fb_og_title = $res1['title'];

	
	$videoDetails = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$url_video_unique_code."&part=contentDetails,statistics,snippet,status&key=AIzaSyCauWoLWHHF9H0PrV1Pq8I9edEqXEJYzZU");

	$res1 = json_decode($videoDetails, true);
	$fb_og_description = $res1['items'][0]['snippet']['description'];
	$fb_og_description = str_replace("\n", ".", $fb_og_description);
	$fb_og_description = str_replace('"',"'", $fb_og_description);

	if($fb_og_description == "")
	{
		$fb_og_description = $fb_og_title;
	}

	$short_fb_og_description = substr($fb_og_description,0,500);
	$fb_og_description = $short_fb_og_description;
}
else if($file_name == $blogs_url)
{
	$fb_og_url = $entire_url;

	$parts = parse_url($entire_url);
	parse_str($parts['query'], $query);
	$url_blog_unique_id = $query['r'];

	$query = "SELECT * FROM blogposts WHERE unique_id='$url_blog_unique_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);

	$fb_og_title = $get["post_title"];


	$fb_og_image = $get['post_img_url'];

	if($fb_og_image != "")
	list($fb_og_image_width, $fb_og_image_height, $dummy_type, $dummy_attr) = getimagesize($fb_og_image);

	$fb_og_type = "article";


	$fb_og_description = strip_tags($get["post_content"]);
	$fb_og_description = str_replace('"',"'", $fb_og_description);

	$short_fb_og_description = substr($fb_og_description,0,500);
	$fb_og_description = $short_fb_og_description;
}
else if($file_name == $donate_url)
{
	$fb_og_url = $entire_url;

	$parts = parse_url($entire_url);
	parse_str($parts['query'], $query);
	$url_blog_unique_id = $query['d'];

	$query = "SELECT * FROM donate_posts WHERE unique_id='$url_blog_unique_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);

	$fb_og_title = $get["post_title"];


	$fb_og_image = $get['post_img_url'];

	if($fb_og_image != "")
	list($fb_og_image_width, $fb_og_image_height, $dummy_type, $dummy_attr) = getimagesize($fb_og_image);

	$fb_og_type = "article";


	$fb_og_description = strip_tags($get["post_content"]);
	$fb_og_description = str_replace('"',"'", $fb_og_description);

	$short_fb_og_description = substr($fb_og_description,0,500);
	$fb_og_description = $short_fb_og_description;
}

?>