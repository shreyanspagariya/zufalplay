<?php
include ("./inc/connect.inc.php"); 
session_start();
if(isset($_SESSION["email1"]))
{
	header("Location: ".$g_url);
}
?>
<!Doctype html>
<html>
	<head>
		<title>Zufalplay</title>
		<link href="css/bootstrap.min.css" rel="stylesheet"> 
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<link href="css/mystylesheet.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
        <link href="images/favico.png" rel="icon">  
        <link href='http://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
        <link href='https://www.google.com/fonts#QuickUsePlace:quickUse/Family:Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Sigmar+One' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="fa/css/font-awesome.min.css">
        
	</head>
	<body class="zfp-inner" style='margin-top:-50px;'>
		<div class="container">
			<br>
			<h3 align="center">Facebook Login</h3>
			<div class="container">
				<div class="alert alert-zfp hidden top_notif" role="alert" align="center"><p class="top_notif_msg"></p></div>
			</div>
			<hr>
			<div class="col-md-6">
				<div class="welcome-form elevatewhite" align="center">
					<br><h4>New User?</h4><br>
					<form class="" id="register-form"  method = "POST">
							<input type="text" name="fb_picture_url" id="fb_picture_url" value="<?php echo $_SESSION['fb_picture_url'];?>" hidden>
							<input type="text" name="campaign_id" id="campaign_id" value="<?php echo $_SESSION['campaign_id'];?>" hidden>
							<div class="row">
								<div class="col-md-6">
									<div class="input-group ">
										<input type="text" class="form-control fname" placeholder="First Name" aria-describedby="basic-addon1" name="fname" value="<?php echo $_SESSION['fname'];?>" disabled>
									</div>
									<p class="invalid_fname status"></p>
								</div>
								<div class="col-md-6">
									<div class="input-group ">
										<input type="text" class="form-control lname" placeholder="Last Name" aria-describedby="basic-addon1" name="lname" value="<?php echo $_SESSION['lname'];?>" disabled>
									</div>
									<p class="invalid_lname status"></p>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="">
									<div class="col-md-10 input-group ">
										<input type="text" class="form-control email" placeholder="Email ID - [Verification Required]" aria-describedby="basic-addon1" name="email">
									</div>
									<p class="invalid_email status"></p>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="">
									<div class="col-md-10 input-group ">
										<input type="password" class="form-control password" placeholder="Password" aria-describedby="basic-addon1" name="password">
									</div>
									<p class="invalid_password status"></p>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="">
									<div class="col-md-10 input-group ">
										<input type="password" class="form-control password1" placeholder="Re-enter Password" aria-describedby="basic-addon1" name="password1">
									</div>
									<p class="invalid_password1 status"></p>
								</div>
							</div>
							<br>
							<p class="signup-success"></p>								
							<button class="signup-btn btn btn-default btn-flat" onclick="validateEmail()" value="Sign-Up"><b>Sign Up</b></button><br><br>
							
					    </form>
				</div>
			</div>
			<div class="col-md-6">
				<div class="welcome-form elevatewhite" align="center">
				<br><h4>Already a User?</h4><br>
					<form class="navbar-form form-inline" id="login-form" method = "POST">
				        <div class="col-md-10 input-group ">
							<input type="text" class="form-control login_email" placeholder="Email" aria-describedby="basic-addon1" name = "email1">
						</div>
						<br><br>
						<div class="col-md-10 input-group ">
							<input type="password" class="form-control login_password" placeholder="Password" aria-describedby="basic-addon1" name = "password1">
						</div>
						<br><br>
						<button class="btn btn-default btn-flat" onclick="verifyLogin_FB()" value="Log-In"><b>Log In</b></button><br><br>
				    </form>
				</div>
				<br>
				<center>
				<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1489957891297107";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
					<div class='alert alert-zfp alert-dismissible' role='alert'>
			  	<div class='fb-like' data-href='https://www.facebook.com/zufalplay' data-layout='standard' data-action='like' data-show-faces='true' data-share='true'></div>
			  	</div>
			 </center>
			</div>
		</div>
		<br><br>
<script>
    var _gaq = _gaq || [];  
    _gaq.push(['_setAccount', 'UA-65871967-1']);  
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="<?php echo $g_url;?>js/signup_login.js"></script>
<script src="<?php echo $g_url;?>js/bootstrap.min.js"></script>
<script src="<?php echo $g_url;?>js/smoothscroll.js"></script>
<script src="<?php echo $g_url;?>notifications/notif.js"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var $_Tawk_API={},$_Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/55ca28dc9f1e65a7205a162c/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>