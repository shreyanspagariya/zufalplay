if($( window ).width() < 1200)
{
	$("#sidebar-wrapper").hide();
	$("#sidebar-toggle-button").show();
}

function sidebar_toggle() 
{
  $("#sidebar-wrapper").toggle();
}