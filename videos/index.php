<?php include ("../inc/extuser.inc.php");
include ("video-entity.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}
?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Videos - Watch and Earn @Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8">
		<center>
			<?php 
				$getposts_genre = mysqli_query($con,"SELECT * FROM videos_genre ORDER BY genre_view_count DESC");
				while($row_genre = mysqli_fetch_assoc($getposts_genre))
				{
					$genre = $row_genre['genre_name'];
					$genre_display = $row_genre['genre_display'];
					echo"
					<div class='row hrwhite elevatewhite' style='padding:5px;'>
					
						<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href='genre.php?genre=$genre'><b>$genre_display</b> &nbsp; <font size='2'>Now Trending</font></a></font></h4>
					";
					
					$datetime = getDateTimeIST();
					$getposts = mysqli_query($con,"SELECT * FROM videos WHERE genre = '$genre' ORDER BY ((view_count/dislike_count)*(like_count))/(datediff('$datetime',time_published)) DESC LIMIT 4");
					while($row = mysqli_fetch_assoc($getposts))
					{
						echo_video_entity($row, $g_url);	
					}
					echo"</div><br>";
				}
			?>
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