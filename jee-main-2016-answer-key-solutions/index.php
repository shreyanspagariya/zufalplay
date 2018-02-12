<?php
include ("../inc/extuser.inc.php"); 
?>

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

<?php
$query = "SELECT * FROM placedbets";
$result = mysqli_query($con,$query);
$live_placed_bets = number_format(mysqli_num_rows($result));

$query = "SELECT * from game_playhistory WHERE game_id='2'";
$result = mysqli_query($con,$query);
$currmatches_handcricket = number_format(mysqli_num_rows($result));

?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Jee Main 2016 Answer Key & Solutions - Zufalplay</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("../inc/sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8">
		<center>
			<div class="row hrwhite elevatewhite">
				<h3>Jee Main 2016 Answer Key</h3><hr>
				<?php 
					for($i = 1; $i <= 39; $i++)
					{
						echo"
						<img src = ".$g_url."jee-main-2016-answer-key-solutions/images/".$i.".jpg><br><br>";
					}
				?>
			</div>
			<br><br>
	</div>
	<div class="col-md-2">
		<?php 
			for($i = 1; $i <= 8; $i++)
			{?>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-client="ca-pub-7888738492112143"
				     data-ad-slot="1322728114"
				     data-ad-format="auto"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script><br><br>
			<?php
			}
		?>
	</div>
</body>
<br>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php include ("../inc/footer.inc.php"); ?>	
