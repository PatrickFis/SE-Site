<?php
ob_start();
session_start();
require_once 'dbconnect.php';
// it will never let you open index(resetpsas) page if session is set
if ( isset($_SESSION['user'])!="" ) {
  header("Location: Main.php");
  exit;
}

$error = false;

if( isset($_POST['btn-reset']) ) {

  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  $code = trim($_POST=['secCode']);
  $code = strip_tags($code);
  $code = htmlspecialchars($code)
  // prevent sql injections / clear user invalid inputs

  if(empty($email)){
    $error = true;
    $emailError = "Please enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
    $error = true;
    $emailError = "Please enter valid email address.";
  }

  if(empty($pass)){
    $error = true;
    $passError = "Please enter your password.";
  }

  if(empty($code)) {
    $error = true;
    $secError = "Please enter the code emailed to you.";
  }
  // if there's no error, change the password
  if (!$error) {

    $password = hash('sha256', $pass); // password hashing using SHA256

    $res=mysql_query("SELECT idUsers, username, password FROM Users WHERE resetString ='$code'");
    $row=mysql_fetch_array($res);
    $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
    $id = $row['idUsers'];
    if( $count == 1) {
      $updateQuery = mysql_query("UPDATE Users SET password='$password' WHERE idUsers='$id'");
    } else {
      $errMSG = "Something went wrong, please try again...";
    }

  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <?php include_once("analyticstracking.php") ?>

  <nav class="navbar navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Brentwood Leadership</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="Main.php">Home</a></li>
        <li><a href="calendar.php">Calendar</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="donate.php">Donate</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">

    <div id="login-form">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

        <div class="col-md-12">

          <div class="form-group">
            <h2 class="">Sign In.</h2>
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
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
            </div>
            <span class="text-danger"><?php echo $passError; ?></span>
          </div>

          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input type="text" name="secCode" class="form-control" placeholder="Reset Code" maxlength="45" />
            </div>
            <span class="text-danger"><?php echo $secretError; ?></span>
          </div>

          <div class="form-group">
            <hr />
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary" name="btn-reset">Reset Password</button>
          </div>

        </div>

      </form>
    </div>

  </div>
</body>
</html>
<?php ob_end_flush(); ?>
