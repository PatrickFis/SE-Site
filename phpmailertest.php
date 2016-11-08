<?php
  require("class.phpmailer.php");
  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->Host = smtp.gmail.com;
  $mail->From = "brentwoodcalendar2016@gmail.com";
  $mail->AddAddress("fischerpl@mail.lipscomb.edu");

  $mail->Subject  = "First PHPMailer Message";
  $mail->Body     = "Hi! \n\n This is my first e-mail sent through PHPMailer.";
  $mail->WordWrap = 50;

  if(!$mail->Send()) {
    echo 'Message was not sent.';
    echo 'Mailer error: ' . $mail->ErrorInfo;
  } else {
    echo 'Message has been sent.';
  }
?>
