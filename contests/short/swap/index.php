<?php include ("header.inc.php");

$query = "SELECT * from short_contest_manager";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$contest_status = $get['contest_status'];
$contest_end_time = $get['contest_end_time'];

if($email == "shalvin.shalvin@gmail.com")
{
	$contest_status = 0;
}

if($contest_status == -1)
{
	header("Location: ".$g_url."contests/short/conteststart.php");
}
else if($contest_status == 1)
{
	header("Location: ".$g_url."contests/short/leaderboard.php?id=2");
}

$query = "SELECT * FROM short_contest_leaderboard WHERE user='$email' AND contest_id='2'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);
if($numResults == 0)
{
  date_default_timezone_set('Asia/Kolkata');
  $datetime = date("Y-m-d H:i:sa");

  mysqli_query($con,"INSERT INTO short_contest_leaderboard (contest_id,user,levels_cleared,rupees_earned) VALUES ('2','$email','0','0')");
  mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','10','2','$datetime')");
}

?>

	<script src="js/tile.js"></script>
	<script src="js/ai.js"></script>
	<script src="js/levels.js"></script>
	<script src="js/player.js"></script>
	<script src="js/world.js"></script>
	<script src="js/draw.js"></script>
	<script src="js/keypress-1.0.8.min.js"></script>
	<script src="js/input.js"></script>
	<script type="text/javascript">
		window.onload = function() 
		{
			var level = window.location.hash.match(/\d+/) || 1;
			world.init(level-1, "canvas", "hud", "tip");
			document.getElementById("reset").onclick = function() 
			{
				world.resetLevel();
			}
			document.getElementById("skip").onclick = function() 
			{
				world.victory();
			}
			document.getElementById("mute").onclick = function() 
			{
				var music = document.getElementById("music");
				if(music.paused) 
				{
					music.play();
					document.getElementById("mute").innerHTML = "<i class='fa fa-volume-up'></i>";
				}
				else 
				{
					music.pause();
					document.getElementById("mute").innerHTML = "<i class='fa fa-volume-off'></i>&nbsp;&nbsp;";
				}
			}

		}
	</script>

	<audio id="music" src="music.mp3" preload autoplay loop></audio>
	<meta property="og:image" content="thumbnail.png" />

	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

	<style>
		a.action-btn 
		{
			text-decoration: none;
			color: gray;
		}
		a.action-btn:hover 
		{
			text-decoration: none;
			color: gray;
		}
		#reset 
		{
			float: left;
		}
		#skip 
		{
			float: right;
		}
	</style>

</head>
<body class='zfp-inner'>
	<br><br>
	<div style="width: 640px;text-align: center;margin: 0 auto">
		<span id="hud" style="font-size: 24px; margin-left: 110px;"></span>
		<span style="float: right;font-size: 36px;"><a href="#" id="mute" class="action-btn"><i class="fa fa-volume-up"></i></a></span>
		<br>
		<canvas id="canvas" width="640" height="640" style="box-shadow:0 0 15px darkgrey;"></canvas>
		<span style="width: 640px;font-size:18px; display: inline-block;">
			<a href="#" id="reset" class="action-btn"><em>Reset <i class="fa fa-repeat"></i></em></a>
		</span>
		<br>
		<span id="tip" style="font-size: 24px; text-align: center;"></span>
		<br>
	</div>	
<div style="position: fixed; bottom:0; z-index:1000;">
    <div class="alert alert-zfp alert-dismissible hidden top_notif" role="alert" align="center" style="margin-bottom:50px;">
      <!--<button type='button' class='close' data-dismiss='alert' aria-label='Close'><i class='fa fa-times-circle'></i></button>-->
      <p class="top_notif_msg"></p>
    </div>
</div>

<footer class="footer navbar-fixed-bottom" style="background-color:#382762" hidden>
  <div class="container">
  	<div class="col-md-8">
    	<ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_url.'about'; ?>">About</a></li>
        <li class=""><a href="<?php echo $g_url.'games'; ?>">Games</a></li>
        <li class=""><a href="<?php echo $g_url.'videos'; ?>">Videos</a></li>
        <li class=""><a href="<?php echo $g_url.'market'; ?>">Market</a></li>
        <li><a href="<?php echo $g_url.'about/privacy.php'; ?>">Privacy Policy</a></li>
        <li><a href="<?php echo $g_url.'about/contact.php'; ?>">Contact Us</a></li>
        <li>
        </li>
      </ul>
  	</div>
  	
  </div>
</footer>
<script>
    var _gaq = _gaq || [];  
    _gaq.push(['_setAccount', 'UA-65871967-1']);  
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>

<h1 hidden><span></span></h1>

<div class="modal" id="adblock-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center><h4 class="modal-title" id="myModalLabel">Please Disable Adblock</h4></center>
      </div>
      <div class="modal-body">
        <div class="beforesubmit">
          <img src='<?php echo $g_url;?>images/Disable-Adblock.png' style='width:100%;height:100%;'> 
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo $g_url;?>adblock/fuckadblock.js"></script>
<script src="<?php echo $g_url;?>adblock/detectadblock.js"></script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="<?php echo $g_url;?>js/signup_login.js"></script>
<script src="<?php echo $g_url;?>js/bootstrap.min.js"></script>
<script src="<?php echo $g_url;?>js/smoothscroll.js"></script>
<script src="<?php echo $g_url;?>js/searchsuggest.js"></script>
<script src="<?php echo $g_url;?>notifications/notif.js"></script>
<?php if(isset($_SESSION["email1"]))
  {
    mysqli_query($con,"UPDATE table2 SET pageviews = pageviews + 1, total_time_on_site = total_time_on_site - 10 WHERE email = '$email'");
    ?>
    <script src="<?php echo $g_url;?>js/recursive.js"></script>
    <?php
  }
?>

<script>
  function adblock_popup() 
  {
      var x = $('h1 span').text();
      if(x.localeCompare("yes") == 0)
      {
        $('#adblock-modal').modal('show');
      }
  }
</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var $_Tawk_API={},$_Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/55ca28dc9f1e65a7205a162c/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
