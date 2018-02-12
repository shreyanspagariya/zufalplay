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
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_id='3' AND game_week='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id) VALUES ('0','$email','0','0','3')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','3','0','$datetime')");
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

  $play_id = generateRandomString()."2048";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='3'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."2048";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='3'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id) 
    VALUES ('$email','0','0','0','$play_id','$datetime','3')"); 
?>
<head>
<link href="style/main.css" rel="stylesheet" type="text/css">
</head>
<br>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<body class="zfp-inner">
  <br>
	<div class="container gamecard elevatewhite">
    
    <div class="col-md-6">
  		<div class="heading">
		<div class="col-md-5">
        <h1 class="title">2048</h1>
		</div>
        <br>
		<div class="col-md-4">
		<a class="restart-button" onclick="abandon_game()">Abandon Game</a>
		</div>
		<div class="col-md-3">
        <a class="restart-button" onclick="window.location.reload()">Restart</a>
		</div>
        
      </div>
      <div class="above-game">
        <p class="game-intro">Join the numbers and get to the <strong>2048 tile!</strong></p>
        
      </div>
      
      <p class="game-explanation">
        <strong class="important">How to play:</strong> Use your <strong>arrow keys</strong> to move the tiles. When two tiles with the same number touch, they <strong>merge into one!</strong>
      </p>
      <hr>
      <div class="scores-container gamecard elevatewhite">
          <div class="score-container" style='color:#000;'>0</div>
          <!--<div class="best-container" id='best_score'></div>-->
      </div>
        <br>
    </div>
    <div class="col-md-6">

      <div class="game-container">
        <div class="game-message">
          <p></p>
          <div class="lower">
  	        <a class="keep-playing-button">Keep going</a>
            <a class="retry-button">Try again</a>
          </div>
        </div>

        <div class="grid-container">
          <div class="grid-row">
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
          </div>
          <div class="grid-row">
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
          </div>
          <div class="grid-row">
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
          </div>
          <div class="grid-row">
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
            <div class="grid-cell"></div>
          </div>
        </div>

        <div class="tile-container">

        </div>
      </div>
    </div>
  </div>
  <script src="js/bind_polyfill.js"></script>
  <script src="js/classlist_polyfill.js"></script>
  <script src="js/animframe_polyfill.js"></script>
  <script src="js/keyboard_input_manager.js"></script>
  <script src="js/html_actuator.js"></script>
  <script src="js/grid.js"></script>
  <script src="js/tile.js"></script>
  <script src="js/local_storage_manager.js"></script>
  <script src="js/game_manager.js"></script>
  <script src="js/application.js"></script>
</body>
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>		