<?php include ("../../inc/header.inc.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}

if(!isset($_GET["filter_by_r"]))
{
	?>
	<head>
	<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Analytics (All Posts) - Zufalplay</title>
	<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	</head>
	<body class="zfp-inner">
		<div class="col-md-2">
			<?php include ("../sidebar.inc.php"); ?>
	    </div>
		<div class="col-md-8 hrwhite">
			<h3 align='center'><b>Analytics</b> (All Posts)</h3><hr>
			<div class="table-responsive elevatewhite hrwhite">
				<table class="table table-bordered">
					<thead>
				        <tr>
						  <th>#</th>
						  <th>View Time</th>
				          <th>Post Viewed</th>
						  <th>View Location</th>
						  <th>Time Spent (sec)</th>
				        </tr>
				    </thead>
				    <tbody>
						<?php
							$slno = 1;
							$getposts = mysqli_query($con,"SELECT * FROM read_history R, blogposts B WHERE R.unique_id = B.unique_id AND B.blogger_unique_id = '$unique_name' AND R.is_money_distributed='1' ORDER BY R.end_time DESC LIMIT 100");
							while($row = mysqli_fetch_assoc($getposts))
							{
								$read_duration_sec = $row["read_duration_sec"];
								$user_id_read = $row["user_id_read"];
								$local_unique_id = $row["unique_id"];

								$read_ip = $row["ip_address"];
								$details = $details = json_decode(file_get_contents("http://freegeoip.net/json/$read_ip"));
								$read_location = $details->city.", ".$details->region_name.", ".$details->country_name;

								$start_time = $row["start_time"];
								$end_time = $row["end_time"];
								$read_duration_sec = $row["read_duration_sec"];

								$local_post_title = $row["post_title"];

								$time_spent = strtotime($end_time) - strtotime($start_time);

								echo "
									<tr>
										<td>$slno</td>
										<td>$end_time</td>
										<td><a href='?filter_by_r=".$local_unique_id."' target='_blank'>$local_post_title</a></td>
										<td>$read_location</td>
										<td>$time_spent</td>
									</tr>
								";
								$slno++;
							}
						?>
					</tbody>
				</table>
			</div>
		    <br><br>
		</div>
	<?php
}
else
{
	$unique_id = mysqli_real_escape_string($con,$_GET['filter_by_r']);
	$query = "SELECT * FROM blogposts WHERE unique_id='$unique_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$post_title = $get["post_title"];
	?>
	<head>
	<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Analytics (<?php echo $post_title;?>) - Zufalplay</title>
	<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	</head>
	<body class="zfp-inner">
		<div class="col-md-2">
			<?php include ("../sidebar.inc.php"); ?>
	    </div>
		<div class="col-md-8 hrwhite">
			<h3 align='center'><b>Analytics</b> - "<?php echo $post_title;?>"</h3><hr>
			<div class="table-responsive elevatewhite hrwhite">
				<table class="table table-bordered">
					<thead>
				        <tr>
						  <th>#</th>
						  <th>View Time</th>
						  <th>View Location</th>
						  <th>Time Spent (sec)</th>
				        </tr>
				    </thead>
				    <tbody>
						<?php
							$slno = 1;
							$getposts = mysqli_query($con,"SELECT * FROM read_history R, blogposts B WHERE R.unique_id = B.unique_id AND B.blogger_unique_id = '$unique_name' AND R.is_money_distributed='1' AND R.unique_id='$unique_id' ORDER BY R.end_time DESC LIMIT 25");
							while($row = mysqli_fetch_assoc($getposts))
							{
								$read_duration_sec = $row["read_duration_sec"];
								$user_id_read = $row["user_id_read"];
								$local_unique_id = $row["unique_id"];

								$read_ip = $row["ip_address"];
								$details = $details = json_decode(file_get_contents("http://freegeoip.net/json/$read_ip"));
								$read_location = $details->city.", ".$details->region_name.", ".$details->country_name;

								$start_time = $row["start_time"];
								$end_time = $row["end_time"];
								$read_duration_sec = $row["read_duration_sec"];

								$local_post_title = $row["post_title"];

								$time_spent = strtotime($end_time) - strtotime($start_time);

								echo "
									<tr>
										<td>$slno</td>
										<td>$end_time</td>
										<td>$read_location</td>
										<td>$time_spent</td>
									</tr>
								";
								$slno++;
							}
						?>
					</tbody>
				</table>
			</div>
		    <br><br>
		</div>
	<?php
}
?>

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
<?php include ("../../inc/footer.inc.php"); ?>	