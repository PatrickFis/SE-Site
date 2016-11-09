<?php
ob_start();
session_start();
require_once 'dbconnect.php';

// If user is currently logged in leave this page.
if ( isset($_SESSION['user'])!="" ) {
  header("Location: Main.php");
  exit;
}

$error = false;

if( isset($_POST['btn-login']) ) {

  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
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

    if( $count == 1 && $row['email']==$password ) {
      $errMsg = "Is this working?";
    } else {
      $errMSG = "Email not found.";
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Homepage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <?php include_once("analyticstracking.php") ?>

  <nav class="navbar navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Brentwood Leadership</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="Main.php">Home</a></li>
          <li><a href="calendar.php">Calendar</a></li>
          <li><a href="contact.php">Contact Us</a></li>
          <li><a href="donate.php">Donate</a></li>
          <?php if(!isset($_SESSION['user'])): ?> <!-- Hides these two buttons if logged in. -->
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
          <?php if($adminRow['isadmin'] == 1): ?>
            <li><a href="admin.php">Admin</a></li>
          <?php endif; ?>
        <?php endif; ?>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <div class="container">

      <div id="login-form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

          <div class="col-md-12">

            <div class="form-group">
              <h2 class="">Forgot password</h2>
            </div>

            <div class="form-group">
              <hr />
            </div>

            <?php
            if ( isset($errMSG) ) {

              ?>
              <div class="form-group">
                <div class="alert alert-danger">
                  <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
              </div>
              <?php
            }
            ?>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
              </div>
              <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            <div class="form-group">
              <hr />
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-block btn-primary" name="btn-login">Send Email</button>
            </div>
            <div class="form-group">
              <hr />
            </div>

          </div>

        </form>
      </div>

    </div>
  </div>

  </body>
  </html>
  <?php ob_end_flush(); ?>
