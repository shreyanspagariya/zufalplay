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
		$query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_id='16' AND game_week='0'";
		$result = mysqli_query($con,$query);
		$numResults = mysqli_num_rows($result);
		if($numResults == 0)
		{
			mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id) VALUES ('0','$email','0','0','16')");
			mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','1016','0','$datetime')");
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

	$play_id = generateRandomString()."TWINCARD";
	$query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='16'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);

	while($numResults!=0)
	{
		$play_id = generateRandomString()."TWINCARD";
		$query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='16'";
		$result = mysqli_query($con,$query);
		$numResults = mysqli_num_rows($result);
	}

	mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id) 
		VALUES ('$email','0','0','0','$play_id','$datetime','16')"); 
?>
<!doctype html> 
<html> 
<head>
<title>Card Game</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="control.js"></script>
<link rel="stylesheet" href="design.css">
<link href='https://fonts.googleapis.com/css?family=PT+Serif:700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
</head>

<?php
if(isset($_SESSION["email1"]))
{?>
<style>
.pushup {
	margin-top:-8px;
}
</style>
<div class="pushup">
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10; border-color: #000; border-width: 1px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
  <div class="container">
  	<div class="col-md-8">
    	<ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_g_url; ?>">Play Twin Cards</a></li>
        <li class=""><a data-toggle='modal' data-target='#twin-cards-rules'>Rules</a></li>
        <li><a href="<?php echo $g_url.'games/leaderboard.php?game=twin-cards'?>">Leaderboard</a></li>
		    <li>
          <div style="margin-top:4px;">
            &nbsp;&nbsp;&nbsp;
            <div class="fb-share-button" 
              data-href="<?php echo $g_url;?>games/twin-cards/" 
              data-layout="button">
            </div>
          </div>
        </li>
      </ul>
  	</div>
  </div>
</footer> 
</div>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<body class="zfp-inner">
	<div class="container">
	    <br><br>
	    <div id="beforegame">
		    <div class="gamecard pitch">
		    	<center>
		    		<h3>How much money would you like to pitch?</h3><br>
		    		<h4>If you win, you'll get back <b>DOUBLE</b> the money.</h4><br><br>
		    		<form onsubmit="return false;" autocomplete="off">
				    	<input class="" id="zufals_pitched" autofocus>&nbsp;
				    	<button onclick="complete_pitch()"><font color='black'><b>Go</b></font></button><br><br>
				    </form>
				    <p id="zufals-insufficient"></p>
				    <br>
				</center>
		    </div>
		    <br>
		    <center>
		     	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> 
				<ins class="adsbygoogle"
				     style="display:inline-block;width:728px;height:90px"
				     data-ad-client="ca-pub-7888738492112143"
				     data-ad-slot="8311271319"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</center>
		</div>
		<script>
			function complete_pitch()
			{

				var zufals_pitched = document.getElementById("zufals_pitched").value;
				var play_id = document.getElementById('play_id').value;

				$("#beforegame").addClass("hidden");
				$(".game-loading").removeClass("hidden");

				$.ajax(
				{
				  	url: "addscore.php",
				  	dataType: "json",
				  	type:"POST",
				  	data:
				  	{
						mode:"pitch_zufals",
						zufals_pitched:zufals_pitched,
						play_id:play_id,
				  	},
				  	success: function(json)
				  	{
				  		if(json.status == 1)
				  		{
				  			$("#user_points").html(Math.floor(json.user_points*100)/100);
							$('.top_notif').removeClass('hidden');
					        $('.top_notif').addClass('animated slideInUp');
					        $('.top_notif_msg').html("<div class='hrwhite'>"+json.notif_text+"</div>"+"<br><div class='pull-left'><i class='fa fa-bell'></i>&nbsp;<small>New Notification</small></div><div class='pull-right'><i class='fa fa-clock-o'></i>&nbsp;<small>Just Now</small></div><br>");
					        	
					        	var sound = new Audio("<?php echo $g_url?>inc/notification.mp3");
								sound.play();

					        setTimeout(function()
					        {
					        	$('.top_notif').removeClass('animated slideInUp');
					            $('.top_notif').addClass('animated fadeOut');

					            $('#aftergame').removeClass("hidden");
					            $(".game-loading").addClass("hidden");

							}, 2000)
						}
						else if(json.status == 0)
						{
							$("#beforegame").removeClass("hidden");
							$(".game-loading").addClass("hidden");
							$("#zufals-insufficient").html("<br><b>Sorry, you cannot pitch-in more money than you have in your account.</b>");
						}
						else if(json.status == -1)
						{
							$("#beforegame").removeClass("hidden");
							$(".game-loading").addClass("hidden");
							$("#zufals-insufficient").html("<br><b>Sorry, you cannot pitch-in negative money.</b>");
						}
					},
					error : function()
					{
						
					}
				});
			}
		</script>
		<center>
			<img style="margin-top:150px;" class="game-loading hidden" src="<?php echo $g_url?>images/loading2.gif">
		</center>
		<div id="aftergame" class="hidden">
			<br>
		<div id="mainbox">
			<font id="game_status">
				
			</font>
			<div id="card_1">
				<font id="start_game_text">
					Start Game!
				</font>
			</div>

			<div id="animator_player_1">
				<font id="num_top">
					
				</font>
				<font id="num_bottom">
					
				</font>
				<font id="deck_type">
					
				</font>
			</div>

			<div id="card_player_1">
				<font id="cards_number_1">
					26 Cards Left
				</font>
				<font id="player_1_id">
					Player-1 (You)
				</font>
			</div>

			<div id="animator_player_2">
				<font id="num_top_2">
					
				</font>
				<font id="num_bottom_2">
					
				</font>
				<font id="deck_type_2">
					
				</font>
			</div>

			<div id="card_player_2">
				<font id="cards_number_2">
					26 Cards Left
				</font>
				<font id="player_2_id">
					Player-2 (Opponent)
				</font>
			</div>

			<font id="cards_number_main">
				0 cards left
			</font>

		</div>
		</div>
<?php
}
else
{?>
<style>
.pushup {
	margin-top:52px;
}
</style>
<div class="pushup">
<footer class="footer navbar-fixed" style="background-color:#382762;width: 100%;position: fixed;z-index: 10; border-color: #000; border-width: 1px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
  <div class="container">
  	<div class="col-md-8">
    	<ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_g_url; ?>">Play Twin Cards</a></li>
        <li class=""><a data-toggle='modal' data-target='#twin-cards-rules'>Rules</a></li>
        <li><a href="<?php echo $g_url.'games/leaderboard.php?game=twin-cards'?>">Leaderboard</a></li>
		    <li>
          <div style="margin-top:4px;">
            &nbsp;&nbsp;&nbsp;
            <div class="fb-share-button" 
              data-href="<?php echo $g_url;?>games/twin-cards/" 
              data-layout="button">
            </div>
          </div>
        </li>
      </ul>
  	</div>
  </div>
</footer> 
</div>
<input class="trans" id="zufals_pitched" hidden>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<body>
	<br>
		<div id="mainbox">
			<font id="game_status">
				
			</font>
			<div id="card_1">
				<font id="start_game_text">
					Start Game!
				</font>
			</div>

			<div id="animator_player_1">
				<font id="num_top">
					
				</font>
				<font id="num_bottom">
					
				</font>
				<font id="deck_type">
					
				</font>
			</div>

			<div id="card_player_1">
				<font id="cards_number_1">
					26 Cards Left
				</font>
				<font id="player_1_id">
					Player-1 (You)
				</font>
			</div>

			<div id="animator_player_2">
				<font id="num_top_2">
					
				</font>
				<font id="num_bottom_2">
					
				</font>
				<font id="deck_type_2">
					
				</font>
			</div>

			<div id="card_player_2">
				<font id="cards_number_2">
					26 Cards Left
				</font>
				<font id="player_2_id">
					Player-2 (Opponent)
				</font>
			</div>

			<font id="cards_number_main">
				0 cards left
			</font>

		</div>

</body>


</html>
<?php
}
?>
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>