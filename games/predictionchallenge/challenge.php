<?php include ("./inc/header.inc.php"); ?>
<?php 
	top_banner();
	if(isset($_GET['u']))
	{
		$challenge_pseudo_id = mysqli_real_escape_string($con,$_GET['u']);
	}
?>
<body class="zfp-inner">
	<br><br>
	<div class="container">
        <center><!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
Header
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="8311271319"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>--></center>
		<center><h1>Challenge <?php echo $challenge_pseudo_id; ?></h1><div class="container"><hr></div></center>
		<div class="col-md-3"><!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>--></div>
</div>
<div class='col-md-3'></div>
<div class='col-md-6'>
<?php 
		$bet_id = $challenge_pseudo_id-179245;
		$getposts = mysqli_query($con,"SELECT * FROM placedbets WHERE userid_placedby = '$email' AND bet_id='$bet_id'");
		while($row = mysqli_fetch_assoc($getposts))
		{
			$bet_option = $row['bet_option'];
			$stake_points = $row['stake_points'];
			$bet_status = $row['bet_status'];
			$time_placed = $row['time_placed'];
			$getposts2 = mysqli_query($con,"SELECT * FROM bets WHERE betid='$bet_id'");
			while($row2 = mysqli_fetch_assoc($getposts2))
			{
				$betdes= $row2['betdes'];
				$option1 = $row2['option1'];
				$option2 = $row2['option2'];
				$option1_users = $row2['option1_users'];
				$option2_users = $row2['option2_users'];
				$option1_points = $row2['option1_points'];
				$option2_points = $row2['option2_points'];
				if($option1_points!=0)
				{
					$mult1 = round(1+$option2_points/$option1_points,2);
					$mult1str = "X pitched Rs.";
				}
				else
				{
					$mult1="";
					$mult1str="";
				}
				if($option2_points!=0)
				{
					$mult2 = round(1+$option1_points/$option2_points,2);
					$mult2str = "X pitched Rs.";
				}
				else
				{
					$mult2="";
					$mult2str="";
					
				}
				if($bet_option == 1)
				{
					$zufals_profit=$mult1*$stake_points;
					$option = $row2['option1'];
				}
				else
				{
					$zufals_profit=$mult2*$stake_points;
					$option = $row2['option2'];
				}
				$zufals_profit=$zufals_profit-$stake_points;
				if($bet_status==0) 
				{
					$zufals_profit=0;
					$bgcolor = "ongoing";
				}
				else if($bet_status==-1)	
				{
					$zufals_profit=-$stake_points;
					$bgcolor = "lost";
				}
				else if($bet_status==1)
				{
					$bgcolor = "won";
				}
                else
                {
                	$zufals_profit=0;
                    $bgcolor = "tied";
                }
                $zufals_profit_sign="";
				if($zufals_profit>0)
				{
					$zufals_profit_sign="+";
				}
				$str1 = "";
				$getposts3 = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$bet_id' AND bet_option='1'");
				while($row3 = mysqli_fetch_assoc($getposts3))
				{
					$emailx=$row3['userid_placedby'];
					$stake_pointsx=$row3['stake_points'];
					$query = "SELECT * from table2 where email='$emailx'";
					$result1 = mysqli_query($con,$query);
					$get1 = mysqli_fetch_assoc($result1);
					$fnamex = $get1['fname'];
					$lnamex = $get1['lname'];
					$Idx = $get1['Id'];
					//$str1 = "Data Not Available";
					//$str1 = $str1 + $fname + " " + $lname + "bet" + $stake_pointsx + "\n\n";
					$str1.="<b><a href=".$g_url."profile.php?u=$Idx target='_blank'>";
					$str1.=$fnamex;
					$str1.=" ";
					$str1.=$lnamex;
					$str1.="</a></b>";
					$str1.=" with ";
					$str1.="<b>";
					if($stake_pointsx==1)
					{
						$str1.="Rs. ";
					}
					else
					{
						$str1.="Rs. ";
					}
					$str1.=$stake_pointsx;
					$str1.="</b>";
					$str1.="<br>";
				}
				$str2="";
				$getposts3 = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$bet_id' AND bet_option='2'");
				while($row3 = mysqli_fetch_assoc($getposts3))
				{
					$emailx=$row3['userid_placedby'];
					$stake_pointsx=$row3['stake_points'];
					$query = "SELECT * from table2 where email='$emailx'";
					$result1 = mysqli_query($con,$query);
					$get1 = mysqli_fetch_assoc($result1);
					$fnamex = $get1['fname'];
					$lnamex = $get1['lname'];
					$Idx = $get1['Id'];
					//$str2 = "Data Not Available";
					//$str1 = $str1 + $fname + " " + $lname + "bet" + $stake_pointsx + "\n\n";
					$str2.="<b><a href=".$g_url."profile.php?u=$Idx target='_blank'>";
					$str2.=$fnamex;
					$str2.=" ";
					$str2.=$lnamex;
					$str2.="</a></b>";
					$str2.=" with ";
					$str2.="<b>";
					if($stake_pointsx==1)
					{
						$str2.="Rs. ";
					}
					else
					{
						$str2.="Rs. ";
					}
					$str2.=$stake_pointsx;
					$str2.="</b>";
					$str2.="<br>";
				} 

echo"
<div class='bet $bgcolor'>
	<div class='col-md-6'><b class='number'>Rs. $stake_points</b></font> on <font size=2>$option</font></div> 
	<div class='col-md-3'>Profit: <b class='number'>$zufals_profit_sign"."$zufals_profit</b></div>
	<h6>Pitched ".time_elapsed_string($time_placed)."</h6>
	<hr>
	<div class='bet_content' style='padding-left:10px; padding-right:10px; padding-bottom:20px;'>
		$betdes<br><br>
		<div class='col-md-6'>
			<div class='hrwhite'>
				<p>$option1 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModal$bet_id'>?</a></b>)</font></p>
				<p><b class='number'>$option1_users</b> user(s) with<br><b class='number'>Rs. $option1_points </b>in favour<br><b class='number'>$mult1</b>$mult1str</p>
			</div>
		</div>
		<div class='col-md-5'>
		<div class='hrwhite'>
			<div class='bet_option'>
				<p>$option2 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModalx$bet_id'>?</a></b>)</font></p>
			</div>
			<p><b class='number'>$option2_users</b> user(s) with<br><b class='number'>Rs. $option2_points </b>in favour<br><b class='number'>$mult2</b>$mult2str</p>
			</div>
		</div>
		<br><br>
	</div>
</div><br>
<!-- Modal -->
<div class='modal fade' id='myModal$bet_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  	<div class='modal-dialog'>
    	<div class='modal-content'>
      		<div class='modal-header'>
        		<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        		<h4 class='modal-title' id='myModalLabel' align='center'><font color='black'><b>User(s) in favour of $option1</b></font></h4>
      		</div>
      		<div class='modal-body'>
        		<font color='black' size='3' align='center'>$str1</font> 
      		</div>
      		<div class='modal-footer'>
        		<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
      		</div>
    	</div>
  </div>
</div>
<div class='modal fade' id='myModalx$bet_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  	<div class='modal-dialog'>
    	<div class='modal-content'>
      		<div class='modal-header'>
        		<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        		<h4 class='modal-title' id='myModalLabel' align='center'><font color='black'><b>User(s) in favour of $option2</b></font></h4>
      		</div>
      		<div class='modal-body'>
        		<font color='black' size='3' align='center'>$str2</font> 
      		</div>
      		<div class='modal-footer'>
        		<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
      		</div>
    	</div>
  	</div>
</div>
";
			}
			
		}
?>
</div>
</body>
<?php include ("../../inc/footer.inc.php"); ?>						