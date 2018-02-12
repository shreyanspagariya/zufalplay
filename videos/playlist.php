<?php include ("../inc/header.inc.php");
header("Location:".$g_url);
if(isset($_SESSION["email1"]))
{
	top_banner();
}

?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Playlist - Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8 hrwhite">
		<div class="elevatewhite"><hr><h4 align='center'>Playlist</h4><hr></div>
		<center>
		<div class="table-responsive elevatewhite">
			<table class="table table-bordered">
				<thead>
			        <tr>
			          <th>Name</th>
					  <th>Zufals</th>
			        </tr>
			    </thead>
			    <tbody>
			<?php 
				$getposts = mysqli_query($con,"SELECT * FROM videos V, videos_playlist P WHERE P.user_email='$email' AND V.unique_code=P.video_unique_code ORDER BY P.id");
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

						$zufals_winnable = $row['zufals_winnable'];
						$unique_code = $row['unique_code'];
						$image_link = "https://i.ytimg.com/vi/$unique_code/mqdefault.jpg";
						$view_count = number_format($row['view_count']);
						$author_url = $row['author_url'];
						$short_title = substr($title,0,18);
						echo "

						<tr>
							<td>
								<div class='col-md-2 hrwhite'>
									<a href=$g_url"."videos/video.php?v="."$unique_code&playlist=1>
										<div class='thumbnail'>
											<center>
												<img src='$image_link' style='height:100%;width:100%;'>
											</center>
										</div>
									</a>
								</div>
								<div class='col-md-10'>
									<a href=$g_url"."videos/video.php?v="."$unique_code&playlist=1><b>$title</b></a><br><br>
									<font size='2'>$str_time &nbsp;&nbsp; | &nbsp;&nbsp; $author_name &nbsp;&nbsp; | &nbsp;&nbsp; $view_count views</font>
								</div>
							</td>
							<td>
								<br><b class='number'>+$zufals_winnable</b>
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