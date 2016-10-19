<?php
ob_start();
session_start();
if( !isset($_SESSION['user'])!="" ){
  header("Location: Main.php");
}
include_once 'dbconnect.php';
$error = false;
$res=mysql_query("SELECT * FROM Users WHERE idUsers=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
if ( isset($_POST['btn-signup']) ) {
  // Fetch user data
  $email = $userRow['email'];
  // clean user inputs to prevent sql injections
  $oldPass = trim ($_POST['oldPass']);
  $oldPass = strip_tags($oldPass);
  $oldPass = htmlspecialchars($oldPass);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  // password validation
  $oldPass = hash('sha256', $oldPass);
  if(empty($oldPass)) {
    $error = true;
    $oldPassError = "Please enter old password.";
  }
  else if($oldPass != $userRow['password']) {
    $error = true;
    $oldPassError = "Incorrect password.";
  }
  if (empty($pass)){
    $error = true;
    $passError = "Please enter password.";
  } else if(strlen($pass) < 8) {
    $error = true;
    $passError = "Password must have atleast 8 characters.";
  }

  // password encrypt using SHA256();
  $password = hash('sha256', $pass);

  // if there's no error, continue to signup
  if( !$error ) {

    $query = "UPDATE Users SET password='$password' WHERE email='$email'";
    $res = mysql_query($query);
    if ($res) {
      $errTyp = "success";
      $errMSG = "Successfully changed password";
      unset($email);
      unset($oldPass);
      unset($pass);
    } else {
      $errTyp = "danger";
      $errMSG = "Something went wrong, try again later...";
    }

  }


}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
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
          <li class="active"><a href="/Main.php">Home</a></li>
          <li><a href="/calendar.php">Calendar</a></li>
          <li><a href="/contact.php">Contact Us</a></li>
          <li><a href="/donate.php">Donate</a></li>
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
  

  </div>

</body>
</html>
<?php ob_end_flush(); ?>
