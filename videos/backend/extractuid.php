<?php include ("../../inc/extuser.inc.php"); ?>

<?php

$link_string = mysqli_real_escape_string($con,$_POST['youtube_link']);

function get_title($vid)
{
	$oembed_details = file_get_contents("https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=$vid");
	$res1 = json_decode($oembed_details, true);
	
	$title = $res1['title'];
	$string_length = strlen($title);
	for($i=0;$i<$string_length;$i++)
	{
		if(ord($title[$i])==39)
		{
			$title[$i]=chr(34);
		}
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

	return($link_title);
}

if(strpos($link_string,"/watch?v=") !== false)
{
	$needle = '/watch?v=';
	$pos = strpos($link_string, $needle);
	$link_final='';
	if (!($pos === false)) 
	{
		$pos+=9;
		for($i=$pos;$i<11+$pos;$i++)
		{
	  		$link_final .= $link_string[$i];
		}
		$vid = $link_final;
	  	header("Location:".$g_url."videos/video.php?title=".get_title($vid)."&v=".$vid);
	}
}
else if(strpos($link_string,"youtu.be/")!==false)
{
	$needle = 'youtu.be/';
	$pos = strpos($link_string, $needle);
	$link_final='';
	if (!($pos === false)) 
	{
		$pos+=9;
		for($i=$pos;$i<11+$pos;$i++)
		{
	  		$link_final .= $link_string[$i];
		}
		$vid = $link_final;
	  	header("Location:".$g_url."videos/video.php?title=".get_title($vid)."&v=".$vid);
	}
}
else
{
	header("Location:".$g_url."videos");
}

?>