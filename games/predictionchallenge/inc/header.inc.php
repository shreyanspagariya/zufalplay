<?php include ("../../inc/extuser.inc.php"); ?>
<?php include("connect.inc.php"); ?>
<style>
.pushup {
	margin-top:-8px;
}
</style>

<?php
global $g_g_url;
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
  <div class="container">
  	<div class="col-md-8">
    	<ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_g_url; ?>">Open Challenges</a></li>
        <li class=""><a href="<?php echo $g_g_url.'past-challenges.php'; ?>">Past Challenges</a></li>
        <li><a href="<?php echo $g_g_url.'suggest.php'; ?>">Suggest a Challenge</a></li>
		<?php if($email=="shreyanspagariya@gmail.com")
		{
			echo "<li><a href=$g_g_url"."add.php>Add Challenge</a></li>
			";
		}?>
		<!--<li><a href="<?php echo $g_g_url.'rules.php'; ?>">Rules</a></li>-->
    <li>
    <div style="margin-top:4px;">
      &nbsp;&nbsp;&nbsp;
      <div class="fb-share-button" 
        data-href="https://www.facebook.com/zufalplay/posts/528352433994837" 
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
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Prediction Challenge - Zufalplay</title>
</head>
<?php
  $total = 0;
  $getposts = mysqli_query($con,"SELECT * FROM bets");
  while($row = mysqli_fetch_assoc($getposts))
  {
    $id = $row['betid'];
    $betdes = $row['betdes'];
    //$date_added = $row['time_added'];
    //$added_by = $row['added_by'];
    $option1 = $row['option1'];
    $option2 = $row['option2'];
    $option1_users = $row['option1_users'];
    $option2_users = $row['option2_users'];
    $option1_points = $row['option1_points'];
    $option2_points = $row['option2_points'];
    $bet_result_status = $row['bet_result_status'];
    if($bet_result_status==0)
    {
      $sum = 0;
      $getposts2 = mysqli_query($con,"SELECT * FROM placedbets WHERE userid_placedby='$email'");
      while($row2 = mysqli_fetch_assoc($getposts2))
      {
        $bet_id = $row2['bet_id'];
        if($id == $bet_id)
        {
          $sum = $sum + 1;
        }
      }
      if($sum==0)
      {
        $total = $total + 1;
      }
    }
  }
?>