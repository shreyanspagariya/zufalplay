<?php include ("../inc/header.inc.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}

if(isset($_GET["type"]))
{
	$type = mysqli_real_escape_string($con,$_GET['type']);
	if($type == "published_posts")
	{
		$is_published = 1;
		$page_title = "My Published Posts";
	}
	else if($type == "drafts")
	{
		$is_published = 0;
		$page_title = "My Drafts";
	}
}

$query = "SELECT * FROM blogposts WHERE blogger_unique_id='$unique_name' AND is_published='$is_published'";
$result = mysqli_query($con,$query);
$numPosts = mysqli_num_rows($result);

?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> <?php echo $page_title;?> - Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8 hrwhite">
		<h3 align='center'><?php echo $page_title;?> <b>(<?php echo $numPosts;?>)</b></h3><hr>
			<?php
				$count = 0;
				$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE blogger_unique_id='$unique_name' AND is_published='$is_published' ORDER BY time_published DESC");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$count++;
					$post_title = $row['post_title'];
					if($post_title == "")
					{
						$post_title = "No Title";
					}
					$post_img_url = $row['post_img_url'];
					if($post_img_url == "")
					{
						$post_img_url = "https://thetechtemple.com/wp-content/themes/TechNews/images/img_not_available.png";
					}
					$post_url = $row['post_url'];
					$unique_id = $row['unique_id'];
					$is_published = $row['is_published'];
					$time_published = time_elapsed_string($row['time_published']);
					$post_earnings = $row["post_earnings"];
					$post_earnings = number_format(floor($post_earnings*100)/100,2,'.','');
					$post_views = $row["post_views"];
					
					//$numResults = $post_views;

					$query = "SELECT * FROM read_history WHERE unique_id='$unique_id' AND is_money_distributed='1'";
				    $result = mysqli_query($con,$query);
				    $numResults = mysqli_num_rows($result);

					if($numResults == 1)
					{
						$str_s = "";
					}
					else
					{
						$str_s = "s";
					}

					$numResults = number_format($numResults);

					if($is_published == 0)
					{
						echo "
						<div class='table-responsive elevatewhite' style='padding:10px;'>
							<div class='col-md-2 hrwhite'>
								<a href=$g_url"."blogs/add.php?id=".$unique_id.">
									<div class='thumbnail'>
										<center>
											<img src='$post_img_url' style='height:100%;width:100%;'>
										</center>
									</div>
								</a>
							</div>
							<div class='col-md-10'>
								<h4><a href=$g_url"."blogs/add.php?id=".$unique_id." target='_blank'><b>$post_title</b></a></h4>
								<i class='fa fa-lock' aria-hidden='true'></i>&nbsp;&nbsp;This post has not been published and hence it will not be visible to public.&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;<a href=$g_url"."blogs/add.php?id=".$unique_id."><i class='fa fa-pencil' aria-hidden='true'></i>&nbsp;Edit</a><hr>
								<div style='margin-top:-10px;' align='right'>(Earnings)&nbsp;&nbsp;<font size='3'><b>-</b></font></div>
							</div>
						</div><br>
						";
					}
					else
					{
						echo "
						<div class='table-responsive elevatewhite' style='padding:10px;'>
							<div class='col-md-2 hrwhite'>
								<a href=$g_url"."blogs/post.php?title=".$post_url."&r=".$unique_id." target='_blank'>
									<div class='thumbnail'>
										<center>
											<img src='$post_img_url' style='height:100%;width:100%;'>
										</center>
									</div>
								</a>
							</div>
							<div class='col-md-10'>
								<h4><a href=$g_url"."blogs/post.php?title=".$post_url."&r=".$unique_id." target='_blank'><b>$post_title</b></a></h4>
								<i class='fa fa-globe' aria-hidden='true'></i>&nbsp;Public&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-clock-o' aria-hidden='true'></i>&nbsp;$time_published&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-eye' aria-hidden='true'></i>&nbsp;<font size='3'><b>$numResults</b></font> view$str_s&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=".$g_url."blogs/post.php?title=".$post_url."&r=".$unique_id."&edit=true><i class='fa fa-pencil' aria-hidden='true'></i>&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=".$g_url."blogs/analytics/?filter_by_r=".$unique_id." target='_blank'><i class='fa fa-bar-chart' aria-hidden='true'></i>&nbsp;Analytics</a><hr>
								<div style='margin-top:-10px;' align='right'>(Earnings)&nbsp;&nbsp;<font size='3'><b>Rs. $post_earnings</b></font></div>
							</div>
						</div><br>
						";
					}
				}
			?>
			</div>
	    <br><br>
	</div>
	<div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
	</div>
</body>
<?php include ("../inc/footer.inc.php"); ?>	