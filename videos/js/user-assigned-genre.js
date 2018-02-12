function finalize_user_assigned_genre()
{
	$('.assign-genre-loading').removeClass('hidden');
	$('#finalize_genre').hide();
	$("input[name='genre_name']").attr("disabled",true);

	var genre_name = $("input[name='genre_name']:checked").val();
	if(!genre_name)
	{
		genre_name = "";
	}
	var video_unique_code = document.getElementById("video_unique_code").value;

	$.ajax(
	  {
		url: "../videos/backend/user-assigned-genre.php",
	    dataType: "json",
	    type:"POST",
	    data:
	    {
	      mode:'user_assigned_genre',
	      genre_name:genre_name,
	      video_unique_code:video_unique_code
	    },
	    success: function(json)
	    {
	      if(json.status==1)
	      {
	    	$('.assign-genre-loading').addClass('hidden');
	    	$('#success_message').html("<font size='3' color='green'><i class='fa fa-check-circle' aria-hidden='true'></i></font> Successfully assigned <b>'"+json.genre_display+"'</b> Genre to this Video.");
	      }
	      else if(json.status==0)
	      {
	      	$('.assign-genre-loading').addClass('hidden');
	      	$('#finalize_genre').show();
			$("input[name='genre_name']").attr("disabled",false);
	    	$('#success_message').html("<font size='3' color='orange'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></font> Please select a Genre.");
	      }
	    },
	    error : function()
	    {
	      //console.log("something went wrong");
	    }
	  });
}