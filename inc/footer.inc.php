<div style="position: fixed; bottom:0; z-index:1000;">
    <div class="alert alert-zfp alert-dismissible hidden top_notif" role="alert" align="center" style="margin-bottom:50px;">
      <!--<button type='button' class='close' data-dismiss='alert' aria-label='Close'><i class='fa fa-times-circle'></i></button>-->
      <p class="top_notif_msg"></p>
    </div>
</div>

<footer class="footer navbar-fixed-bottom" style="background-color:#382762" hidden>
  <div class="container">
  	<div class="col-md-8">
    	<ul class="nav navbar-nav">
        <li class=""><a href="<?php echo $g_url.'about'; ?>">About</a></li>
        <li class=""><a href="<?php echo $g_url.'games'; ?>">Games</a></li>
        <li class=""><a href="<?php echo $g_url.'videos'; ?>">Videos</a></li>
        <li class=""><a href="<?php echo $g_url.'market'; ?>">Market</a></li>
        <li class=""><a href="<?php echo $g_url.'contests'; ?>">Contests</a></li>
        <li class=""><a href="<?php echo $g_url.'invite-earn'; ?>">Invite & Earn</a></li>
        <li><a href="<?php echo $g_url.'about/privacy.php'; ?>">Privacy Policy</a></li>
        <li><a href="<?php echo $g_url.'about/contact.php'; ?>">Contact Us</a></li>
        <li>
        </li>
      </ul>
  	</div>
  	
  </div>
</footer>
<script>
    var _gaq = _gaq || [];  
    _gaq.push(['_setAccount', 'UA-65871967-1']);  
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>

<!--<h1 hidden><span></span></h1>-->

<!--<div class="modal" id="adblock-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center><h4 class="modal-title" id="myModalLabel">Please Disable Adblock</h4></center>
      </div>
      <div class="modal-body">
        <div class="beforesubmit">
          <center>
            Sorry, we detect your <b>AdBlock</b> extension is active.<br>
            Please <b>turn off</b> or <b>remove</b> your <b>adblock</b> extension before browsing the website!<br><br>
            Appreciate us by viewing the ads we provide.<br>
            Ads help us to keep the website active and growing.<br>
            Thank You.<br><br>
            <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal" aria-label="Close">Ok, I got it!</button>
          </center> 
        </div>
      </div>
    </div>
  </div>
</div>-->

<div class="modal" id="amount-multiplier-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center><h4 class="modal-title" id="myModalLabel">The Multiplier</h4></center>
      </div>
      <div class="modal-body">
        <div class="beforesubmit">
          <center>
            <span id='amount_multiplier_modal_1' style='font-size:72px;'></span><br><br>
            The amount you receive will be multiplied by the above factor before it gets credited to your account. 
            This adjustment takes into consideration two main factors - traffic on Zufalplay and funds available with Zufalplay.
            The Multiplier gets updated every 10 seconds in order to make a fair real time adjustment.<br><br>
            <button class="login-btn btn btn-primary btn-flat" data-dismiss="modal">Ok, I got it!</button><br><br>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>  
<script src="<?php echo $g_url;?>adblock/fuckadblock.js"></script>
<script src="<?php echo $g_url;?>adblock/detectadblock.js"></script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="<?php echo $g_url;?>js/signup_login.js"></script>
<script src="<?php echo $g_url;?>js/bootstrap.min.js"></script>
<script src="<?php echo $g_url;?>js/smoothscroll.js"></script>
<script src="<?php echo $g_url;?>js/searchsuggest.js"></script>
<script src="<?php echo $g_url;?>notifications/notif.js"></script>
<script src="<?php echo $g_url;?>js/recursive.js"></script>
<?php if(isset($_SESSION["email1"]))
  {
    mysqli_query($con,"UPDATE table2 SET pageviews = pageviews + 1, total_time_on_site = total_time_on_site - 10 WHERE email = '$email'");
  }
?>

<script>
  function adblock_popup() 
  {
      var x = $('h1 span').text();
      if(x.localeCompare("yes") == 0)
      {
        $('#adblock-modal').modal('show');
      }
  }
</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var $_Tawk_API={},$_Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/55ca28dc9f1e65a7205a162c/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>