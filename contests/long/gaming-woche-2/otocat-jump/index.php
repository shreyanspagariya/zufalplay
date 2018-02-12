<!DOCTYPE html>
<?php include ("../../../../inc/extuser.inc.php"); 
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
  $game_id = 12;
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

  $play_id = generateRandomString()."OTOCAT";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='$game_id' AND is_competition='$is_competition'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."OTOCAT";
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
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!-- <link href='http://fonts.googleapis.com/css?family=Chewy' rel='stylesheet' type='text/css'> -->
  <title>Octocat Jump - Gaming Woche 2 | Zufalplay</title>
  <style>
    @font-face {
        font-family: 'Chewy';
        src: url('assets/fonts/chewy-webfont.eot');
        src: url('assets/fonts/chewy-webfont.eot?#iefix') format('embedded-opentype'),
             url('assets/fonts/chewy-webfont.woff') format('woff'),
             url('assets/fonts/chewy-webfont.ttf') format('truetype'),
             url('assets/fonts/chewy-webfont.svg#ChewyRegular') format('svg');
        font-weight: normal;
        font-style: normal;

    }

    @font-face {
        font-family: 'Octicons';
        font-weight: normal;
        font-style: normal;
        src: 
          url("assets/fonts/octicons-regular-webfont.woff#OcticonsRegular") format("woff"),
          url("assets/fonts/octicons-regular-webfont.ttf#OcticonsRegular") format("truetype"),
          url("assets/fonts/octicons-regular-webfont.svg#OcticonsRegular") format("svg"),
        ;
      }

/*    @font-face {
      font-family: 'Octicons Regular';
      src: url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.eot?ade8e027");
      src: url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.eot?ade8e027#iefix") format("embedded-opentype")
         , url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.woff?fca05081") format("woff")
         , url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.ttf?b2778fb1") format("truetype")
         , url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.svg?b5c3b089#newFontRegular") format("svg")
         ;
      font-weight: normal;
      font-style: normal;
    }*/


    * {
      margin: 0;
      padding: 0;
      cursor: default;
    }

    body, html { margin:0; padding: 0; overflow:hidden; height: 100%; font-family: Chewy, Arial; font-size:20px }
    body, html {
      background: rgb(224,226,228); /* Old browsers */
      background: -moz-linear-gradient(top,  rgba(224,226,228,1) 0%, rgba(185,187,189,1) 100%); /* FF3.6+ */
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(224,226,228,1)), color-stop(100%,rgba(185,187,189,1))); /* Chrome,Safari4+ */
      background: -webkit-linear-gradient(top,  rgba(224,226,228,1) 0%,rgba(185,187,189,1) 100%); /* Chrome10+,Safari5.1+ */
      background: -o-linear-gradient(top,  rgba(224,226,228,1) 0%,rgba(185,187,189,1) 100%); /* Opera 11.10+ */
      background: -ms-linear-gradient(top,  rgba(224,226,228,1) 0%,rgba(185,187,189,1) 100%); /* IE10+ */
      background: linear-gradient(to bottom,  rgba(224,226,228,1) 0%,rgba(185,187,189,1) 100%); /* W3C */
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e0e2e4', endColorstr='#b9bbbd',GradientType=0 ); /* IE6-9 */
    }
    #cr-stage {
      border:1px solid #999; 
      margin:50px auto; 
      color:white; 
      -webkit-box-shadow: 0px 0px 32px 0px rgba(0, 0, 0, .5);
      box-shadow: 0px 0px 32px 0px rgba(0, 0, 0, .5);
    }
    #loader { 
      background: url('assets/images/octocat-spinner-128.gif') no-repeat center center #fff;
      width: 400px;
      height: 640px;
      border:1px solid #999; 
      margin:50px auto; 
      color:white; 
      -webkit-box-shadow: 0px 0px 32px 0px rgba(0, 0, 0, .5);
      box-shadow: 0px 0px 32px 0px rgba(0, 0, 0, .5);
    }

    #scoreboard td, th {
      padding: 0;
      text-align: center;
      border-bottom: 1px solid #aaa;
      padding: 0 20px;
      width: 100%;
    }
    #scoreboard tr:last-child td{
      border-bottom: none;
    }

    #scoreboard th {
      color: #666;
      background: #ccc;
    }
    #scoreboard th:first-child {
      border-top-left-radius: 8px;
      border-right: 1px solid #888;
    }
    #scoreboard th:last-child {
      border-top-right-radius: 8px;
    }
    #scoreboard td:first-child {
      border-right: 1px solid gray;
    }
  </style>
</head>
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
      <li class=""><a href="<?php echo $g_url.'contests/long/gaming-woche-2'; ?>">Contest Arena</a></li>
        <li class=""><a href="<?php echo $g_url.'contests/long/gaming-woche-2/otocat-jump'; ?>">Play <?php echo "Otocat-Jump";?></a></li>
        <li><a href="<?php echo $g_url.'contests/long/localleaderboard.php?game=otocat'?>">Local Leaderboard</a></li>
        <li class=""><a href="<?php echo $g_url.'contests/long/leaderboard.php?u=2'; ?>">Overall Leaderboard</a></li>
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
<body>
  <div id="loader"></div>
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="crafty.js"></script>
  <script type="text/javascript" src="octocatjump.js"></script>
</body>
</html>
<?php include ("../../../../inc/footer.inc.php"); ?>