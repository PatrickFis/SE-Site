<?php
  include_once ('../dbconnect.php');
  $deleteme = $_POST['selCon'];
  // Get the image path from the database
  $selectQuery = "SELECT * FROM contact WHERE caption = '$deleteme'";
  $res = mysql_query($selectQuery);
  mysql_error();
  // Delete the file from the contactimg directory
  while($row = mysql_fetch_array($res)) {
    unlink($row['imgpath']);
  }
  // Query to delete sponsor
  $deleteQuery = "DELETE FROM contact WHERE caption = '$deleteme'";
  $res = mysql_query($deleteQuery);
  // Redirect the user back to the admin page.
  header("Location: ../admin.php");
 ?>
