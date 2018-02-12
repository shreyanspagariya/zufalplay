<?php include ("./inc/header.inc.php"); ?>
<?php 
	top_banner();
?>
<body class="zfp-inner">
<div class="hrwhite">
<div class="container"><br>
	<h2 align="center">2048</h2><hr> 
	<h3 align="center">Your Score has been recorded.</h3><br>
	<div align="center"><a href="<?php echo $g_g_url; ?>"><h4>Click to Start New Game</h4></a><br></div>
	<div align="center"><a href="<?php echo $g_url; ?>games/leaderboard.php?game=2048">View Leaderboard</a></div><hr>
</div>
</body>
<?php include ("../../inc/footer.inc.php"); ?>
