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
  $game_id = 14;
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

  $play_id = generateRandomString()."RAGEGAR";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."RAGEGAR";
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Raging Gardens is an HTML5 game by Dvubuz Games.">
    <meta name="keywords" content="raging gardens, rabbits game, html5, javascript, indie, browser based, 2D game">    
    <title>Raging Gardens</title>
    <script type="text/javascript" src="lib/modernizr.custom.js"></script>
    <link rel="shortcut icon" href="favicon.ico" />
    <link type="text/css" href="css/style.css" rel="stylesheet" /> 
    <link type="text/css" href="css/le-frog/jquery-ui-1.9.2.custom.css" rel="stylesheet">
    <script type="text/javascript" src="lib/jquery.191.min.js"></script>
    <script type="text/javascript" src="lib/jquery-ui.192.min.js"></script>
    <script type="text/javascript" src="lib/gj-js-api-min.js"></script>
    <script type="text/javascript" src="lib/crafty-063-min.js"></script>
    <script type="text/javascript" src="lib/underscore-min.js"></script>
    <script type="text/javascript" src="lib/backbone-min.js"></script>
    <script type="text/javascript" src="lib/graph.js"></script>
    <script type="text/javascript" src="lib/astar.js"></script>
</head>
<style>
.pushup {
  margin-top:-8px;
}
</style>
<div class="pushup" style='font-size: 14px; font-family: 'Roboto', sans-serif;'>
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10; border-color: #000; border-width: 1px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
  <div class="container">
    <div class="col-md-8">
      <ul class="nav navbar-nav">
      <li class=""><a href="<?php echo $g_url.'contests/long/gaming-woche-2'; ?>">Contest Arena</a></li>
        <li class=""><a href="<?php echo $g_url.'contests/long/gaming-woche-2/raging-gardens'; ?>">Play <?php echo "Raging-Gardens";?></a></li>
        <li><a href="<?php echo $g_url.'contests/long/localleaderboard.php?game=raginggardens'?>">Local Leaderboard</a></li>
        <li class=""><a href="<?php echo $g_url.'contests/long/leaderboard.php?u=2'; ?>">Overall Leaderboard</a></li>
         <li class="hidenav"><a href='#' onclick='hide_navbar()'>Hide Navbar</a></li>
         <script>
          function hide_navbar()
          {
            if($(".navbar").hasClass("hidden"))
            {
              $(".navbar").removeClass("hidden");
              $('.pushup').css({'margin-top':'-8px'});
              $(".hidenav").html("<a href='#' onclick='hide_navbar()'>Hide Navbar</a>");
            }
            else
            {
              $(".navbar").addClass("hidden");
              $('.pushup').css({'margin-top':'-60px'});
              $(".hidenav").html("<a href='#' onclick='hide_navbar()'>Show Navbar</a>");
            }
          }
         </script>
      </ul>
    </div>
  </div>
</footer> 
</div>
<body class='zfp-inner'>
<!--[if lt IE 8]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
    <div id="dialog-save-score" style="display: none;"></div>
    <div id="dialog-score" style="display: none;"></div>
    <div id="dialog-howto" style="display: none;">
    <h1>Story</h1>
    <p>
    It's a lovely day at farmers field. A great time for a hungry (ninja) rabbit to sneak in and <span class="keys">pull</span> 
    some carrots to eat. Too bad you weren't the only one with that idea. A horde of hungry opponents approaches fast! 
    Pull as many carrots as you can in <span class="keys">3 minutes</span>. To fight your opponents, you must use ancient rabbitjutsu tactics. 
    These are slightly unorthodox. Simply uhm ... fart to <span class="keys">push</span> your opponents away or use a 
    <span class="keys">Carrot-on-a-Fork</span> totem decoy to deceive them. The totem is spawned on your current position.
    </p>
    <h1>Goal &amp; Controls</h1>
    <p>Collect as many carrots as possible in 3 minutes. Use the controls to move and repel opponents.</p>
    <ul>
        <li><span class="keys">Arrow keys</span> - Move your ninja rabbit on the map.</li>
        <li><span class="keys">Z (or Y)</span> - Hold down to pull a carrot from the ground. You need to be close to a carrot.</li>
        <li><span class="keys">Q</span> - Eat <span class="keys">1 carrot</span> and fart to push opponents away from you.</li>
        <li><span class="keys">W</span> - Eat <span class="keys">2 carrots</span> and spawn a "Carrot-on-a-Fork" totem that attracts 
        opponents and gives you time to pull more carrots elsewhere on the map.</li>
    </ul>
    </div>
    <div id="dialog-credits" style="display: none;">
        <p>Game design and programming - <a href="http://petarov.vexelon.net">Petar Petrov</a></p>
        <br />
        <p>Art and graphics - <a href="http://stremena.com/">Stremena Tuzsuzova</a></p>
        <br />
        <p>Sound and Music - <a href="https://github.com/petarov/game-off-2012#sound-and-music">See here</a></p>
    </div>
    <div id="dialog-restart" style="display: none;">Would you like to restart the game?</div>
    
    <div id="fps" style="display: none;"></div>
    <div id="wrapper" style='margin-top:30px;'>
        <div id="left-frame" style="display: none;"></div>
        <div id="right-frame" style="display: none;"></div>           
        <div id="bottom-frame" style="display: none;"></div>

        <div id="stage">
            <div id="msgs" class="text center"></div>
            <div id="loading" class="text left" style="display: none;"></div>
            <div id="stats" style="display: none;">
                <div id="timer" class="text timer"></div>
                <div id="carrots" class="text carrots"></div>
            </div>
            <div id="in-menu" style="display: none;">
                <div id="toggle-music"></div>
                <div id="toggle-sfx"></div>
            </div>
            <div id="menu" style="display: none;">
                <div id="menu-start" class="button" style="left: 76px">Play Game</div>
                <div id="menu-howto" class="button" style="left: 248px">How to Play</div>
                <div id="menu-hiscore" class="button" style="left: 438px">Hiscores</div>
                <div id="menu-credits" class="button" style="left: 618px">Credits</div>
            </div>
        </div>
    </div>
    <!--URCHIN-->
<script type="text/javascript">
var ver = new Date().getTime();
window._Globals = {env:'dev', version:ver, scene:'splash'};
var require = {waitSeconds:15, urlArgs:"bust="+ver};
</script>
<script data-main="src/bootstrap" src="lib/require.js">
</script>
</body>
</html>
