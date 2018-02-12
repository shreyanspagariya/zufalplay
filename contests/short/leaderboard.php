<?php include ("../../inc/extuser.inc.php"); 
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
if(isset($_GET['id']))
{
	$contest_id = mysqli_real_escape_string($con,$_GET['id']);
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
        	<li class=""><a>Short Contest <?php echo $contest_id;?></a></li>
        	<li><a href="<?php echo $g_url.'contests/short/leaderboard.php?id=2'; ?>">Contest Leaderboard</a></li>
      	</ul>
  	</div>
  </div>
</footer> 
</div>

<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Short Contest <?php echo $contest_id;?> | Leaderboard - Zufalplay</title>
</head>

<body class="zfp-inner">
	<div class="">
        <br><br>
		<div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
		<div class="col-md-8">
		<div class="hrwhite">
			<center><h3>Leaderboard - Short Contest <?php echo $contest_id;?></h3><hr></center>
			<div class="table-responsive elevatewhite">
			  <table class="table table-bordered table-condensed">
				<thead>
				<tr>
				  <th><center>#</center></th>
				  <th>&nbsp;User</th>
				  <th><center>Levels Cleared</center></th>
				  <th><center>Earnings</center></th>
				</tr>
			  </thead>
			  <tbody>
				<?php
				$getposts = mysqli_query($con,"SELECT * FROM short_contest_leaderboard WHERE contest_id='$contest_id' ORDER BY levels_cleared DESC, time_completed ASC");
				$x=1;
				while($row = mysqli_fetch_assoc($getposts))
				{
					$user = $row['user'];

					$query = "SELECT * from table2 where email='$user'";
					$result = mysqli_query($con,$query);
					$get = mysqli_fetch_assoc($result);
					$idx = $get['Id'];
					$fnamex = $get['fname'];
					$lnamex = $get['lname'];

					$levels_cleared = $row['levels_cleared'];
					$rupees_earned = $row['rupees_earned'];

					echo "<tr>
					<td><center>$x</center></td>
					<td>&nbsp;<a href=".$g_url."profile.php?u=$idx target='_blank'>$fnamex $lnamex</td>
					<td><center>$levels_cleared</center></td>
					<td><center>Rs. $rupees_earned</center></td>
					</tr>
					";
					$x++;
				}
				?>
				</tbody>
			</table>
			</div>
		</div>
		</div>
<div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
	</div>
</body>

<?php include ("../../inc/footer.inc.php"); ?>