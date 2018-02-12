<?php include ("../inc/header.inc.php"); ?>
<?php 
	top_banner();
?>

<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Notifications - Zufalplay</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="zfp-inner">
		<div class='col-md-2'>
            <?php include ("../inc/sidebar.inc.php"); ?>
        </div>
		<div class="col-md-8" >
	<?php
		$countunseen = mysqli_query($con,"SELECT seen FROM notifications WHERE to_user = '$email' AND seen = 0");
	?>
		<h2 align="center">All Notifications (<span id="countunseen"><?php echo mysqli_num_rows($countunseen); ?></span>)</h2><hr>
		<div class="all-notifs">
		  
	<?php
		$getnotifs = mysqli_query($con,"SELECT * FROM notifications WHERE to_user='$email' ORDER BY time_generated DESC LIMIT 50");
        $numnotifs = mysqli_num_rows($getnotifs); 
        while($notifrow = mysqli_fetch_assoc($getnotifs))
    	{
      		$notif_id = $notifrow['notif_id'];
      		$notif_text = $notifrow['notif_text'];
      		$notif_href = $notifrow['notif_href'];
      		$notif_seen = $notifrow['seen'];
    ?>
		<div class="elevatewhite notif-card <?php if($notif_seen == 0){echo 'unread';}?>" id="unread<?php echo $notif_id; ?>">
		<div style="cursor:pointer;">
                   <a class='pull-right'onclick="notifread(<?php echo $notif_id;?>); return true;"><span class="fa fa-check"></span></a>
                </div>
			<a href='<?php echo $g_url.$notif_href;?>' onclick="notifread(<?php echo $notif_id;?>); return true;" style="color:#000;text-decoration:none"><?php echo $notif_text;?>
			<small class="pull-right"><?php echo time_elapsed_string($notifrow['time_generated']); ?>&nbsp;&nbsp;</small></a>
		</div><br>
    <?php
        }//End while 
       
	?>
		</div>
		</div>
		<div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
	</div>
</body>
<br><br><br>
<?php include ("../inc/footer.inc.php"); ?>		