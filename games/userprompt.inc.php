<?php 
if(!isset($_SESSION["email1"]))
{
	?>
	<script>
	   $(window).load(function(){
	   		$('#signup-login-modal .modal-dialog .modal-content .modal-header .modal-title').text("Want to earn by playing this game? Signup Now!");
	        $('#signup-login-modal').modal('show');
	    });
	</script>
	<?php
}
?>