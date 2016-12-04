<?php
  include_once ('../dbconnect.php');
  $deleteme = $_POST['selCls'];
  // Query to delete class member
  $deleteQuery = "DELETE FROM classMembers WHERE name = '$deleteme'";
  $res = mysql_query($deleteQuery);
  // Redirect the user back to the admin page.
  header("Location: ../admin.php");
 ?>
