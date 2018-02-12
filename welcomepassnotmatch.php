<?php
include('inc/header.inc.php');
$go_to_url = $_GET["go_to_url"];
if($password!="")
{
	header("Location: ".$go_to_url);
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
	<body class="zfp-inner">
		<div class="container" style='margin-top:-30px;'>
			<h3 align="center">Set a Password to your Account</h3><br>
			<h4 align="center">You are just one step away from entering into the world of Zufalplay!</h4><br><hr><br>
			<div class="col-md-3"></div>
			<div class="col-md-6">

				<div class="welcome-form elevatewhite" align="center">
					<br><br>
					<form class="" action = "setpassfirstime.php" method = "POST">
						<input type="text" name="fb_id" value="<?php if(isset($_GET['fb_id'])){echo $_GET['fb_id'];}?>" hidden>
						<input type="text" name="go_to_url" value="<?php echo $go_to_url;?>" hidden>
						<div class="row">
							<div class="col-md-6">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="First Name" aria-describedby="basic-addon1" name="fname" value="<?php echo $fname;?>" disabled>
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Last Name" aria-describedby="basic-addon1" name="lname" value="<?php echo $lname;?>" disabled>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="">
								<div class="col-md-10 input-group">
									<input type="text" class="form-control" placeholder="Email" aria-describedby="basic-addon1" name="email" value="<?php echo $email?>" disabled>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="">
								<div class="col-md-10 input-group">
									<input type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" name="password">
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="">
								<div class="col-md-10 input-group">
									<input type="password" class="form-control" placeholder="Re-enter Password" aria-describedby="basic-addon1" name="password1">
								</div>
							</div>
						</div>
						<br>
						<b>Passwords don't match!</b>
						<br>
						<br>								
						<button class="btn btn-default btn-flat" type="submit" value="Sign-Up"><b>Finish</b></button><br><br>
				    </form>
				</div>
			</div>
		</div>
		<br><br>
	</body>