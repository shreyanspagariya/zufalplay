<?php
function echo_game_entity_index($row, $g_url, $con)
{
	$game_display = $row['game_display'];
	$game_link = $row['game_link'];
	$game_gif = $row['game_gif'];
	$max_score = number_format($row['max_score']);
	$max_zufals = $row['max_zufals'];
	$gif_height_percent = $row['gif_height_percent'];
	$gif_width_percent = $row['gif_width_percent'];
	$game_id = $row['game_id'];

	$query = "SELECT * from game_playhistory WHERE game_id='$game_id' AND isout='1' AND play_id!='TRAINGAME'";
	$result = mysqli_query($con,$query);
	$currmatches = number_format(mysqli_num_rows($result));

	if($currmatches == 0)
	{
		$query = "SELECT * FROM placedbets";
		$result = mysqli_query($con,$query);
		$currmatches = number_format(mysqli_num_rows($result));
	}

	echo "
		<div class='col-md-3 hrwhite'>
			<a href=$g_url"."$game_link data-toggle='tooltip' title='$game_display'>
				<div class='' align='left'>
					<img src=$g_url"."$game_gif style='height:$gif_height_percent%; width:$gif_width_percent%;'>
					<div style='font-size:13px; margin-top:5px; margin-bottom:3px;'><b>$game_display</b></div>
					<div style='font-size:11px; margin-bottom:3px;'> 
						Play and Earn &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp$currmatches 
						<font size='1'>games played</font>
					</div>
				</div>
			</a>
		</div>
	";
}
?>