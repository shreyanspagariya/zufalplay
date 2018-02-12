<!DOCTYPE html>
<?php include ("../../../../inc/nosidebar.inc.php"); 
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
  $game_id = 13;
  $is_competition = 1;
  if($email!="EXTUSER")
  {
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_week='0' AND game_id='$game_id' AND is_competition='$is_competition'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id,is_competition) VALUES ('0','$email','0','0','$game_id','$is_competition')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','$game_id','0','$datetime')");
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

  $play_id = generateRandomString()."ZOKO";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."ZOKO";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id,is_competition) 
    VALUES ('$email','0','0','0','$play_id','$datetime','$game_id','$is_competition')");
?>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<html>
  <head>
    <title>Zoko - Gaming Woche 2 | Zufalplay</title>
    <script type="text/javascript" src="//use.typekit.net/apk7kwq.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <link href="css/font-awesome.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
  </head>
  <body class="tk-nimbus-sans">
    <div class="container">
      <div id="wrapper">
        <div class="content">
          <canvas id="zoko" height="450" width="850"></canvas>

          <div id="overlay">
            <p id="steps">0 steps</p>
            <p id="level">Level <span class="levelNumber">1</span></p>
          </div>

          <div id="menu">
            <div class="options">
              <h2 class="title">Options</h2>
              <button id="continueBtn" class="btn">Continue Game</button>
              <button id="nextBtn" class="btn">Next Level &rarr;</button>
              <button id="previousBtn" class="btn">&larr; Previous Level</button>
              <a href="<?php echo $g_url.'contests/long/gaming-woche-2'; ?>" target='_blank'><button class='btn'>Contest Arena</button></a>
              <a href="<?php echo $g_url.'contests/long/localleaderboard.php?game=zoko'?>" target='_blank'><button class='btn'>Local Leaderboard</button></a>
              <a href="<?php echo $g_url.'contests/long/leaderboard.php?u=2'; ?>" target='_blank'><button class='btn'>Overall Leaderboard</button></a>
            </div>
            <div class="highscore">
              <h2>Highscore</h2>
              <table class="table">
                <tbody>
                  <tr>
                    <td>Level 1
                    <td>2 steps</td>
                  </tr>
                  <tr>
                    <td>Level 2
                    <td>3 steps</td>
                  </tr>
                  <tr>
                    <td>Level 3
                    <td>?</td>
                  </tr>
                  <tr>
                    <td>Level 4
                    <td>?</td>
                  </tr>
                  <tr class="last">
                    <td>Level 5
                    <td>?</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div id="menuOverlay"></div>
          <h1 id="logo">zoko</h1>
          <div id="btn-group">
            <a id="menuBtn" class="icon-btn icon-home" title="Show Menu"></a>
            <a id="restartBtn" class="icon-btn icon-undo" title="Restart Level"></a>
          </div>
        </div>
      </div>
    </div>
    <br><br><br>
  </body>
  <script src="js/jquery-1.8.3.min.js"></script>
  <script src="js/zoko.js"></script>
  <script>
    $(function() {
      $(document).ready(function() {
        container = $('div.container');
        zoko = new Zoko(container);
      });
    });
  </script>
</html>
<?php include ("../../../../inc/footer.inc.php"); ?>