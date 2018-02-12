<?php
function echo_video_entity($row, $g_url)
{
	$title = $row['title'];
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

	$view_count = number_format($row['view_count']);
	$unique_code = $row['unique_code'];
	$image_link = "https://i.ytimg.com/vi/$unique_code/mqdefault.jpg";
	$short_title = substr($title,0,45);

	if(strlen($short_title) == strlen($title))
	{
		$dot_dot_dot = "";
	}
	else
	{
		$dot_dot_dot = "...";
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

	echo "
		<div class='col-md-3 hrwhite' style=''>
			<a href=$g_url"."videos/video.php?title="."$link_title&v="."$unique_code data-toggle='tooltip' title='$title'>
				<div class='' align='left'>
					<img src='$image_link' style='height:100%;width:100%;'>
					<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$short_title$dot_dot_dot</b></div>
					<div style='font-size:11px; margin-bottom:3px;'>
						$str_time &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp$view_count 
						<font size='1'>views</font>
					</div>
				</div>
			</a>
		</div>
	";
}

function echo_video_entity_recommend($row, $g_url)
{
	$title = $row['title'];
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

	$view_count = number_format($row['view_count']);
	$unique_code = $row['unique_code'];
	$image_link = "https://i.ytimg.com/vi/$unique_code/mqdefault.jpg";
	$short_title = substr($title,0,45);

	if(strlen($short_title) == strlen($title))
	{
		$dot_dot_dot = "";
	}
	else
	{
		$dot_dot_dot = "...";
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

	echo "
		<a href=$g_url"."videos/video.php?title="."$link_title&v="."$unique_code data-toggle='tooltip' title='$title'>
			<div class='' align='left'>
				<img src='$image_link' style='height:100%;width:100%;'>
				<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$short_title$dot_dot_dot</b></div>
				<div style='font-size:11px; margin-bottom:3px;'>
					$str_time &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp$view_count 
					<font size='1'>views</font>
				</div>
			</div>
		</a>
		<br>
	";
}

function echo_video_entity_genre($row, $g_url, $count)
{
	$title = $row['title'];
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

	$view_count = number_format($row['view_count']);
	$unique_code = $row['unique_code'];
	$image_link = "https://i.ytimg.com/vi/$unique_code/mqdefault.jpg";
	$short_title = substr($title,0,45);

	if(strlen($short_title) == strlen($title))
	{
		$dot_dot_dot = "";
	}
	else
	{
		$dot_dot_dot = "...";
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

	if($count % 4 == 1)
	{
		echo"<div class='row'>";
	}

	echo "
		<div class='col-md-3 hrwhite' style=''>
			<a href=$g_url"."videos/video.php?title="."$link_title&v="."$unique_code data-toggle='tooltip' title='$title'>
				<div class='' align='left'>
					<img src='$image_link' style='height:100%;width:100%;'>
					<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$short_title$dot_dot_dot</b></div>
					<div style='font-size:11px; margin-bottom:3px;'>
						$str_time &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp$view_count 
						<font size='1'>views</font>
					</div>
				</div>
			</a>
		</div>
	";
}

function echo_video_entity_index($row, $g_url)
{
	$title = $row['title'];
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

	$view_count = number_format($row['view_count']);
	$unique_code = $row['unique_code'];
	$image_link = "https://i.ytimg.com/vi/$unique_code/mqdefault.jpg";
	$short_title = substr($title,0,20);

	if(strlen($short_title) == strlen($title))
	{
		$dot_dot_dot = "";
	}
	else
	{
		$dot_dot_dot = "...";
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

	echo "
		<div class='col-md-3 hrwhite' style=''>
			<a href=$g_url"."videos/video.php?title="."$link_title&v="."$unique_code data-toggle='tooltip' title='$title'>
				<div class='' align='left'>
					<img src='$image_link' style='height:100%;width:100%;'>
					<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$short_title$dot_dot_dot</b></div>
					<div style='font-size:11px; margin-bottom:3px;'>
						Watch and Earn &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp$view_count 
						<font size='1'>views</font>
					</div>
				</div>
			</a>
		</div>
	";
}
?>