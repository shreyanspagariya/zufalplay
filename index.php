<?php
include ("./inc/extuser.inc.php"); 
include("videos/video-entity.php");
include("games/game-entity.php");
include("blogs/blog-entity.php");
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

$query = "SELECT * from game_playhistory WHERE game_id='2' AND isout='1' AND play_id!='TRAINGAME'";
$result = mysqli_query($con,$query);
$currmatches_handcricket = number_format(mysqli_num_rows($result));

$query = "SELECT * from game_playhistory WHERE game_id='16' AND isout='1' AND play_id!='TRAINGAME'";
$result = mysqli_query($con,$query);
$currmatches_twincards = number_format(mysqli_num_rows($result));

$query = "SELECT * from game_playhistory WHERE game_id='17' AND isout='1' AND play_id!='TRAINGAME'";
$result = mysqli_query($con,$query);
$currmatches_reflektor = number_format(mysqli_num_rows($result));

$query = "SELECT * from game_playhistory WHERE game_id='18' AND isout='1' AND play_id!='TRAINGAME'";
$result = mysqli_query($con,$query);
$currmatches_multisnake = number_format(mysqli_num_rows($result));
?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Play Games, Watch Videos & Write Blogs to Donate to the Poor & get Free Recharges @Zufalplay</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("./inc/sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8">
		<center>
			<div class="row hrwhite elevatewhite" style='padding:5px;'>
				<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href='games/'><b>Games</b> &nbsp; <font size='2'>Play and Earn</font></a></font></h4>
				<?php
					$getposts = mysqli_query($con,"SELECT * FROM games WHERE (game_id!='4' AND game_id!='13') ORDER BY RAND() LIMIT 4");
					while($row = mysqli_fetch_assoc($getposts))
					{
						echo_game_entity_index($row, $g_url, $con);
					}
				?>
			</div>
			<br>
			<div class='row hrwhite elevatewhite' style='padding:5px;'>
				<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href='videos/'><b>Videos</b> &nbsp; <font size='2'>Watch and Earn</font></a></font></h4>
				<?php 
					$getposts_genre = mysqli_query($con,"SELECT * FROM videos_genre ORDER BY genre_view_count DESC LIMIT 4");
					while($row_genre = mysqli_fetch_assoc($getposts_genre))
					{
						$genre = $row_genre['genre_name'];
						$genre_display = $row_genre['genre_display'];

						$getposts = mysqli_query($con,"SELECT * FROM videos WHERE genre = '$genre' ORDER BY RAND() LIMIT 1");
						while($row = mysqli_fetch_assoc($getposts))
						{
							echo_video_entity_index($row, $g_url);
						}
					}
				?>
			</div>
			<br>
			<div class='row hrwhite elevatewhite' style='padding:5px;'>
				<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href='blogs/'><b>Blogs</b> &nbsp; <font size='2'>Write and Earn</font></a></font></h4>
				<?php
					$count = 0;
					$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' ORDER BY RAND() DESC LIMIT 4");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$count++;
						echo_blog_entity_index($con, $row, $g_url);
					}
				?>
			</div>
			<br>
			<div class='row hrwhite elevatewhite' style='padding:5px;'>
				<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href='donate/'><b>Donate</b> &nbsp; <font size='2'>Help the Poor</font></a></font></h4>
				<?php
					$count = 0;
					$getposts = mysqli_query($con,"SELECT * FROM donate_posts WHERE is_complete='0' ORDER by RAND() LIMIT 4");
					while($row = mysqli_fetch_assoc($getposts))
					{
						$unique_id = $row["unique_id"];
						$post_url = $row["post_url"];
						$post_title = $row["post_title"];
						$post_img_url = $row["post_img_url"];
						$post_content = $row["post_content"];
						$collection = $row["collection"];

						$short_title = substr($post_title,0,20);

						if(strlen($post_title) > strlen($short_title))
						{
							$dotdotdot = "...";
						}
						else
						{
							$dotdotdot = "";
						}
						
						echo "
							<div class='col-md-3 hrwhite'>
								<a href=$g_url"."donate/details.php?title="."$post_url&d="."$unique_id data-toggle='tooltip' title='$post_title'>
									<div class='' align='left'>
										<img src='$post_img_url' style='height:110px; width:195px;'><br>
										<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$short_title$dotdotdot</b></div>
										<div style='font-size:11px; margin-bottom:3px;'>
											Help the Poor &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp
											<font size='1'>Raised: <b>Rs.</b> </font>$collection</font> 
										</div>
									</div>
								</a>
							</div>
						";
					}
				?>
			</div>
			<br>
			</center>
			<div class='row hrwhite elevatewhite' style="padding:5px;">
				<h4 align='left' style='padding-left:15px; padding-right:15px;'><font size='3'><a href='market/'><b>Market</b> &nbsp; <font size='2'>Redeem your Earnings</font></a></font></h4>
				<?php 
				$getposts = mysqli_query($con,"SELECT * FROM zufal_products");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$prod_id=$row['prod_id'];
					$prod_name = $row['prod_name'];
					$prod_details = $row['prod_details'];
					$image_link = $row['prod_imgloc'];
					$prod_marketprice = $row['prod_marketprice'];
					$prod_zufalprice = $row['prod_zufalprice'];
					$deadline = $row['deadline'];
					$sizeRequired = $row['sizeRequired'];
					$client = $row['client'];
					$is_coupon = $row['is_coupon'];
					$discount_description = $row['discount_description'];
					$width = $row['width'];

					$short_title = substr($prod_name,0,19);
					if(strlen($prod_name)>20)
					{
						$short_title.="...";
					}

					if(isset($_SESSION["email1"]))
					{
						if($user_points >= $prod_zufalprice)
						{
							echo "
								<center>
									<div class='col-md-3 hrwhite'>
									<a data-toggle='modal' href='#purchase_modal$prod_id'>
										<span data-toggle='tooltip' title='$prod_name'>
											<div class=''>
												<img src='$image_link' style='height:100%; width:100%;'>
												<font size='2'><b>$short_title - Rs. $prod_marketprice</b></font><br><br>
											</div>
										</span>
									</a>
									</div>
								</center>
								<div class='modal fade' id='purchase_modal$prod_id' tabindex='-1' role='dialog' aria-labelledby='purchase_modal".$prod_id."Label'>
								  <div class='modal-dialog modal-lg' role='document'>
									<div class='modal-content'>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										<h4 class='modal-title' align='center' id='purchase_modal".$prod_id."Label'>$prod_name - Rs. $prod_marketprice</h4>
									  </div>
									  <div class='modal-body row'>
										<div class='col-md-6'>
											<p id='left_info'>
												<div class='form-group input-group col-md-12'>
											        <input type='text' id='phone_no$prod_id' name='phone_no$prod_id' class='form-control' placeholder='Mobile No.'>
											    </div><br>
												Terms & Conditions:<br>
												<ul>
													$prod_details
												</ul>
											</p>
											<p id='recharge_notify$prod_id'></p>
										</div>
										<div class='col-md-6'>
											<center>
												<div class='row'>
													<img src='$image_link' style='height:100%;width:80%;'>
												</div>
												<br>
												<button class='btn btn-primary btn-flat' id='submit_recharge$prod_id' onclick='complete_recharge($prod_id)' value='Add'><b>Get for Rs. $prod_zufalprice</b></button>
											</center>
										</div>
									  </div>
									</div>
								  </div>
								</div>
							";
						}
						else
						{
							echo "
								<center>
									<div class='col-md-3 hrwhite'>
									<a data-toggle='modal' href='#purchase_modal$prod_id'>
										<span data-toggle='tooltip' title='$prod_name'>
											<div class=''>
												<img src='$image_link' style='height:100%; width:100%;'>
												<font size='2'><b>$short_title - Rs. $prod_marketprice</b></font><br><br>
											</div>
										</span>
									</a>
									</div>
								</center>
								<div class='modal fade' id='purchase_modal$prod_id' tabindex='-1' role='dialog' aria-labelledby='purchase_modal".$prod_id."Label'>
								  <div class='modal-dialog modal-lg' role='document'>
									<div class='modal-content'>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										<span class='modal-title' align='center' id='purchase_modal".$prod_id."Label'>
											<center>
												<font size='3'><b>Sorry, you do not have enough money in your account to buy the $prod_name.</b></font>
											</center>
										</span>
									  </div>
									</div>
								  </div>
								</div>
							";
						}
					}
					else
					{
						echo "
							<center>
								<div class='col-md-3 hrwhite'>
								<a data-toggle='modal' href='#login-login-modal'>
									<span data-toggle='tooltip' title='$prod_name'>
										<div class=''>
											<img src='$image_link' style='height:100%;width:100%;'>
											<font size='2'><b>$short_title - Rs. $prod_marketprice</b></font><br><br>
										</div>
									</span>
								</a>
								</div>
							</center>
						";
					}
				}
			?>
			</div>
			<br><br>
	</div>
	<script>
		function complete_recharge(prod_id)
		{
			$("#submit_recharge"+prod_id).hide();
	        $("#phone_no"+prod_id).prop('disabled', true);
	        
			var user_phno = document.getElementById("phone_no"+prod_id).value;
			$.ajax(
	          {
	            url: "<?php echo $g_url;?>market/rechargebackend.php",
	            dataType: "json",
	            type:"POST",
	            async: false,

	            data:
	            {
	              mode:'complete_recharge',
	              prod_id: prod_id,
	              user_phno: user_phno,
	            },

	            success: function(json)
	            {
	              if(json.status==1)
	              {	
	               	$("#recharge_notify"+prod_id).html("<center><font size='4' color='green'><i class='fa fa-check-circle' aria-hidden='true'></i> <b>Recharge Successful</b></center>");
	               	$("#user_points").html(Math.floor(json.user_points*100)/100);
	              }
	              else if(json.status==-1)
	              {
	              	$("#recharge_notify"+prod_id).html("<center><font size='4' color='orange'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>"+json.msg+"</b></center>");
	              	$("#phone_no"+prod_id).prop('disabled', false);
	              	$("#submit_recharge"+prod_id).show();
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
			}
	</script>
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
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php include ("./inc/footer.inc.php"); ?>	
