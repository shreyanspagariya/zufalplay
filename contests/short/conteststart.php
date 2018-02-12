<?php
include ("../../inc/extuser.inc.php"); 
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}

$query = "SELECT * from short_contest_manager";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$contest_begin_time = strtotime($get['contest_begin_time']);
$contest_status = $get['contest_status'];

date_default_timezone_set("Asia/Kolkata");
$curr_time = time();

$time_left = $contest_begin_time - $curr_time;

$contest_id = 2;

$query = "SELECT * FROM short_contest_leaderboard WHERE contest_id='$contest_id'";
$result = mysqli_query($con,$query);
$numRegistered_users = mysqli_num_rows($result);

?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Short Contest 2 - Zufalplay</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("../../inc/sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8">
		<center>
			<br><br>
			<div class='elevatewhite' style='padding: 10px;'>
				<h2><i class="fa fa-trophy"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Short Contest 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-trophy"></i></h2><hr>
				<h4>26<sup>th</sup> March 2016, 21:30 Hrs IST</h4>
				<h4>Duration: 1 Hour</h4>
				<hr>
				<h3>Contest begins in</h3>
				<font style='font-size:36px;'><span id='time'></span></font><br><br>
				<?php
				if($contest_status == -1)
				{
					if(isset($_SESSION["email1"]))
					{
						$contest_id = 2;

						$query = "SELECT * FROM short_contest_leaderboard WHERE user='$email' AND contest_id='$contest_id'";
						$result = mysqli_query($con,$query);
						$numResults = mysqli_num_rows($result);

						if($numResults == 0)
						{
							echo"<form action='completereg.php'><button class='signup-btn btn btn-primary btn-lg btn-flat' onclick='complete_registeration()' value='Sign-Up' id='signup-button'>Register</button></form><br>";
						}
						else
						{
							echo"<font color='green' size='5'><b>Successfully Registered</b></font><br><br>";
						}
					}
					else
					{
						echo"<button class='signup-btn btn btn-primary btn-lg btn-flat' href='' data-toggle='modal' data-target='#login-login-modal' value='Sign-Up' id='signup-button'>Register</button><br><br>";
					}
				}
				else
				{
					if(isset($_SESSION["email1"]))
					{
						$contest_id = 2;

						$query = "SELECT * FROM short_contest_leaderboard WHERE user='$email' AND contest_id='$contest_id'";
						$result = mysqli_query($con,$query);
						$numResults = mysqli_num_rows($result);

						echo"<form action='completereg.php'><button class='signup-btn btn btn-primary btn-lg btn-flat' onclick='complete_registeration()' value='Sign-Up' id='signup-button'>Enter Contest</button></form><br>";
					}
					else
					{
						echo"<button class='signup-btn btn btn-primary btn-lg btn-flat' href='' data-toggle='modal' data-target='#login-login-modal' value='Sign-Up' id='signup-button'>Enter Contest</button><br><br>";
					}
				}
				?>
				<font size='5'><b><?php echo $numRegistered_users?></b></font>&nbsp;&nbsp;<font size='4'>users registered.</font>
			</h2>
		</center>
	</div>
	<div class="col-md-2">
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
</body>
<script>
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
    	hours = parseInt(timer / 3600, 10);
        minutes = parseInt(timer / 60 - hours*60, 10);
        seconds = parseInt(timer % 60, 10);

        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.text(hours + ":" + minutes + ":" + seconds);

        if (--timer < 0) 
        {
        	display.text("00" + ":" + "00" + ":" + "00");
            timer = duration;
        }
        if(timer == 0)
        {
        	location.reload();
        }
    }, 1000);
}

jQuery(function ($) {
    var fiveMinutes = "<?php echo $time_left; ?>",
        display = $('#time');
    startTimer(fiveMinutes, display);
});
</script>
<br>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php include ("../../inc/footer.inc.php"); ?>	
