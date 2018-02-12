<?php include ("./inc/header.inc.php"); 
top_banner();
?>
<head>
	<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Account Transactions - Zufalplay</title>
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("./inc/sidebar.inc.php"); ?>
	</div>
	<div class='hrwhite'>
		<div class="col-md-8">
			<center><h2>Account Transactions</h2><hr></center>
			<div class="table-responsive elevatewhite">
			  <table class="table table-bordered">
				<thead>
				<tr>
				  <th>Date Time</th>
				  <th>Description</th>
				  <th>Account Balance</th>
				</tr>
			  </thead>
			  <tbody>
				<?php

				$getposts = mysqli_query($con,"SELECT * FROM account_transactions WHERE user_email='$email' ORDER BY transaction_time DESC, transaction_id DESC LIMIT 50");
				while($row = mysqli_fetch_assoc($getposts))
				{
					$transaction_id = $row['transaction_id'];
					$transaction_time = $row['transaction_time'];
					$user_points_after = $row['user_points_after'];
					$bet_pseudo_id = $row['bet_pseudo_id'];
					$transaction_description = $row['transaction_description'];
					if($bet_pseudo_id >= 179245 && $bet_pseudo_id <= 189245)
					{
						echo "<tr>
						<td>$transaction_time</td>
						<td>$transaction_description - <a href='games/predictionchallenge/challenge.php?u=$bet_pseudo_id' target='_blank'><font size='1'><u><b>View Challenge</b></u></font></a></td>
						<td>$user_points_after</td>
						</tr>
						";
					}
					else if($bet_pseudo_id < 179245)
					{
						echo "<tr>
						<td>$transaction_time</td>
						<td>$transaction_description</td>
						<td>$user_points_after</td>
						</tr>
						";
					}
					else
					{
						if(strpos($transaction_description,"match")!==false)	
						echo "<tr>
						<td>$transaction_time</td>
						<td>$transaction_description - <a href='games/one-on-one/handcricket/game.php?u=$bet_pseudo_id' target='_blank'><font size='1'><u><b>View Challenge</b></u></font></a></td>
						<td>$user_points_after</td>
						</tr>
						";
						else if(strpos($transaction_description,"Snake")!==false)
						echo "<tr>
						<td>$transaction_time</td>
						<td>$transaction_description - <a href='games/one-on-one/snake/game.php?u=$bet_pseudo_id' target='_blank'><font size='1'><u><b>View Challenge</b></u></font></a></td>
						<td>$user_points_after</td>
						</tr>
						";	
						else if(strpos($transaction_description,"Mario")!==false)
						echo "<tr>
						<td>$transaction_time</td>
						<td>$transaction_description - <a href='games/one-on-one/mario/game.php?u=$bet_pseudo_id' target='_blank'><font size='1'><u><b>View Challenge</b></u></font></a></td>
						<td>$user_points_after</td>
						</tr>
						";
						else if(strpos($transaction_description,"Hextris")!==false)
						echo "<tr>
						<td>$transaction_time</td>
						<td>$transaction_description - <a href='games/one-on-one/hextris/game.php?u=$bet_pseudo_id' target='_blank'><font size='1'><u><b>View Challenge</b></u></font></a></td>
						<td>$user_points_after</td>
						</tr>
						";
						else if(strpos($transaction_description,"Pappu-Pakia")!==false)
						echo "<tr>
						<td>$transaction_time</td>
						<td>$transaction_description - <a href='games/one-on-one/pappu-pakia/game.php?u=$bet_pseudo_id' target='_blank'><font size='1'><u><b>View Challenge</b></u></font></a></td>
						<td>$user_points_after</td>
						</tr>
						";
						else if(strpos($transaction_description,"Coil")!==false)
						echo "<tr>
						<td>$transaction_time</td>
						<td>$transaction_description - <a href='games/one-on-one/coil/game.php?u=$bet_pseudo_id' target='_blank'><font size='1'><u><b>View Challenge</b></u></font></a></td>
						<td>$user_points_after</td>
						</tr>
						";	
					}
				}
				?>
				</tbody>
			</table>
			</div>
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

<?php include ("./inc/footer.inc.php"); ?>