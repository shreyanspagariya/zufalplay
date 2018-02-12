<?php include ("./inc/extuser.inc.php"); 
if(isset($_SESSION["email1"]))
{
  $email = $_SESSION["email1"];
  top_banner();
}
else
{
  $email = "EXTUSER";
  top_banner_extuser();
}

date_default_timezone_set('Asia/Calcutta');
$datetime = date("Y-m-d H:i:sa");

?>
<head>
	<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Search Results - Zufalplay</title>
</head>
<body class="zfp-inner">
	<div class="">
		<div class='col-md-2'>
			<?php include ("./inc/sidebar.inc.php"); ?>
		</div>
		<div class="col-md-8">
			<center><h3>Search Results</h3><hr></center>
			<div class="table-responsive elevatewhite hrwhite">
				<table class="table table-bordered">
					<thead>
				        <tr>
				          <th>Name</th>
				        </tr>
				    </thead>
				    <tbody>
						<?php

						$search_results_count = 0;
						$max_results = 25;

						if(isset($_GET['query']))
						{
							$user = mysqli_real_escape_string($con,$_GET['query']); 


							if(isset($_SESSION["email1"]))
							{
								$search_user_email = $_SESSION["email1"];
								mysqli_query($con,"INSERT INTO search_queries (user_email,query_string,time,is_real_time) VALUES ('$search_user_email','$user','$datetime','0')");
							}
							else
							{
								$search_user_email = spit_ip();
								mysqli_query($con,"INSERT INTO search_queries (user_email,query_string,time,is_real_time) VALUES ('$search_user_email','$user','$datetime','0')");
							}

				            if($user) 
				            {
				            	$getposts = mysqli_query($con,"SELECT * FROM games WHERE game_id!='4'");
								while($row = mysqli_fetch_assoc($getposts))
								{
									$game_id = $row["game_id"];
									$game_display = $row["game_display"];
									$game_link = $row["game_link"];
									$game_profile_image = $row["game_profile_image"];
									$game_gif = $row['game_gif'];

									$query = "SELECT * from game_playhistory WHERE game_id='$game_id' AND isout='1' AND play_id!='TRAINGAME'";
									$result = mysqli_query($con,$query);
									$currmatches = number_format(mysqli_num_rows($result));

									if($currmatches == 0)
									{
										$query = "SELECT * FROM placedbets";
										$result = mysqli_query($con,$query);
										$currmatches = number_format(mysqli_num_rows($result));
									}

									$search_game_title = strtolower($user);
									$game_display1 = strtolower($game_display);

									if(strpos($game_display1,$search_game_title)!==false)
									{
										echo "
										<tr>
											<td>
												<div class='col-md-4 hrwhite'>
													<a href=$g_url"."$game_link>
														<div class='thumbnail'>
															<center>
																<img src='$game_gif' style='height:100%;width:100%;'>
															</center>
														</div>
													</a>
												</div>
												<div class='col-md-8'>
													<a href=$g_url"."$game_link><font size='3'><b>$game_display - Game | Play and Earn</b></font></a><br><br>
													<font size='2'>Play and Earn &nbsp;&nbsp; | &nbsp;&nbsp; $currmatches games played.</font>
												</div>
											</td>
										</tr>
										";

										$search_results_count++;
										if($search_results_count >= $max_results)
										{
											break;
										}
									}
								}

								function get_post_views($con,$func_unique_id)
								{
									$query = "SELECT * FROM read_history WHERE unique_id='$func_unique_id' AND is_money_distributed='1'";
									$result = mysqli_query($con,$query);
									$numResults = mysqli_num_rows($result);
									$numResults = number_format($numResults);

									return($numResults);
								}

								$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' ORDER BY trend_value DESC");
								while($row = mysqli_fetch_assoc($getposts))
								{
									$post_title = $row['post_title'];
									$post_url = $row['post_url'];
									$post_img_url = $row['post_img_url'];
									$unique_id = $row['unique_id'];

									$blogger_unique_id = $row['blogger_unique_id'];
									$unique_id = $row['unique_id'];
									$post_views = get_post_views($con,$unique_id);

									$post_content = strip_tags($row["post_content"]);
									$post_content = str_replace('"',"'", $post_content);

									$post_content = substr($post_content,0,150);

									$query = "SELECT * from table2 where unique_name='$blogger_unique_id'";
									$result = mysqli_query($con,$query);
									$numResults = mysqli_num_rows($result);
									$get = mysqli_fetch_assoc($result);
									$fnamex = $get['fname'];
									$lnamex = $get['lname'];

									$search_blog_title = strtolower($user);
									$post_title1 = strtolower($post_title);

									$flag = 0;

									for($i=1;$i<=5;$i++)
									{
										$tag[$i] = mysqli_real_escape_string($con,$row["tag$i"]);
										if(strpos(strtolower($tag[$i]),$search_blog_title)!==false)
										{
											$flag = 1;
										}
									}

									if(strpos($post_title1,$search_blog_title)!==false || $flag==1)
									{
										echo "
										<tr>
											<td>
												<div class='col-md-4 hrwhite'>
													<a href=$g_url"."blogs/post.php?title="."$post_url&r="."$unique_id>
														<div class='thumbnail'>
															<center>
																<img src='$post_img_url' style='height:100%;width:100%;'>
															</center>
														</div>
													</a>
												</div>
												<div class='col-md-8'>
													<a href=$g_url"."blogs/post.php?title="."$post_url&r="."$unique_id><font size='3'><b>$post_title</b></font></a><br><br>
													<font size='2'>$fnamex $lnamex &nbsp;&nbsp; | &nbsp;&nbsp; $post_views views</font><br><br>
													<font size='2'>$post_content...</font>
												</div>
											</td>
										</tr>
										";

										$search_results_count++;
										if($search_results_count >= $max_results)
										{
											break;
										}
									}
								}

				            	$getposts = mysqli_query($con,"SELECT * FROM videos ORDER by ((view_count/dislike_count)*(like_count))/(datediff('$datetime',time_published)) DESC");
								while($row = mysqli_fetch_assoc($getposts))
								{
									$title = $row['title'];
									$author_name = $row['author_name'];
									$title1 = strtolower($title);
									$author_name1 = strtolower($author_name);
									$search_video_title = strtolower($user);

									$flag = 0;
									$tag_array = unserialize(base64_decode($row["tags"]));
									$tag_array_size = count($tag_array);

									for($i=0; $i<$tag_array_size;$i++)
									{
										if(strpos(strtolower($tag_array[$i]),$search_video_title)!==false)
										{
											$flag = 1;
											break;
										}
									}

									if(strpos($title1,$search_video_title)!==false || strpos($author_name1,$search_video_title)!==false || $flag == 1)
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

										$search_results_count++;
										if($search_results_count >= $max_results)
										{
											break;
										}
									}
								}

								$getposts = mysqli_query($con,"SELECT * FROM table2 ORDER by user_points DESC");
								while($row = mysqli_fetch_assoc($getposts))
								{
									$username = $row['email'];
									$firstname = $row['fname'];
									$lastname = $row['lname'];
						            $useridx = $row['Id'];
									$username1 = strtolower ($username);
									$firstname1 = strtolower ($firstname);
									$lastname1 = strtolower ($lastname);
						            $user = strtolower($user);
									$user_points = $row['user_points'];
									if (strpos($username1,$user)!==false || strpos($firstname1,$user)!==false || strpos($lastname1,$user)!==false ||
										strpos($firstname1." ".$lastname1,$user)!==false)
									{
										echo "<tr>
										<td><a href='profile.php?u=$useridx' target='_blank'>$firstname $lastname</a></td>
										</tr>
										";

										$search_results_count++;
										if($search_results_count >= $max_results)
										{
											break;
										}
									}
								}
							}
						}
						?>
						</tbody>
				</table>
			</div>
		</div>
<div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
	</div>
</body>

<?php include ("./inc/footer.inc.php"); ?>