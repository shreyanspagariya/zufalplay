<style>
.pushup {
  margin-top:-8px;
  margin-bottom:38px;
}
</style>
 
<?php 
if(isset($_SESSION["email1"]))
{?>
	<div class="pushup">
	<footer class="footer navbar-fixed" style="background-color:rgba(0,0,0,0.7);width: 100%;position: fixed;z-index: 10">
	  <div class="">
	    <div class="col-md-1"></div>
	    <div class="">
	      <ul class="nav navbar-nav">
	        <li style='margin-left:115px' class=""><a href="<?php echo $g_url.'market/redeemedcoupons.php'; ?>">View Redeemed Coupons</a></li>
	      </ul>
	    </div>
	  </div>
	</footer> 
	</div>
	<?php
}?>