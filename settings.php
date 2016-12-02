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
$adminRes=mysql_query("SELECT * FROM admin WHERE idadmin=".$userRow['idUsers']);
$adminRow=mysql_fetch_array($adminRes); // Check to see if current user is an admin
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
  <title>Settings</title>
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
          <li><a href="sponsor.php">Sponsors</a></li>
          <?php if(!isset($_SESSION['user'])): ?> <!-- Hides these two buttons if logged in. -->
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php endif; ?>
        <?php if($adminRow['idadmin'] != ""): ?> <!-- Display an admin link if the user is an administrator -->
          <li><a href="admin.php">Admin</a></li>
        <?php endif; ?>
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
    <ul class="nav nav-tabs-no-style nav-stacked col-md-3">
      <li class="active"><a data-toggle="tab" href="#pword">Change my Password</a></li>
      <li><a data-toggle="tab" href="#news">Newsletter Signup</a></li>
    </ul>
    <div class="col-md-9">
      <div class="tab-content">
        <div id="pword" class="tab-pane fade in active">
          <h3>Change my Password</h3>
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
                    <input type="password" name="oldPass" class="form-control" placeholder="Old Password" maxlength="15" value="<?php echo $email ?>" />
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
        <div id="news" class="tab-pane fade">
          <!-- Begin MailChimp Signup Form -->
          <link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
          <style type="text/css">
          	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}
          	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
          	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
          </style>
          <div id="mc_embed_signup">
          <form action="//222.us14.list-manage.com/subscribe/post?u=04adb189e747ffa76377f49fb&amp;id=657959c55f" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
              <div id="mc_embed_signup_scroll">
          	<label for="mce-EMAIL">Subscribe to our mailing list</label>
          	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
              <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
              <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_04adb189e747ffa76377f49fb_657959c55f" tabindex="-1" value=""></div>
              <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
              </div>
          </form>
          </div>

          <!--End mc_embed_signup-->
        </div>
      </div>

</body>
</html>
<?php ob_end_flush(); ?>
