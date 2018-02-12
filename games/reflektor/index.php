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
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_week='0' AND game_id='17' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id) VALUES ('0','$email','0','0','17')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','1017','0','$datetime')");
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

  $play_id = generateRandomString()."REFLEK";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='17' AND is_competition='0'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."REFLEK";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='17' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id) 
    VALUES ('$email','0','0','0','$play_id','$datetime','17')");
?>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<head>
	<meta charset="UTF-8" />
	
	<!-- build:css main.min.css -->
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<!-- /build -->

	<!-- build:js main.min.js -->
	<script type="text/javascript" src="js/lib/phaser.min.js"></script>
	<script type="text/javascript" src="js/Enemy.js"></script>
	<script type="text/javascript" src="js/EnemyShip.js"></script>
	<script type="text/javascript" src="js/load.js"></script>
	<script type="text/javascript" src="js/menu.js"></script>
	<script type="text/javascript" src="js/play.js"></script>
	<script type="text/javascript" src="js/playagain.js"></script>
	<script type="text/javascript" src="js/game.js"></script>
	<!-- /build -->
</head>
<body>
<br>
<div id="game"></div>

<br />

<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>
