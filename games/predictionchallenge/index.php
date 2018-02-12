<?php include ("./inc/header.inc.php"); 
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
		<center><h3>Open Challenges <?php if($total!=0) echo "(".$total.")"; ?></h3><div class="container"><hr></div></center>
		<div class="col-md-3"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
		<div class="col-md-6">
			<?php
		$getposts = mysqli_query($con,"SELECT * FROM bets ORDER BY start_time ASC");
		while($row = mysqli_fetch_assoc($getposts))
		{
			$id = $row['betid'];
			$betdes = $row['betdes'];
			//$date_added = $row['time_added'];
			//$added_by = $row['added_by'];
			$option1 = $row['option1'];
			$option2 = $row['option2'];
			$option1_users = $row['option1_users'];
			$option2_users = $row['option2_users'];
			$option1_points = $row['option1_points'];
			$option2_points = $row['option2_points'];
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
			$bet_result_status = $row['bet_result_status'];
			if($bet_result_status==0)
			{
			$sum = 0;
			$getposts2 = mysqli_query($con,"SELECT * FROM placedbets WHERE userid_placedby='$email'");
			while($row2 = mysqli_fetch_assoc($getposts2))
			{
				$bet_id = $row2['bet_id'];
				if($id == $bet_id)
				{
					$sum = $sum + 1;
				}
			}
			if($sum==0)
			{
				$str1 = "";
				$getposts3 = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$id' AND bet_option='1'");
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
					// $str1 = "Data Not Available";
					// $str1 = $str1 + $fname + " " + $lname + "bet" + $stake_pointsx + "\n\n";
					$str1.="<b><a href='".$g_url."profile.php?u=$Idx' target='_blank'>";
					$str1.=$fnamex;
					$str1.=" ";
					$str1.=$lnamex;
					$str1.="</a></b>";
					$str1.=" with ";
					$str1.="<b>";
					if($stake_pointsx==1)
					{
						$str1.=" Rs. ";
					}
					else
					{
						$str1.=" Rs. ";
					}
					$str1.=$stake_pointsx;
					$str1.="</b>";
					$str1.="<br>";
				}
				$str2="";
				$getposts3 = mysqli_query($con,"SELECT * FROM placedbets WHERE bet_id='$id' AND bet_option='2'");
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
					// $str2 = "Data Not Available";
					// $str1 = $str1 + $fname + " " + $lname + "bet" + $stake_pointsx + "\n\n";
					$str2.="<b><a href='".$g_url."profile.php?u=$Idx' target='_blank'>";
					$str2.=$fnamex;
					$str2.=" ";
					$str2.=$lnamex;
					$str2.="</a></b>";
					$str2.=" with ";
					$str2.="<b>";
					if($stake_pointsx==1)
					{
						$str2.=" Rs. ";
					}
					else
					{
						$str2.=" Rs. ";
					}
					$str2.=$stake_pointsx;
					
					$str2.="</b>";
					$str2.="<br>";
				}
				if(strpos($betdes,"Game")!==false || strpos($betdes,"ICC")!==false  || strpos($betdes,"ODI")!==false || strpos($betdes,"Test")!==false || strpos($betdes,"T20")!==false)
				{
					$bet_img = "<img src='http://exchangedownloads.smarttech.com/public/content/cf/cf4cacb8-8da9-46d8-bd3b-bd926be7de3a/previews/small/0001.png' style='width:40px; height: 60px;'>";
				}
				else if(strpos($betdes,"IPL")!==false)
				{
					$bet_img = "<img src='http://iplzilla.com/wp-content/uploads/2013/02/pepsi-ipl-logo-1024x729.png' 
								style='width:70px; height: 50px;'>";
				}
				else if(strpos($betdes,"NBA")!==false)
				{
					$bet_img = "<img src='http://www.jumpstartsports.com/upload/images/Radnor_Basketball/448650-basketball__mario_sports_mix_.png' 
								style='width:50px; height: 50px;'>";
				}
				else if(strpos($betdes,"Indian Super League")!==false || strpos($betdes,"English Premier League")!==false 
					|| strpos($betdes,"La Liga")!==false || strpos($betdes,"UEFA")!==false)
				{
					$bet_img = "<img src='https://insidetameside.com/wp-content/uploads/2015/11/footy.png' 
								style='width:50px; height: 50px;'>";
				}
				else if(strpos($betdes,"Bollywood")!==false)
				{
					$bet_img = "<img src='https://www.articleonepartners.com/wp-content/uploads/2015/06/1000px-Clapboard.svg_.png' 
								style='width:50px; height: 50px;'>";
				}
				else if(strpos($betdes,"Vice")!==false)
				{
					$bet_img = "<img src='http://zufalplay.com/images/people.png' 
								style='width:50px; height: 50px;'>";
				}
				else
				{
					$bet_img = "<img src='http://info.articleonepartners.com/wp-content/uploads/2015/06/1000px-Clapboard.svg_.png' 
								style='width:50px; height: 50px;'>";
				}
				if(isset($_SESSION["email1"]))
				{
echo"
<div class='elevatewhite' style='padding-bottom:40px;'>
	<div class='bet_content'>
		<div class='row'>
			<div class='col-md-10' style='padding-left:30px; padding-top:5px;'>
				$betdes
			</div>
			<div class='col-md-2'>
				$bet_img
			</div>
		</div>
		<hr>
		<form id='submitbet$id' action='placebet.php' method='POST'>
			<div class='col-md-6'>
				<div class='bet_option'>
					<div class='hrwhite'>
						<input type='radio' name='options' value='option1' onclick='f($id)'> $option1 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModal$id'>?</a></b>)</font><br><br>
					</div>
					<b class='number'>$option1_users</b> user(s) with<br><b class='number'>$option1_points</b> Rs. in favour<br><b class='number'>$mult1</b>$mult1str
				</div>
			</div>
			<div class='col-md-6'>
				<div class='bet_option'>
					<div class='hrwhite'>
						<input type='radio' value='option2' name='options' onclick='f($id)'> $option2 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModalx$id'>?</a></b>)</font><br><br>
					</div>
					<b class='number'>$option2_users</b> user(s) with<br><b class='number'>$option2_points</b> Rs. in favour<br><b class='number'>$mult2</b>$mult2str
				</div>
			</div>
			<br><br>
        	<input name='betid' value=$id hidden><input id='userpoints' value=$user_points hidden><br><br>
			<div id='points$id' align='center'></div><br>
			<center><p id='error_message$id'></p></center>
			<div id='betbutton$id' align='center'></div>
		</form>
	</div>
</div><br>
<!-- Modal -->
<div class='modal fade' id='myModal$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
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
<div class='modal fade' id='myModalx$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
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
</div>";
}
else
{
echo"
<div class='elevatewhite' style='padding-bottom:40px;'>
	<div class='bet_content' style='padding-bottom:10px;'>
		<div class='row'>
			<div class='col-md-10' style='padding-left:30px; padding-top:5px;'>
				$betdes
			</div>
			<div class='col-md-2'>
				$bet_img
			</div>
		</div>
		<center>(<b>Please <a href='' data-toggle='modal' data-target='#login-login-modal'><u>Login</u></a> to place your bet</b>)</center>
		<hr>
		<div class='col-md-6'>
			<div class='bet_option'>
				<div class='hrwhite'>
					$option1 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModal$id'>?</a></b>)</font><br><br>
				</div>
				<b class='number'>$option1_users</b> user(s) with<br><b class='number'>$option1_points</b> Rs. in favour<br><b class='number'>$mult1</b>$mult1str
			</div>
		</div>
		<div class='col-md-6'>
			<div class='bet_option'>
				<div class='hrwhite'>
					$option2 <font size='2'>(<b><a href='' data-toggle='modal' data-target='#myModalx$id'>?</a></b>)</font><br><br>
				</div>
				<b class='number'>$option2_users</b> user(s) with<br><b class='number'>$option2_points</b> Rs. in favour<br><b class='number'>$mult2</b>$mult2str
			</div>
		</div>
		<br><br>
        <input hidden><br><input hidden><br><br>
	</div>
</div><br><br>
<!-- Modal -->
<div class='modal fade' id='myModal$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
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
<div class='modal fade' id='myModalx$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
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
</div>";
}
		}
			}
		}
	?>
	
	<script>
		function g(i)
		{
			var x,y;
			x = document.getElementById('bp'+i).value;
			y = document.getElementById('userpoints').value;

			$.ajax(
			{
			  	url: "validatepitch.php",
			  	dataType: "json",
			  	type:"POST",
			  	data:
			  	{
					mode:"pitch_zufals",
					zufals_pitched:x,
			  	},
			  	success: function(json)
			  	{
			  		if(json.status == 1)
			  		{
						document.getElementById("submitbetbut"+i).disabled = 'true';
						document.getElementById("submitbet"+i).submit();
					}
					else if(json.status == 0)
					{
						$("#error_message"+i).html("<b>" + json.msg + "</b>");
					}
				},
				error : function()
				{
					
				}
			});
		}
		function f(i)
		{
			document.getElementById('points'+i).innerHTML = "<br>"+"<hr>" + "I pitch in " + "<b>Rs.</b> <input type='text' class='elevatewhite' name='betpoints' id='bp"+i+"'>";
			document.getElementById('betbutton'+i).innerHTML = "<button type='button' id='submitbetbut"+i+"' name='savebet"+i+"' onclick='g("+i+")'><font color='black'><b>Finalize</b></font></button>";
		}
	</script>
</div>
        <div class="col-md-3"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
<?php include ("../userprompt.inc.php"); ?>
<?php include ("../../inc/footer.inc.php"); ?>							