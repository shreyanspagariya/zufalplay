<?php
include ("../inc/extuser.inc.php"); 
 
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
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Donate - Help the Poor @Zufalplay</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("../inc/sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8">
		<center><h2>Donate</h2>Your chance to help the poor and needy.<hr>
		<b>Do you know someone who is need of monetory help? <br>Email us right away at <a href="https://mail.google.com/mail/?view=cm&fs=1&to=donations@zufalplay.com" target="_blank">donations@zufalplay.com</a> to raise funds.</b>
		</center><hr>
		<div class="table-responsive elevatewhite hrwhite">
			<table class="table table-bordered">
				<thead>
			        <tr>
			          <th>Details</th>
			        </tr>
			    </thead>
			    <tbody>
			    <?php
			    	$getposts = mysqli_query($con,"SELECT * FROM donate_posts WHERE is_complete='0' ORDER by time_deadline ASC");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$unique_id = $row["unique_id"];
						$post_url = $row["post_url"];
						$post_title = $row["post_title"];
						$post_img_url = $row["post_img_url"];
						$post_content = $row["post_content"];
						$collection = $row["collection"];

						$post_content = strip_tags($post_content);
						$post_content = str_replace('"',"'", $post_content);

						$short_post_content = substr($post_content,0,350);

						echo "
						<tr>
							<td>
								<div class='col-md-4 hrwhite'>
									<a href=$g_url"."donate/details.php?title="."$post_url&d="."$unique_id target='_blank'>
										<div class='thumbnail'>
											<center>
												<img src='$post_img_url' style='height:100%;width:100%;'>
											</center>
										</div>
									</a>
								</div>
								<div class='col-md-8'>
									<div class='row'>
										<a href=$g_url"."donate/details.php?title="."$post_url&d="."$unique_id target='_blank'><font size='4'><b>$post_title</b></font></a><br><br>
										$short_post_content... <a href=$g_url"."donate/details.php?title="."$post_url&d="."$unique_id target='_blank'><b>View >></b></a>
									</div>
									<hr>
									<div class='row'>
										<div class='col-md-6'>
											<center>
												Funds Raised: &nbsp;<font size='4'>Rs.</font> <font size='4'><b>$collection</b></font>
											</center>
										</div>
										<div class='col-md-6'>
											<center>
												<a style='color:white;' href=$g_url"."donate/details.php?title="."$post_url&d="."$unique_id target='_blank' type='button' class='login-btn btn btn-primary btn-flat'>Donate</a>
											</center>
										</div>
									</div>
								</div>
							</td>
						</tr>
						";
					}
			    ?>
			    </tbody>
			</table>
		</div>
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
<?php include ("../inc/footer.inc.php"); ?>						
