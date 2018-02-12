<?php include ("./inc/header.inc.php"); ?>
<?php
session_start();
session_destroy();
header("Location: ".$g_url);
?>