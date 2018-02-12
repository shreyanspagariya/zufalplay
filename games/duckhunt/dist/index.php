<!DOCTYPE HTML>
<?php include ("../../../inc/extuser.inc.php"); 
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
  $game_id = 11;
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

  $play_id = generateRandomString()."DUCK";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."DUCK";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id,is_competition) 
    VALUES ('$email','0','0','0','$play_id','$datetime','$game_id','$is_competition')");
?>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<html>
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
        <li class=""><a href="<?php echo $g_url.'games/duckhunt/dist'; ?>">Play <?php echo "Duckhunt";?></a></li>
        <li><a href="<?php echo $g_url.'games/leaderboard.php?game=duckhunt'?>">Leaderboard</a></li>
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
              $('.pushup').css({'margin-top':'0px'});
              $(".hidenav").html("<a href='#' onclick='hide_navbar()'>Show Navbar</a>");
            }
          }
         </script>
      </ul>
    </div>
  </div>
</footer> 
</div>
<head>
  <title>Duckhunt - Gaming Woche 2 | Zufalplay</title>
  <meta name="description" content="An open source, web based, responsive implementation of Duck Hunt in HTML5 and ES2015">
  <meta name="author" content="Matt Surabian">
  <style>
    body {
      overflow:hidden;
      margin: 0;
      padding: 0;
      background-color: #000000;
    }
  </style>
  <script src="duckhunt.js"></script>
</head>
<body class=''>
</body>
</html>
<?php include ("../../userprompt.inc.php"); ?> 
<?php include ("../../../inc/footer.inc.php"); ?>