var g_url='http://localhost:8080/zufalplay/';
//var g_url="http://www.zufalplay.com/";
/* checking for availability of email id */
function validateEmail()
{
  clearInputError(); 
  var fname= $('.fname').val();
  var lname= $('.lname').val();
  var email= $('.email').val();
  var password= $('.password').val();
  var password1= $('.password1').val();
  var campaign_id = $('.campaign_id').val();
  var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
  if(fname=="" || lname=="" || email==""|| password=="" ||password1=="")
  {
    if(fname==""){$('.invalid_fname').html('<b>Please enter a valid First Name</b>');}
    if(lname==""){$('.invalid_lname').html('<b>Please enter a valid Last Name</b>');}
    if(email==""){$('.invalid_email').html('<b>Please enter a valid Email Id</b>');}
    if(password==""){$('.invalid_password').html('<b>Password cannot be left blank</b>');}
    if(password1==""){$('.invalid_password1').html('<b>Password cannot be left blank</b>');}
  }
  else if(password != password1)
  {
  	$('.invalid_password1').html('<br><b>Passwords do not match</b>');
  }
  else if(pattern.test(email))
  {
  	$('.dupemail-loading').removeClass('hidden');
    $.ajax(
    {
      url: g_url+"signup.php",
      dataType: "json",
      type:"POST",
      data:
      {
        mode:'valid_email',
        email:email,
      },
      success: function(json)
      {
        if(json.status==1)
        {
          if(json.msg == "duplicate_email")
          {
          	$('.dupemail-loading').addClass('hidden');
            $('.invalid_email').html('<br><b>This Email is already registered on Zufalplay</b>');
          }
        }
        else
        {
          //console.log('Hi');
          createUser();
        }
      },
      error : function()
      {
        //console.log("something went wrong in email checking!");
      }
    });
  }
  else
  {
    $('.invalid_email').html('<b>Please enter a valid Email Id</b>');
  }

}
$("#register-form").submit(function(e) {
    e.preventDefault();
});
$("#login-form").submit(function(e) {
    e.preventDefault();
});
function clearInputError()
{
  $('.status').html("");
}
/* creating a new user */
function createUser()
{

  $('#signup-login-modal .modal-body .beforesubmit').addClass('hidden');
  $('.signup-loading').removeClass('hidden');

  var fname= $('.fname').val();
  var lname= $('.lname').val();
  var email= $('.email').val();
  var password= $('.password').val();
  var password1= $('.password1').val();
  var campaign_id = $('.campaign_id').val();
  //console.log(fname);
    $.ajax(
    {
      url: g_url+"signup.php",
      type:"POST",
      data:
      {
        mode:'signup',
        fname:fname,
        lname:lname,
        email:email,
        password:password,
        campaign_id:campaign_id,
      },
      success: function()
      {
      	$('.signup-loading').addClass('hidden');
        $('.signup-success').html("<b>A Confirmation email has been sent to the email address associated with this account. If you do not receive the message within a few minutes, please check your 'Promotions' or 'Spam' email folders. You must verify your email account to login.</b><br>");
      },
      error: function()
      {
        $('.signup-success').html("Some unknown error occurred. Try again or drop a line in the chatbox below for assistance!");
      }
    });
}
/*Login*/
function verifyLogin()
{

  $('#login-login-modal .modal-body .beforesubmit').addClass('hidden');
  $('.login-loading').removeClass('hidden');

  email = $('.login_email_modal').val();
  password = $('.login_password_modal').val();

  $.ajax(
    {
      url: g_url+"login.php",
      dataType:"json",
      type:"POST",
      data:
      {
        email:email,
        password:password,
        fb_picture_url:"",
      },
      success: function(json)
      {
        if(json.status == 1)
        {
    			if(json.msg=='not_verified')
    			{
    				$('#login-login-modal .modal-body .beforesubmit').removeClass('hidden');
  					$('.login-loading').addClass('hidden');

    				$('.invalid_email_or_password').html('<br><b>Your email is not verified. Please verify your email account to continue.</b>');
    			}
    			else
    			{
    				//window.location.replace(g_url+"games");
            		location.reload();
    			}
        }
        else
        {
        	$('#login-login-modal .modal-body .beforesubmit').removeClass('hidden');
  			$('.login-loading').addClass('hidden');

         	$('.invalid_email_or_password').html('<br><b>Invalid email or password. Please try again!</b>');
        }
      },
      error: function()
      {
      	$('#login-login-modal .modal-body .beforesubmit').removeClass('hidden');
  		$('.login-loading').addClass('hidden');
      	$('.invalid_email_or_password').html('<br><b>Some unknown error occurred. Try again or drop a line in the chatbox below for assistance!</b>');
      }
    });
}
function verifyLogin_FB()
{
  var email= $('.login_email').val();
  var password= $('.login_password').val();
  var fb_picture_url=document.getElementById("fb_picture_url").value;
  $.ajax(
    {
      url: g_url+"login.php",
      dataType:"json",
      type:"POST",
      data:
      {
        email:email,
        password:password,
        fb_picture_url:fb_picture_url,
      },
      success: function(json)
      {
        if(json.status == 1)
        {
          if(json.msg=='not_verified')
          {
            $('.top_notif').removeClass('hidden');
            $('.top_notif_msg').html("<b>Your email is not verified. Please verify your email account to continue.</b>");
          }
          else
          {
            //window.location.replace(g_url+"games");
            location.reload();
          }
        }
        else
        {
          $('.top_notif').removeClass('hidden');
          $('.top_notif_msg').html('Invalid email or password. Please try again!');
        }
      },
      error: function()
      {
        $('.top_notif_msg').html("Some unknown error occurred. Try again or drop a line in the chatbox below for assistance!");
      }
    });
}