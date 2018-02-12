var g_url='http://localhost:8080/zufalplay/';
//var g_url="http://www.zufalplay.com/";
function show_notification()
{
  var read_id = "-1";
  var auto_save_post_title = "DEFAULT";
  var auto_save_post_img_url = "DEFAULT";
  var auto_save_post_content = "DEFAULT";
  var auto_save_unique_id = "DEFAULT";
  var auto_save_tag1 = "DEFAULT";
  var auto_save_tag2 = "DEFAULT";
  var auto_save_tag3 = "DEFAULT";
  var auto_save_tag4 = "DEFAULT";
  var auto_save_tag5 = "DEFAULT";

  if(document.getElementById("read_id"))
  {
    read_id = document.getElementById("read_id").value;
  }

  if(document.getElementById("auto_save_post_title"))
  {
    /*
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
      
    */  
    auto_save_post_title = document.getElementById("auto_save_post_title").value;
    auto_save_post_img_url = document.getElementById("auto_save_post_img_url").value;
    auto_save_post_content = document.getElementsByName("post_content")[0].value;
    auto_save_unique_id = document.getElementById("auto_save_unique_id").value;
    auto_save_tag1 = document.getElementById("auto_save_tag1").value;
    auto_save_tag2 = document.getElementById("auto_save_tag2").value;
    auto_save_tag3 = document.getElementById("auto_save_tag3").value;
    auto_save_tag4 = document.getElementById("auto_save_tag4").value;
    auto_save_tag5 = document.getElementById("auto_save_tag5").value;
  }

  $.ajax(
  {
    url: g_url + "inc/getnotif.php",
    dataType: "json",
    type:"POST",
    data:
    {
      mode:'get_notif',
      read_id:read_id,
      auto_save_post_title:auto_save_post_title,
      auto_save_post_img_url:auto_save_post_img_url,
      auto_save_post_content:auto_save_post_content,
      auto_save_unique_id:auto_save_unique_id,
      auto_save_tag1:auto_save_tag1,
      auto_save_tag2:auto_save_tag2,
      auto_save_tag3:auto_save_tag3,
      auto_save_tag4:auto_save_tag4,
      auto_save_tag5:auto_save_tag5,
    },
    success: function(json)
    {
      var amount_multiplier = json.amount_multiplier;

      if(amount_multiplier >= 1)
      {
        $('#amount_multiplier').html("<font size='3' color='#01DF01'><i class='fa fa-caret-up' aria-hidden='true'></i></font> "+amount_multiplier+"x");
        $('#amount_multiplier_modal_1').html("<font color='#01DF01'><i class='fa fa-caret-up' aria-hidden='true'></i></font> <b>"+amount_multiplier+"</b>x");
      }
      else
      {
        $('#amount_multiplier').html("<font size='3' color='#FF0000'><i class='fa fa-caret-down' aria-hidden='true'></i></font> "+amount_multiplier+"x");
        $('#amount_multiplier_modal_1').html("<font color='#FF0000'><i class='fa fa-caret-down' aria-hidden='true'></i></font> <b>"+amount_multiplier+"</b>x");
      }
      if(json.status==1)
      {
        $('.top_notif').removeClass('hidden');
        $('.top_notif').addClass('animated slideInUp');
        $('.top_notif_msg').html("<div class='hrwhite'><a href="+g_url+json.notif_href+">"+
        	json.notif_text+"</div></a>"+"<br><div class='pull-left'><i class='fa fa-bell'></i>&nbsp;<small>New Notification</small></div><div class='pull-right'><i class='fa fa-clock-o'></i>&nbsp;<small>Just Now</small></div><br>");
        	
        	var sound = new Audio(g_url+"inc/notification.mp3");
			    sound.play();

          setTimeout(function(){
  
            $('.top_notif').removeClass('animated slideInUp');
            $('.top_notif').addClass('animated fadeOut');

          }, 5000)
      }
      else
      {
      }
      if(json.other_status == 2)
      {
        if(document.getElementById("draft_status"))
        {
          $("#draft_status").html("<font color='green' size='4'><i class='fa fa-check-circle' aria-hidden='true'></i></font> <i>Draft Autosaved.</i>");
        }
      }
    },
    error : function()
    {
      //console.log("something went wrong");
    }
  });

  setTimeout(function(){
  
    show_notification();

  }, 10000)
}
window.onload=show_notification();