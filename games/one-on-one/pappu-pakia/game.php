<?php include ("../../../inc/header.inc.php"); ?>
<style>
.pushup {
	margin-top:-8px;
}
</style>

<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Pappupakia | One-on-One - Zufalplay</title>
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
        <li><a href="<?php echo $g_url.'games/one-on-one/pappu-pakia'; ?>">Play Pappu Pakia (One-on-One)</a></li>
        <li>
        <div style="margin-top:4px;">
          &nbsp;&nbsp;&nbsp;
          <div class="fb-share-button" 
            data-href="https://www.facebook.com/zufalplay/photos/a.495776280585786.1073741827.495739933922754/524430014387079/?type=3&theater" 
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
	$query = "SELECT * from pappupakia_oneonone WHERE challenge_id='$challenge_id'";
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
		  <link rel="stylesheet" href="css/main.css">
  <style>
    .pushright 
    {
      margin-left: 180px;
      margin-top: 72px;
    }
    .pushleft 
    {
      margin-right: 180px;
      margin-top: 80px;
    }
    .pushleft1
    {
      margin-right: 180px;
      margin-top: 110px;
    }
    .pushdown
    {
      margin-top:80px;
    }
    .gamecard
    {
      background-color: rgba(0,0,0,0.4);
      padding: 0px 10px 0px 10px;
    }
    .gamecard:hover {
      -webkit-box-shadow: 0 0 2px #fff;
            box-shadow: 0 0 2px #fff;
    }
  </style>
<body class="zfp-inner">
    <div class="pushright">
    <!-- Start Screen -->
    <div id="start_screen" class="pushright">
      <br><br>
      <h1 id="title">pappu pakia</h1>
      <h3 id="last_score"></h3>
      <h3 id="high_score"></h3>
      <div class="controls pushdown"></div>

      <div class="options">
        <ul>
          <li><a href="javascript:void(0);" id="start_game">start</a></li>
          <li><a href="javascript:void(0);" target="_blank" id="tweet">tweet</a></li>
          <li><a href="https://www.facebook.com/zufalplay" target="_blank" id="fb">fb like</a></li>
        </ul>
      </div>
    </div>
    <!-- /Start Screen -->
  
    <!-- Loading sounds -->
    <audio id="start" loop>
      <source src="sound/pappu-pakia2.3.ogg"  type="audio/ogg">
      <source src="sound/pappu-pakia2.3.mp3"  type="audio/mp3">
    </audio>
    
    <audio id="angry_jump">
      <source src="sound/jump1.ogg" type="audio/ogg">
      <source src="sound/jump1.mp3" type="audio/mp3">
    </audio>
    
    <audio id="sad_jump">
      <source src="sound/jump2.ogg" type="audio/ogg">
      <source src="sound/jump2.mp3" type="audio/mp3">
    </audio>
    
    <audio id="happy_jump">
      <source src="sound/jump3.ogg" type="audio/ogg">
      <source src="sound/jump3.mp3" type="audio/mp3">
    </audio>
    
    <audio id="flap">
      <source src="sound/flap.ogg" type="audio/ogg">
      <source src="sound/flap.mp3" type="audio/mp3">
    </audio>
    
    <audio id="ting">
      <source src="sound/ting.ogg" type="audio/ogg">
      <source src="sound/ting.mp3" type="audio/mp3">
    </audio>

    <canvas id="game_bg"></canvas>
    <canvas id="game_main"></canvas>

    <div id="score_board" class="pushright">0</div>

    <div id="invincible_timer">
      <div id="invincible_loader"></div>
    </div>

    <a href="javascript:void(0)" id="mute" class="pushleft1"></a>
    
    <!-- Loading Screen -->
    <div id="loading">
      <p id="loadText">Loading...</p>
      <div id="barCont">
        <div id="bar"></div>
      </div>
    </div>

  

  <div id="fps_count" class="pushleft"></div>

  <script src="js/jquery-1.8.2.min.js"></script>
  <script>window.mit = window.mit || {};</script>
  <script src="js/utils.js"></script>
  <script src="js/backgrounds.js"></script>
  <script src="js/forks.js"></script>
  <script src="js/branches.js"></script>
  <script src="js/collectibles.js"></script>
  <script src="js/pappu.js"></script>
  <script src="js/pakia.js"></script>
  <script src="js/main.js"></script>
  <script src="js/loader.js"></script>
</div>
		<input id="challenge_id" value="<?php echo $challenge_id; ?>" hidden>
		<?php
	}
	else if($challenge_status==-1 && $from_user_email==$email)
	{
		?>
		<body class="zfp-inner">
			<div class="container">
			    <br>
				<h2 align="center">Pappu Pakia</h2><hr>
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
				<h2 align="center">Pappu Pakia</h2><hr>
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
				<h2 align="center">Pappu Pakia</h2><hr>
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
				<h2 align="center">Pappu Pakia</h2><hr>
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
				<h2 align="center">Pappu Pakia</h2><hr>
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
				<h2 align="center">Pappu Pakia</h2><hr>
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
				<h2 align="center">Pappu Pakia</h2><hr>
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
				<h2 align="center">Pappu Pakia</h2><hr>
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
				<h2 align="center">Pappu Pakia</h2><hr>
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
				<h2 align="center">Pappu Pakia</h2><hr>
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