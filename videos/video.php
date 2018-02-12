<?php include ("../inc/extuser.inc.php");
include ("backend/convert-youtube-datetime.php");
include ("backend/convert-youtube-time-duration-to-sec.php");
include ("video-entity.php");
if(isset($_SESSION["email1"]))
{
	$autoplay = 1;
	top_banner();
}
else
{
	$autoplay = 0;
	top_banner_extuser();
}

date_default_timezone_set("Asia/Kolkata");
$datetime = date("Y-m-d H:i:sa");

// is_complete = 0 -> Video Started But Not Completed
// is_complete = 1 -> Video Completed
// is_complete = 2 -> For Sure this video cannot be completed (if tab closed before completion) OR Handling the case of playing videos in multiple tabs

mysqli_query($con,"UPDATE videos_watch_history SET is_complete='2' WHERE user_email='$email' AND is_complete='0'");

if(isset($_GET['v']))
{
	$unique_code = mysqli_real_escape_string($con,$_GET['v']);

	if(isset($_GET['sharer']))
	{
		$sharer = mysqli_real_escape_string($con,$_GET['sharer']);
	}
	else
	{
		$sharer = "";
	}

	$query = "SELECT * FROM videos WHERE unique_code='$unique_code'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get_videoDetails_DB = mysqli_fetch_assoc($result);
	
	if($numResults == 0)
	{
		$vid = $unique_code;
	  	$videoDetails = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$vid."&part=contentDetails,statistics,snippet,status&key=AIzaSyCauWoLWHHF9H0PrV1Pq8I9edEqXEJYzZU");

		$res1 = json_decode($videoDetails, true);

	    $str = $res1['items'][0]['contentDetails']['duration'];
	    $view_count = $res1['items'][0]['statistics']['viewCount'];
	    $like_count = $res1['items'][0]['statistics']['likeCount'];
	    $dislike_count = $res1['items'][0]['statistics']['dislikeCount'];
	    $favorite_count = $res1['items'][0]['statistics']['favoriteCount'];
	    $comment_count = $res1['items'][0]['statistics']['commentCount'];
	    $time_published = convert_youtube_datetime($res1['items'][0]['snippet']['publishedAt']);
	    $video_description = $res1['items'][0]['snippet']['description'];
	    $video_description_serialized = base64_encode($video_description);
	    $video_description = str_replace("\n", "<br>", $video_description);

	    $tags_array = $res1['items'][0]['snippet']['tags'];
	    $tags_array_serialized = base64_encode(serialize($tags_array));

		$sec = convert_time($str);
		$zufals_winnable = floor(sqrt($sec/60)); 


		$oembed_details = file_get_contents("https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=$vid");
		
	    $res1 = json_decode($oembed_details, true);

		$title = $res1['title'];
		$title = addslashes($title);
		$image_link = $res1['thumbnail_url'];
		$author_url = $res1['author_url'];
		$author_name = $res1['author_name'];

		if($title!="")
		{
			mysqli_query($con,"INSERT INTO videos (unique_code, user_addedby, title, genre, time_sec_length, zufals_winnable, image_link, view_count, 
				like_count, dislike_count, author_name, comment_count, favorite_count, author_url,time_added, time_published, tags, description) VALUES 
				('$vid','$email','$title','other','$sec','$zufals_winnable','$image_link','$view_count',
					'$like_count','$dislike_count','$author_name','$comment_count','$favorite_count','$author_url','$datetime','$time_published','$tags_array_serialized','$video_description_serialized')");

			$query = "SELECT * FROM videos_author_genre WHERE author='$author_url'";
			$result = mysqli_query($con,$query);
			$get = mysqli_fetch_assoc($result);
			$numResults = mysqli_num_rows($result);

			if($numResults==0)
			{
				mysqli_query($con,"INSERT INTO videos_author_genre (author,genre) VALUES ('$author_url','other')");
			}
			else
			{
				$genre_author = $get['genre'];
				mysqli_query($con,"UPDATE videos SET genre='$genre_author' WHERE unique_code='$unique_code'");
			}
		}
	}
	else
	{
		$vid = $unique_code;
		$videoDetails = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$vid."&part=contentDetails,statistics,snippet,status&key=AIzaSyCauWoLWHHF9H0PrV1Pq8I9edEqXEJYzZU");

		$res1 = json_decode($videoDetails, true);

		$str = $res1['items'][0]['contentDetails']['duration'];
	    $view_count = $res1['items'][0]['statistics']['viewCount'];
	    $like_count = $res1['items'][0]['statistics']['likeCount'];
	    $dislike_count = $res1['items'][0]['statistics']['dislikeCount'];
	    $favorite_count = $res1['items'][0]['statistics']['favoriteCount'];
	    $comment_count = $res1['items'][0]['statistics']['commentCount'];
	    $video_description = $res1['items'][0]['snippet']['description'];
	    $video_description = str_replace("\n", "<br>", $video_description);

	    $sec = convert_time($str);

	    mysqli_query($con,"UPDATE videos SET time_sec_length='$sec', view_count='$view_count', like_count='$like_count', dislike_count='$dislike_count', favorite_count='$favorite_count', comment_count='$comment_count' WHERE unique_code='$vid'");
		
		$author_url = $get_videoDetails_DB["author_url"];

		$query = "SELECT * FROM videos_author_genre WHERE author='$author_url'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$genre_author = $get['genre'];
		mysqli_query($con,"UPDATE videos SET genre='$genre_author' WHERE author_url='$author_url' AND genre='other'");
	}
	
	$query = "SELECT * FROM videos WHERE unique_code='$unique_code'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$title = $get['title'];
	$time_sec_length = $get['time_sec_length'];
	$view_count = $get['view_count'];
	$like_count = $get['like_count'];
	$dislike_count = $get['dislike_count'];
	$author_name = $get['author_name'];
	$genre = $get['genre'];
	$author_url = $get['author_url'];
	$tags = unserialize(base64_decode($get['tags']));

	function generateRandomString($length = 9) 
	{
	    $characters = '123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	$watch_id = generateRandomString();
	$query = "SELECT * FROM videos_watch_history WHERE watch_id='$watch_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);

	while($numResults!=0)
	{
		$watch_id = generateRandomString();
		$query = "SELECT * FROM videos_watch_history WHERE watch_id='$watch_id'";
		$result = mysqli_query($con,$query);
		$numResults = mysqli_num_rows($result);
	}

	if($email!="")
	{
		mysqli_query($con,"INSERT INTO videos_watch_history (video_unique_code,time_started,user_email,watch_id,is_complete,sharer) 
							VALUES ('$unique_code','$datetime','$email','$watch_id','0','$sharer')");

		$query = "SELECT * FROM videos_playlist WHERE video_unique_code='$unique_code' AND user_email='$email'";
		$result = mysqli_query($con,$query);
		$numResults = mysqli_num_rows($result);
		$get = mysqli_fetch_assoc($result);
		$id = $get['id'];

		if($numResults != 0 && isset($_GET['playlist']) && $_GET['playlist'] == 1)
		{
			$query = "SELECT * FROM videos_playlist WHERE user_email='$email' AND id>'$id' ORDER BY id LIMIT 1";
			$result = mysqli_query($con,$query);
			$get = mysqli_fetch_assoc($result);
			$next_unique_code = $get['video_unique_code'];
		}
		else
		{
			$next_unique_code = "";
		}
		$next_unique_code = "";
	}
	else
	{
		$next_unique_code = "";

		if(!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} 
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		else 
		{
		    $ip = $_SERVER['REMOTE_ADDR'];
		}

		mysqli_query($con,"INSERT INTO videos_watch_history (video_unique_code,time_started,user_email,watch_id,is_complete,sharer) 
							VALUES ('$unique_code','$datetime','$ip','$watch_id','0','$sharer')");
	}
}

?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> <?php echo $title;?> - Watch and Earn @Zufalplay</title>
<img src="https://i.ytimg.com/vi/<?php echo $unique_code;?>/mqdefault.jpg" hidden>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8">
	<div class='row hrwhite elevatewhite' style='padding:20px;'>
		<?php
			$share_url = $g_url."videos/video.php?v=".$unique_code."&sharer=".$unique_name;
		?>
		<div class="modal" id="share-video-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        		<center><h4 class="modal-title" id="myModalLabel">Share & Earn (Per View)</h4></center>
		      		</div>
			      	<div class="modal-body">
				        <div class="beforesubmit">
				        	<center>
				        		<?php
									$earnings_sharer = 0;
									$getposts = mysqli_query($con,"SELECT * FROM videos_watch_history WHERE sharer='$unique_name' AND video_unique_code='$unique_code' AND is_money_distributed_to_sharer='1'");
									while($row = mysqli_fetch_assoc($getposts))
									{
										$earnings_sharer = $earnings_sharer + $row['earnings_sharer'];
									}

									$query = "SELECT * FROM videos_watch_history WHERE sharer='$unique_name' AND video_unique_code='$unique_code' AND is_money_distributed_to_sharer='1'";
									$result = mysqli_query($con,$query);
									$views_sharer = number_format(mysqli_num_rows($result));
								?>
								<div class='col-md-6'>
									<center>
										<div style='margin-top:5px; border:1px solid black;'>Earnings: <font size='4'><b>Rs. <?php echo $earnings_sharer;?></b></font> on Shares</div>
									</center>
								</div>
								<div class='col-md-6'>
									<center>
										<div style='margin-top:5px; border:1px solid black;'><font size='4'><b><?php echo $views_sharer;?></b></font> Views on Shares</div>
									</center>
								</div>
								<br><br><br>
				        		<div class="fb-share-button" data-href="<?php echo $share_url;?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url?>&src=sdkpreparse">Share</a></div>
				        		<br><br><br>
				        		<div style="border-top: #9D9D9D dashed 1.5px;"><span style="background-color:white; position:relative; top: -0.8em; left:0.63%;">&nbsp;OR&nbsp;</span></div><br>
				          		<input type='text' value='<?php echo $share_url;?>' style="width: 100%; text-align:center; background-color: #E6E6E6; border:1px solid black;" readonly></input>
				          		<br><br>
				          	</center> 
				        </div>
			   		</div>
				</div>
			</div>
		</div>
		<center>
			<iframe type="text/html" width="100%" height="470"
		    	src="http://www.youtube.com/embed/<?php echo $unique_code;?>?version=3&enablejsapi=1&fs=1&autoplay=<?php echo $autoplay;?>&showinfo=0&color=green&modestbranding=1&rel=0&origin=http://zufalplay.com&iv_load_policy=3"
		       	frameborder="0" allowfullscreen>
		    </iframe>
		    <br>
		</center>
		    <?php 
				if(!isset($_SESSION["email1"]))
				{	
					?>
					
						<h4><b><?php echo $title;?></b></h4><br>
						<?php echo "<a href=".$g_url."videos/author.php?author=".urlencode($author_name).">".$author_name."</a>"; ?>
						<div align='right' style='margin-top:-3%;'>
							<h4><b><?php echo number_format($view_count); ?></b></h4>
							<h4><i class="fa fa-thumbs-up"></i>&nbsp;<font size='2'><?php echo number_format($like_count);?></font>&nbsp;&nbsp;<i class="fa fa-thumbs-down"></i>&nbsp;<font size='2'><?php echo number_format($dislike_count);?></font></h4>
						</div>
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<ins class="adsbygoogle"
						     style="display:block"
						     data-ad-client="ca-pub-7888738492112143"
						     data-ad-slot="1322728114"
						     data-ad-format="auto"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
						<hr>
						<div class="row">
							<div class='col-md-4'>
								<img src="https://i.ytimg.com/vi/<?php echo $unique_code;?>/mqdefault.jpg" style="width:100%;">
								<div style='margin-top:5px; margin-bottom:10px;'><b>"<?php echo $title;?>"</b></div>
								<center>
									<button type="button" data-toggle="modal" data-target="#login-login-modal" class="login-btn btn btn-primary btn-flat">Share & Earn</button><br><br>
								</center>
							</div>
							<div class='col-md-8'>
								<div style='margin-top:-10px;margin-bottom:10px;'><center><h4>Assign a Genre to this Video</h4></center></div>
								<form onsubmit="return false;" method="POST">
									<div class="row">
										<?php
											$getgenre = mysqli_query($con,"SELECT * FROM videos_genre ORDER BY genre_view_count DESC");
											while($genrerow = mysqli_fetch_assoc($getgenre))
											{
												$genre_name = $genrerow["genre_name"];
												$genre_display = $genrerow["genre_display"];
												echo "<div class='col-md-4'><input type='radio' name='genre_name' value=".$genre_name."> ".$genre_display."</div>";
											}
										?>
									</div>
									<input id="video_unique_code" name="video_unique_code" value="<?php echo $unique_code;?>" hidden>
									<div style='margin-top:10px'>
										<center>
											<button id='finalize_genre' onclick="finalize_user_assigned_genre()">Finalize Genre</button>
											<img class="assign-genre-loading hidden" src="<?php echo $g_url?>images/loading.gif">
											<span id='success_message'></span>
										</center>
									</div>
								</form>
							</div>
						</div>
						<hr>
						<?php
							$numTags = count($tags);
							for($i=0; $i<$numTags; $i++)
							{
								echo "<a href=".$g_url."videos/tag.php?tag=".urlencode($tags[$i])."><span style='background:#D8D8D8; color:#585858; padding:5px; display:inline-block; margin-top:3px; margin-bottom:3px; margin-left:1px; margin-right:1px;'>".$tags[$i]."</span></a>
									";
							}
						?>
						<hr>
						<div class="col-md-6">
							<?php echo $video_description;?>
						</div>
						<div class="col-md-6">
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script><br>
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
					</div>
					<br><br><br>
					<?php
				}
				else
				{
					?>
				    <h4><b><?php echo $title;?></b></h4><br>
						<?php 
						
				    	$query = "SELECT * FROM videos_playlist WHERE video_unique_code='$unique_code' AND user_email='$email'";
						$result = mysqli_query($con,$query);
						$numResults = mysqli_num_rows($result);

						if($numResults == 0)
						{
				    		echo"<button onclick='addtoplaylist()' id='playlistbutton' class='btn btn-sm btn-default' style='background-color: rgba(0,0,0,0.4); border-radius:0px;'>
							+ <b>Add to Favorites</b></button>
							<input id='addtype' value='0' hidden>";
						}
						else
						{
							echo"<button onclick='addtoplaylist()' id='playlistbutton' class='btn btn-sm btn-default' style='background-color: rgba(0,0,0,0.4); border-radius:0px;'>
							<i class='fa fa-times'></i> &nbsp;<b>Remove from Favorites</b></button>
							<input id='addtype' value='1' hidden>";
						}
						
					?><br><br>
					<?php echo "<a href=".$g_url."videos/author.php?author=".urlencode($author_name).">".$author_name."</a>"; ?>
						<div align='right' style='margin-top:-9%;'>
							<h4><b><?php echo number_format($view_count); ?></b></h4>
							<h4><i class="fa fa-thumbs-up"></i>&nbsp;<font size='2'><?php echo number_format($like_count);?></font>&nbsp;&nbsp;<i class="fa fa-thumbs-down"></i>&nbsp;<font size='2'><?php echo number_format($dislike_count);?></font></h4>
						</div>
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<ins class="adsbygoogle"
						     style="display:block"
						     data-ad-client="ca-pub-7888738492112143"
						     data-ad-slot="1322728114"
						     data-ad-format="auto"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
						<hr>
						<div class="row">
							<div class='col-md-4'>
								<img src="https://i.ytimg.com/vi/<?php echo $unique_code;?>/mqdefault.jpg" style="width:100%;">
								<div style='margin-top:5px; margin-bottom:10px;'><b>"<?php echo $title;?>"</b></div>
								<center>
									<button type="button" data-toggle="modal" data-target="#share-video-modal" class="login-btn btn btn-primary btn-flat">Share & Earn</button><br><br>
								</center>
							</div>
							<div class='col-md-8'>
								<div style='margin-top:-10px;margin-bottom:10px;'><center><h4>Assign a Genre to this Video</h4></center></div>
								<?php
									$query = "SELECT * FROM videos_user_assigned_genre WHERE user_email='$email' AND video_unique_code='$unique_code'";
									$result = mysqli_query($con,$query);
									$numResults = mysqli_num_rows($result);

									if($numResults == 0)
									{
										?>
										<form onsubmit="return false;" method="POST">
											<div class="row">
												<?php
													$getgenre = mysqli_query($con,"SELECT * FROM videos_genre ORDER BY genre_view_count DESC");
													while($genrerow = mysqli_fetch_assoc($getgenre))
													{
														$genre_name = $genrerow["genre_name"];
														$genre_display = $genrerow["genre_display"];
														echo "<div class='col-md-4'><input type='radio' name='genre_name' value=".$genre_name."> ".$genre_display."</div>";
													}
												?>
											</div>
											<input id="video_unique_code" name="video_unique_code" value="<?php echo $unique_code;?>" hidden>
											<div style='margin-top:10px'>
												<center>
													<button id='finalize_genre' onclick="finalize_user_assigned_genre()">Finalize Genre</button>
													<img class="assign-genre-loading hidden" src="<?php echo $g_url?>images/loading.gif">
													<span id='success_message'></span>
												</center>
											</div>
										</form>
										<?php
									}
									else
									{
										$get = mysqli_fetch_assoc($result);
										$local_genre_name = $get["genre"];

										$query = "SELECT * FROM videos_genre WHERE genre_name='$local_genre_name'";
										$result = mysqli_query($con,$query);
										$get = mysqli_fetch_assoc($result);
										$local_genre_display = $get["genre_display"];

										?>
										<form onsubmit="return false;" method="POST">
											<div class="row">
												<?php
													$getgenre = mysqli_query($con,"SELECT * FROM videos_genre ORDER BY genre_view_count DESC");
													while($genrerow = mysqli_fetch_assoc($getgenre))
													{
														$genre_name = $genrerow["genre_name"];
														$genre_display = $genrerow["genre_display"];
														echo "<div class='col-md-4'><input type='radio' name='genre_name' value=".$genre_name." disabled> ".$genre_display."</div>";
													}
												?>
											</div>
											<input id="video_unique_code" name="video_unique_code" value="<?php echo $unique_code;?>" hidden>
											<div style='margin-top:10px'>
												<center>	
													<span id='success_message'><font size='3' color='green'><i class='fa fa-check-circle' aria-hidden='true'></i></font> Successfully assigned <b>'<?php echo $local_genre_display;?>'</b> Genre to this Video.</span>
												</center>
											</div>
										</form>
										<?php
									}
								?>
							</div>
						</div>
						<hr>
						<?php
							$numTags = count($tags);
							for($i=0; $i<$numTags; $i++)
							{
								echo "<a href=".$g_url."videos/tag.php?tag=".urlencode($tags[$i])."><span style='background:#D8D8D8; color:#585858; padding:5px; display:inline-block; margin-top:3px; margin-bottom:3px; margin-left:1px; margin-right:1px;'>".$tags[$i]."</span></a>
									";
							}
						?>
						<hr>
						<div class="col-md-6">
							<?php echo $video_description;?>
						</div>
						<div class="col-md-6">
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script><br>
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
					</div><br><br><br>
				    <script>
				    	function addtoplaylist()
				    	{
				    		if(document.getElementById("addtype").value == 0)
				    		{
				    			$("#playlistbutton").html('<i class="fa fa-times"></i> &nbsp;<b>Remove from Favorites</b>');
				    			document.getElementById("addtype").value = 1;
				    		}
				    		else
				    		{
				    			$("#playlistbutton").html('+ <b>Add to Favorites</b>');
				    			document.getElementById("addtype").value = 0;
				    		}
				    		$.ajax(
							  {
								url: "<?php echo $g_url;?>videos/backend/addtoplaylist.php",
							    dataType: "json",
							    type:"POST",
							    data:
							    {
							      mode:'addto_playlist',
							      unique_code:"<?php echo $unique_code; ?>",
							    },
							    success: function(json)
							    {
							      if(json.status==1)
							      {
							        
							      }
							      else
							      {
							      }
							    },
							    error : function()
							    {
							      //console.log("something went wrong");
							    }
							  });
				    	}
				    </script>
					<?php
				}
			?>
	</div>
	<div class="col-md-2 hrwhite">
		<center>
		<?php
			$query = "SELECT * FROM videos_no_ads WHERE unique_code='$unique_code'";
			$result = mysqli_query($con,$query);
			$numResults = mysqli_num_rows($result);
			if($numResults==0)
			{
				?>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-client="ca-pub-7888738492112143"
				     data-ad-slot="1322728114"
				     data-ad-format="auto"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
				<?php
			}
		?>
		</center>
		<div class='' style='padding:10px;'>
			<center>
			<?php

				$recommended_count = 0;

				$i=0;
				$getposts = mysqli_query($con,"SELECT * FROM videos WHERE author_url='$author_url' AND genre='$genre' ORDER BY ((view_count/dislike_count)*(like_count))/(datediff('$datetime',time_published)) ASC");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$similar_videos[$i]['title'] = $row['title'];
					$similar_videos[$i]['time_sec_length'] = $row['time_sec_length'];
					$similar_videos[$i]['view_count'] = $row['view_count'];
					$similar_videos[$i]['unique_code'] = $row['unique_code'];
					$i++;
				}

				$similar_videos_author = $i;
				for($j=0;$j<$similar_videos_author;$j++)
				{
					if($similar_videos[$j]['unique_code'] == $unique_code)
					{
						for($k=($j-1+$similar_videos_author)%$similar_videos_author,$rec_limit=0;$rec_limit<10;$k=($k-1+$similar_videos_author)%$similar_videos_author)
						{
							if($k!=$j)
							{
								$rec_limit++;
								$recommended_count++;
								$row = $similar_videos[$k];
								echo_video_entity_recommend($row, $g_url);
							}
							else
							{
								break;
							}
						}
						break;
					}
				}

				$getposts = mysqli_query($con,"SELECT * FROM videos WHERE genre='$genre' AND unique_code!='$unique_code' ORDER BY RAND() LIMIT ".(10-$recommended_count));
				while($row = mysqli_fetch_assoc($getposts))
				{
					echo_video_entity_recommend($row, $g_url);
				}
			?>
			</center>
		</div>
	</div>
</body>
<script src="js/user-assigned-genre.js"></script>
<script>
	var x="<?php echo $time_sec_length; ?>",y=-5;
	function f()
	{
		y+=5;
		if(y+10>=x)
		{
			$.ajax(
			  {
				url: "<?php echo $g_url;?>videos/backend/updatehistory.php",
			    dataType: "json",
			    type:"POST",
			    data:
			    {
			      mode:'video_complete',
			      watch_id:"<?php echo $watch_id; ?>",
			    },
			    success: function(json)
			    {
			      if(json.status==1)
			      {
			    	
			      }
			      else
			      {
			      }
			    },
			    error : function()
			    {
			      //console.log("something went wrong");
			    }
			  });

			setTimeout(function()
			{
				var next_in_list = "<?php echo $next_unique_code;?>";
				if(next_in_list!="")
				{
					location.href = "<?php echo $g_url;?>videos/video.php?v=" + next_in_list + "&playlist=1";
				}
			 }, 10000);
		}
		else
		{
			 setTimeout(function(){
			 	f();
			 }, 5000);
		}
	}
	window.onload=f();
</script>
<?php 
if(!isset($_SESSION["email1"]))
{
	?>
	<script>
	   $(window).load(function(){
	   		$('#signup-login-modal .modal-dialog .modal-content .modal-header .modal-title').text("Want to earn by watching this video? Signup Now!");
	        $('#signup-login-modal').modal('show');
	    });
	</script>
	<?php
}
?>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php include ("../inc/footer.inc.php"); ?>
