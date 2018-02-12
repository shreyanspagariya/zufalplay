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
		$query = "SELECT * FROM game_leaderboard WHERE user='$email' AND game_id='2' AND game_week='0'";
		$result = mysqli_query($con,$query);
		$numResults = mysqli_num_rows($result);
		if($numResults == 0)
		{
			mysqli_query($con,"INSERT INTO game_leaderboard (game_week,user,high_score,zufals_earned,game_id) VALUES ('0','$email','0','0','2')");
			mysqli_query($con,"INSERT INTO profile_tempfill (user_email,game_id,gameweek,time) VALUES ('$email','2','0','$datetime')");
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

	$play_id = generateRandomString()."HANDC";
	$query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='2'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);

	while($numResults!=0)
	{
		$play_id = generateRandomString()."HANDC";
		$query = "SELECT * FROM game_playhistory WHERE play_id='$play_id' AND game_id='2'";
		$result = mysqli_query($con,$query);
		$numResults = mysqli_num_rows($result);
	}

	mysqli_query($con,"INSERT INTO game_playhistory (user_played,final_score,game_week,isout,play_id,time_played,game_id) 
		VALUES ('$email','0','0','0','$play_id','$datetime','2')"); 
?>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php
if(isset($_SESSION["email1"]))
{?>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<body class="zfp-inner">
	<div class="container">
	    <br><br>
	    <div id="beforegame">
		    <div class="gamecard pitch">
		    	<center>
		    		<h3>How much money would you like to pitch?</h3><br>
		    		<h4>The more money you pitch, the more you earn.</h4><br><br>
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
			<img style="background-color:rgba(0,0,0,0.6); margin-top:150px;" class="game-loading hidden" src="<?php echo $g_url?>images/loading2.gif">
		</center>
		<div id="aftergame" class="gamecard hidden">
			<center>
					<h3>Score: <strong style="font-size:32px"><span id="totalruns" >0</span>*</strong>(<span id="totalballs">0</span>)</h3><br>
			<div class="row">
				<div class="col-md-2"><br>
					<div class="btn-group btn-group-vertical" role="group" aria-label="...">
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="one" onclick="f(1)">1</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="two" onclick="f(2)">2</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="three" onclick="f(3)">3</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="four" onclick="f(4)">4</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="five" onclick="f(5)">5</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="six" onclick="f(6)">6</button>
					</div>
				</div>
				<div class="col-md-3">
					<h3><?php echo $fname;?></h3>
					<img id="hi" src="images/bat.jpg" style='border:1px solid #000;'>
				</div>
				<div class="col-md-2">
					<img class="versus" src="images/vs.png">
				</div>
				<div class="col-md-3">
					<h3>Zufalplay</h3>
					<img id="by" src="images/cricketball.png" style='border:1px solid #000;'>
				</div>
				<div class="col-md-2"><br>
					<div class="btn-group btn-group-vertical" role="group" aria-label="...">
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="one1" onclick="f(1)" disabled>1</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="two1" onclick="f(2)" disabled>2</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="three1" onclick="f(3)" disabled>3</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="four1" onclick="f(4)" disabled>4</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="five1" onclick="f(5)" disabled>5</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="six1" onclick="f(6)" disabled>6</button>
					</div>
				</div>
			</div>
			<div class="runs btn-group btn-group-vertical" role="group" aria-label="...">
				
			</div>
			<p id="runs"></p>
			</center>
		</div>
	</div>
	
	<p id="totalruns"></p>
	<p id="runs"></p>
	<p id="go"></p>
	
	<form action="submitscore.php" method="POST" id="submitscore">
	</form>
	<form action="cheating.php" method="POST" id="cheating">
	</form>
	<script src="js/handcricket.js"></script>
	
</body>
<?php
}
else
{?>
<input class="trans" id="zufals_pitched" hidden>
<input id="play_id" value="<?php echo $play_id;?>" hidden>
<body class="zfp-inner">
	<div class="container">
	    <br><br>
		<div class="gamecard game">
			<center>
					<h3>Score: <strong style="font-size:32px"><span id="totalruns" >0</span>*</strong>(<span id="totalballs">0</span>)</h3><br>
			<div class="row">
				<div class="col-md-2"><br>
					<div class="btn-group btn-group-vertical" role="group" aria-label="...">
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="one" onclick="f(1)">1</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="two" onclick="f(2)">2</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="three" onclick="f(3)">3</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="four" onclick="f(4)">4</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="five" onclick="f(5)">5</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="six" onclick="f(6)">6</button>
					</div>
				</div>
				<div class="col-md-3">
					<h3>Extuser</h3>
					<img id="hi" src="images/bat.jpg" style='border:1px solid #000;'>
				</div>
				<div class="col-md-2">
					<img class="versus" src="images/vs.png">
				</div>
				<div class="col-md-3">
					<h3>Zufalplay</h3>
					<img id="by" src="images/cricketball.png" style='border:1px solid #000;'>
				</div>
				<div class="col-md-2"><br>
					<div class="btn-group btn-group-vertical" role="group" aria-label="...">
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="one1" onclick="f(1)" disabled>1</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="two1" onclick="f(2)" disabled>2</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="three1" onclick="f(3)" disabled>3</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="four1" onclick="f(4)" disabled>4</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="five1" onclick="f(5)" disabled>5</button>
						<button class="btn outline btn-lg btn-flat btn-default" type="button" id="six1" onclick="f(6)" disabled>6</button>
					</div>
				</div>
			</div>
			<div class="runs btn-group btn-group-vertical" role="group" aria-label="...">
				
			</div>
			<p id="runs"></p>
			</center>
		</div>
	</div>
	
	<p id="totalruns"></p>
	<p id="runs"></p>
	<p id="go"></p>
	
	<form action="submitscore.php" method="POST" id="submitscore">
	</form>
	<form action="cheating.php" method="POST" id="cheating">
	</form>
	<script src="js/handcricket.js"></script>
	
</body>
<?php
}
?>
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>		