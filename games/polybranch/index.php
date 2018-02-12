<!DOCTYPE html>
<?php include ("../../inc/nosidebar.inc.php"); 
if(isset($_SESSION["email1"]))
{
  $email = $_SESSION["email1"];
  top_banner();
}
else
{
  $email = "EXTUSER";
  top_banner_extuser();
}?>
<?php 
  date_default_timezone_set('Asia/Kolkata');
  $datetime = date("Y-m-d H:i:sa");
  $game_id = 15;
  $profile_id = 1000+$game_id;
  $is_competition = 0;
  if($email!="EXTUSER")
  {
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_week='0' AND game_id='$game_id' AND is_competition='$is_competition'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id,is_competition) VALUES ('0','$email','0','0','$game_id','$is_competition')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','$profile_id','0','$datetime')");
    }
    else
    {
      $query = "SELECT * FROM profile_tempfill WHERE user_email='$email' AND game_id='$profile_id'";
      $result = mysqli_query($con,$query);
      $numResults = mysqli_num_rows($result);
      if($numResults == 0)
      {
        mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','$profile_id','0','$datetime')");
      }
    }
  }
  function generateRandomString($length = 9) 
  {
      $characters = '123456789';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

  $play_id = generateRandomString()."POLYB";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."POLYB";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id,is_competition) 
    VALUES ('$email','0','0','0','$play_id','$datetime','$game_id','$is_competition')");
?>
<style>
.pushup {
  margin-top:52px;
}
</style>
<div class="pushup" style='font-size: 14px; font-family: 'Roboto', sans-serif;'>
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10; border-color: #000; border-width: 1px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
  <div class="container">
    <div class="col-md-8">
      <ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_url.'games/polybranch'; ?>">Play <?php echo "Polybranch";?></a></li>
        <li><a href="<?php echo $g_url.'games/leaderboard.php?game=polybranch'?>">Leaderboard</a></li>
         <li class="hidenav"><a href='#' onclick='hide_navbar()'>Hide Navbar</a></li>
         <script>
          function hide_navbar()
          {
            if($(".navbar").hasClass("hidden"))
            {
              $(".navbar").removeClass("hidden");
              $('.pushup').css({'margin-top':'52px'});
              $(".hidenav").html("<a href='#' onclick='hide_navbar()'>Hide Navbar</a>");
            }
            else
            {
              $(".navbar").addClass("hidden");
              $('.pushup').css({'margin-top':'-50px'});
              $(".hidenav").html("<a href='#' onclick='hide_navbar()'>Show Navbar</a>");
            }
          }
         </script>
      </ul>
    </div>
  </div>
</footer> 
</div>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Polybranch - Gaming Woche 2 | Zufalplay</title>
		<meta name="description" content="PolyBranch is a minimalist 3D game. Avoid the branches protruding from the walls as you fly through the tunnel. Dodging branches may seem easy at first, but how long can you hold up as you approach terminal velocity? Dive in, stay focused, and enjoy the ride!">
		<meta property="og:title" content="PolyBranch"/>
		<meta property="og:description" content="PolyBranch is a minimalist 3D game. Avoid the branches protruding from the walls as you fly through the tunnel. Dodging branches may seem easy at first, but how long can you hold up as you approach terminal velocity? Dive in, stay focused, and enjoy the ride!"/>
	    <meta property="og:type" content="game"/>
	    <meta property="og:url" content="http://gregbatha.com/branches/"/>
	    <meta property="og:image" content="http://gregbatha.com/branches/screenshot1.png"/>

		<link rel="icon"  type="image/x-icon" href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAQAAVzABAEAjBQAaDwYAWjUGAGE6CQBrQQ0ATS8PAFhAJwBUQC8AbFI6AHVXPACBZk4A4NrWAPb19QAAAAAAAMmZmZmZmgAJIwAAAAAAcMIjPjA+PjAKpxIuMDMzMAm0Ii4zMzMACaIiLt3dMAAJtyIuIzPQAAm0Un5yM+IzKLRkfncy4iIotRF+dyLkIiq0QX53F+EiGrQUTkd34iIatEVu7u5iIVrBVVRBRFRVbAtGZGZla2uwAMu7u7u8vADAAwAAgAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIABAADAAwAA" />
		<meta name="Generator" content="Processing" />
		<!-- - - - - - - - - - - - - - - - - - - - - 
		+
		+    Wondering how this works? 
		+
		+    Go to: http://processing.org/
		+    and: http://processingjs.org/
		+
		+ - - - - - - - - - - - - - - - - - - - - -->
		<style type="text/css">
	
		</style>
		<!--[if lt IE 9]>
			<script type="text/javascript">alert("Your browser does not support the canvas tag.");</script>
		<![endif]-->
		<script src="js/libs/processing-1.4.1.min.js" type="text/javascript"></script>
		<script src="js/libs/jquery-1.8.3.min.js" type="text/javascript"></script>
		<link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>
		<link href='css/styles.css' rel='stylesheet' type='text/css'>
		<script type="text/javascript">
		   var bound = false;
		   var pjs;

		    function bindJavascript() {
		      pjs = Processing.getInstanceById('polybranch');
		      if(pjs!=null) {
		        pjs.bindJavascript(this);
		        bound = true;
		      }
		      if(!bound) setTimeout(bindJavascript, 250);
		    }

		    bindJavascript();

		</script>
		<script src="js/script.js" type="text/javascript"></script>
		<script type="text/javascript">
// convenience function to get the id attribute of generated sketch html element
function getProcessingSketchId () { return 'polybranch'; }
</script>

	</head>
	<body>
		<div id="content">
			<div id="game-wrapper">
				<canvas id="polybranch" data-processing-sources="polybranch.pjs" 
						width="800" height="800">
					<p>Your browser does not support the canvas tag.</p>
					<!-- Note: you can put any alternative content here. -->
				</canvas>
				<div class="overlay" id="main-menu">
					<div class="content">
						<h1>PolyBranch</h1>
						<a class="button" id="start">START</a>
					</div>
				</div>
				<div id="hud">
					<h1 id="score">0</h1>
					<h1 id="level">L<span>1</span></h1>
				</div>
				<img id="arrowkeys" src="Arrow_keys.png"/>
				<div class="overlay" id="flash"></div>
				<div class="overlay" id="gameover-menu">
					<div class="content">
						<h1 id="score"></h1>
						<h2 id="highscore"></h2>
						<h2 id="nextlevel">NEXT LEVEL AT <span></span></h2>
						<a class="button" id="retry">TRY AGAIN</a>
					</div>
				</div>
				<div class="overlay" id="loading">
					<h2>Loading...</h2>
				</div>
	    	</div>
		</div>
	</body>
</html>
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>
