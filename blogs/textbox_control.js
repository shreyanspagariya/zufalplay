$(document).ready(function(){
	
	var post_url_width = $('[name="post_img_url"]').css("width");

	function parseforURL(text){
		var url_pattern = new RegExp("((http|https)(:\/\/))?([a-zA-Z0-9]+[.]{1}){2}[a-zA-z0-9]+(\/{1}[a-zA-Z0-9]+)*\/?", "i");
		if(url_pattern.exec(text) == null || url_pattern.exec(text).index > 0) { 
  			console.log("Invalid URL");
  			return false;
		} 
		else{
			console.log("Valid URL");
			return true;
		}
	}
	$("#text_editor").keyup(function(e){
		/*
		var text = $("#text_editor").text();
		console.log(text);
		parseforURL(text);
		*/
	});

	var image_counter=1;

	$("#control_panel_image").click(function(){
		var url = prompt("Enter URL of the image");
		if(url != null && parseforURL(url)){
			
			var htmlstring = document.getElementById("text_editor").innerHTML;
			var img_id = "img"+image_counter.toString();

			var get_location = function(href){
				var l = document.createElement("a");
				l.href = href;
				return l;
			};

			var l = get_location(url);

			var host_name = l.hostname;

			document.execCommand('insertHTML',true,'<br><center><img src="'+url+'" id ="'+img_id+'" class="post_img"></img><br><br><font class = "post_img_source">Image Source : <a href="http://'+host_name+'" target="_blank">'+host_name+'</a></center><br>');
			
			document.getElementsByName("post_content")[0].value = document.getElementById("text_editor").innerHTML; //Manual copy from Editor to dummy textarea due to absence of 'onekeyup' for this operation.

			image_counter++;
		}
	});

	var video_counter = 1;
	$("#control_panel_video").click(function(){
		var url = prompt("Enter URL of the video");
		if(url != null && parseforURL(url)){
			
			var htmlstring = document.getElementById("text_editor").innerHTML;
			var img_id = "vid"+video_counter.toString();

			var get_location = function(href){
				var l = document.createElement("a");
				l.href = href;
				return l;
			};

			var l = get_location(url);

			var host_name = l.hostname;
			var url = url.replace("watch?v=", "embed/");
			document.execCommand('insertHTML',true,'<br><center><iframe allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" width="'+parseInt(post_url_width)/1.5+'" height="315" src="'+url+'" id ="'+img_id+'" class="post_vid"></iframe><br><br><font class = "post_img_source">Video Source : <a href="http://'+host_name+'" target="_blank">'+host_name+'</a></center><br>');
			
			document.getElementsByName("post_content")[0].value = document.getElementById("text_editor").innerHTML; //Manual copy from Editor to dummy textarea due to absence of 'onekeyup' for this operation.

			video_counter++;
		}
	});

	$("#control_panel_hyperlink").click(function(){
		var url = prompt("Enter URL of the hyperlink");
		if(url != null && parseforURL(url)){
			var selection = document.getSelection();
			document.execCommand("CreateLink",false,url);
			selection.anchorNode.parentElement.target = '_blank';
		}
	});

});