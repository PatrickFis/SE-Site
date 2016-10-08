<?php
ob_start();
session_start();
if( !isset($_SESSION['user'])!="" ){
  header("Location: Main.php");
}
include_once 'dbconnect.php';
$error = false;
if ( isset($_POST['btn-signup']) ) {
  // Fetch user data
  $res=mysql_query("SELECT * FROM Users WHERE idUsers=".$_SESSION['user']);
  $userRow=mysql_fetch_array($res);

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
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Brentwood Leadership</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="/Main.php">Home</a></li>
        <li><a href="/calendar.html">Calendar</a></li>
        <li><a href="/contact.html">Contact Us</a></li>
        <li><a href="/donate.html">Donate</a></li>
        <li><a href="/login.php">Login</a></li>
        <li class="active"><a href="/register.php">Register</a></li>
      </ul>
    </div>
  </nav>
  <div class="container">

    <div id="login-form">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

        <div class="col-md-12">

          <div class="form-group">
            <hr />
          </div>

          <?php
          if ( isset($errMSG) ) {

            ?>
            <div class="form-group">
              <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
              </div>
            </div>
            <?php
          }
          ?>


          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input type="password" name="oldPass" class="form-control" placeholder="Password" maxlength="15" value="<?php echo $email ?>" />
            </div>
            <span class="text-danger"><?php echo $oldPassError; ?></span>
          </div>

          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input type="password" name="pass" class="form-control" placeholder="New Password" maxlength="15" />
            </div>
            <span class="text-danger"><?php echo $passError; ?></span>
          </div>

          <div class="form-group">
            <hr />
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Change Password</button>
          </div>

          <div class="form-group">
            <hr />
          </div>

        </div>

      </form>
    </div>

  </div>

</body>
</html>
<?php ob_end_flush(); ?>
