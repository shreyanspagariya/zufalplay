<?php include ("./inc/connect.inc.php"); ?>
<?php include ("./inc/Crypto.php"); ?>
<?php 
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function send_notif_mail($from = "",$email="",$subject = "",$usr_name = "",$template = "",$link="")
{
	global $mandrill;
	$message = array(
		'subject' => $subject,
		'from_name' => 'Team Zufalplay',
		'from_email' => $from,
		'to' => array(array('email' => $email, 'name' => $usr_name)),
		'merge_vars' => array(array(
			'rcpt' => $email,
			'vars' =>
			array(
				array(
					'name' => 'FNAME',
					'content' => $usr_name,
				),
				array(
					'name' => 'LINK',
					'content' => $link,
				)))));

	$template_name = $template;
	$mandrill->messages->sendTemplate($template_name, "", $message);
	echo "Sent";
}
  
$fname = mysqli_real_escape_string($con,$_POST['fname']);
$lname = mysqli_real_escape_string($con,$_POST['lname']);
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
$campaign_id =  mysqli_real_escape_string($con,$_POST['campaign_id']);
$fb_id="";
$fb_picture_url="";
session_start();
if(isset($_SESSION['fb_id']))
{
	$fb_id = $_SESSION['fb_id'];
}
if(isset($_SESSION['fb_picture_url']))
{
	$fb_picture_url = $_SESSION['fb_picture_url'];
}
if(isset($_SESSION['campaign_id']))
{
	$campaign_id = $_SESSION['campaign_id'];
}

/*Parsing Duplicate Email Ids*/

$nakedemail = $email;
$nakedemail = str_replace(array('.', ','), '' , $nakedemail);
$nakedemail = str_replace(array('google'), 'g' , $nakedemail);
$nakedemail = strtolower($nakedemail);

$query = "SELECT nakedemail FROM table2 where nakedemail='$nakedemail'";
$result = mysqli_query($con,$query);
$numResults = mysqli_num_rows($result);
if( $_REQUEST['mode'] == 'valid_email')
{
	if($numResults>=1)
	{
		$result = array('status' => 1,'msg'=>'duplicate_email');
    	echo json_encode($result);	
	}
    else
    {
    	$result = array('status' => 0,'msg'=>'email is good to go!');
    	echo json_encode($result);
    }
}
else if($_REQUEST['mode'] == 'signup')
{
	$password1=md5($password);
	mysqli_query($con,"INSERT INTO table2 (fname,lname,email,password,nakedemail,campaign_id,fb_id,fb_picture_url) 
		VALUES ('$fname','$lname','$email','$password1','$nakedemail','$campaign_id','$fb_id','$fb_picture_url')");

	$ver_code = generateRandomString(10);
	$strSQL = mysqli_query($con,"SELECT Id from table2 where email='$email'");
	$Results = mysqli_fetch_array($strSQL);
	mysqli_query($con,"UPDATE table2 SET ver_code='$ver_code' WHERE email='$email'");
	$uid = $Results['Id'];
	$send_string = "a=".$uid."&b=".$ver_code;
	//echo $send_string;
	$encrypted_string = encrypt($send_string,$encryption_key);
	$link = $g_url."accounts/verify.php?s=".$encrypted_string;
	//echo $link;
	require_once 'src/Mandrill.php'; //Not required with Composer
	$mandrill = new Mandrill('iPSqhOZXFJx62UBvcD9QdA');
	$from = "team@zufalplay.com";
	$subject="Zufalplay Email Verification";
	$template = "email-verification";
	if($email)
		send_notif_mail($from,$email,$subject,$fname,$template,$link);
	$result = array('status' => 1,'msg'=>'signup success');
	echo json_encode($result);
}

	
?>	