<?php
ob_start();
session_start();
require_once 'dbconnect.php';
require("/var/www/html/vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
// If user is currently logged in leave this page.
if ( isset($_SESSION['user'])!="" ) {
  header("Location: Main.php");
  exit;
}

$error = false;

$email = trim($_POST['resetemail']);
$email = strip_tags($email);
$email = htmlspecialchars($email);

if(empty($email)){
  $error = true;
  $emailError = "Please enter your email address.";
} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
  $error = true;
  $emailError = "Please enter valid email address.";
}

if (!$error) {

  $res=mysql_query("SELECT idUsers, email FROM Users WHERE email ='$email'");
  $row=mysql_fetch_array($res);
  $count = mysql_num_rows($res); // Should only return one row

  if( $count == 1 && $row['email']==$email ) {
    // Generate a 45 character random string.
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 45; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $resetQuery = mysql_query("UPDATE Users SET resetString='$randomString', sentResetEmail=0 WHERE email='$email'");
  } else {
    $errMSG = "Email not found.";
  }
}

if($error) {
  echo $errMsg;
}
else {
  echo "If you do not receive an email within half an hour, please contact an administrator or try again.";
}
?>
