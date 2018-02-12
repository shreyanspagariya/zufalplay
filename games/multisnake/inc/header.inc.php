<?php include ("../../inc/extuser.inc.php"); ?>
<?php include("connect.inc.php");
?>
<style>
.pushup {
	margin-top:52px;
}
</style>
<?php
$query = "SELECT * from games where game_id='18'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
?>

<div class="pushup">
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10; border-color: #000; border-width: 1px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
  <div class="">
  	<div class="col-md-1"></div>
  	<div class="">
    	<ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_g_url; ?>">Play Mulitsnake</a></li>
        <li><a href="<?php echo $g_url.'games/leaderboard.php?game=multisnake'; ?>">Leaderboard</a></li>
      </ul>
  	</div>
  </div>
</footer> 
</div>
<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Multisnake | Individual - Zufalplay</title>
</head>