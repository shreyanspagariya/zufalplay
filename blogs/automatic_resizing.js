$(document).ready(function(){

	var post_url_width = $('[name="post_img_url"]').css("width");
	$("#wrapper_text_editor_out").css("width",post_url_width);
	$("#text_editor").css("width",post_url_width);
	$("#controlbox_text_editor").css("width",post_url_width);

	$("#control_panel_image").css('left',Math.round(parseInt(post_url_width)/60)+'px');
	$("#control_panel_video").css('left',Math.round(parseInt(post_url_width)/30)+'px');
	$("#control_panel_hyperlink").css('left',Math.round(parseInt(post_url_width)/20)+'px');
	$("#control_panel_numberedlist").css('left',Math.round(parseInt(post_url_width)/1.48)+'px');
	$("#control_panel_unnumberedlist").css('left',Math.round(parseInt(post_url_width)/1.45)+'px');
	$("#control_panel_bold").css('left',Math.round(parseInt(post_url_width)/1.42)+'px');
	$("#control_panel_italic").css('left',Math.round(parseInt(post_url_width)/1.4)+'px');
	$("#control_panel_underline").css('left',Math.round(parseInt(post_url_width)/1.39)+'px');
});