<?php
function get_post_views($con,$func_unique_id)
{
	$query = "SELECT * FROM read_history WHERE unique_id='$func_unique_id' AND is_money_distributed='1'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$numResults = number_format($numResults);

	return($numResults);
}

function echo_blog_entity($con, $row, $g_url)
{
	$post_title = $row['post_title'];
	if($post_title == "")
	{
		$post_title = "No Title";
	}
	$post_url = $row['post_url'];
	$post_img_url = $row['post_img_url'];
	if($post_img_url == "")
	{
		$post_img_url = "https://thetechtemple.com/wp-content/themes/TechNews/images/img_not_available.png";
	}
	$blogger_unique_id = $row['blogger_unique_id'];
	$unique_id = $row['unique_id'];
	$post_views = get_post_views($con,$unique_id);

	$query = "SELECT * from table2 where unique_name='$blogger_unique_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$fnamex = $get['fname'];

	$short_title = substr($post_title,0,45);

	if(strlen($post_title) > strlen($short_title))
	{
		$dotdotdot = "...";
	}
	else
	{
		$dotdotdot = "";
	}
	
	echo "
		<div class='col-md-3 hrwhite'>
			<a href=$g_url"."blogs/post.php?title=$post_url&r=$unique_id data-toggle='tooltip' title='$post_title'>
				<div class='' align='left'>
					<img src='$post_img_url' style='height:110px; width:195px;'><br>
					<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$short_title$dotdotdot</b></div>
					<div style='font-size:11px; margin-bottom:3px;'>
						<font size='1'>by <b>$fnamex</b></font> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp$post_views 
						<font size='1'>views</font>
					</div>
				</div>
			</a>
		</div>
	";
}

function echo_blog_entity_orderby($con, $row, $g_url, $count)
{
	$post_title = $row['post_title'];
	if($post_title == "")
	{
		$post_title = "No Title";
	}
	$post_url = $row['post_url'];
	$post_img_url = $row['post_img_url'];
	if($post_img_url == "")
	{
		$post_img_url = "https://thetechtemple.com/wp-content/themes/TechNews/images/img_not_available.png";
	}
	$blogger_unique_id = $row['blogger_unique_id'];
	$unique_id = $row['unique_id'];
	$post_views = get_post_views($con,$unique_id);

	$query = "SELECT * from table2 where unique_name='$blogger_unique_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$fnamex = $get['fname'];

	$short_title = substr($post_title,0,45);

	if(strlen($post_title) > strlen($short_title))
	{
		$dotdotdot = "...";
	}
	else
	{
		$dotdotdot = "";
	}

	if($count % 4 == 1)
	{
		echo"<div class='row'>";
	}
	
	echo "
		<div class='col-md-3 hrwhite'>
			<a href=$g_url"."blogs/post.php?title=$post_url&r=$unique_id data-toggle='tooltip' title='$post_title'>
				<div class='' align='left'>
					<img src='$post_img_url' style='height:110px; width:195px;'><br>
					<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$short_title$dotdotdot</b></div>
					<div style='font-size:11px; margin-bottom:3px;'>
						<font size='1'>by <b>$fnamex</b></font> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp$post_views 
						<font size='1'>views</font>
					</div>
				</div>
			</a>
		</div>
	";
	if($count % 4 == 0)
	{
		echo"</div><br>";
	}
}

function echo_blog_entity_recommend($con, $row, $g_url)
{
	$post_title = $row['post_title'];
	if($post_title == "")
	{
		$post_title = "No Title";
	}
	$post_url = $row['post_url'];
	$post_img_url = $row['post_img_url'];
	if($post_img_url == "")
	{
		$post_img_url = "https://thetechtemple.com/wp-content/themes/TechNews/images/img_not_available.png";
	}
	$blogger_unique_id = $row['blogger_unique_id'];
	$unique_id = $row['unique_id'];
	$post_views = get_post_views($con,$unique_id);

	$query = "SELECT * from table2 where unique_name='$blogger_unique_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$fnamex = $get['fname'];

	$short_title = substr($post_title,0,45);

	if(strlen($post_title) > strlen($short_title))
	{
		$dotdotdot = "...";
	}
	else
	{
		$dotdotdot = "";
	}
	
	echo "
		<div class='hrwhite'>
			<a href=$g_url"."blogs/post.php?title=$post_url&r=$unique_id data-toggle='tooltip' title='$post_title'>
				<div class='' align='left'>
					<img src='$post_img_url' style='height:98px; width:175px;'><br>
					<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$short_title$dotdotdot</b></div>
					<div style='font-size:11px; margin-bottom:3px;'>
						<font size='1'>by <b>$fnamex</b></font> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp$post_views 
						<font size='1'>views</font>
					</div>
				</div>
			</a>
			<br>
		</div>
	";
}

function echo_blog_entity_index($con, $row, $g_url)
{
	$post_title = $row['post_title'];
	if($post_title == "")
	{
		$post_title = "No Title";
	}
	$post_url = $row['post_url'];
	$post_img_url = $row['post_img_url'];
	if($post_img_url == "")
	{
		$post_img_url = "https://thetechtemple.com/wp-content/themes/TechNews/images/img_not_available.png";
	}
	$blogger_unique_id = $row['blogger_unique_id'];
	$unique_id = $row['unique_id'];
	$post_views = get_post_views($con,$unique_id);

	$query = "SELECT * from table2 where unique_name='$blogger_unique_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$fnamex = $get['fname'];

	$short_title = substr($post_title,0,20);

	if(strlen($post_title) > strlen($short_title))
	{
		$dotdotdot = "...";
	}
	else
	{
		$dotdotdot = "";
	}
	
	echo "
		<div class='col-md-3 hrwhite'>
			<a href=$g_url"."blogs/post.php?title=$post_url&r=$unique_id data-toggle='tooltip' title='$post_title'>
				<div class='' align='left'>
					<img src='$post_img_url' style='height:110px; width:195px;'><br>
					<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$short_title$dotdotdot</b></div>
					<div style='font-size:11px; margin-bottom:3px;'>
						Write and Earn &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp
						<font size='1'>by $fnamex</font>
					</div>
				</div>
			</a>
		</div>
	";
}
?>