<?php
$to = 'fischerpl@mail.lipscomb.edu.';
$subject = 'This is subject';
$message = 'This is body of email';
$from = "From: FirstName LastName <no-reply@bwoodleadership.com>";
mail($to,$subject,$message,$from);
?>
