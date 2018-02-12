<?php include ("../inc/extuser.inc.php"); ?>
<?php 
	if(isset($_SESSION["email1"]))
	{
		top_banner();
	}
	else
	{
		top_banner_extuser();
	}
?>
<br>
<body class="zfp-inner">
<div class="hrwhite">
<div class="container">
	<div class='elevatewhite' style='padding:20px;'>
		<h2 align="center">Unusual Activity Detected.</h2>
		<hr>
		<div align="center"><h4>Some unusual activity has been detected from your account.</h4><br></div>
		<div align="center"><b><h4>If you think you are seeing this by mistake, please text us right away in the query box provided below or drop a mail to team@zufalplay.com</b></h4></div><br>
	</div>
</div>
</body>
<?php include ("../inc/footer.inc.php"); ?>
