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
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_week='0' AND game_id='9' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id) VALUES ('0','$email','0','0','9')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','1009','0','$datetime')");
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

  $play_id = generateRandomString()."PAPPAK";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='9' AND is_competition='0'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."PAPPAK";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='9' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id) 
    VALUES ('$email','0','0','0','$play_id','$datetime','9')");
?>
  
  <link rel="stylesheet" href="css/main.css">
  <style>
    .pushright 
    {
      margin-left: 180px;
      margin-top: 72px;
    }
    .pushleft 
    {
      margin-right: 180px;
      margin-top: 80px;
    }
    .pushleft1
    {
      margin-right: 180px;
      margin-top: 110px;
    }
    .pushdown
    {
      margin-top:80px;
    }
    .gamecard
    {
      background-color: rgba(0,0,0,0.4);
      padding: 0px 10px 0px 10px;
    }
    .gamecard:hover {
      -webkit-box-shadow: 0 0 2px #fff;
            box-shadow: 0 0 2px #fff;
    }
  </style>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<body class="zfp-inner">
    <div class="pushright">
    <!-- Start Screen -->
    <div id="start_screen" class="pushright">
      <br><br>
      <h1 id="title">pappu pakia</h1>
      <h3 id="last_score"></h3>
      <h3 id="high_score"></h3>
      <div class="controls pushdown"></div>

      <div class="options">
        <ul>
          <li><a href="javascript:void(0);" id="start_game">start</a></li>
          <li><a href="javascript:void(0);" target="_blank" id="tweet">tweet</a></li>
          <li><a href="https://www.facebook.com/zufalplay" target="_blank" id="fb">fb like</a></li>
        </ul>
      </div>
    </div>
    <!-- /Start Screen -->
  
    <!-- Loading sounds -->
    <audio id="start" loop>
      <source src="sound/pappu-pakia2.3.ogg"  type="audio/ogg">
      <source src="sound/pappu-pakia2.3.mp3"  type="audio/mp3">
    </audio>
    
    <audio id="angry_jump">
      <source src="sound/jump1.ogg" type="audio/ogg">
      <source src="sound/jump1.mp3" type="audio/mp3">
    </audio>
    
    <audio id="sad_jump">
      <source src="sound/jump2.ogg" type="audio/ogg">
      <source src="sound/jump2.mp3" type="audio/mp3">
    </audio>
    
    <audio id="happy_jump">
      <source src="sound/jump3.ogg" type="audio/ogg">
      <source src="sound/jump3.mp3" type="audio/mp3">
    </audio>
    
    <audio id="flap">
      <source src="sound/flap.ogg" type="audio/ogg">
      <source src="sound/flap.mp3" type="audio/mp3">
    </audio>
    
    <audio id="ting">
      <source src="sound/ting.ogg" type="audio/ogg">
      <source src="sound/ting.mp3" type="audio/mp3">
    </audio>

    <canvas id="game_bg"></canvas>
    <canvas id="game_main"></canvas>

    <div id="score_board" class="pushright">0</div>

    <div id="invincible_timer">
      <div id="invincible_loader"></div>
    </div>

    <a href="javascript:void(0)" id="mute" class="pushleft1"></a>
    
    <!-- Loading Screen -->
    <div id="loading">
      <p id="loadText">Loading...</p>
      <div id="barCont">
        <div id="bar"></div>
      </div>
    </div>
    </div>

  <div id="fps_count" class="pushleft" style='color:#000;'></div>

  <script src="js/jquery-1.8.2.min.js"></script>
  <script>window.mit = window.mit || {};</script>
  <script src="js/utils.js"></script>
  <script src="js/backgrounds.js"></script>
  <script src="js/forks.js"></script>
  <script src="js/branches.js"></script>
  <script src="js/collectibles.js"></script>
  <script src="js/pappu.js"></script>
  <script src="js/pakia.js"></script>
  <script src="js/main.js"></script>
  <script src="js/loader.js"></script>
</div>
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>
