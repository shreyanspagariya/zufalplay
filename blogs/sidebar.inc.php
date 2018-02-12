<div id="sidebar-wrapper" style="margin-top:-0.5%; background:#F2F2F2; overflow-x: hidden; margin-left:-290px; padding-left:7px;">
    <ul class="sidebar-nav">
        <br>
        <div style="margin-left:15%; margin-top:-5%;">
            <li style=''>
                <a href="<?php echo $g_url.'blogs/';?>"><font size='4' color='#B43104'><i class="fa fa-book" aria-hidden="true"></i></font>&nbsp; Read</a>
            </li>
            <li style=''>
                <a <?php if(isset($_SESSION["email1"])){echo "href=".$g_url.'blogs/preadd.php';}else {echo "data-toggle='modal' href='#login-login-modal'";}?>><font size='4' color='#045FB4'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></font>&nbsp; Write & Earn</a>
            </li>
            <li style=''>
                <a <?php if(isset($_SESSION["email1"])){echo "href=".$g_url.'blogs/myposts.php?type=published_posts';}else {echo "data-toggle='modal' href='#login-login-modal'";}?>><font size='4' color='#DF7401'><i class="fa fa-list-ul" aria-hidden="true"></i></font>&nbsp; My Posts</a>
            </li>
            <li style=''>
                <a <?php if(isset($_SESSION["email1"])){echo "href=".$g_url.'blogs/myposts.php?type=drafts';}else {echo "data-toggle='modal' href='#login-login-modal'";}?>><font size='4' color='#424242'><i class="fa fa-file-text-o" aria-hidden="true"></i></font>&nbsp; Drafts</a>
            </li>
            <li style=''>
                <a <?php if(isset($_SESSION["email1"])){echo "href=".$g_url.'blogs/analytics/';}else {echo "data-toggle='modal' href='#login-login-modal'";}?>><font size='4' color='#088A08'><i class="fa fa-bar-chart" aria-hidden="true"></i></font>&nbsp; Analytics</a>
            </li>
            <hr>
            <li style=''>
                <a href="<?php echo $g_url.'blogs/?sort_by=trending';?>"><font size='4' color='#0080FF'><i class="fa fa-line-chart" aria-hidden="true"></i></font>&nbsp; Trending Posts</a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'blogs/?sort_by=top_viewed';?>"><font size='4' color='#585858'><i class="fa fa-search" aria-hidden="true"></i></font>&nbsp; Top Viewed Posts</a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'blogs/?view=tags';?>"><font size='4' color='#DF0101'><i class="fa fa-tags" aria-hidden="true"></i></font>&nbsp; Popular Tags</a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'blogs/?sort_by=recent_posts';?>"><font size='4' color='#FFBF00'><i class="fa fa-hourglass-start" aria-hidden="true"></i></font>&nbsp; Recent Posts</a>
            </li>
            <li style=''>
                <a href="<?php echo $g_url.'blogs/?sort_by=recommended_posts';?>"><font size='4' color='#8904B1'><i class="fa fa-magic" aria-hidden="true"></i></font>&nbsp; Recommended</a>
            </li>
            <?php
            if(isset($_GET["id"]))
            {?>
                <hr>
                <li style=''>
                    <span id='draft_status' align='right' style='margin-bottom:-30px; margin-top:10px;'><font color='green' size='4'><i class="fa fa-check-circle" aria-hidden="true"></i></font> <i>Draft Autosaved.</i></span>
                </li>
                <?php 
            }
            else
            {?>
                <hr>
                <div style="margin-left:17%">
                    <a href='https://www.facebook.com/zufalplay' target='_blank'><font size='4' color='#3b5998'><i class="fa fa-facebook" aria-hidden="true"></i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href='https://twitter.com/zufalplay' target='_blank'><font size='4' color='#0084b4'><i class="fa fa-twitter" aria-hidden="true"></i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href='https://www.linkedin.com/company/zufalplay' target='_blank'><font size='4' color='#4875B4'><i class="fa fa-linkedin-square" aria-hidden="true"></i></font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href='https://plus.google.com/+Zufalplay_Official/posts' target='_blank'><font size='4' color='#C63D2D'><i class="fa fa-google-plus" aria-hidden="true"></i></font></a>
                </div>
                <?php 
            }
            ?>
        </div>
    </ul>
</div>
<script src="<?php echo $g_url;?>js/adjust_sidebar.js"></script>
