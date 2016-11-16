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

$email = trim($_POST['email']);
echo $email;
?>
