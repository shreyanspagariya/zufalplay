<div id="sidebar-wrapper" style="margin-top:-0.5%; background:#F2F2F2; overflow-x: hidden; margin-left:-290px; padding-left:7px;">
    <ul class="sidebar-nav">
        <br>
        <div style="margin-left:15%; margin-top:-5%;">
            <li style=''>
                <a href="<?php echo $g_url.'games';?>"><font size='4'><i class="fa fa-gamepad"></i></font>&nbsp; Play Games</a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'videos';?>"><font size='4' color='#DF0101'><i class="fa fa-youtube-play"></i></font>&nbsp; Watch Videos</a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'blogs/';?>"><font size='4' color='#8000FF'><i class="fa fa-rss" aria-hidden="true"></i></font>&nbsp; Blogs<!-- &nbsp;<sup><span style='background-color:red; border-radius:50px; padding-top:1px; padding-bottom:1px; padding-left:3px; padding-right:3px; color:#FFF'>New!</span></sup>--></a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'donate/';?>"><font size='4' color='#DF0101'><i class="fa fa-heart-o" aria-hidden="true"></i></font>&nbsp; Donate</a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'market';?>"><font size='4' color='#088A08'><i class="fa fa-shopping-cart"></i></font>&nbsp; Market</a>
            </li>
            <li>
                <a <?php if(isset($_SESSION["email1"])){echo "href=".$g_url.'invite-earn';}else {echo "data-toggle='modal' href='#login-login-modal'";}?>><font size='3' color='#0080FF'><i class="fa fa-diamond"></i></font>&nbsp; Invite & Earn <!--<sup><span style='background-color:red; border-radius:50px; padding-top:1px; padding-bottom:1px; padding-left:3px; padding-right:3px; color:#FFF'>New</span></sup>--></a>
            </li>
            <!--<li>
                <a href="<?php echo $g_url.'contests';?>"><font size='4' color='#DF7401'><i class="fa fa-trophy"></i></font>&nbsp; Contests &nbsp;<sup><span style='background-color:red; border-radius:50px; padding-top:1px; padding-bottom:1px; padding-left:3px; padding-right:3px; color:#FFF'>Ongoing</span></sup></a>
            </li>-->
            <li style=''>
                <a href="<?php echo $g_url.'leaderboard';?>"><font size='3' color='#DBA901'><i class="fa fa-list-ol"></i></font>&nbsp; Leaderboard</a>
            </li><hr>
            <!--<li style=''>
                <a href="<?php echo $g_url;?>"><font size='4' color='#FF8000'><i class="fa fa-home"></i></font>&nbsp; Home</a>
            </li>-->
            <li style=''>
                <a href="<?php echo $g_url.'about';?>"><font size='4' color='#045FB4'><i class="fa fa-info-circle"></i></font>&nbsp; About Us</a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'about/privacy.php';?>"><font size='4' color='#B43104'><i class="fa fa-lock"></i></font>&nbsp; Privacy Policy</a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'about/contact.php';?>"><font size='4' color='#8904B1'><i class="fa fa-phone"></i></font>&nbsp; Contact Us</a>
            </li><hr>
            <div style="margin-left:17%">
                <a href='https://www.facebook.com/zufalplay' target='_blank'><font size='4' color='#3b5998'><i class="fa fa-facebook" aria-hidden="true"></i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href='https://twitter.com/zufalplay' target='_blank'><font size='4' color='#0084b4'><i class="fa fa-twitter" aria-hidden="true"></i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href='https://www.linkedin.com/company/zufalplay' target='_blank'><font size='4' color='#4875B4'><i class="fa fa-linkedin-square" aria-hidden="true"></i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href='https://plus.google.com/+Zufalplay_Official/posts' target='_blank'><font size='4' color='#C63D2D'><i class="fa fa-google-plus" aria-hidden="true"></i></font></a>
            </div>
        </div>
    </ul>
</div>
<script src="<?php echo $g_url;?>js/adjust_sidebar.js"></script>