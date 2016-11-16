#!/usr/bin/php

<?php
    // Remember to write a query to update sentResetEmail to 1
    require_once '/var/www/html/dbconnect.php';
    require("/var/www/html/vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
    // Get the emails of users who requested a password reset
    $res=mysql_query("SELECT idUsers, email, resetString FROM Users WHERE resetString IS NOT NULL AND sentResetEmail = 0");

    if (!$res) {
      echo "Could not successfully run query from DB: " . mysql_error();
      exit;
    }

    if (mysql_num_rows($res) == 0) {
        echo "No rows found, nothing to print so am exiting";
        exit;
    }
    while($row = mysql_fetch_assoc($res)) {
      // echo $row['idUsers'];
      // echo $row['email'];
      // echo $row['resetString'];
      $rString = $row['resetString'];
      $mail = new PHPMailer;
      // $mail->IsSMTP();
      $mail->IsMail(); // Seeing if this is faster than SMTP
      // $mail->Host = gethostbyname(smtp.gmail.com);
      // $mail->Port = 587;
      // $mail->SMTPSecure = "tls";
      // $mail->SMTPAuth = true;
      // $mail->Username = "brentwoodcalendar2016@gmail.com";
      // $mail->Password = ""; // Change this password back and it will send emails again...

      $mail->setFrom("brentwoodcalendar2016@gmail.com", "Brentwood Leadership");
      $mail->addReplyTo("brentwoodcalendar2016@gmail.com", "Brentwood Leadership");
      $mail->addAddress($row['email']);
      $mail->Subject = "Reset Password";
      $mail->Body = "Reset string: '$rString'";

      if(!$mail->Send()) {
        echo "Message was not sent.";
        echo "Mailer error: " . $mail->ErrorInfo;
      } else {
        echo "Message has been sent.";
        $updateQuery = mysql_query("UPDATE Users SET sentResetEmail=1 WHERE idUsers='$row['idUsers']'");
        if(!$updateQuery) {
          echo "Update query error.";
        }
        else {
          echo "Update query success.";
        }
      }
    }
?>
