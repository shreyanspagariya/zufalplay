<?php
include ("../inc/extuser.inc.php"); 
include ("blog-entity.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}

$no_image = $g_url."images/blog_default.jpg";

date_default_timezone_set('Asia/Kolkata');
$datetime = date("Y-m-d H:i:sa");
$curr_time = time();

$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1'");
while($row = mysqli_fetch_assoc($getposts))
{
	$unique_id = $row["unique_id"];
	$post_views = $row["post_views"];
	$time_published = $row["time_published"];

	$hours_passed = ($curr_time - strtotime($time_published))/3600;

	$trend_value = $post_views/$hours_passed;

	mysqli_query($con,"UPDATE blogposts SET trend_value='$trend_value' WHERE unique_id='$unique_id'");
}

?>

<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Blogs - Write and Earn @Zufalplay</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8">
		<center>
			<?php
			if(!isset($_GET["tag"]) && !isset($_GET["sort_by"]))
			{
				if(!isset($_GET["view"]))
				{
					echo"
					<div class='row hrwhite elevatewhite' style='padding:5px;'>
						<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href=".$g_url."blogs/?sort_by=trending><b><i class='fa fa-line-chart' aria-hidden='true'></i>&nbsp;&nbsp;Trending</b></a></font></h4>";

					$count = 0;
					$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' ORDER BY trend_value DESC LIMIT 4");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$count++;
						echo_blog_entity($con, $row, $g_url);
					}
					echo"</div><br>";
					echo"
					<div class='row hrwhite elevatewhite' style='padding:5px;'>
						<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href=".$g_url."blogs/?sort_by=top_viewed><b><i class='fa fa-search' aria-hidden='true'></i>&nbsp;&nbsp;Top Viewed</b></a></font></h4>";

					$count = 0;
					$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' ORDER BY post_views DESC LIMIT 4");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$count++;
						echo_blog_entity($con, $row, $g_url);
					}
					echo"</div><br>";
					echo"
					<div class='row hrwhite elevatewhite' style='padding:5px;'>
						<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href=".$g_url."blogs/?view=tags><b><i class='fa fa-tags' aria-hidden='true'></i>&nbsp;&nbsp;Popular Tags</b></a></font></h4>";

					$count = 0;
					$getposts = mysqli_query($con,"SELECT * FROM blogpost_tags ORDER BY tag_views DESC LIMIT 4");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$count++;
						$tag_name = $row['tag_name'];
						$tag_url = $row['tag_url'];
						$tag_img_url = $row['tag_img_url'];
						if($tag_img_url == "")
						{
							$tag_img_url = $no_image;
						}
						$tag_views = number_format($row['tag_views']);

						$short_title = substr($tag_name,0,60);

						if(strlen($tag_name) > strlen($short_title))
						{
							$dotdotdot = "...";
						}
						else
						{
							$dotdotdot = "";
						}
						
						echo "
							<div class='col-md-3 hrwhite'>
								<a href=$g_url"."blogs/?tag=$tag_url data-toggle='tooltip' title='$tag_name'>
									<div class=''>
										<img src='$tag_img_url' style='height:110px; width:195px;'><br>
										<font size='2'><b>$short_title$dotdotdot</b></font>
										<div style=''>
											<font size='2'>$tag_views</font> 
											<font size='1'>post views</font>
										</div>
									</div>
								</a>
							</div>
						";
					}
					echo"</div><br>";
					echo"
					<div class='row hrwhite elevatewhite' style='padding:5px;'>
						<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href=".$g_url."blogs/?sort_by=recent_posts><b><i class='fa fa-hourglass-start' aria-hidden='true'></i>&nbsp;&nbsp;Recent</b></a></font></h4>";

					$count = 0;
					$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' ORDER BY time_published DESC LIMIT 4");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$count++;
						echo_blog_entity($con, $row, $g_url);
					}
					echo"</div><br>";
					echo"
					<div class='row hrwhite elevatewhite' style='padding:5px;'>
						<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href=".$g_url."blogs/?sort_by=recommended_posts><b><i class='fa fa-magic' aria-hidden='true'></i>&nbsp;&nbsp;Recommended</b></a></font></h4>";

					$count = 0;
					$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' ORDER BY RAND() DESC LIMIT 4");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$count++;
						echo_blog_entity($con, $row, $g_url);
					}
					echo"</div><br>";
				}
				else
				{
					echo"
						<div class='elevatewhite'><hr><h4 align='center'>Popular Tags</h4><hr></div>";

					$count = 0;
					$getposts = mysqli_query($con,"SELECT * FROM blogpost_tags ORDER BY tag_views DESC");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$count++;
						$tag_name = $row['tag_name'];
						$tag_url = $row['tag_url'];
						$tag_img_url = $row['tag_img_url'];
						if($tag_img_url == "")
						{
							$tag_img_url = $no_image;
						}
						$tag_views = number_format($row['tag_views']);

						$short_title = substr($tag_name,0,60);

						if(strlen($tag_name) > strlen($short_title))
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
								<a href=$g_url"."blogs/?tag=$tag_url data-toggle='tooltip' title='$tag_name'>
									<div class=''>
										<img src='$tag_img_url' style='height:110px; width:195px;'><br>
										<font size='2'><b>$short_title$dotdotdot</b></font>
										<div style=''>
											<font size='2'>$tag_views</font> 
											<font size='1'>post views</font>
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
				}
			}
			else if(isset($_GET["tag"]) && !isset($_GET["sort_by"]))
			{
				$tag_url = mysqli_real_escape_string($con,$_GET['tag']);

				$query = "SELECT * FROM blogpost_tags WHERE tag_url='$tag_url'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$tag_name = mysqli_real_escape_string($con,$get['tag_name']);

				echo"
				<div class='row hrwhite elevatewhite' style='padding:5px;'>
					<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href=".$g_url."blogs/?tag=$tag_url&sort_by=trending><b><i class='fa fa-line-chart' aria-hidden='true'></i>&nbsp;&nbsp;Trending in <b>$tag_name</b></b></a></font></h4>";

				$count = 0;
				$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' AND (tag1='$tag_name' OR tag2='$tag_name' OR tag3='$tag_name' OR tag4='$tag_name' OR tag5='$tag_name') ORDER BY trend_value DESC LIMIT 4");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$count++;
					echo_blog_entity($con, $row, $g_url);
				}
				if($count == 0)
				{
					echo"<center>Sorry, no posts in this category.</center><br>";
				}
				echo"</div><br>";
				echo"
				<div class='row hrwhite elevatewhite' style='padding:5px;'>
					<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href=".$g_url."blogs/?tag=$tag_url&sort_by=top_viewed><b><i class='fa fa-search' aria-hidden='true'></i>&nbsp;&nbsp;Top Viewed in <b>$tag_name</b></b></a></font></h4>";

				$count = 0;
				$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' AND (tag1='$tag_name' OR tag2='$tag_name' OR tag3='$tag_name' OR tag4='$tag_name' OR tag5='$tag_name') ORDER BY post_views DESC LIMIT 4");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$count++;
					echo_blog_entity($con, $row, $g_url);
				}
				if($count == 0)
				{
					echo"<center>Sorry, no posts in this category.</center><br>";
				}
				echo"</div><br>";
				echo"
				<div class='row hrwhite elevatewhite' style='padding:5px;'>
					<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href=".$g_url."blogs/?tag=$tag_url&sort_by=recent_posts><b><i class='fa fa-hourglass-start' aria-hidden='true'></i>&nbsp;&nbsp;Recent in <b>$tag_name</b></b></a></font></h4>";

				$count = 0;
				$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' AND (tag1='$tag_name' OR tag2='$tag_name' OR tag3='$tag_name' OR tag4='$tag_name' OR tag5='$tag_name') ORDER BY time_published DESC LIMIT 4");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$count++;
					echo_blog_entity($con, $row, $g_url);
				}
				if($count == 0)
				{
					echo"<center>Sorry, no posts in this category.</center><br>";
				}
				echo"</div><br>";
				echo"
				<div class='row hrwhite elevatewhite' style='padding:5px;'>
					<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href=".$g_url."blogs/?tag=$tag_url&sort_by=recommended_posts><b><i class='fa fa-magic' aria-hidden='true'></i>&nbsp;&nbsp;Recommended in <b>$tag_name</b></b></a></font></h4>";

				$count = 0;
				$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' AND (tag1='$tag_name' OR tag2='$tag_name' OR tag3='$tag_name' OR tag4='$tag_name' OR tag5='$tag_name') ORDER BY RAND() DESC LIMIT 4");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$count++;
					echo_blog_entity($con, $row, $g_url);
				}
				if($count == 0)
				{
					echo"<center>Sorry, no posts in this category.</center><br>";
				}
				echo"</div><br>";
			}
			else if(!isset($_GET["tag"]) && isset($_GET["sort_by"]))
			{
				$sort_by = mysqli_real_escape_string($con,$_GET['sort_by']);

				if($sort_by == "trending")
				{
					$display = "Trending Posts";
					$column = "trend_value";
				}
				else if($sort_by == "top_viewed")
				{
					$display = "Top Viewed Posts";
					$column = "post_views";
				}
				else if($sort_by == "recent_posts")
				{
					$display = "Recent Posts";
					$column = "time_published";
				}
				else if($sort_by == "recommended_posts")
				{
					$display = "Recommended Posts";
					$column = "RAND()";
				}

				echo"
				<div class='elevatewhite'><hr><h4 align='center'>$display</h4><hr></div>";

				$count = 0;
				$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' ORDER BY $column DESC");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$count++;
					echo_blog_entity_orderby($con, $row, $g_url, $count);
				}
			}
			else if(isset($_GET["tag"]) && isset($_GET["sort_by"]))
			{
				$sort_by = mysqli_real_escape_string($con,$_GET['sort_by']);
				$tag_url = mysqli_real_escape_string($con,$_GET['tag']);

				$query = "SELECT * FROM blogpost_tags WHERE tag_url='$tag_url'";
				$result = mysqli_query($con,$query);
				$get = mysqli_fetch_assoc($result);
				$tag_name = mysqli_real_escape_string($con,$get['tag_name']);

				if($sort_by == "trending")
				{
					$display = "Trending Posts";
					$column = "trend_value";
				}
				else if($sort_by == "top_viewed")
				{
					$display = "Top Viewed Posts";
					$column = "post_views";
				}
				else if($sort_by == "recent_posts")
				{
					$display = "Recent Posts";
					$column = "time_published";
				}
				else if($sort_by == "recommended_posts")
				{
					$display = "Recommended Posts";
					$column = "RAND()";
				}

				echo"
				<div class='elevatewhite'><hr><h4 align='center'>$display</h4><hr></div>";

				$count = 0;
				$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' AND (tag1='$tag_name' OR tag2='$tag_name' OR tag3='$tag_name' OR tag4='$tag_name' OR tag5='$tag_name') ORDER BY $column DESC");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$count++;
					echo_blog_entity_orderby($con, $row, $g_url, $count);
				}
				if($count == 0)
				{
					echo"<center>Sorry, no posts in this category.</center><br>";
				}
			}
			?>
		</center>
	</div>
	<div class="col-md-2">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="ca-pub-7888738492112143"
		     data-ad-slot="1322728114"
		     data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>
</body>
<br>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php 
if(!isset($_SESSION["email1"]))
{
	?>
	<script>
	   $(window).load(function(){
	   		$('#signup-login-modal .modal-dialog .modal-content .modal-header .modal-title').text("Want to earn by Writing? Signup Now!");
	        $('#signup-login-modal').modal('show');
	    });
	</script>
	<?php
}
?>
<?php include ("../inc/footer.inc.php"); ?>						
