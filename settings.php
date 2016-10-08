<?php
ob_start();
session_start();
require_once 'dbconnect.php';
$error = false;
// if session is not set this will redirect to main page
if( !isset($_SESSION['user']) ) {
  header("Location: Main.php");
  exit;
}
// select loggedin users detail
if(isset($_SESSION['user'])) {
  $res=mysql_query("SELECT * FROM Users WHERE idUsers=".$_SESSION['user']);
  $userRow=mysql_fetch_array($res);
}

// Allow the user to change their password
if(isset($_POST['btn-change'])) {
  // Get user details
  $name = $userRow['username'];
  $email = $userRow['email'];

  // Clean up old password input to prevent SQL injections
  $oldPass = trim($_POST['pwd']);
  $oldPass = strip_tags($oldPass);
  $oldPass = htmlspecialchars($oldPass);

  // Clean up new password input to prevent SQL injections
  $newPass = trim($_POST['newPwd']);
  $newPass = strip_tags($newPass);
  $newPass = htmlspecialchars($newPass);

  // Check if password fields are empty
  if(empty($oldPass)) {
    $error = true;
    $oldError = "Please enter your old password.";
  }
  if(empty($newPass)) {
    $error = true;
    $newError = "Please enter your new password.";
  }
  else if(strlen($newPass) < 8) {
    $error = true;
    $newError = "Password must be have at least 8 characters.";
  }

  // Encrypt both old and new password with SHA256().
  $oldPass = hash('sha256', $oldPass);
  $newPass = hash('sha256', $newPass);

  // Make sure old password is correct.
  $query = "SELECT id FROM Users where username='$name' AND email='$email' AND password='$oldPass'";
  $res = mysql_query($query);
  if($count == 0) {
    $error = true;
    $oldError = "Password incorrect.";
  }
  // If there is no error change the password.
  if(!$error) {
    $query = "UPDATE Users SET password='$newPass' WHERE email='$email'";
    $res = mysql_query($query);
    if($res) {
      $errTyp = "success";
      $errMSG = "Changed password.";
      unset($name);
      unset($email);
      unset($oldPass);
      unset($newPass);
    }
    else {
      $errTyp = "danger";
      $errMSG = "Something went wrong, try again later...";
    }
  }
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
          <li><a href="/Main.php">Home</a></li>
          <li><a href="/calendar.html">Calendar</a></li>
          <li><a href="/contact.html">Contact Us</a></li>
          <li><a href="/donate.html">Donate</a></li>
          <li><a href="/login.php">Login</a></li>
          <li><a href="/register.php">Register</a></li>
        </ul>
        <?php if(isset($_SESSION['user'])): ?>
          <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-user"></span>&nbsp;Hi <?php echo $userRow['email']; ?>&nbsp;<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="settings.php"><span class="glyphicon glyphicon-wrench"></span>&nbsp;Settings</a></li>
                  <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                </ul>
              </li>
            </ul>
          <?php endif; ?>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <form>
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd">
      </div>
      <div class="form-group">
        <label for="newPwd">New Password:</label>
        <input type="password" class="form-control" id="newPwd">
      </div>
      <button type="submit" class="btn btn-default" name="btn-change">Submit</button>
    </form>




    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
  </html>
  <?php ob_end_flush(); ?>
