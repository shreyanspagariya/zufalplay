<?php include ("./inc/header.inc.php"); 
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
  if($email!="EXTUSER")
  {
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_week='0' AND game_id='7' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id) VALUES ('0','$email','0','0','7')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','1007','0','$datetime')");
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

  $play_id = generateRandomString()."HEXTRIS";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='7' AND is_competition='0'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."HEXTRIS";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='7' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id) 
    VALUES ('$email','0','0','0','$play_id','$datetime','7')");
?>
		<link rel="icon" type="image/png" href="favicon.ico">
		<link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="style/fa/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<script type='text/javascript' src="vendor/hammer.min.js"></script>
		<script type='text/javascript' src="vendor/js.cookie.js"></script>
		<script type='text/javascript' src="vendor/jsonfn.min.js"></script>
		<script type='text/javascript' src="vendor/keypress.min.js"></script>
		<script type='text/javascript' src="vendor/jquery.js"></script>
		<script type='text/javascript' src="js/save-state.js"></script>
		<script type='text/javascript' src="js/view.js"></script>
		<script type='text/javascript' src="js/wavegen.js"></script>
		<script type='text/javascript' src="js/math.js"></script>
		<script type='text/javascript' src="js/Block.js"></script>
		<script type='text/javascript' src="js/Hex.js"></script>
		<script type='text/javascript' src="js/Text.js"></script>
		<script type='text/javascript' src="js/comboTimer.js"></script>
		<script type='text/javascript' src="js/checking.js"></script>
		<script type='text/javascript' src='js/update.js'></script>
		<script type='text/javascript' src='js/render.js'></script>
		<script type='text/javascript' src="js/input.js"></script>
		<script type='text/javascript' src="js/main.js"></script>
		<script type='text/javascript' src="js/initialization.js"></script>
		<script type='text/javascript' charset='utf-8' src='cordova.js'></script>
		<script src="vendor/sweet-alert.min.js"></script>
		<link rel="stylesheet" href="style/rrssb.css"/>
		<style type="text/css">
			.zfp-inner-hextris
			{
			    background-attachment: fixed !important;
			    background-repeat: no-repeat;
			    font-family: 'Roboto', sans-serif;
			    color: #000000;
			    background-color: #F2F2F2;
			    padding-top: 60px;
			}
		</style>
		<input id="play_id" value="<?php echo $play_id;?>" hidden>
	<body class="zfp-inner-hextris">
		<canvas id="canvas"></canvas>
		<div id="overlay" class="faded overlay"></div>
		<div id='startBtn' ></div>
		<!--<img id="openSideBar" class='helpText' src="./images/btn_help.svg"/>-->
		<div class="faded overlay"></div>
		<img id="pauseBtn" src="./images/btn_pause.svg"/>
		<img id='restartBtn' src="./images/btn_restart.svg"/>
		<div id='highScoreInGameText'>
		</div>
		<div id="gameoverscreen">
			<div id='container'>
				<div id='gameOverBox' class='GOTitle'>GAME OVER</div>
				<div id='cScore'>1843</div>
			</div>
			<div id='bottomContainer'>
				<img id='restart' src='./images/btn_restart.svg' height='57px'>
				<div id='buttonCont'>
					<ul class="rrssb-buttons">	
					</ul>
				</div>
			</div>
		</div>
		<script type="text/javascript" src='vendor/rrssb.min.js'></script>
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>
