<?php
  include_once ('../dbconnect.php');
  $deleteme = $_POST['selImg'];
  // Get the image path from the database
  $selectQuery = "SELECT * FROM sponsors WHERE sidebarName = '$deleteme'";
  $res = mysql_query($selectQuery);
  mysql_error();
  // Delete the file from the sponsorimg directory
  while($row = mysql_fetch_array($res)) {
    unlink($row['imgpath']);
  }
  // Query to delete sponsor
  $deleteQuery = "DELETE FROM sponsors WHERE sidebarName = '$deleteme'";
  $res = mysql_query($deleteQuery);
  // Redirect the user back to the admin page.
  header("Location: ../admin.php#Sponsor");
 ?>
