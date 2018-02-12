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
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_week='0' AND game_id='5' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id) VALUES ('0','$email','0','0','5')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','1005','0','$datetime')");
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

  $play_id = generateRandomString()."SNAKE";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='5' AND is_competition='0'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."SNAKE";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='5' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id) 
    VALUES ('$email','0','0','0','$play_id','$datetime','5')");
?>
<style type="text/css">
  #canvas_container 
  {
    margin: 40px auto;
  }
  .gamecard
  {
    background-color: #FFF;
    padding: 0px 10px 0px 10px;
  }
  .gamecard:hover {
  }
</style>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<body class="zfp-inner">
<div style="margin-top:3%">
  <div class="container gamecard elevatewhite">
      <div class="col-md-5">
        <center>
          <h1><b>Snake</b></h1><hr>
          <b class="number">Arrow</b> keys to <b>Change Direction</b>.<br>
          <b class="number">Space </b> to <b>Start</b> or <b>Pause</b>.<br> 
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
        <div id="canvas_container"><canvas style="background-color: black;margin-top: -25px;"></canvas></div>
      </div>
  
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="atom/atom.js" type='text/javascript'></script>
  <script src="stake.js" type='text/javascript'></script>
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>    
