<?php include ("../inc/header.inc.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}

?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Watch History - Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8 hrwhite">
		<div class="elevatewhite"><hr><h4 align='center'>Watch History</h4><hr></div>
		<center>
		<div class="table-responsive elevatewhite">
			<table class="table table-bordered">
				<thead>
			        <tr>
			          <th>Name</th>
			        </tr>
			    </thead>
			    <tbody>
			<?php 
				$getposts = mysqli_query($con,"SELECT DISTINCT title, author_name, time_sec_length, view_count, author_url, unique_code, description FROM (SELECT unique_code, title, author_name, time_sec_length, view_count, author_url, description FROM videos V, videos_watch_history H WHERE 
					V.unique_code = H.video_unique_code AND 
					H.user_email='$email' AND
					H.is_complete='1'
					ORDER BY H.time_started DESC LIMIT 100) AS T
					");

				while($row = mysqli_fetch_assoc($getposts))
				{
					$title = $row['title'];
					$author_name = $row['author_name'];
					//if(strpos($title1,$search_video_title)!==false || strpos($author_name1,$search_video_title)!==false)
					{
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

						$unique_code = $row['unique_code'];
						$image_link = "https://i.ytimg.com/vi/$unique_code/mqdefault.jpg";
						$view_count = number_format($row['view_count']);
						$author_url = $row['author_url'];
						$short_title = substr($title,0,18);

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

						$video_description = strip_tags(base64_decode($row['description']));
						$video_description = str_replace('"',"'", $video_description);

						$video_description = substr($video_description,0,150);

						echo "

						<tr>
							<td>
								<div class='col-md-4 hrwhite'>
									<a href=$g_url"."videos/video.php?title="."$link_title&v="."$unique_code>
										<div class='thumbnail'>
											<center>
												<img src='$image_link' style='height:100%;width:100%;'>
											</center>
										</div>
									</a>
								</div>
								<div class='col-md-8'>
									<a href=$g_url"."videos/video.php?title="."$link_title&v="."$unique_code><font size='3'><b>$title</b></font></a><br><br>
									<font size='2'>$author_name &nbsp;&nbsp; | &nbsp;&nbsp; $view_count views</font><br><br>
									<font size='2'>$video_description...</font>
								</div>
							</td>
						</tr>
						";
					}
				}
			?>
			</tbody>
				</table>
			</div>
	    </center>
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