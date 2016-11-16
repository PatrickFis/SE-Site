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

if( isset($_POST['btn-login']) ) {
  // Generate a random string for a user to reset their password with. Emails will be
  // sent using a cronjob.
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

    if( $count == 1 && $row['email']==$email ) {
      // Generate a 45 character random string.
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < 45; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      $resetQuery = mysql_query("UPDATE Users SET resetString='$randomString', sentResetEmail=0 WHERE email='$email'");
      // $result = mysql_query($resetQuery);
      // print(mysql_error());
      // print($randomString);
      // print($email);
      // $mail = new PHPMailer;
      // // $mail->IsSMTP();
      // $mail->Host = gethostbyname(smtp.gmail.com);
      // $mail->Port = 587;
      // $mail->SMTPSecure = "tls";
      // $mail->SMTPAuth = true;
      // $mail->Username = "brentwoodcalendar2016@gmail.com";
      // $mail->Password = ""; // Change this password back and it will send emails again...
      //
      // $mail->setFrom("brentwoodcalendar2016@gmail.com", "Brentwood Leadership");
      // $mail->addReplyTo("brentwoodcalendar2016@gmail.com", "Brentwood Leadership");
      // $mail->addAddress($email);
      // $mail->Subject = "PHPMailer GMail Test";
      // $mail->Body = "Hello from PHPMailer!";
      //
      // if(!$mail->Send()) {
      //   echo "Message was not sent.";
      //   echo "Mailer error: " . $mail->ErrorInfo;
      // } else {
      //   echo "Message has been sent.";
      // }
    } else {
      $errMSG = "Email not found.";
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
