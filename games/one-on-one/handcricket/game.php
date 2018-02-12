<?php include ("../../../inc/header.inc.php"); ?>

<style>
	.thumbnail {
    border-radius: 0;
    background-color: rgba(0,0,0,0.4);
	}
	.thumbnail:hover {
		-webkit-box-shadow: 0 0 2px #fff;
	        box-shadow: 0 0 2px #fff;
	}
	.btn.outline {
	background: none;
	color: #fff;
	}
	.btn.outline:hover {
		background: #fff;
		color: #000;
	}
	.ongoing
	{
	    background-color: rgba(255,165,0,0.4);
	}
	.won
	{
	    background-color: rgba(0,255,0,0.4);
	}
	.lost
	{
	    background-color: rgba(255,0,0,0.4)
	}
	.tied
	{
	    background-color: rgba(0,128,255,0.4)
	}
</style>

<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Handcricket | One-on-One - Zufalplay</title>
</head>

<?php 
	date_default_timezone_set('Asia/Kolkata');
	$datetime = date("Y-m-d H:i:sa");
	top_banner();
	//mysqli_query($con,"INSERT INTO handcricket_playhistory (user_played,final_score,game_week,isout) VALUES ('$email','0','$gameweek','0')"); 
	if(isset($_GET['u']))
	{
		$challenge_id = mysqli_real_escape_string($con,$_GET['u']);
	}
	$query = "SELECT * from handcricket_oneonone WHERE challenge_id='$challenge_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);
	$from_user_email = $get['from_user_email'];
	$to_user_email = $get['to_user_email'];
	$from_user_isout = $get['from_user_isout'];
	$to_user_isout = $get['to_user_isout'];
	$from_user_score = $get['from_user_score'];
	$to_user_score = $get['to_user_score'];
	$challenge_status = $get['challenge_status'];

	$query = "SELECT * from table2 where email='$from_user_email'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$from_user_idx = $get['Id'];
	$from_user_fnamex = $get['fname'];
	$from_user_lnamex = $get['lname'];

	$query = "SELECT * from table2 where email='$to_user_email'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$to_user_idx = $get['Id'];
	$to_user_fnamex = $get['fname'];
	$to_user_lnamex = $get['lname'];

	if($email!=$from_user_email && $email!=$to_user_email)
	{
		//header("Location: ".$g_url."games");
	}
	if($challenge_status==0 && (($from_user_email==$email && $from_user_isout==0) || ($to_user_email==$email && $to_user_isout==0))) 
	{
		if($from_user_email==$email)
		{
			$start_score = $from_user_score;
		}
		else if($to_user_email==$email)
		{
			$start_score = $to_user_score;
		}
		?>
		<head>
			<link rel="stylesheet" type="text/css" href="style.css">
		</head>

		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="gamecard">
					<center>
						<h3>Score: <strong style="font-size:32px"><span id="totalruns" ><?php echo $start_score;?></span>*</strong>(<span id="totalballs">0</span>)</h3>
					<div class="row">
						<div class="col-md-2"><br>
							<div class="btn-group btn-group-vertical" role="group" aria-label="...">
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="one" onclick="f(1,<?php echo $challenge_id; ?>)">1</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="two" onclick="f(2,<?php echo $challenge_id; ?>)">2</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="three" onclick="f(3,<?php echo $challenge_id; ?>)">3</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="four" onclick="f(4,<?php echo $challenge_id; ?>)">4</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="five" onclick="f(5,<?php echo $challenge_id; ?>)">5</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="six" onclick="f(6,<?php echo $challenge_id; ?>)">6</button>
							</div>
						</div>
						<div class="col-md-3">
							<h3><?php echo $fname;?></h3>
							<img id="hi" src="images/bat.jpg">
						</div>
						<div class="col-md-2">
							<img class="versus" src="images/vs.png">
						</div>
						<div class="col-md-3">
							<h3>Zufalplay</h3>
							<img id="by" src="images/cricketball.png">
						</div>
						<div class="col-md-2"><br>
							<div class="btn-group btn-group-vertical" role="group" aria-label="...">
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="one1" onclick="f(1,<?php echo $challenge_id; ?>)" disabled>1</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="two1" onclick="f(2,<?php echo $challenge_id; ?>)" disabled>2</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="three1" onclick="f(3,<?php echo $challenge_id; ?>)" disabled>3</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="four1" onclick="f(4,<?php echo $challenge_id; ?>)" disabled>4</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="five1" onclick="f(5,<?php echo $challenge_id; ?>)" disabled>5</button>
								<button class="btn outline btn-lg btn-flat btn-default" type="button" id="six1" onclick="f(6,<?php echo $challenge_id; ?>)" disabled>6</button>
							</div>
						</div>
					</div>
					<div class="runs btn-group btn-group-vertical" role="group" aria-label="...">
						
					</div>
					<p id="runs"></p>
					</center>
				</div>
			</div>

			<br>
			<br>
			<br>
			<br>
			
			<p id="totalruns"></p>
			<p id="runs"></p>
			<p id="go"></p>
			
			<form action="submitscore.php" method="POST" id="submitscore">
			</form>
			<form action="cheating.php" method="POST" id="cheating">
			</form>
			<script src="js/handcricket.js"></script>
			
		</body>
		<?php
	}
	else if($challenge_status==-1 && $from_user_email==$email)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail ongoing">
							<center>
								<br>
								<font size="3">One-on-One Challenge request sent to 
								<a href=<?php echo $g_url."profile.php?u=$to_user_idx target='_blank'" ?>><b>
								<?php echo $to_user_fnamex." ".$to_user_lnamex?></b>.</a></font><br><br>
								<font size="4"><b>Request Pending.</b></font>
								<br><br>
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>
		<?php
	}
	else if($challenge_status==-1 && $to_user_email==$email)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail">
							<center>
								<br>
								<font size="3">You have received a One-on-One Challenge request from
								<a href=<?php echo $g_url."profile.php?u=$from_user_idx target='_blank'" ?>><b>
								<?php echo $from_user_fnamex." ".$from_user_lnamex?></b>.</a></font><br><br><br>
								
								<form action="acceptrequest.php" type="POST">
									<input value="<?php echo $challenge_id; ?>" name="challengeida" hidden>
									<button type="submit" class='btn btn-sm btn-default outline'>
									<i class="fa fa-check"></i> Accept</button>
								</form>

								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

								<form action="rejectrequest.php" type="POST">
									<input value="<?php echo $challenge_id; ?>" name="challengeidr" hidden>
									<button type="submit" class='btn btn-sm btn-default outline'>
									<i class="fa fa-times"></i> Reject</button>
								</form>

								<br>
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>
		<?php
	}
	else if($challenge_status==-2 && $from_user_email==$email)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail lost">
							<center>
								<br>
								<font size="3">Your One-on-One Challenge request to
								<a href=<?php echo $g_url."profile.php?u=$to_user_idx target='_blank'" ?>><b>
								<?php echo $to_user_fnamex." ".$to_user_lnamex?></b></a> was rejected.</font><br><br>
								<font size="4"><b>Request Rejected.</b></font>
								<br><br>
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>
		<?php
	}
	else if($challenge_status==-2 && $to_user_email==$email)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail">
							<center>
								<br>
								<font size="3">One-on-One Challenge request by
								<a href=<?php echo $g_url."profile.php?u=$from_user_idx target='_blank'" ?>><b>
								<?php echo $from_user_fnamex." ".$from_user_lnamex?></b></a> has been successfully rejected.</font><br><br>
								<font size="4"><b>Request Rejected.</b></font>
								<br><br>
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>
		<?php
	}
	else if($challenge_status==1 && $from_user_email==$email && $from_user_score>$to_user_score)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail won">
							<center>
			
								<font size="3"><font size="4">Congratulations! You won.</font><br><br>

								<a href=<?php echo $g_url."profile.php?u=$from_user_idx target='_blank'" ?>><b>
								<?php echo $from_user_fnamex." ".$from_user_lnamex?></b></a>

								vs.

								<a href=<?php echo $g_url."profile.php?u=$to_user_idx target='_blank'" ?>><b>
								<?php echo $to_user_fnamex." ".$to_user_lnamex?></b></a></font><br><br>
								<font size="4"><b><?php echo $from_user_score."-".$to_user_score ?></b></font>
								<hr>
								<b class="number">+2 </b>Zufals to your account.
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>
		<?php
	}
	else if($challenge_status==1 && $from_user_email==$email && $from_user_score<$to_user_score)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail lost">
							<center>
								
								<font size="3"><font size="4">You Lost.</font><br><br>

								<a href=<?php echo $g_url."profile.php?u=$from_user_idx target='_blank'" ?>><b>
								<?php echo $from_user_fnamex." ".$from_user_lnamex?></b></a>

								vs.

								<a href=<?php echo $g_url."profile.php?u=$to_user_idx target='_blank'" ?>><b>
								<?php echo $to_user_fnamex." ".$to_user_lnamex?></b></a></font><br><br>
								<font size="4"><b><?php echo $from_user_score."-".$to_user_score ?></b></font>
								<hr>
								<b class="number">-2 </b>Zufals from your account.
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>
		<?php
	}
	else if($challenge_status==1 && $to_user_email==$email && $from_user_score<$to_user_score)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail won">
							<center>
								
								<font size="3"><font size="4">Congratulations! You won.</font><br><br>

								<a href=<?php echo $g_url."profile.php?u=$to_user_idx target='_blank'" ?>><b>
								<?php echo $to_user_fnamex." ".$to_user_lnamex?></b></a>

								vs.

								<a href=<?php echo $g_url."profile.php?u=$from_user_idx target='_blank'" ?>><b>
								<?php echo $from_user_fnamex." ".$from_user_lnamex?></b></a></font><br><br>
								<font size="4"><b><?php echo $to_user_score."-".$from_user_score ?></b></font>
								<hr>
								<b class="number">+2 </b>Zufals to your account.
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>
		<?php
	}
	else if($challenge_status==1 && $to_user_email==$email && $from_user_score>$to_user_score)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail lost">
							<center>
							
								<font size="3"><font size="4">You Lost.</font><br><br>

								<a href=<?php echo $g_url."profile.php?u=$to_user_idx target='_blank'" ?>><b>
								<?php echo $to_user_fnamex." ".$to_user_lnamex?></b></a>

								vs.

								<a href=<?php echo $g_url."profile.php?u=$from_user_idx target='_blank'" ?>><b>
								<?php echo $from_user_fnamex." ".$from_user_lnamex?></b></a></font><br><br>
								<font size="4"><b><?php echo $to_user_score."-".$from_user_score ?></b></font>
								<hr>
								<b class="number">-2 </b>Zufals from your account.
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>
		<?php
	}
	else if($challenge_status==1 && $from_user_score==$to_user_score)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail tied">
							<center>
								
								<font size="3"><font size="4">Tied.</font><br><br>

								<a href=<?php echo $g_url."profile.php?u=$to_user_idx target='_blank'" ?>><b>
								<?php echo $to_user_fnamex." ".$to_user_lnamex?></b></a>

								vs.

								<a href=<?php echo $g_url."profile.php?u=$from_user_idx target='_blank'" ?>><b>
								<?php echo $from_user_fnamex." ".$from_user_lnamex?></b></a></font><br><br>
								<font size="4"><b><?php echo $to_user_score."-".$from_user_score ?></b></font>
								<hr>
								<b class="number">0 </b>Zufals to your account.
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>j
		<?php
	}
	else if($challenge_status==0)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hand Cricket</h2><hr>
				<div class="col-md-2"></div>
				<div class="hrwhite">
					<div class="col-md-8">
						<div class="thumbnail ongoing">
							<center>
								<br>
								<font size="3"><font size="4">Opponent yet to play.</font><br><br>

								<a href=<?php echo $g_url."profile.php?u=$to_user_idx target='_blank'" ?>><b>
								<?php echo $to_user_fnamex." ".$to_user_lnamex?></b></a>

								vs.

								<a href=<?php echo $g_url."profile.php?u=$from_user_idx target='_blank'" ?>><b>
								<?php echo $from_user_fnamex." ".$from_user_lnamex?></b></a></font><br><br>
								<font size="4"><b><?php echo $to_user_score."-".$from_user_score ?></b></font>
								<br><br>
							</center>
						</div>
						<center>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-7888738492112143"
							     data-ad-slot="1322728114"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</center>
					</div>
				</div>
			</div>
		</body>
		<?php
	}
?>
<?php include ("../../../inc/footer.inc.php"); ?>		