<?php include("connect.inc.php"); 
include("metatags.inc.php"); 
if(isset($_SESSION["email1"]))
{
	$email = $_SESSION["email1"];
}
else
{
	$email = "";
	header("Location: ".$g_url);
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
$password = $get['password'];
$fb_id = $get['fb_id'];
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
				  	<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1489957891297107";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
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
