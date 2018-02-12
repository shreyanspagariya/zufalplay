<?php include ("./inc/header.inc.php"); ?>
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
<body class="zfp-inner">
<br>
<div class="hrwhite">
<div class="container">
	<h2 align="center">Hand Cricket</h2><hr>
	<?php 
		if(isset($_SESSION["email1"]))
		{?>
			<h3 align="center">Congratulations!! You scored a personal best of <b>
			<?php
				$getposts = mysqli_query($con,"SELECT * FROM game_leaderboard WHERE game_week='0' AND user='$email' AND game_id='2'");
				$high_score=-1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$high_score = $row['high_score'];
				}	
				echo $high_score;
			?> runs.</b></h3><br>
			<?php
		}?>
	<div align="center"><a href="<?php echo $g_g_url; ?>"><h4>Click to Start New Game</h4></a><br></div>
	<div align="center"><a href="<?php echo $g_url.'games/leaderboard.php?game=handcricket'; ?>">View Leaderboard</a></div><hr>
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
<?php include ("../../inc/footer.inc.php"); ?>
