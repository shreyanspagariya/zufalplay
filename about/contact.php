<?php include ("../inc/extuser.inc.php");
if(isset($_SESSION["email1"]))
{
  top_banner();
}
else
{
  top_banner_extuser();
}
?>
<head>
<title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Contact Us - Zufalplay</title>
<link href="<?php echo $g_url.'css/simple-sidebar.css'?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body class="zfp-inner">
  <div class="col-md-2">
    <?php include ("../inc/sidebar.inc.php"); ?>
    </div>
  <div class="col-md-8 hrwhite elevatewhite">
     <center><h2>Contact Us</h2><hr></center>

      <h3>Address</h3>
      <p>
        <strong>Zufalplay</strong><br>
        #B-302<br>
        Lal Bahadur Shastri Hall of Residence<br>
        IIT Kharagpur Campus<br>
        West Bengal - 721 302<br>
        Phone: +91 - 7872 686 590<br>
        Email: <a href="mailto:team@zufalplay.com">team@zufalplay.com</a>
      </p>

      <h3>Queries</h3>
      <p>If you have questions, suggestions or concerns, we'd love to hear from you. Please text us right away in the query box or drop a mail to team@zufalplay.com</p>

      <h3>Careers</h3>
      <p>Interested in what we are doing and want to work with us? Drop us a mail at team@zufalplay.com</p>
      <br>
  </div>
  <div class="col-md-2"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7888738492112143"
     data-ad-slot="1322728114"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
  </div>
</body>
<?php include ("../inc/footer.inc.php"); ?> 