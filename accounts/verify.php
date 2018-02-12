<?php include("../inc/connect.inc.php"); ?>
<?php include("../inc/Crypto.php"); ?>
<?php
$gameweek = 0;

date_default_timezone_set('Asia/Kolkata');
$datetime = date("Y-m-d H:i:sa");

$encrypted_string = $_REQUEST['s'];
$decrypted_string = decrypt($encrypted_string,$encryption_key);
$decryptValues = explode('&', $decrypted_string);
$dataSize = sizeof($decryptValues);

for($i = 0; $i < $dataSize; $i++)
{
	$information = explode('=',$decryptValues[$i]);
	if($i==0)
		$uid = $information[1];
	if($i==1)
		$ver_code = $information[1];
}
$s_q="SELECT * FROM `table2` WHERE `Id`='".$uid."'";
$s_res=mysqli_query($con,$s_q);
if(mysqli_num_rows($s_res) > 0)
{
	$user = mysqli_fetch_assoc($s_res);
	if(trim($user['ver_code']) == mb_substr(trim($ver_code), 0, 10))
	{
	  $verified = $user['verified'];
	  $campaign_id = $user['campaign_id'];
	  $new_user_name = $user['fname']." ".$user['lname'];
	  if($verified==0)
	  {
		mysqli_query($con,"UPDATE campaign_leaderboard SET signups=signups+1 WHERE campaign_id='$campaign_id' AND game_week='$gameweek'");

		$query = "SELECT * FROM campaign_leaderboard WHERE campaign_id='$campaign_id' AND game_week='$gameweek'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$referrer_email = $get["user_email"];

		$query = "SELECT * from table2 where email='$referrer_email'";
		$result = mysqli_query($con,$query);
		$get = mysqli_fetch_assoc($result);
		$user_pointsx = $get['user_points'];
		$addpoints = 2;
		$user_pointsx+=$addpoints;

		mysqli_query($con,"UPDATE campaign_leaderboard SET rupees_earned=rupees_earned+'$addpoints' WHERE campaign_id='$campaign_id' AND game_week='$gameweek'");
		
		mysqli_query($con,"UPDATE table2 SET user_points='$user_pointsx' WHERE email='$referrer_email'");
		
		mysqli_query($con,"INSERT INTO account_transactions (user_email,user_points_after,bet_pseudo_id,transaction_description,transaction_time) 
				VALUES ('$referrer_email','$user_pointsx','$gameweek','Account credited Rs. $addpoints on inviting $new_user_name to Zufalplay.','$datetime')");

		mysqli_query($con,"INSERT INTO notifications (to_user,notif_text,notif_href,time_generated,seen) 
		VALUES ('$referrer_email','Account credited Rs. $addpoints on inviting $new_user_name to Zufalplay.','pointslog.php','$datetime','0')");
	  }
	  //UPDATE verified field in users table
	  $up_q="UPDATE table2 SET verified=1 WHERE `Id`='$uid' ";
	  mysqli_query($con,$up_q);
	  $msg = "Your email verification is successful!";
	}
	session_start();
	$_SESSION["email1"]=$user['email'];
	header("Location:".$g_url);

}
else
{
	$msg="Sorry some error occured in verifying your email! Try again or contact team@zufalplay.com for clarifications.";
}
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1489957891297107";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!Doctype html>
<html>
	<head>
		<title>Zufalplay</title>
		<link href="../css/bootstrap.min.css" rel="stylesheet"> 
		<link href="../css/bootstrap.css" rel="stylesheet">
		<link href="../css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="../css/bootstrap-theme.css" rel="stylesheet">
		<link href="../css/mystylesheet.css" rel="stylesheet">
		<link href="../css/style.css" rel="stylesheet">
        <link href="../images/favico.png" rel="icon">  
        <link href='http://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
        <link href='https://www.google.com/fonts#QuickUsePlace:quickUse/Family:Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Sigmar+One' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../fa/css/font-awesome.min.css">
        
	</head>
	<body class="hp">
		<nav class="navbar navbar-zfp">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		    	<a class="" href="#"><img alt="ZufalPlay" src="../images/logo.png"></a>
		    </div>
		  </div><!-- /.container-fluid -->
		</nav>
		<div class="container">
			<div class='alert alert-zfp alert-dismissible' role='alert'>
			  		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><i class='fa fa-times-circle'></i></button>
			  		<center>
			  			<div class='fb-like' data-href='https://www.facebook.com/zufalplay' data-layout='standard' data-action='like' data-show-faces='true' data-share='true'></div>
			  		</center>
			</div>
			<div class="col-md-3"></div>
			<div class="col-md-6" align="center">
				<h4><?php echo $msg;?></h4><br>
				<div class="alert alert-zfp hidden top_notif" role="alert" align="center"><p class="top_notif_msg"></p></div>
				<h2>Login Now</h2><hr>
				<form id="login-form" method="POST">
					<div class="row">
						<div class="">
							<div class="col-md-10 input-group trans">
								<input type="text" class="form-control login_email" placeholder="Email" aria-describedby="basic-addon1" name = "email1">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="">
							<div class="col-md-10 input-group trans">
								<input type="password" class="form-control login_password" placeholder="Password" aria-describedby="basic-addon1" name = "password1">
							</div>
						</div>
					</div>
					<br>							
					<button class="btn btn-default btn-flat" onclick="verifyLogin()" value="Save"><b>Login</b></button>
			    </form>
			</div>
		</div>
		

	<?php include ("../inc/footer.inc.php"); ?>