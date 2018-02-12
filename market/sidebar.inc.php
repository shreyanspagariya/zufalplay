<div id="sidebar-wrapper" style="margin-top:-0.6%; background:rgba(0,0,0,0.6); overflow-x: hidden; margin-left:-290px;">
    <ul class="sidebar-nav">
        <br>
        <li class="sidebar-brand">
            <a href="<?php echo $g_url.'market';?>">
            	<?php
	            	if(isset($_SESSION["email1"]))
	            	{
	            		echo"<div style='margin-top:-15%;margin-left:15%;'>";
	            	}
	            	else
	            	{
	            		echo"<div style='margin-top:-8%;margin-left:15%;'>";
	            	}
            	?>
            	<b>Choose From..</b>
                </div>
            </a>
        </li>
        <?php 
		$getposts_genre = mysqli_query($con,"SELECT * FROM market_type ORDER BY id ASC");
		while($row_genre = mysqli_fetch_assoc($getposts_genre))
		{
			$type_name_sidebar = $row_genre['type_name'];
			$type_display_sidebar = $row_genre['type_display'];
			echo"
			<li>
				<div style='margin-left:15%;'>
					<a href=$g_url"."market/type.php?type=$type_name_sidebar".">$type_display_sidebar</a>
				</div>
			</li>
			";
		}

		?>
    </ul>
</div>
<!-- /#sidebar-wrapper -->