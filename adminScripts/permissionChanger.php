<?php
  include_once ('../dbconnect.php');
  // Get the data submitted by the administrator
  $email = $_POST['acctEmail'];
  $type = $_POST['selType'];
  echo $email;
  echo $type;
  // Fetch information from the database
  $useridQuery = "SELECT * FROM Users WHERE email='$email'";
  $res = mysql_query($useridQuery);
  while($row = mysql_fetch_array($res)) {
    $userId = $row['idUsers'];
    $username = $row['username'];
    if($type == 'Administrator') { // Change the user to an administrator
      $updateAdminQuery = "INSERT INTO admin (idadmin, resetPassword, modifyUsers, modifyCalendar, sendNotifications, adminUsername) VALUES ('$userId', '1', '1', '1', '1', '$username')";
      $update = mysql_query($updateAdminQuery);
    }
    else { // Change the user back to a normal user
      $deleteAdminQuery = "DELETE FROM admin WHERE idadmin='$userId'";
      $delete = mysql_query($deleteAdminQuery);
    }
  }
  // Redirect the user back to the admin page.
  header("Location: ../admin.php");
 ?>
