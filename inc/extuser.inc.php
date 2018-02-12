<?php include("connect.inc.php"); 
include("metatags.inc.php"); 
if(isset($_SESSION["email1"]))
{
	$email = $_SESSION["email1"];
}
else
{
	$email = "";
}
$query = "SELECT * from table2 where email='$email'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);
$get = mysqli_fetch_assoc($result);
$user_id_x = $get['Id'];
$fname = $get['fname'];
$lname = $get['lname'];
$user_points = $get['user_points'];	
$isverified = $get['verified'];
$unique_name = $get['unique_name'];
if($unique_name == "")
{
	$unique_name = strtolower(str_replace(' ','',$fname)).".".strtolower(str_replace(' ','',$lname)).".".$user_id_x;
	mysqli_query($con,"UPDATE table2 SET unique_name = '$unique_name' WHERE Id='$user_id_x'");
}
?>
<?php
	if(isset($_SESSION["email1"]))
	{
		$query = "SELECT * FROM notifications WHERE seen='0' AND to_user='$email'";
		$result = mysqli_query($con,$query);
		$num_notif = mysqli_num_rows($result);
	}
	else
	{
		$num_notif = 0;
	}
?>
<!Doctype html>
<html>
	<head>
		<link href="<?php echo $g_url;?>css/bootstrap.min.css" rel="stylesheet"> 
		<link href="<?php echo $g_url;?>css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo $g_url;?>css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="<?php echo $g_url;?>css/bootstrap-theme.css" rel="stylesheet">
		<link href="<?php echo $g_url;?>css/animate.css" rel="stylesheet">
		<link href="<?php echo $g_url;?>css/mystylesheet.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
		<link href="<?php echo $g_url;?>css/style.css" rel="stylesheet">
		<link href="<?php echo $g_url;?>games/style.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $g_url;?>fa/css/font-awesome.min.css">
		<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
        <link href="<?php echo $g_url;?>images/favico.png" rel="icon">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

        <meta name="google-signin-scope" content="profile email">
	    <meta name="google-signin-client_id" content="7670027949-vv65nuk73eitqb4qi7f9v5kr5rl7hn0f.apps.googleusercontent.com">
	    <script src="https://apis.google.com/js/platform.js" async defer></script>

        <meta property="fb:app_id" content="<?php echo $fb_app_id;?>" />
        <meta property="og:url" content="<?php echo $fb_og_url;?>" />
		<meta property="og:type" content="<?php echo $fb_og_type;?>" />
		<meta property="og:title" content="<?php echo $fb_og_title;?>" />
		<meta property="og:description" content="<?php echo $fb_og_description;?>" />
		<meta property="og:image" content="<?php echo $fb_og_image;?>" />
		<meta property="og:image:width" content="<?php echo $fb_og_image_width;?>" />
		<meta property="og:image:height" content="<?php echo $fb_og_image_height;?>" />
	</head>
<?php
date_default_timezone_set('Asia/Kolkata');
function time_elapsed_string($datetime, $full = false) {
	
   $time = time() - strtotime($datetime); // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'')." ago";
    }
}

function top_banner_extuser()
{
	global $g_url;
	global $email;
	global $con;
	global $fname;
	global $user_points;
	global $strtop;
	global $isverified;
	global $lname;
    global $num_notif;
	if($user_points > 90)
	{
		$battery = 4;
	}
	else if($user_points > 60)
	{
		$battery = 3;
	}
	else if($user_points > 40)
	{
		$battery = 2;
	}
	else if($user_points > 10) 
	{
		$battery = 1;
	}
	else
	{
		$battery = 0;
	}
	/*Invite & Earn Campaign*/
	if(isset($_GET['campaign_id']))
	{
		$campaign_id=mysqli_real_escape_string($con,$_GET['campaign_id']);
	}
	else
	{
		$campaign_id="";
	}
	$go_to_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	?>
		<div class="navbar navbar-zfp-inner navbar-fixed-top">
		  	<div class="container-fluid">
		    	<div class="navbar-header">
		      		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		        		<span class="icon-bar" style="background-color:#382762;"></span>
		        		<span class="icon-bar" style="background-color:#382762;"></span>
		        		<span class="icon-bar" style="background-color:#382762;"></span>
		      		</button>
		      		<a onclick='sidebar_toggle()' id='sidebar-toggle-button' hidden><font size='4'><i class="fa fa-bars" aria-hidden="true"></i></font></a>
		      		<a class="" href="<?php echo $g_url;?>"><img alt="Zufalplay" src="<?php echo $g_url;?>images/logo10.png"></a>
		    	</div>
		    <div class="navbar-collapse collapse" id="searchbar">
		   	
		    <ul class="nav navbar-nav navbar-right">
			    <li class=""><a href="<?php echo $g_url; ?>"><i class="fa fa-home"></i> Home<sup></sup></a></li>
			    <li class=""><a href='' data-toggle='modal' data-target='#login-login-modal'><i class="fa fa-sign-in"></i> Login</a></li>
			    <li class=""><a href='' data-toggle='modal' data-target='#signup-login-modal'><i class="fa fa-user-plus"></i> Signup</a></li>
			    <li class="hidden">
			     	<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1489957891297107";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>

					<script>
					  // This is called with the results from from FB.getLoginStatus().
					  function statusChangeCallback(response) {
					    //console.log('statusChangeCallback');
					    //console.log(response);
					    // The response object is returned with a status field that lets the
					    // app know the current login status of the person.
					    // Full docs on the response object can be found in the documentation
					    // for FB.getLoginStatus().
					    if (response.status === 'connected') {
					      // Logged into your app and Facebook.
					      testAPI();
					    } else if (response.status === 'not_authorized') {
					      // The person is logged into Facebook, but not your app.
					      //document.getElementById('status').innerHTML = 'Please log ' +'into this app.';
					    } else {
					      // The person is not logged into Facebook, so we're not sure if
					      // they are logged into this app or not.
					      //document.getElementById('status').innerHTML = 'Please log ' +'into Facebook.';
					    }
					  }

					  // This function is called when someone finishes with the Login
					  // Button.  See the onlogin handler attached to it in the sample
					  // code below.
					  function checkLoginState() {
					    FB.getLoginStatus(function(response) {
					      statusChangeCallback(response);
					    });
					  }

					  window.fbAsyncInit = function() {
					  FB.init({
					    appId      : '1489957891297107',
					    cookie     : true,  // enable cookies to allow the server to access 
					                        // the session
					    xfbml      : true,  // parse social plugins on this page
					    version    : 'v2.4' // use version 2.2
					  });

					  // Now that we've initialized the JavaScript SDK, we call 
					  // FB.getLoginStatus().  This function gets the state of the
					  // person visiting this page and can return one of three states to
					  // the callback you provide.  They can be:
					  //
					  // 1. Logged into your app ('connected')
					  // 2. Logged into Facebook, but not your app ('not_authorized')
					  // 3. Not logged into Facebook and can't tell if they are logged into
					  //    your app or not.
					  //
					  // These three cases are handled in the callback function.

					  function doLogin() {
					  FB.getLoginStatus(function(response) {
					    statusChangeCallback(response);
					    if (response.status === 'connected') {
					    //console.log(response.authResponse.accessToken);
					  }

					  });
					}

					  };

					  // Load the SDK asynchronously
					  (function(d, s, id) {
					    var js, fjs = d.getElementsByTagName(s)[0];
					    if (d.getElementById(id)) return;
					    js = d.createElement(s); js.id = id;
					    js.src = "//connect.facebook.net/en_US/sdk.js";
					    fjs.parentNode.insertBefore(js, fjs);
					  }(document, 'script', 'facebook-jssdk'));

					  // Here we run a very simple test of the Graph API after login is
					  // successful.  See statusChangeCallback() for when this call is made.
					  function testAPI() {
					    //console.log('Welcome!  Fetching your information.... ');
					     FB.api('/me?fields=id,name,email,first_name,last_name,picture', function(response) {
					  	//console.log(response.picture.data.url);
					  	//console.log(response);

					  	$('#login-login-modal .modal-body .beforesubmit').addClass('hidden');
					  	$('#signup-login-modal .modal-body .beforesubmit').addClass('hidden');
  						$('.signup-loading').removeClass('hidden');
  						$('.login-loading').removeClass('hidden');

  						var campaign_id = $('.campaign_id').val();

					  	 $.ajax(
				        {
				          url: "<?php echo $g_url; ?>fbsigninbackend.php",
				          dataType: "json",
				          type:"POST",

				          data:
				          {
				            mode:'get_idtoken',
				            user:response,
				            campaign_id:campaign_id,
				          },

				          success: function(json)
				          {
				            if(json.status==1)
				            {
				            	if(json.user==1)
				            	{
				            		if(json.verified==1)
				            		{
				            			location.reload();
				            		}
				            		else
				            		{
				            			$('#login-login-modal .modal-body .beforesubmit').removeClass('hidden');
  										$('.login-loading').addClass('hidden');
  										$('#signup-login-modal .modal-body .beforesubmit').removeClass('hidden');
  										$('.signup-loading').addClass('hidden');
				            			$('.invalid_email_or_password').html('<br><b>Your email is not verified. Please verify your email account to continue.</b>');
				            		}
				            	}
				            	else
				            	{
				            		window.location.replace("<?php echo $g_url; ?>fbwelcome.php");
				            	}
				            }
				            else
				            {
				              //console.log('Hi');
				            }
				          },

				          error : function()
				       	  {
				            //console.log("something went wrong");
				          }
				        });

					      //console.log('Successful login for: ' + response.name);
					      //document.getElementById('status').innerHTML ='Thanks for logging in, ' + response.name + '!';
					    });
					  }
					</script>

					
					  <!--Below we include the Login Button social plugin. This button uses
					  the JavaScript SDK to present a graphical Login button that triggers
					  the FB.login() function when clicked.-->
					
					<div class="fb-login-button" onlogin="checkLoginState();" style="margin-top:13px; margin-right:20px;" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>

					<div id="status">
					</div>
			     </li>
			     <li class="hidden">
			     	<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark" style="margin-top:7px;"></div>
				    <script>
				      function onSignIn(googleUser) {
				        // Useful data for your client-side scripts:
				        var profile = googleUser.getBasicProfile();
				        //console.log("ID: " + profile.getId()); // Don't send this directly to your server!
				        //console.log("Name: " + profile.getName());
				        //console.log("Image URL: " + profile.getImageUrl());
				        //console.log("Email: " + profile.getEmail());

				        // The ID token you need to pass to your backend:
				        var id_token = googleUser.getAuthResponse().id_token;
				        //console.log("ID Token: " + id_token);

				        $('#login-login-modal .modal-body .beforesubmit').addClass('hidden');
  						$('.login-loading').removeClass('hidden');
  						$('#signup-login-modal .modal-body .beforesubmit').addClass('hidden');
 						$('.signup-loading').removeClass('hidden');

 						var campaign_id = $('.campaign_id').val();

				        $.ajax(
				        {
				          url: "<?php echo $g_url;?>googlesigninbackend.php",
				          dataType: "json",
				          type:"POST",

				          data:
				          {
				            mode:'get_idtoken',
				            id_token:id_token,
				            campaign_id:campaign_id,
				          },

				          success: function(json)
				          {
				            if(json.status==1)
				            {
				              	if(json.user==0)
				            	{
				              		window.location.replace("<?php echo $g_url; ?>welcome.php?go_to_url="+encodeURIComponent("<?php echo $go_to_url;?>"));
				              	}
				              	else if(json.user==1)
				              	{
				              		location.reload();
				              	}
				            }
				            else
				            {
				              //console.log('Hi');
				            }
				          },

				          error : function()
				          {
				            //console.log("something went wrong");
				          }
				        });

				      };
				    </script>
				    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

			     </li>
			    <li>
			    <style>
			    	.pushleft 
			    	{
			    		margin-right:30px;
			    	}
			    </style>
			    <div class="collapse navbar-collapse pull-right pushleft" id="navbar_top_functions">	
			      <!--<form class="navbar-form form-inline hidden" id="login-form" method = "POST">
			        <div class="input-group trans">
						<input type="text" class="form-control login_email" placeholder="Email" aria-describedby="basic-addon1" name = "email1">
					</div>
					<div class="input-group trans">
						<input type="password" class="form-control login_password" placeholder="Password" aria-describedby="basic-addon1" name = "password1">
					</div>
					<button class="btn btn-default outline" onclick="verifyLogin()" value="Log-In">Log In</button>
			      </form>-->
			    </div><!-- /.navbar-collapse -->
			    </li>
		    </ul>
		     
		    <form class="navbar-form" role="search" action = "<?php echo $g_url;?>searchusers.php" method = "GET" autocomplete="off">
		        <div class="form-group" style="display:inline;">
		          	<div class="input-group" style="display:table;">
				        <input style="border-radius:0px;" type="text" id='querybox' name="query" class="form-control" placeholder="Search Zufalplay for Games, Videos & more..." onkeyup="suggest_search(this.value)">
				        <span class="showsuggest"></span>
				        <span type="submit" class="input-group-addon" style="width:1%; border-radius:0px;"><i class="fa fa-search"></i></span>
		          	</div>
		        </div>
		    </form>

		    </div><!--/.nav-collapse -->
		  </div>
		</div>

		<div class="container">
			<div class="alert alert-zfp hidden top_notif" role="alert" align="center"><p class="top_notif_msg"></p></div>
		</div>

		<div class="modal" id="signup-login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <center><h4 class="modal-title" id="myModalLabel">Sign Up</h4></center>
		      </div>
		      <div class="modal-body">
			      <div class="beforesubmit">
			      <center>
			       <div class="row">
			      	<!--<div class="col-md-6 fb-login-button" onlogin="checkLoginState();" style="margin-top:13px; margin-right:20px;" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>-->
			      	<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark" style="margin-top:7px;"></div>
				  </div>
		  			<br><br>
		    		<!--<div style="border-top: #9D9D9D dashed 1.5px;"><span style="background-color:white; position:relative; top: -0.8em; left:0.63%;">&nbsp;OR&nbsp;</span></div><br>-->
			      	<form class="" id="register-form"  method = "POST">
							<!--<div class="row">
								<div class="col-md-6">
									<div class="input-group">
										<input type="text" class="form-control fname" placeholder="First Name" aria-describedby="basic-addon1" name="fname">
									</div>
									<p class="invalid_fname status"></p>
								</div>
								<div class="col-md-6">
									<div class="input-group">
										<input type="text" class="form-control lname" placeholder="Last Name" aria-describedby="basic-addon1" name="lname">
									</div>
									<p class="invalid_lname status"></p>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="">
									<div class="col-md-10 input-group">
										<input type="text" class="form-control email" placeholder="Email" aria-describedby="basic-addon1" name="email">
									</div>
									<p class="invalid_email status"></p>
									<img class="dupemail-loading hidden" src="<?php echo $g_url?>images/loading.gif">
								</div>
							</div>
							<br>
							<div class="row">
								<div class="">
									<div class="col-md-10 input-group">
										<input type="password" class="form-control password" placeholder="Password" aria-describedby="basic-addon1" name="password">
									</div>
									<p class="invalid_password status"></p>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="">
									<div class="col-md-10 input-group">
										<input type="password" class="form-control password1" placeholder="Re-enter Password" aria-describedby="basic-addon1" name="password1">
									</div>
									<p class="invalid_password1 status"></p>
								</div>
							</div>
							<br>-->	
							Already have an account?
							<a href='' data-toggle='modal' data-dismiss='modal' data-target='#login-login-modal'><b>Login</b></a>
							<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
							<input class='campaign_id' value='<?php echo $campaign_id;?>' hidden>					
							<!--<button class="signup-btn btn btn-primary btn-flat" onclick="validateEmail()" value="Sign-Up" id="signup-button">Sign Up</button><br>-->
					    </form>
					</center>
			      </div>
			      <div class="aftersubmit">
			      	<center>
				      <img class="signup-loading hidden" src="<?php echo $g_url?>images/loading.gif">
				      <p class="signup-success"></p>
				    </center>
			      </div>
		      </div>
		    </div>
		  </div>
		</div>
		<div class="modal" id="login-login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <center><h4 class="modal-title" id="myModalLabel">Log In</h4></center>
		      </div>
		      <div class="modal-body">
		      <div class="beforesubmit">
			      <center>
			       <div class="row">
				      <!--<div class="col-md-6 fb-login-button" onlogin="checkLoginState();" style="margin-top:13px; margin-right:20px;" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>-->
				      <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark" style="margin-top:7px;"></div>
				   </div>
		  			<br><br>
		    		<div style="border-top: #9D9D9D dashed 1.5px;"><span style="background-color:white; position:relative; top: -0.8em; left:0.63%;">&nbsp;OR&nbsp;</span></div><br>
			      	<form onsubmit="return false;" class="navbar-form form-inline" id="login-form_modal" method = "POST">
				        <div class="input-group">
							<input type="text" class="form-control login_email_modal" placeholder="Email" aria-describedby="basic-addon1" name = "email1">
						</div>
						<br><br>
						<div class="input-group">
							<input type="password" class="form-control login_password_modal" placeholder="Password" aria-describedby="basic-addon1" name = "password1">
						</div>
						<br>
						<p class="invalid_email_or_password status"></p>
						<br>
						<button class="login-btn btn btn-primary btn-flat" onclick="verifyLogin()" value="Log-In">Log In</button><br><br>
						Don't have an account?
						<a href='' data-toggle='modal' data-dismiss='modal' data-target='#signup-login-modal'><b>Signup</b></a>
			      	</form>
				  </center>
				</div>
				<div class="aftersubmit">
					<center><img class="login-loading hidden" src="<?php echo $g_url?>images/loading.gif"></center>
				</div>
		      </div>
		    </div>
		  </div>
		</div>
	<?php
}
function top_banner()
{
	global $g_url;
	global $email;
	global $con;
	global $fname;
	global $user_points;
	global $strtop;
	global $isverified;
	global $lname;
    global $total;
	if($user_points > 90)
	{
		$battery = 4;
	}
	else if($user_points > 60)
	{
		$battery = 3;
	}
	else if($user_points > 40)
	{
		$battery = 2;
	}
	else if($user_points > 10) 
	{
		$battery = 1;
	}
	else
	{
		$battery = 0;
	}
    $query = "SELECT * from campaign_current_gameweek where id='1'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$gameweek = $get['game_week'];
	$query = "SELECT * from campaign_leaderboard where user_email='$email' AND game_week='$gameweek'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	global $urlreg;
	$urlreg=0;
	if($numResults==0)
	{
		$urlreg=1;
	}
	?>

	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1489957891297107";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

		<div class="navbar navbar-zfp-inner navbar-fixed-top">
		  	<div class="container-fluid">
		    	<div class="navbar-header">
		      		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		        		<span class="icon-bar" style="background-color:#382762;"></span>
		        		<span class="icon-bar" style="background-color:#382762;"></span>
		        		<span class="icon-bar" style="background-color:#382762;"></span>
		      		</button>
		      		<a onclick='sidebar_toggle()' id='sidebar-toggle-button' hidden><font size='4'><i class="fa fa-bars" aria-hidden="true"></i></font></a>
		      		<a class="" href="<?php echo $g_url;?>"><img alt="Zufalplay" src="<?php echo $g_url;?>images/logo10.png"></a>
		    	</div>
		    <div class="navbar-collapse collapse" id="searchbar" style='margin-right:1.5%;'>
		   	
		    <ul class="nav navbar-nav navbar-right">
		    	<li class=""><a href='#' data-toggle='modal' data-dismiss='modal' data-target='#amount-multiplier-modal'><span id="amount_multiplier"></span></a></li>
                <li class=""><a href="<?php echo $g_url; ?>"><i class="fa fa-home"></i> Home<sup></sup></a></li>          
                <!--<li class="" <?php if($urlreg == 1){ echo "onclick='showregModal_campaign()'";} else{ echo "onclick='enter_campaign()'";} ?> style="cursor: pointer;"><a><i class="fa fa-diamond"></i> Invite & Earn</a></li>-->
		        <li><a href="<?php echo $g_url.'htoprofile.php'; ?>"><i class="fa fa-user"></i> <?php echo $fname;?></a></li>
				<li class=""><a href="<?php echo $g_url.'pointslog.php'; ?>"><b>Rs.</b> <span id='user_points'><?php echo number_format(floor($user_points*100)/100,2,'.','');?></span></a></li>
				<?php 
				/* Code for fetching notifications */
				if($email)
				{
					$getnotifs = mysqli_query($con,"SELECT * FROM notifications WHERE to_user='$email' AND seen=0 ORDER BY time_generated DESC LIMIT 10");
	            	$numnotifs = mysqli_num_rows($getnotifs);
	
	        	?>
	        		<li class="dropdown" <?php if($numnotifs == 0){ echo "data-toggle='tooltip' data-placement='bottom' title='No unread Notifications'";}?>><a class="dropdown-toggle" href='#' data-toggle='dropdown' data-hover="false" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i><?php if($numnotifs){?><sup><span class="badge" id="unseenbadge" style='background-color:red;'><?php if($numnotifs == 10){echo "10+";}else{echo $numnotifs;}?></span></sup><?php }?></a>
	        		<!-- Dropdown Structure -->
	        		<ul class='dropdown-menu'>
	        	<?php
	            	while($notifrow = mysqli_fetch_assoc($getnotifs))
	            	{
	              		$notif_id = $notifrow['notif_id'];
	              		$notif_text = $notifrow['notif_text'];
	              		$notif_href = $notifrow['notif_href'];
	        	?>
	            		<li style="width:500px;"><p style="margin-left:5px;margin-right:5px"><a style="color:#000;text-decoration:none" href='<?php echo $g_url.$notif_href;?>' onclick="notifread(<?php echo $notif_id;?>); return true;" class=""><?php echo $notif_text;?><small class="pull-right" style="color:#000;"><?php echo time_elapsed_string($notifrow['time_generated']); ?></small></a></p></li>
	            		<li role="separator" class="divider"></li>
	        	<?php
	            	}//End while 
	        	?>
	          			
	          		<li><a href="<?php echo $g_url.'notifications/'; ?>" class="blue-text">See All Notifications</a></li>
	        		</ul>
	        		</li>
	        	<?php
					}//End if
				?>
				<li class="dropdown">
			      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> <i class="fa fa-caret-down"></i></a>
			      <ul class="dropdown-menu">
                                
	                <?php 
				    if($email == "shreyanspagariya@gmail.com")
					{?>  
						<li class=""><a href="<?php echo $g_url.'admin.php'; ?>"><i class="fa fa-lock"></i> Admin<sup></sup></a></li>
	                    <li role="separator" class="divider"></li>
					<?php
					}
					?>
                 
			        <li><a href="<?php echo $g_url.'settings.php'; ?>">Change Password</a></li>
                                
					<li role="separator" class="divider"></li>
			        
			         <li><a href="<?php echo $g_url.'logout.php'; ?>" onclick="signOut();">Log Out</a></li>

			         <script>
				    function onLoad() {
				      gapi.load('auth2', function() {
				        gapi.auth2.init();
				      });
				    }
				  	</script>
				  	<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

			        <script>
					  function signOut() {
					    var auth2 = gapi.auth2.getAuthInstance();
					    auth2.signOut().then(function () {
					      console.log('User signed out.');
					    });
					}
					</script>
					
			      </ul>
			    </li>
		      </ul>
		      <form class="navbar-form" role="search" action = "<?php echo $g_url;?>searchusers.php" method = "GET" autocomplete="off">
		        <div class="form-group" style="display:inline;">
		          	<div class="input-group" style="display:table;">
				        <input style="border-radius:0px;" type="text" id='querybox' name="query" class="form-control" placeholder="Search Zufalplay for Games, Videos & more..." onkeyup="suggest_search(this.value)">
				        <span class="showsuggest"></span>
				        <span type="submit" class="input-group-addon" style="width:1%; border-radius:0px;"><i class="fa fa-search"></i></span>
		          	</div>
		        </div>
		    </form>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</div>
	<?php
}

//Automatic Challenge Locking System

date_default_timezone_set("Asia/Kolkata");
$datetime_now = date("Y-m-d H:i:sa");
mysqli_query($con,"UPDATE bets SET bet_result_status=1 WHERE bet_result_status=0 AND start_time<='$datetime_now'");

//Unique Name SETALL if Empty

$getposts = mysqli_query($con,"SELECT * FROM table2 WHERE unique_name=''");
while($row = mysqli_fetch_assoc($getposts))
{
	$fname = $row['fname'];
	$lname = $row['lname'];
	$id = $row['Id'];
	$unique_name = strtolower(str_replace(' ','',$fname)).".".strtolower(str_replace(' ','',$lname)).".".$id;

	mysqli_query($con,"UPDATE table2 SET unique_name = '$unique_name' WHERE Id='$id'");
}

?>
