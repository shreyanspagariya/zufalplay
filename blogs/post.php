<?php
include ("../inc/extuser.inc.php"); 
include ("blog-entity.php");
if(isset($_SESSION["email1"]))
{
	top_banner();
}
else
{
	top_banner_extuser();
}
?>

<?php
if(isset($_GET['r']))
{
	$post_url = mysqli_real_escape_string($con,$_GET['title']);

	$unique_id = mysqli_real_escape_string($con,$_GET['r']);

	$query = "SELECT * FROM blogposts WHERE unique_id='$unique_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$numResults = mysqli_num_rows($result);

	if($numResults != 0)
	{
		$post_title = $get["post_title"];
		$post_url = $get['post_url'];
		$post_img_url = $get['post_img_url'];
		$post_views = number_format($get['post_views']);
		$post_content = $get["post_content"];
		$blogger_unique_id = $get['blogger_unique_id'];
		$time_published = $get['time_published'];

		$word_count = str_word_count(strip_tags($post_content));
		$read_duration_sec = ($word_count/200)*60;

		mysqli_query($con,"UPDATE blogposts SET read_duration_sec='$read_duration_sec' WHERE unique_id = '$unique_id'");
		
		for($i=1;$i<=5;$i++)
		{
			$tag[$i] = mysqli_real_escape_string($con,$get["tag$i"]);
		}

		$query = "SELECT * from table2 where unique_name='$blogger_unique_id'";
		$result = mysqli_query($con,$query);
		$numResults = mysqli_num_rows($result);
		$get2 = mysqli_fetch_assoc($result);
		$fnamex = $get2['fname'];
		$lnamex = $get2['lname'];
		$emailx = $get2['email'];
	}

	$edit = 0;
	if(isset($_GET['edit']))
	{
		if($_GET['edit'] == "true")
		{
			if(!isset($_SESSION["email1"]) || $_SESSION["email1"] != $emailx)
			{
				
			}
			else
			{
				$edit = 1;
			}

			if($_SESSION["email1"] == "shreyanspagariya@gmail.com")
			{
				$edit = 1;
			}
		}
	}
	function generateRandomString($length = 10) 
	{
	    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789abcdefghijklmnopqrstuvwxyz-';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	$read_id = generateRandomString();
	$query = "SELECT * FROM read_history WHERE read_id='$read_id'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);

	while($numResults!=0)
	{
		$read_id = generateRandomString();
		$query = "SELECT * FROM read_history WHERE read_id='$read_id'";
		$result = mysqli_query($con,$query);
		$numResults = mysqli_num_rows($result);
	}

	date_default_timezone_set('Asia/Kolkata');
	$datetime = date("Y-m-d H:i:sa");

	if(!empty($_SERVER['HTTP_CLIENT_IP'])) 
	{
	    $ip = $_SERVER['HTTP_CLIENT_IP'];
	} 
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
	{
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} 
	else 
	{
	    $ip = $_SERVER['REMOTE_ADDR'];
	}

	$query = "SELECT * FROM read_history WHERE unique_id='$unique_id' AND ip_address='$ip'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$numResults_ip = mysqli_num_rows($result);

	$query = "SELECT * FROM read_history WHERE unique_id='$unique_id' AND user_id_read='$user_id_x'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$numResults_useraccount = mysqli_num_rows($result);

	if((isset($_SESSION["email1"]) && $blogger_unique_id == $unique_name) || (isset($_SESSION["email1"]) && $numResults_useraccount != 0) || (!isset($_SESSION["email1"]) && $numResults_ip != 0))
	{
		$is_money_distributed = -1;
	}
	else
	{
		$is_money_distributed = 0;
		mysqli_query($con,"UPDATE blogposts SET post_views = post_views + 1 WHERE unique_id = '$unique_id'");
	}

	//Taking Care of multiple load case - leading to 0 duration reads

	$query = "SELECT * FROM read_history WHERE user_id_read='$user_id_x' AND unique_id='$unique_id' AND ip_address='$ip' AND is_money_distributed='0'";
	$result = mysqli_query($con,$query);
	$numResults = mysqli_num_rows($result);
	$get = mysqli_fetch_assoc($result);

	if($numResults > 0)
	{
		$read_id = $get['read_id'];
	}
	else
	{
		mysqli_query($con,"INSERT INTO read_history (start_time,read_duration_sec,user_id_read,unique_id,ip_address,read_id,end_time,is_money_distributed) VALUES ('$datetime','0','$user_id_x','$unique_id','$ip','$read_id','$datetime','$is_money_distributed')");
	}
}
?>

<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> <?php echo $post_title;?>  - Write and Earn @Zufalplay</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="control_text_editor_design.css">
<style type="text/css">
 a:hover {
  cursor:pointer;
 }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script type="text/javascript" src="textbox_control.js"></script>
<script type="text/javascript" src="automatic_resizing.js"></script>
<img src="<?php echo $post_img_url;?>" hidden>
</head>
<input id="read_id" value="<?php echo $read_id;?>" hidden>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8 elevatewhite" style='padding-top:2px;'>
		<?php 
		if($edit == 0)
		{
			$time = strtotime($time_published);
			$display_date = date("D, d M Y", $time);
			?>
			<h3><b><?php echo $post_title;?></b></h3>
			by&nbsp;&nbsp;<a href="<?php echo $g_url.'profile.php?id='.$blogger_unique_id;?>" target='_blank'><b><?php echo $fnamex." ".$lnamex; ?></b></a> on <b><?php echo $display_date;?></b>
			&nbsp;&nbsp;
			<?php
				if($blogger_unique_id == $unique_name || $unique_name=="shreyans.pagariya.1")
				{
					echo"<a href=$g_url"."blogs/post.php?title=".$post_url."&r=".$unique_id."&edit=true><i class='fa fa-pencil' aria-hidden='true'></i>&nbsp;Edit</a>
					";
				}
			?>
			<?php
				$fb_share_url = $g_url."blogs/post.php?title=".$post_url."&r=".$unique_id;
			?>
			<hr>
			<font size='3'><?php echo $post_content;?></font>
			<br>
		<h4>Tags:</h4><br>
		<?php
			for($i=1;$i<=5;$i++)
			{
				if($tag[$i] != "")
				{
					$query = "SELECT * FROM blogpost_tags WHERE tag_name='$tag[$i]'";
					$result = mysqli_query($con,$query);
					$get = mysqli_fetch_assoc($result);
					$tag_url = $get['tag_url'];

					if($is_money_distributed==0)
					{
						mysqli_query($con,"UPDATE blogpost_tags SET tag_views = tag_views + 1 WHERE tag_name='$tag[$i]'");
					}

					echo "<a href=".$g_url."blogs/?tag=$tag_url><span style='background:#D8D8D8; color:#585858; padding:8px; display:inline-block; margin-top:3px; margin-bottom:3px; margin-left:2px; margin-right:2px;'>$tag[$i]</span></a>
					";
				}
			}
			?>
			<br><br><hr>
			<div class="fb-share-button" data-href="<?php $fb_share_url;?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php $fb_share_url?>&src=sdkpreparse">Share</a></div>
			<hr>
			<div class="fb-comments" data-href="<?php $fb_share_url;?>" data-numposts="5"></div>
			<?php
		}
		else
		{
			?>
			<form action="completeedit.php" method="POST" autocomplete="off">
				<h4><b>Post Title</b></h4>
				<input style="width:100%; height:40px; padding:5px;" value="<?php echo $post_title;?>" name="post_title"><br><br>
				
				<h4><b>Post Image (Thumbnail) URL</b></h4>
				<input style="width:100%; height:40px; padding:5px;" value="<?php echo $post_img_url;?>" name="post_img_url"><br><br>
				
				<h4><b>Content Body</b></h4>
				<div id='controlbox_text_editor'>
					<img  id="control_panel_image" src="img_picture.png" alt="Add Image" style="cursor:pointer"></img>
					<img  id="control_panel_video" src="video_picture.png" alt="Add Video" style="cursor:pointer"></img>
					<img  id="control_panel_hyperlink" src="hyperlink_picture.png" alt="Hyperlink Text" style="cursor:pointer"></img>
					<img  onclick="document.execCommand('insertorderedlist');" id="control_panel_numberedlist" src="numberedlist_picture.png" alt="Numbered List" style="cursor:pointer"></img>
					<img  onclick="document.execCommand('insertunorderedlist');" id="control_panel_unnumberedlist" src="unnumberedlist_picture.png" alt="List" style="cursor:pointer"></img>
					<img  onclick="document.execCommand('bold',false,null);" id="control_panel_bold" src="bold_picture.png" alt="Bold Text" style="cursor:pointer"></img>
					<img  onclick="document.execCommand('italic',false,null);" id="control_panel_italic" src="italic_picture.png" alt="Italic Text" style="cursor:pointer"></img>
					<img  onclick="document.execCommand('underline',false,null);" id="control_panel_underline" src="underline_picture.png" alt="Underline Text" style="cursor:pointer"></img>
				</div>
			
				<div id='wrapper_text_editor_out'>
					<div id='wrapper_text_editor_in'>
						<div id='text_editor' contenteditable="true" onkeyup='make_copy()'>
							<?php echo $post_content;?>
						</div>
					</div>
				</div>

				<textarea name="post_content" style="display:none;"><?php echo $post_content;?></textarea>

				<script>
					function make_copy() 
					{
						document.getElementsByName("post_content")[0].value = document.getElementById("text_editor").innerHTML;	
					}
				</script>

				<h4><b>Tags (Max. 5)</b></h4>
				<div class='row'>
					<?php
						for($i=1;$i<=5;$i++)
						{
							$tag_x = $tag[$i];
							echo"
							<div class='col-md-2' style='margin-right:20px;'>
								<input name='tag$i' id='auto_save_tag$i' onkeyup='suggest_tag(this.value,$i)' value='$tag_x'>
								<span class='showsuggest$i'></span>
							</div>
							";
						}
					?>
				</div>
				<br><br>

				<input name="unique_id" value="<?php echo $unique_id;?>" hidden>

				<button class="btn btn-primary btn-flat">Save Changes</button>
			</form>
			<?php
		}
		?>
		<br><br><br>
	</div>
	<div class="col-md-2">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="ca-pub-7888738492112143"
		     data-ad-slot="1322728114"
		     data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>

		<div class='' style='padding:10px;'>
			<center>
			<?php
				$getposts = mysqli_query($con,"SELECT * FROM blogposts WHERE is_published='1' ORDER BY RAND() LIMIT 10");
				while($row = mysqli_fetch_assoc($getposts))
				{
					echo_blog_entity_recommend($con, $row, $g_url);
				}
			?>
			</center>
		</div>

	</div>
</body>
<br>
<!--
<script src="//cdn.ckeditor.com/4.5.8/full/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'editor1' );
</script>
-->
<script>

	// $("#text_editor").bind("paste", function(e){
	// 	alert("Sorry, pasting into the editor is not allowed!");
	// 	e.preventDefault();
	// });

	function suggest_tag(x,i)
	{
		var tag_name = document.getElementById("auto_save_tag"+i).value;
		var tag_name_length = tag_name.length;

		if(tag_name_length > 0)
		{
			$.ajax(
	        {
	          url: "suggesttags.php",
	          dataType: "json",
	          type:"POST",
	          async: false,

	          data:
	          {
	            mode:'search',
	            tag_entered:tag_name,
	            tag_box_number:i,
	          },

	          success: function(json)
	          {
	            if(json.status==1)
	            {
	              $(".showsuggest"+i).html(json.msg);
	              $('#dropdownsearch'+i).find('[data-toggle=dropdown]').dropdown('toggle');
	              $("#auto_save_tag"+i).focus();
	            }
	            else
	            {
	              //console.log('Hi');
	            }
	          },
	          
	          error : function()
	          {
	          //console.log("something went wrong");
	          }
	      });
		}
	}

	function fill_tag(i,tag_name)
	{
		$("#auto_save_tag"+i).val(tag_name);
		$("#auto_save_tag"+(i+1)).focus();
	}
</script>
<?php include ("../inc/footer.inc.php"); ?>						
