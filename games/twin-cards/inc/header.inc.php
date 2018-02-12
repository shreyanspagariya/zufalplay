<?php include ("../../inc/extuser.inc.php"); ?>
<?php include("connect.inc.php");
?>

<?php
$query = "SELECT * from games where game_id='16'";
$result = mysqli_query($con,$query);
$get = mysqli_fetch_assoc($result);
$gameweek = 0;
$fb_share_link = $get['fb_share_link'];
global $g_g_url;
global $gameweek;
?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1489957891297107";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<head>
  <title><?php if($num_notif!=0) echo "(".$num_notif.")"?> Twin Cards | Individual - Zufalplay</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<img src="<?php echo $g_url;?>games/images/twin-cards.png" hidden>

<div class="modal" id="twin-cards-rules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center><h4 class="modal-title" id="myModalLabel">Rules - Twin Cards</h4></center>
      </div>
      <div class="modal-body">
        <div class="beforesubmit">
          <ul>
           	<li>Each player will be given 26 cards which are randomly chosen from the deck of 52 cards.</li><br>

			<li>Player-1 (i.e. the user) plays first by clicking on left deck and the top-most card in his deck is taken out and transferred to the main (central) deck.</li><br>

			<li>After Player-1's chance, CPU plays by taking out the top card of the right deck and transferring it to the central deck. </li><br>

			<li>In-case, if in any move one of the players puts a card of the same value as on the top of the central deck, all the cards of the central deck (shuffled in a random order) including the current card is transferred to that player.</li><br>

			<li>The player who is not able to make a move loses the game.</li><br>

			<li>In-case both the players end up with zero cards in their respective moves, it will be a draw.</li><br>
		</ul>
            <center><button type="button" class="btn btn-danger btn-flat" data-dismiss="modal" aria-label="Close">Ok, I got it!</button></center>
        </div>
      </div>
    </div>
  </div>
</div>