<?php include ("./inc/connect.inc.php"); ?>

<?php

date_default_timezone_set('Asia/Calcutta');
$datetime = date("Y-m-d H:i:sa");

$user = mysqli_real_escape_string($con,$_POST['query']);

session_start();

if(isset($_SESSION["email1"]))
{
	$search_user_email = $_SESSION["email1"];
	mysqli_query($con,"INSERT INTO search_queries (user_email,query_string,time,is_real_time) VALUES ('$search_user_email','$user','$datetime','1')");
}
else
{
	$search_user_email = spit_ip();
	mysqli_query($con,"INSERT INTO search_queries (user_email,query_string,time,is_real_time) VALUES ('$search_user_email','$user','$datetime','1')");
}

$sendback_string = "<div class='dropdown' style='margin-top:32px;' id='dropdownsearch'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' style='display:none;'>Dropdown Example
<span class='caret'></span></button><ul class='dropdown-menu'>";

$count = 0;

$getposts = mysqli_query($con,"SELECT * FROM games WHERE game_id!='4'");
while($row = mysqli_fetch_assoc($getposts))
{
	$game_display = $row["game_display"];
	$game_link = $row["game_link"];
	$game_profile_image = $row["game_profile_image"];

	$search_game_title = strtolower($user);
	$game_display1 = strtolower($game_display);

	if(strpos($game_display1,$search_game_title)!==false)
	{
		$count++;
		$sendback_string = $sendback_string."<li><a href=$g_url".$game_link."><img src=$g_url".$game_profile_image." style='height:40px;'>&nbsp;&nbsp;$game_display</a></li>";
	}
	if($count>=10)
	{
		break;
	}
}

$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' ORDER BY trend_value DESC");
while($row = mysqli_fetch_assoc($getposts))
{
	$post_title = $row['post_title'];
	$post_url = $row['post_url'];
	$post_img_url = $row['post_img_url'];
	$unique_id = $row['unique_id'];

	$search_blog_title = strtolower($user);
	$post_title1 = strtolower($post_title);

	$flag = 0;

	for($i=1;$i<=5;$i++)
	{
		$tag[$i] = mysqli_real_escape_string($con,$row["tag$i"]);
		if(strpos(strtolower($tag[$i]),$search_blog_title)!==false)
		{
			$flag = 1;
		}
	}

	if(strpos($post_title1,$search_blog_title)!==false || $flag==1)
	{
		$count++;
		$sendback_string = $sendback_string."<li><a href=$g_url"."blogs/post.php?title=$post_url&r=$unique_id><img src=".$post_img_url." style='height:40px;'>&nbsp;&nbsp;$post_title</a></li>";
	}
	if($count>=10)
	{
		break;
	}
}

$getposts = mysqli_query($con,"SELECT * FROM videos ORDER by ((view_count/dislike_count)*(like_count))/(datediff('$datetime',time_published)) DESC");
while($row = mysqli_fetch_assoc($getposts))
{
	if($count>=10)
	{
		break;
	}

	$title = $row['title'];
	$author_name = $row['author_name'];
	$title1 = strtolower($title);
	$author_name1 = strtolower($author_name);
	$search_video_title = strtolower($user);

	$flag = 0;
	$tag_array = unserialize(base64_decode($row["tags"]));
	$tag_array_size = count($tag_array);

	for($i=0; $i<$tag_array_size;$i++)
	{
		if(strpos(strtolower($tag_array[$i]),$search_video_title)!==false)
		{
			$flag = 1;
			break;
		}
	}

	if(strpos($title1,$search_video_title)!==false || strpos($author_name1,$search_video_title)!==false || $flag == 1)
	{
		$count++;
		$time_sec_length = $row['time_sec_length'];
		$min = floor($time_sec_length/60);
		$sec = $time_sec_length - 60*$min;

		if($min<10)
		{
			$str_time = "0".$min;
		}
		else
		{
			$str_time=$min;
		}
		if($sec<10)
		{
			$str_time = $str_time.":0".$sec;
		}
		else
		{
			$str_time = $str_time.":".$sec;
		}

		$zufals_winnable = $row['zufals_winnable'];
		$unique_code = $row['unique_code'];
		$image_link = "https://i.ytimg.com/vi/$unique_code/mqdefault.jpg";
		$view_count = number_format($row['view_count']);
		$author_url = $row['author_url'];
		$short_title = substr($title,0,80);
		if(strlen($title) > strlen($short_title))
		{
			$dotdotdot = "...";
		}
		else
		{
			$dotdotdot = "";
		}

		$link_title = $title;
		$link_title = preg_replace("/[^A-Za-z0-9]/", '-', $link_title);

		for($i=1;$i<=5;$i++)
		{
			$link_title = str_replace("---", "-", $link_title);
		}
		for($i=1;$i<=5;$i++)
		{
			$link_title = str_replace("--", "-", $link_title);
		}

		$sendback_string = $sendback_string."<li><a href=$g_url"."videos/video.php?title="."$link_title&v="."$unique_code><img src='$image_link' style='width:70px'>&nbsp;&nbsp;$short_title$dotdotdot</a></li>";
	}
	if($count>=10)
	{
		break;
	}
}

$getposts = mysqli_query($con,"SELECT * FROM table2 ORDER by login_count DESC");
while($row = mysqli_fetch_assoc($getposts))
{
	if($count>=10)
	{
		break;
	}

	$username = $row['email'];
	$firstname = $row['fname'];
	$lastname = $row['lname'];
    $useridx = $row['Id'];

    $profile_pic_url1 = $row['google_picture_url'];
	if($profile_pic_url1=="")
	{
		$profile_pic_url1 = $row['fb_picture_url'];
		if($profile_pic_url1=="")
		{
			$profile_pic_url1="http://www.zufalplay.com/images/default_ppic.png";
		}
	}

	$username1 = strtolower ($username);
	$firstname1 = strtolower ($firstname);
	$lastname1 = strtolower ($lastname);
    $user = strtolower($user);
	$user_points = $row['user_points'];

	if (strpos($username1,$user)!==false || strpos($firstname1,$user)!==false || strpos($lastname1,$user)!==false || strpos($firstname1." ".$lastname1,$user)!==false)
	{
		$count++;
		$sendback_string.= "<li><a href=$g_url"."profile.php?u=$useridx><img src=".$profile_pic_url1." style='width: 40px; height: 40px;'>&nbsp;&nbsp;$firstname $lastname</a></li>";
	}
}

if($count>=10)
{
	$sendback_string = $sendback_string."<li role='separator' class='divider'></li><li><a href=$g_url"."searchusers.php?query="."$user><i class='fa fa-search'></i>&nbsp;&nbsp;See all results for <b>\"$user\"</b></a></li>";
}
else
{
	if($count == 0)
	{
		$sendback_string = $sendback_string."<li><a><i class='fa fa-search'></i>&nbsp;&nbsp;No results found for <b>\"$user\"</b></a></li>";
	}
	else
	{
		$sendback_string = $sendback_string."<li role='separator' class='divider'></li><li><a href=$g_url"."searchusers.php?query="."$user><i class='fa fa-search'></i>&nbsp;&nbsp;Showing all results for <b>\"$user\"</b></a></li>";
	}
}

$sendback_string.="</ul></div>";

$result = array('status' => 1, 'msg' => $sendback_string);
echo json_encode($result);
?>