<?php include ("../../../inc/header.inc.php"); ?>
<?php
top_banner();
?>
<style>
.pushup {
  margin-top:-8px;
}
</style>
<?php
$g_g_url = $g_url."contests/short/swap/";
global $g_g_url;
?>

<div class="pushup">
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10; border-color: #000; border-width: 1px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
  <div class="">
    <div class="col-md-1"></div>
    <div class="">
      <ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_g_url; ?>">Short Contest 2</a></li>
        <li><a href="<?php echo $g_url.'contests/short/leaderboard.php?id=2'; ?>" target='_blank'>Contest Leaderboard</a></li>
      </ul>
    </div>
  </div>
</footer> 
</div>
<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Short Contest 2 - Zufalplay</title>
</head>