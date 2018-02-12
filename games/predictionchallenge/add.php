<?php include ("./inc/header.inc.php"); 
top_banner();
?>
<?php
	if($email!="shreyanspagariya@gmail.com")
	{
		header("Location: index.php");
	}
?>

<body class="zfp-inner"></body>
	<div class = "row">
		<div class = "col-md-5"></div>
		<div class = "col-md-3">
			<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add Bet</h3>
		</div>
	</div>
<form action="completeadd.php" method="POST">
	<div class = "row">
		<div class = "col-md-4"></div>
		<div class = "col-md-4" style="background-color:#A4A4A4">
			<br>
			<div class="input-group input-group">
				<textarea name="betdes" rows="4" cols="51" placeholder=" Bet Description" style="
    color: #000;
"></textarea>
			</div>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-4"></div>
		<div class = "col-md-4" style="background-color:#A4A4A4">
			<br>
			<div class="input-group input-group">
				<span class="input-group-addon" id="basic-addon1"></span>
				<input type="text" class="form-control" placeholder="Option 1" aria-describedby="basic-addon1" name="option1">
			</div>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-4"></div>
		<div class = "col-md-4" style="background-color:#A4A4A4">
			<br>
			<div class="input-group input-group">
				<span class="input-group-addon" id="basic-addon1"></span>
				<input type="text" class="form-control" placeholder="Option 2" aria-describedby="basic-addon1" name="option2">
			</div>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-4"></div>
		<div class = "col-md-4" style="background-color:#A4A4A4">
			&nbsp;
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-4"></div>
		<div class = "col-md-4" style="background-color:#A4A4A4">
			<div class = "col-md-5"></div>
			&nbsp;&nbsp;
			<input type="datetime" class="form-control" placeholder="Date" aria-describedby="basic-addon1" name="date_time">
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-4"></div>
		<div class = "col-md-4" style="background-color:#A4A4A4">
			&nbsp;
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-4"></div>
		<div class = "col-md-4" style="background-color:#A4A4A4">
			<div class = "col-md-5"></div>
			&nbsp;&nbsp;
			<button class="btn btn-default" type="submit" value="Add">Add</button>
		</div>
	</div>
	</form>
	<div class = "row">
		<div class = "col-md-4"></div>
		<div class = "col-md-4" style="background-color:#A4A4A4">
			&nbsp;
		</div>
	</div>
	<div class = "row" >
		&nbsp;
	</div>
	<div class = "row">
	<div class="col-md-4">
		&nbsp;
	</div>
	<div class="col-md-4">
	<?php
		$getposts = mysqli_query($con,"SELECT * FROM bets ORDER by start_time DESC");
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
echo"
<pre>
<b>$betdes</b>
<form id='submitbet$id' action='calculateresult.php' method='POST'><div class ='col-md-5'>
<input type='radio' name='options' value='option1' onclick='f($id)'> $option1
             
<font size='3'><b>$option1_users</b></font> user(s)<br><font size='3'><b>$option1_points</b></font> point(s)	
</div><div class='col-md-1'></div><div class = 'col-md-5'>
<input type='radio' value='option2' name='options' onclick='f($id)'> $option2

<font size='3'><b>$option2_users</b></font> user(s)<br><font size='3'><b>$option2_points</b></font> point(s)
</div>			
                               <input type='radio' value='option4' name='options' onclick='f($id)'> Tie				
<input name='betid' value=$id hidden><input id='userpoints' value=$user_points hidden>
                      <input type='radio' value='option3' name='options'> Lock Bet
					   
                       <button type='button' name='lockbet$id' id='lockbets$id' onclick='g($id)'>Lock Bet</button>
<div id='points$id'></div>

<div id='betbutton$id'></div>
</form>
</pre>";
		}
	?>
	<script>
		function g(i){
			document.getElementById("submitbet"+i).submit();
		}
		function f(i){
			document.getElementById('betbutton'+i).innerHTML = "                  "+"<button type='button' name='savebet"+i+"' onclick='g("+i+")'><font size='4'><b>Declare Result</b></font></button>";
		}
		
	</script>
	</div>
	</div>
<?php include ("../../inc/footer.inc.php"); ?>	