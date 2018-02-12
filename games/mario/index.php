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
}
?>
<?php 
  date_default_timezone_set('Asia/Kolkata');
  $datetime = date("Y-m-d H:i:sa");
  if($email!="EXTUSER")
  {
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_week='0' AND game_id='8' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id) VALUES ('0','$email','0','0','8')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','1008','0','$datetime')");
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

  $play_id = generateRandomString()."MARIO";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='8' AND is_competition='0'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."MARIO";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='8' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id) 
    VALUES ('$email','0','0','0','$play_id','$datetime','8')");
?>
<style type="text/css">
  .gamecard
  {
    background-color: #FFF;
    padding: 0px 10px 0px 10px;
  }
  .gamecard:hover {
  }
</style>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<body class="zfp-inner">
    <div style="margin-top:3%">
		<div class="container gamecard elevatewhite">
        <div class="col-md-5">
        <center>
          <h1><b>Mario</b></h1><hr>
          <b>Left/Right Arrow</b> keys to Move<br>
          <b class="number">S </b>key to Jump/Enter a New Level<br> 
          <b class="number">A </b>key to throw a Fireball/Run Fast
          <hr><br>
          <div class="gamecard elevatewhite">
            <div style="font-size:80px;" id="gamescore"><b>0</b></div>
          </div>
          <br>
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- gmpgad -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:100px"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="6895543716"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        </center>
      </div>
      <center>
        <br>
    		<canvas id="canvas" width="640" height="480">
    			<p>Your browser does not support the canvas element.</p>
    		</canvas>
      </center>

    </div>
    </div>
        <!-- Enjine Includes -->
        <script src="Enjine/core.js"></script>
        <script src="Enjine/gameCanvas.js"></script>
        <script src="Enjine/keyboardInput.js"></script>
        <script src="Enjine/resources.js"></script>
        <script src="Enjine/drawable.js"></script>
        <script src="Enjine/state.js"></script>
        <script src="Enjine/gameTimer.js"></script>
        <script src="Enjine/camera.js"></script>
        <script src="Enjine/drawableManager.js"></script>
        <script src="Enjine/sprite.js"></script>
        <script src="Enjine/spriteFont.js"></script>
        <script src="Enjine/frameSprite.js"></script>
        <script src="Enjine/animatedSprite.js"></script>
        <script src="Enjine/collideable.js"></script>
        <script src="Enjine/application.js"></script>
        
        <!-- Actual game code -->
        <script src="code/setup.js"></script>
        <script src="code/spriteCuts.js"></script>
        <script src="code/level.js"></script>
        <script src="code/backgroundGenerator.js"></script>
        <script src="code/backgroundRenderer.js"></script>
        <script src="code/improvedNoise.js"></script>
        <script src="code/notchSprite.js"></script>
        <script src="code/character.js"></script>
        <script src="code/levelRenderer.js"></script>
        <script src="code/levelGenerator.js"></script>
        <script src="code/spriteTemplate.js"></script>
        <script src="code/enemy.js"></script>
        <script src="code/fireball.js"></script>
        <script src="code/sparkle.js"></script>
        <script src="code/coinAnim.js"></script>
        <script src="code/mushroom.js"></script>
		<script src="code/particle.js"></script>
		<script src="code/fireFlower.js"></script>
        <script src="code/bulletBill.js"></script>
        <script src="code/flowerEnemy.js"></script>
        <script src="code/shell.js"></script>
        
        <script src="code/titleState.js"></script>
        <script src="code/loadingState.js"></script>
        <script src="code/loseState.js"></script>
        <script src="code/winState.js"></script>
        <script src="code/mapState.js"></script>
        <script src="code/levelState.js"></script>
        
        <script src="code/music.js"></script>

        <script>$(document).ready(function() { new Enjine.Application().Initialize(new Mario.LoadingState(), 320, 240) });</script>
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>