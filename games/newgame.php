<?php include ("../inc/extuser.inc.php"); ?>
<?php 
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
	if(isset($_GET['game']))
	{
		$game = mysqli_real_escape_string($con,$_GET['game']);
		$game_display = ucfirst($game);
		$query = "SELECT * FROM games WHERE game_name = '$game'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$game_link = $get["game_link"];
	}
	if(isset($_GET['score']))
	{
		$score = mysqli_real_escape_string($con,$_GET['score']);
	}
?>
<body class="zfp-inner">
<br>
<div class="hrwhite">
<div class="container">
	<h2 align="center"><?php echo $game_display; ?></h2><hr>
	<div class="row">
		<div class="col-md-4">
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
		<div class="col-md-4">
			<h3 align="center">Last Score: <b><?php echo $score?></b></h3><br>
			<div align="center"><a href="<?php echo $g_url.$game_link; ?>"><h4>Click to Start a New Game</h4></a><br></div>
			<div align="center"><a href="<?php echo $g_url.'games/leaderboard.php?game='.$game; ?>">View Leaderboard</a></div>
		</div>
		<div class="col-md-4">
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
	<hr>
        <center><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> 
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="8311271319"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></center>
</div>
</body>
<?php include ("../inc/footer.inc.php"); ?>
	