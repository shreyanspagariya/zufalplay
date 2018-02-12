<?php
define('DB_HOST','localhost');
define('DB_NAME','u287075261_zufal');
define('DB_USER','root');
define('DB_PASSWORD','');

/*define('DB_HOST','mysql.hostinger.in');
define('DB_NAME','u287075261_zufal');
define('DB_USER','u287075261_paggu');
define('DB_PASSWORD','12raninandubala');*/

/*define('DB_HOST','mysql12.000webhost.com');
define('DB_NAME','a6516970_zufal');
define('DB_USER','a6516970_zufal');
define('DB_PASSWORD','12raninandubala');*/

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die("Failed to connect to MySQL: " . mysql_error());

/*Global urls*/
$g_url = "http://localhost:8080/zufalplay/";
//$g_url = "http://www.zufalplay.com/";

/*fb credentials for localhost
$fb_client_id = "1491333281159568";
$fb_client_secret = "aad48d6b60955271dd70c4f9a72839a8";
$fb_authorized_access_token = "1491333281159568|BBnsWhxOkbl10WpB4PMDYpeibwk";*/
/*fb credentials for zufalplay.com*/
$fb_client_id = "1489957891297107";
$fb_client_secret = "1a85caf520f989fdbeb3246cbf914e80";
$fb_authorized_access_token = "1489957891297107|tRzjhxZVsFV5KY9kUqODt0n-ldw";

/*url encryption key*/
$encryption_key = "BCB9A2E61483";

//error_reporting(0);

function spit_ip()
{
	if(!empty($_SERVER['HTTP_CLIENT_IP'])) 
	{
	    $ip = $_SERVER['HTTP_CLIENT_IP'];
	} 
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
	{
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} 
	else 
	{
	    $ip = $_SERVER['REMOTE_ADDR'];
	}
	return($ip);
}

function getDateTimeIST()
{
	date_default_timezone_set("Asia/Kolkata");
	return(date("Y-m-d H:i:sa"));
}

?>