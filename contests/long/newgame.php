<?php include ("../../inc/extuser.inc.php"); ?>
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
<style>
.pushup {
	margin-top:-8px;
}
</style>
<div class="pushup">
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10; border-color: #000; border-width: 1px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
  <div class="container">
  	<div class="col-md-8">
    	<ul class="nav navbar-nav">
    	<li class=""><a href="<?php echo $g_url.'contests/long/gaming-woche-2'; ?>">Contest Arena</a></li>
        <li class=""><a href="<?php echo $g_url.'contests/long/leaderboard.php?u=2'; ?>">Overall Leaderboard</a></li>
        <!--<li>
          <div style="margin-top:4px;">
            &nbsp;&nbsp;&nbsp;
            <div class="fb-share-button" 
              data-href="<?php echo $fb_share_link;?>" 
              data-layout="button">
            </div>
          </div>
        </li>-->
      </ul>
  	</div>
  </div>
</footer> 
</div>
<body class="zfp-inner">
<br>
<div class="hrwhite">
<div class="container">
	<br><h2 align="center"><?php echo $game_display; ?></h2><hr>
	<h3 align="center">Last Score: <b><?php echo $score?></b></h3><br>
	<div align="center"><a href="<?php echo $g_url.$game_link; ?>"><h4>Click to Start a New Game</h4></a><br></div>
	<div align="center"><a href="<?php echo $g_url.'contests/long/localleaderboard.php?game='.$game; ?>">View Local Leaderboard</a></div><hr>
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
	