<?php include ("../inc/extuser.inc.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}
?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> About Us - Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
	<div class="col-md-2">
		<?php include ("../inc/sidebar.inc.php"); ?>
    </div>
	<div class="col-md-8 hrwhite elevatewhite">
		<center><h3>About Us</h3><hr></center>
			<p>
				Zufalplay is a web based interactive platform which aims at monetizing users' free time. <br>
				Users can Play Games, Watch their favourite Youtube Videos and Write Blogs to earn money (credit). 
				This money can be either Donated to the Poor and Needy or can be used to take up Mobile Recharges @Zufalplay Market.
			</p>
			<hr>
			<center>
				<font size='3'>Follow us on...</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href='https://www.facebook.com/zufalplay' target='_blank'><font size='5' color='#3b5998'><i class="fa fa-facebook-square" aria-hidden="true"></i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href='https://twitter.com/zufalplay' target='_blank'><font size='5' color='#0084b4'><i class="fa fa-twitter-square" aria-hidden="true"></i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href='https://www.linkedin.com/company/zufalplay' target='_blank'><font size='5' color='#4875B4'><i class="fa fa-linkedin-square" aria-hidden="true"></i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href='https://plus.google.com/+Zufalplay_Official/posts' target='_blank'><font size='5' color='#C63D2D'><i class="fa fa-google-plus-square" aria-hidden="true"></i></font></a>
			</center>
		<br>							
	</div>
	<div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
	</div>
</body>
<?php include ("../inc/footer.inc.php"); ?>	
