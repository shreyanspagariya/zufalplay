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
    $query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_week='0' AND game_id='6' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
    if($numResults == 0)
    {
      mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id) VALUES ('0','$email','0','0','6')");
      mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','1006','0','$datetime')");
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

  $play_id = generateRandomString()."COIL";
  $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='6' AND is_competition='0'";
  $result = mysqli_query($con,$query);
  $numResults = mysqli_num_rows($result);

  while($numResults!=0)
  {
    $play_id = generateRandomString()."COIL";
    $query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='6' AND is_competition='0'";
    $result = mysqli_query($con,$query);
    $numResults = mysqli_num_rows($result);
  }

  mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id) 
    VALUES ('$email','0','0','0','$play_id','$datetime','6')");
?>
<link href="css/reset.css" rel="stylesheet" media="screen" />
<link href="css/main.css" rel="stylesheet" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Molengo' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<body class="zfp-inner">
	<div id="game">
		<canvas id="effects"></canvas>
		<canvas id="world"></canvas>
		<p id="lag-warning">Looks like the game is running slowly. <a href="#">Disable grid effects?</a></p>
		<div id="menu">
			<h1>Coil</h1>
			<div id="score">
				<h3>Your Score:</h3>
				<p>123312</p>
			</div>
			<section class="welcome">
				<h2>Instructions</h2>
				<p>Enclose the blue orbs before they explode. Gain bonus points by enclosing multiple orbs at once.</p>
				<a class="button" id="start-button" href="#">Start Game</a>
			</section>
		</div>
	</div>
	<script src="js/libs/jquery-1.6.2.min.js"></script>
	<script src="js/header.js"></script>
	<script src="js/util.js"></script>
	<script src="js/coil.js"></script>
<?php include ("../userprompt.inc.php"); ?> 
<?php include ("../../inc/footer.inc.php"); ?>    