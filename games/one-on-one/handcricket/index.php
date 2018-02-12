<?php include ("../../../inc/header.inc.php"); ?>
<?php
	top_banner();
?>
<style>
	.btn.outline {
	background: none;
	color: #fff;
	}
	.btn.outline:hover {
		background: #fff;
		color: #000;
	}
	.thumbnail {
    border-radius: 0;
    background-color: rgba(0,0,0,0.4);
	}
	.thumbnail:hover {
		-webkit-box-shadow: 0 0 2px #fff;
	        box-shadow: 0 0 2px #fff;
	}
</style>
<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Handcricket | One-on-One - Zufalplay</title>
</head>
<body class="zfp-inner">
	<div class="hrwhite">
	<div class="container">
		 <br>
			<h2 align="center">Hand Cricket</h2><hr>
			<div class="col-md-3"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
			<div class="col-md-6">
				<div class="thumbnail" style="padding:15px;">
				<center><b class="number">+2</b> Zufals if you <b>Win</b>.<br> <b class="number">-2</b> Zufals if you <b>Lose</b>. <br>
				<b class="number">0</b> Zufals if it is a <b>Tie</b>.</center>
				</div>
				<div class="table-responsive">
				  <table class="table table-bordered table-condensed">
					<thead>
						<tr>
						  <th>#</th>
						  <th>User</th>
						  <th><center>Send Challenge Request</center></th>
						</tr>
				  	</thead>
				  	<tbody>
				  	<?php

				  		$query = "SELECT * from handcricket_oneonone WHERE 
						(from_user_email='$email' OR to_user_email='$email') AND (challenge_status='-1' OR challenge_status='0')";
						
						$result = mysqli_query($con,$query);
						$numResults = mysqli_num_rows($result);
						$get = mysqli_fetch_assoc($result);
						

						$subtract = 2*$numResults;

						if($user_points-$subtract>=2)
						{

					  		$getposts = mysqli_query($con,"SELECT * FROM table2 WHERE user_points>='2' ORDER BY login_count DESC");
					  		$x=1;
							while($row = mysqli_fetch_assoc($getposts))
							{
								$emailx = $row['email'];
								$fnamex = $row['fname'];
								$lnamex = $row['lname'];
								$idx = $row['Id'];

								$query = "SELECT * from handcricket_oneonone WHERE 
								(from_user_email='$emailx' OR to_user_email='$emailx') AND (challenge_status='-1' OR challenge_status='0')";
								
								$result = mysqli_query($con,$query);
								$numResults = mysqli_num_rows($result);
								
								$user_pointsx = $row['user_points'];
								
								$subtract = 2*$numResults;

								if($emailx!=$email && $user_pointsx-$subtract>=2)
								{
									echo "<tr>
									<td>$x</td>
									<td><a href=".$g_url."profile.php?u=$idx target='_blank'>$fnamex $lnamex</td>
									<td><center>
									<form id='$x' action='sendrequest.php' method='POST'>
										<input id='$x' value='$idx' name='userid' hidden>
										<button type='submit' class='btn btn-sm btn-default outline' style='background-color: rgba(0,0,0,0.4);'>
										Send Challenge Request</button></center></td>
									</form>
									</tr>
									";
									$x++;
								}
							}
						}
						else
						{
							echo "<tr>
									<center><b>Sorry, you do not enough Zufals to challenge anyone.</b></center><br> 
								  </tr>";
						}
				  	?>
				  	</tbody>
				  </table>
				</div>
			</div>
			<div class="col-md-3"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
		</div>
	</div>
<?php include ("../../../inc/footer.inc.php"); ?>