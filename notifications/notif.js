function notifread (notif_id) {
	$.ajax(
	{
	  url: g_url+"notifications/notifread.php",
	  dataType: "json",
	  type:"POST",
	  data:
	  {
	  	notif_id:notif_id,
	  },
	  success: function(json)
	  {
		if(json.status==1)
		{
			$('#unread'+notif_id).removeClass('unread');
			$('#countunseen').html(json.unseen);
			$('#unseenbadge').html(json.unseen);
		}
		else
		{
		  
		}
	  },
	  error : function()
	  {
		//console.log("something went wrong");
	  }
	});
}