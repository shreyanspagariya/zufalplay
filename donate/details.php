<?php
include ("../inc/extuser.inc.php"); 
 
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
if(isset($_GET['d']))
{
	$post_url = mysqli_real_escape_string($con,$_GET['title']);

	$unique_id = mysqli_real_escape_string($con,$_GET['d']);

	$query = "SELECT * FROM donate_posts WHERE unique_id='$unique_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$numResults = mysqli_num_rows($result);

	if($numResults != 0)
	{
		$post_title = $get["post_title"];
		$post_url = $get['post_url'];
		$post_img_url = $get['post_img_url'];
		$post_content = $get["post_content"];
		$user_added_by = $get['user_added_by'];
		$collection = $get['collection'];
	}
}
?>

<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> <?php echo $post_title;?> | Donate  - Zufalplay</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="control_text_editor_design.css">
<style type="text/css">
 a:hover {
  cursor:pointer;
 }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<img src="<?php echo $post_img_url;?>" hidden>
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("../inc/sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8 elevatewhite">
		<div class="row">
			<div class='col-md-8'>
				<center><h3><b><?php echo $post_title;?></b></h3></center>
				<?php
					$fb_share_url = $g_url."blogs/post.php?title=".$post_url."&r=".$unique_id;
				?>
				<hr>
				<?php echo $post_content;?>
				<br>
			</div>
			<div class='col-md-4'>
				<br>
				<div class="balance elevatewhite" align='center'>
					<font size='6'>Rs.</font><font size='8'><b> <?php echo number_format(floor($collection*100)/100,2,'.',''); ?></b></font><br>
					<font size='2'> raised until now.</font><br><br>
					<?php
						if(isset($_SESSION["email1"]))
						{?>
							<button type='button' data-toggle='modal' data-target='#make-donation' class='login-btn btn btn-primary btn-flat'>Donate</button><hr>
							<?php
						}
						else
						{
							?>
							<button type='button' data-toggle='modal' data-target='#login-login-modal' class='login-btn btn btn-primary btn-flat'>Donate</button><hr>
							<?php
						}
					?>
					<?php
						$getposts = mysqli_query($con,"SELECT * FROM donations WHERE user_email='$email' AND unique_id='$unique_id' ORDER BY time_donated ASC");
						while($row = mysqli_fetch_assoc($getposts))
						{
							$amount_donated = $row["amount_donated"];

							echo"<font size='3' color='green'><i class='fa fa-check-circle' aria-hidden='true'></i></font> <b>You donated Rs. $amount_donated</b><br>";
						}
					?>
					<br>
				</div><br>
				<div class="table-responsive elevatewhite hrwhite">
					<table class="table">
						<thead>
					        <tr>
							  <th><center>Donations</center></th>
					        </tr>
					    </thead>
					    <tbody>
							<?php
								$getposts = mysqli_query($con,"SELECT * FROM donations WHERE unique_id='$unique_id' ORDER BY amount_donated DESC LIMIT 10");
								while($row = mysqli_fetch_assoc($getposts))
								{
									$amount_donated = $row["amount_donated"];
									$user_donated = $row["user_email"];

									$query = "SELECT * from table2 where email='$user_donated'";
									$result = mysqli_query($con,$query);
									$get = mysqli_fetch_assoc($result);
									$unique_name_x = $get['unique_name'];
									$fnamex = $get['fname'];

									echo "
										<tr>
											<td><a href='".$g_url."profile.php?id=$unique_name_x' target='_blank'><b>$fnamex</b></a> donated Rs. $amount_donated</td>
										</tr>";
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<hr>
		<center>
		<b>Do you know someone who is need of monetory help? <br>Email us right away at <a href="https://mail.google.com/mail/?view=cm&fs=1&to=donations@zufalplay.com" target="_blank">donations@zufalplay.com</a> to raise funds.</b>
		</center>
		<hr>
		<div class="fb-share-button" data-href="<?php $fb_share_url;?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php $fb_share_url?>&src=sdkpreparse">Share</a></div>
		<hr>
		<div class="fb-comments" data-href="<?php $fb_share_url;?>" data-numposts="5"></div>
		<br><br><br>
	</div>
	<div class="modal" id="make-donation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<center><h4 class="modal-title" id="myModalLabel">Make a Donation - <?php echo $post_title;?></h4></center>
				</div>
				<div class="modal-body">
					<?php
						if($user_points < 1)
						{
							echo "
							<div class='alert alert-danger'>
								<strong><font size='3'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></font>&nbsp; Looks like you have a low account balance. Play Games, Watch Videos and Write Blogs to earn.</strong>
							</div>";
						}
					?>
					<div class='col-md-3'></div>
					<div class='form-group input-group col-md-6'>
				        <input type='text' id='donation_amount' name='donation_amount' class='form-control' placeholder='Enter Amount'>
					</div>
					<center>
						<button id='submit_donation' type="button" class="btn btn-primary btn-flat" onclick="complete_donation('<?php echo $unique_id;?>')">Finalize</button>
						<p id='donation_notify'></p>
					</center>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="ca-pub-7888738492112143"
		     data-ad-slot="1322728114"
		     data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>
</body>
<br>
<script src="<?php echo $g_url;?>/donate/js/complete_donation.js"></script>
<?php include ("../inc/footer.inc.php"); ?>						
