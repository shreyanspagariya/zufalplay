<?php
include ("../inc/header.inc.php"); 
 
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
if(isset($_GET['id']))
{
	$unique_id = mysqli_real_escape_string($con,$_GET['id']);

	$query = "SELECT * FROM blogposts WHERE unique_id='$unique_id'";
	$result = mysqli_query($con,$query);
	$get = mysqli_fetch_assoc($result);
	$numResults = mysqli_num_rows($result);

	if($numResults != 0)
	{
		$post_title = $get["post_title"];
		$post_img_url = $get['post_img_url'];
		$post_content = $get["post_content"];
		
		for($i=1;$i<=5;$i++)
		{
			$tag[$i] = $get["tag$i"];
		}
	}
}
?>

<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?>Add Post - Zufalplay</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="control_text_editor_design.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script type="text/javascript" src="textbox_control.js"></script>
<script type="text/javascript" src="automatic_resizing.js"></script>
<style type="text/css">
 a:hover {
  cursor:pointer;
 }
</style>
</head>
<body class="zfp-inner">
	<div class='col-md-2'>
		<?php include ("sidebar.inc.php"); ?>
	</div>
	<div class="col-md-8 elevatewhite">
		<form action="completepublish.php" method="POST" autocomplete="off">
			<h4><b>Post Title</b></h4>
			<input onkeyup='change_draft_status()' style="width:100%; height:40px; padding:5px;" name="post_title" value="<?php echo $post_title;?>" id='auto_save_post_title'><br><br>
			
			<h4><b>Post Image (Thumbnail) URL</b></h4>
			<input onkeyup='change_draft_status()' style="width:100%; height:40px; padding:5px;" name="post_img_url" value="<?php echo $post_img_url;?>" id='auto_save_post_img_url'><br><br>
			
			<h4><b>Content Body</b></h4>
			<!--<textarea onkeyup='change_draft_status()' id="editor1" rows="10" cols="80" name="post_content"  id='auto_save_post_content'><?php echo $post_content;?></textarea><br>
			-->
			
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
					<div id='text_editor' contenteditable="true" onkeyup='change_draft_status()'>
						<?php echo $post_content;?>
					</div>
				</div>
			</div>

			<textarea name="post_content" id='auto_save_post_content' style="display:none;"><?php echo $post_content;?></textarea>

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

			<input name="unique_id" value="<?php echo $unique_id;?>" id='auto_save_unique_id' hidden>
			
			<button class="btn btn-primary btn-flat">Publish Post</button>
			<br><br><br>
		</form>
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

	function change_draft_status()
	{
		document.getElementsByName("post_content")[0].value = document.getElementById("text_editor").innerHTML;
		$("#draft_status").html("<font color='orange' size='4'><i class='fa fa-circle' aria-hidden='true'></i></font> <i>Saving Draft...</i>");
	}

	function suggest_tag(x,i)
	{
		change_draft_status();

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
