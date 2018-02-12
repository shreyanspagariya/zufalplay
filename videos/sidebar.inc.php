<div id="sidebar-wrapper" style="margin-top:-0.6%; background:#F2F2F2; margin-left:-290px; padding-left:7px;">
    <ul class="sidebar-nav">
    	  <?php 
        	if(isset($_SESSION["email1"]))
        	{?>
		        <li>
		        	<div style='margin-left:7%; margin-bottom:-8%; margin-top:2%;'>
						<a href=<?php echo $g_url.'videos/favorites.php';?>><b><i class="fa fa-list-ul"></i> &nbsp;View Favorites</b></a>
					</div>
		        </li>
		        <?php
		    }?>
    	<li>
    		<form class="navbar-form form-inline" action="backend/extractuid.php" method="POST">
	        	<div class="input-group" style='margin-left:5.5%; width:65%; margin-top:7%;'>
					<input type="input" class="form-control login_password" placeholder="Youtube URL" aria-describedby="basic-addon1" name = "youtube_link">
				</div>
				
				<button class="btn btn-default" style='margin-top:7%; border-radius:0px;'><i class="fa fa-youtube-play"></i></button>
				
			</form>
        </li>
        <?php 
        	if(isset($_SESSION["email1"]))
        	{?>
		        <li>
		        	<div style='margin-left:7%;'>
						<a href="<?php echo $g_url.'videos/history.php';?>"><font size='4' color='#8904B1'><i class="fa fa-history" aria-hidden="true"></i></font>&nbsp; Watch History</a>
					</div>
		        </li>
		        <?php
		    }
		?>
        <li>
        	<div style='margin-left:7%;'>
				<a href='' data-toggle='modal' data-target='#videos-terms-modal'><font size='4' color='#045FB4'><i class="fa fa-info-circle"></i></font>&nbsp; Terms of Service</a>
			</div>
        </li>
        <br>
        <li class="sidebar-brand">
            <a href="<?php echo $g_url.'videos';?>">
            	<div style='margin-top:-8%;margin-left:15%;'>
                	<b>Choose From..</b>
                </div>
            </a>
        </li>
        <?php 
		$getposts_genre = mysqli_query($con,"SELECT * FROM videos_genre ORDER BY genre_view_count DESC");
		while($row_genre = mysqli_fetch_assoc($getposts_genre))
		{
			$genre_name_sidebar = $row_genre['genre_name'];
			$genre_display_sidebar = $row_genre['genre_display'];
			echo"
			<li>
				<div style='margin-left:15%;'>
					<a href=$g_url"."videos/genre.php?genre=$genre_name_sidebar".">$genre_display_sidebar</a>
				</div>
			</li>
			";
		}
		?>
    </ul>
</div>
<div class="modal" id="videos-terms-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
  		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<center><h4 class="modal-title" id="myModalLabel">Terms of Service</h4></center>
      		</div>
	      	<div class="modal-body">
	      		<ul>
	      			<li>
	      				Fast forwarding a video does not help in crediting balance into your account. You have to play the entire video to get credit.
	      			</li><br>
	      			<li>
						On opening multiple videos simultaneously from a single user account, amount will be credited only for the last opened video.
					</li><br>
					<li>
						Sometimes, it may take a minute or two extra (after the video is over) for the amount to be credited into your account. 
						In such a case, please wait patiently till you get the amount for that video before moving on to the next video.
					</li><br>
	      		</ul>
	     		<div class="beforesubmit">
		      		<center>
						<button class="login-btn btn btn-primary btn-flat" data-dismiss="modal">Ok, I got it!</button><br><br>
			  		</center>
				</div>
	      	</div>
    	</div>
	</div>
</div>
<script src="<?php echo $g_url;?>js/adjust_sidebar.js"></script>
<!-- /#sidebar-wrapper -->