<?php include ("./inc/header.inc.php"); ?>
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
<body class="zfp-inner">
	<div class="">
        <br><br>
        <center><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="8311271319"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></center><br><br>
		<div class="col-md-4"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
		<div class="col-md-4">
			<div class="changepassword-form">
				<center>
					<h2>Suggest a Challenge</h2><hr>
					<form class="" action="completesuggest.php" method="POST">
						<div class="row">
							<div class="">
								<div class="col-md-10 input-group trans">
									<textarea class="form-control" name="betdes" placeholder = "Challenge Description"></textarea>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="">
								<div class="col-md-10 input-group trans">
									<input type="text" class="form-control" placeholder="Option 1" aria-describedby="basic-addon1" name="option1">
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="">
								<div class="col-md-10 input-group trans">
									<input type="text" class="form-control" placeholder="Option 2" aria-describedby="basic-addon1" name="option2">
								</div>
							</div>
						</div>
						<br>							
						<button class="btn btn-default btn-flat" type="submit" value="Add"><b>Suggest</b></button><br><br>
						<font color='white'>Challenge successfully submitted for verification.</font>
				    </form>
				</center>
			</div>
		</div>
<div class="col-md-4"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
<?php include ("../../inc/footer.inc.php"); ?>	