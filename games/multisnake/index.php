<!DOCTYPE html>
<?php include ("./inc/header.inc.php"); 
if(isset($_SESSION["email1"]))
{
  $email = $_SESSION["email1"];
  top_banner();
  $margin_top = 5;
}
else
{
  $email = "EXTUSER";
  top_banner_extuser();
  $margin_top = 0;
}?>
<?php 
  date_default_timezone_set('Asia/Kolkata');
  $datetime = date("Y-m-d H:i:sa");
  $game_id = 18;
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

  $play_id = generateRandomString()."MULTSNAK";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."MULTSNAK";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id,is_competition) 
    VALUES ('$email','0','0','0','$play_id','$datetime','$game_id','$is_competition')");
?>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
  <head> 
    <meta charset="UTF-8" />
    <script type="text/javascript" src="assets/js/phaser.min.js"></script>
    <script type="text/javascript" src="src/boot.js"></script>
    <script type="text/javascript" src="src/load.js"></script>
    <script type="text/javascript" src="src/menu.js"></script>
    <script type="text/javascript" src="src/play.js"></script>
    <script type="text/javascript" src="src/end.js"></script>
    <script type="text/javascript" src="src/game.js"></script>
    <style type="text/css">
    </style>
  </head>
  <body>
  <div style="margin-top:3%">
  <div style='padding:20px;padding-top:<?php echo $margin_top;?>%' class="container gamecard elevatewhite">
      <div class="col-md-5">
        <center>
          <h1><b>Multisnake</b></h1><hr>
          <b class='number'>Minimum score</b> of both snakes will be <br>considered as the <b class='number'>final score</b>.
          <hr><br>
          <div class="gamecard elevatewhite">
            <div style="font-size:100px;" id="gamescore"><b>0</b></div>
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
      <div class="col-md-7">
        <center>
          <div id="game"></div><br>
        </center>
      </div>
  
</div>
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?> 
