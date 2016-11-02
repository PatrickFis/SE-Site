<?php
ob_start();
session_start();
require_once 'dbconnect.php';

// it will never let you open index(login) page if session is set
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

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
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

  // if there's no error, continue to login
  if (!$error) {

    $password = hash('sha256', $pass); // password hashing using SHA256

    $res=mysql_query("SELECT idUsers, username, password FROM Users WHERE email ='$email'");
    $row=mysql_fetch_array($res);
    $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row

    if( $count == 1 && $row['password']==$password ) {
      $_SESSION['user'] = $row['idUsers'];
      header("Location: Main.php");
    } else {
      $errMSG = "Incorrect Credentials, Try again...";
    }

  }

}
?>
<script>
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  var id_token = googleUser.getAuthResponse().id_token;
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail());
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'gplus.php?id=' + id_token);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
  console.log('Signed in as: ' + xhr.responseText);
};
  xhr.send('id=' + id_token);
}
</script>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <meta name="google-signin-client_id" content="734686445061-9kf59997o88nfdj9sgc8b63a9q3h4gsc.apps.googleusercontent.com">
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
        <li class="active"><a href="login.php">Login</a></li>
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
            <hr />
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
          </div>
          <div class="form-group">
            <hr />
          </div>
          <div class="g-signin2" data-onsuccess="onSignIn"></div>
          <div class="form-group">
            <a href="register.php">Sign Up Here...</a>
          </div>

        </div>

      </form>
    </div>

  </div>
<div class ="container">
	<a href="#" data-target="#pwdModal" data-toggle="modal">Forgot my password</a>
</div>
  <div id="pwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h1 class="text-center">What's My Password?</h1>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                  <div class="panel panel-default">
                      <div class="panel-body">
                          <div class="text-center">

                            <p>If you have forgotten your password you can reset it here.</p>
                              <div class="panel-body">
                                  <fieldset>
                                      <div class="form-group">
                                          <input class="form-control input-lg" placeholder="E-mail Address" name="email" type="email">
                                      </div>
                                      <input class="btn btn-lg btn-primary btn-block" value="Send My Password" type="submit">
                                  </fieldset>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
        </div>
        <div class="modal-footer">
            <div class="col-md-12">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
  		  </div>
        </div>
    </div>
    </div>
  </div>
</body>
</html>
<?php ob_end_flush(); ?>
