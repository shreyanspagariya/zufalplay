<?php include ("../inc/extuser.inc.php"); ?>
<?php
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
	<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Leaderboard - Zufalplay</title>
</head>
<body class="zfp-inner">
		<div class='col-md-2'>
			<?php include ("../inc/sidebar.inc.php"); ?>
		</div>
		<div class="col-md-8">
			<center><h2>Overall Leaderboard</h2><hr></center>
			<div class="table-responsive elevatewhite hrwhite">
				<table class="table table-bordered">
					<thead>
				        <tr>
						  <th>#</th>
				          <th>Name</th>
						  <th>Amount</th>
				        </tr>
				    </thead>
				    <tbody>
						<?php 
						        $slno = 1;
								$getposts = mysqli_query($con,"SELECT * FROM table2 ORDER by user_points DESC LIMIT 100");
								while($row = mysqli_fetch_assoc($getposts))
								{
									$username = $row['email'];
									$firstname = $row['fname'];
									$lastname = $row['lname'];
						            $useridx = $row['Id'];
						            $unique_namex = $row['unique_name'];
									$user_points = $row['user_points'];
									$user_points_r = number_format(floor($user_points*100)/100,2,'.','');

									if($username==$email)
									{
										$scroll_slno=$slno;

										echo "<tr>
										<td><div id='$slno'><b>$slno</b></div></td>
										<td><b><a href=".$g_url."profile.php?id=$unique_namex target='_blank'>$firstname $lastname</a></b></td>
										<td><b>Rs. $user_points_r</b></td>
										</tr>
										";
									}
									else
									{
										echo "<tr>
										<td><div id='$slno'>$slno</div></td>
										<td><a href=".$g_url."profile.php?id=$unique_namex target='_blank'>$firstname $lastname</a></td>
										<td>Rs. $user_points_r</td>
										</tr>
										";
									}
									
									$slno++;
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

<script>
	function Scrolldown() 
	{
    	window.location.hash = '#<?php echo $scroll_slno-5;?>';
	}
	window.onload = Scrolldown();
</script>

<?php include ("../inc/footer.inc.php"); ?>