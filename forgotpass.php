<?php
  function sendEmail($email) {
    $to = $email;
    $subject = "Password Change Request";

    $message = "Someone recently requested that the password associated with";
    $message .= "this email be reset. Please copy the following string into the";
    $message .= "field provided on the login page.";

    $header = "From:no-reply@bwood.com \r\n";
    //$header .= "Cc:no-reply@bwood.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $retval = mail ($to,$subject,$message,$header);

    if( $retval == true ) {
       echo "Message sent successfully...";
    }else {
       echo "Message could not be sent...";
    }
  }
 ?>
