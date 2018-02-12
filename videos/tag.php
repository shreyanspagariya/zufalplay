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

if(isset($_GET['tag']))
{
	$tag = urldecode($_GET['tag']);
	$tag = ucwords($tag);
}
?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> <?php echo $tag;?> - Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8">
		<div class='elevatewhite'><hr><h4 align='center'><?php echo $tag;?></h4><hr></div>
		<center>
			<?php
				$datetime = getDateTimeIST();
				$count = 0; 
				$getposts = mysqli_query($con,"SELECT * FROM videos ORDER BY ((view_count/dislike_count)*(like_count))/(datediff('$datetime',time_published)) DESC");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$flag = 0;
					$tag_array = unserialize(base64_decode($row["tags"]));
					$tag_array_size = count($tag_array);

					for($i=0; $i<$tag_array_size;$i++)
					{
						if(strtolower($tag_array[$i]) == strtolower($tag))
						{
							$flag = 1;
							break;
						}
					}

					if($flag == 1)
					{
						$count++;
						echo_video_entity_genre($row, $g_url, $count);

						if($count % 4 == 0)
						{
							echo"</div><br>";
						}
					}
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