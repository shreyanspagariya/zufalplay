<?php include ("../../inc/extuser.inc.php"); ?>
<?php include("connect.inc.php");
?>
<style>
.pushup {
  margin-top:-8px;
}
</style>
<?php
$query = "SELECT * from games where game_id='8'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$gameweek = 0;
$fb_share_link = $get['fb_share_link'];
global $g_g_url;
global $gameweek;
?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1489957891297107";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="pushup">
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10; border-color: #000; border-width: 1px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
  <div class="">
    <div class="col-md-1"></div>
    <div class="">
      <ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_g_url; ?>">Play Mario</a></li>
        <li><a href="<?php echo $g_url.'games/leaderboard.php?game=mario'?>">Leaderboard</a></li>
        <li>
        <div style="margin-top:4px;">
          &nbsp;&nbsp;&nbsp;
          <div class="fb-share-button" 
            data-href="<?php echo $fb_share_link;?>" 
            data-layout="button">
          </div>
        </div>
        </li>
      </ul>
    </div>
  </div>
</footer> 
</div>
<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Mario | Individual - Zufalplay</title>
</head>