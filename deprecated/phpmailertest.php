<?php
  // This actually works.
  require("/var/www/html/vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
  require_once "dbconnect.php";
  $mail = new PHPMailer;
  // $mail->IsSMTP();
  $mail->Host = smtp.gmail.com;
  $mail->Port = 587;
  $mail->SMTPSecure = "tls";
  $mail->SMTPAuth = true;
  $mail->Username = "brentwoodcalendar2016@gmail.com";
  $mail->Password = "";

  $mail->setFrom("brentwoodcalendar2016@gmail.com", "Brentwood Leadership");
  $mail->addReplyTo("brentwoodcalendar2016@gmail.com", "Brentwood Leadership");
  $mail->addAddress("fischerpl@mail.lipscomb.edu");
  $mail->Subject = "PHPMailer GMail Test";
  $mail->Body = "Hello from PHPMailer!";

  if(!$mail->Send()) {
    echo "Message was not sent.";
    echo "Mailer error: " . $mail->ErrorInfo;
  } else {
    echo "Message has been sent.";
  }
?>
