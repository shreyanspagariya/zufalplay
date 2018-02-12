<?php include ("../../../inc/header.inc.php"); ?>
<style>
.pushup {
	margin-top:-8px;
}
</style>

<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Hextris | One-on-One - Zufalplay</title>
</head>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1489957891297107";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="pushup">
<footer class="footer navbar-fixed" style="background-color:rgba(0,0,0,0.7);width: 100%;position: fixed;z-index: 10">
  <div class="">
  	<div class="col-md-1"></div>
  	<div class="">
    	<ul class="nav navbar-nav">
        <li><a href="<?php echo $g_url.'games/one-on-one/hextris'; ?>">Play Hextris (One-on-One)</a></li>
        <li>
        <div style="margin-top:4px;">
          &nbsp;&nbsp;&nbsp;
          <div class="fb-share-button" 
            data-href="https://www.facebook.com/zufalplay/photos/a.495776280585786.1073741827.495739933922754/524428427720571/?type=3&theater" 
            data-layout="button">
          </div>
        </div>
        </li>
      </ul>
  	</div>
  </div>
</footer> 
</div>
<?php
	top_banner();
?>

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

<?php 
	date_default_timezone_set('Asia/Kolkata');
	$datetime = date("Y-m-d H:i:sa");
	top_banner();
	//mysqli_query($con,"INSERT INTO handcricket_playhistory (user_played,final_score,game_week,isout) VALUES ('$email','0','$gameweek','0')"); 
	if(isset($_GET['u']))
	{
		$challenge_id = mysqli_real_escape_string($con,$_GET['u']);
	}
	$query = "SELECT * from hextris_oneonone WHERE challenge_id='$challenge_id'";
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
		?>
		<link rel="icon" type="image/png" href="favicon.ico">
		<link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="style/fa/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<script type='text/javascript' src="vendor/hammer.min.js"></script>
		<script type='text/javascript' src="vendor/js.cookie.js"></script>
		<script type='text/javascript' src="vendor/jsonfn.min.js"></script>
		<script type='text/javascript' src="vendor/keypress.min.js"></script>
		<script type='text/javascript' src="vendor/jquery.js"></script>
		<script type='text/javascript' src="js/save-state.js"></script>
		<script type='text/javascript' src="js/view.js"></script>
		<script type='text/javascript' src="js/wavegen.js"></script>
		<script type='text/javascript' src="js/math.js"></script>
		<script type='text/javascript' src="js/Block.js"></script>
		<script type='text/javascript' src="js/Hex.js"></script>
		<script type='text/javascript' src="js/Text.js"></script>
		<script type='text/javascript' src="js/comboTimer.js"></script>
		<script type='text/javascript' src="js/checking.js"></script>
		<script type='text/javascript' src='js/update.js'></script>
		<script type='text/javascript' src='js/render.js'></script>
		<script type='text/javascript' src="js/input.js"></script>
		<script type='text/javascript' src="js/main.js"></script>
		<script type='text/javascript' src="js/initialization.js"></script>
		<script type='text/javascript' charset='utf-8' src='cordova.js'></script>
		<script src="vendor/sweet-alert.min.js"></script>
		<link rel="stylesheet" href="style/rrssb.css"/>
		<style type="text/css">
			.zfp-inner-hextris
			{
			    background-attachment: fixed !important;
			    background-repeat: no-repeat;
			    background: url('../../../../images/cover3_mc.jpg');
			    font-family: Quicksand;
			    color: #ffffff;
			    background-color: #464646;
			    padding-top: 60px;
			}
		</style>
	<body class="zfp-inner-hextris">
		<canvas id="canvas"></canvas>
		<div id="overlay" class="faded overlay"></div>
		<div id='startBtn' ></div>
		<!--<img id="openSideBar" class='helpText' src="./images/btn_help.svg"/>-->
		<div class="faded overlay"></div>
		<img id="pauseBtn" src="./images/btn_pause.svg"/>
		<img id='restartBtn' src="./images/btn_restart.svg"/>
		<div id='HIGHSCORE'>HIGH SCORE</div>
		<div id='highScoreInGameText'>
		</div>
		<div id="gameoverscreen">
			<div id='container'>
				<div id='gameOverBox' class='GOTitle'>GAME OVER</div>
				<div id='cScore'>1843</div>
			</div>
			<div id='bottomContainer'>
				<img id='restart' src='./images/btn_restart.svg' height='57px'>
				<div id='buttonCont'>
					<ul class="rrssb-buttons">	
					</ul>
				</div>
			</div>
		</div>
		<script type="text/javascript" src='vendor/rrssb.min.js'></script>
		<input id="challenge_id" value="<?php echo $challenge_id; ?>" hidden>
		<?php
	}
	else if($challenge_status==-1 && $from_user_email==$email)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Hextris</h2><hr>
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
				<h2 align="center">Hextris</h2><hr>
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
				<h2 align="center">Hextris</h2><hr>
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
				<h2 align="center">Hextris</h2><hr>
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
				<h2 align="center">Hextris</h2><hr>
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
								<b class="number">+1 </b>Zufal to your account.
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
				<h2 align="center">Hextris</h2><hr>
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
								<b class="number">-1 </b>Zufal from your account.
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
				<h2 align="center">Hextris</h2><hr>
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
								<b class="number">+1 </b>Zufal to your account.
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
				<h2 align="center">Hextris</h2><hr>
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
								<b class="number">-1 </b>Zufal from your account.
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
				<h2 align="center">Hextris</h2><hr>
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
				<h2 align="center">Hextris</h2><hr>
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