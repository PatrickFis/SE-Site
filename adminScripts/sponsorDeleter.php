<?php
  include_once ('../dbconnect.php');
  $deleteme = $_POST['selImg'];
  echo $deleteme;
  // Get the image path from the database
  $selectQuery = "SELECT * FROM sponsors WHERE sidebarName = $deleteme";
  $res = mysql_query($selectQuery);
  // Delete the file from the sponsorimg directory
  while($row = mysql_fetch_array($res)) {
    unlink($res['imgpath']);
  }
  // Query to delete sponsor
  $deleteQuery = "DELETE FROM sponsors WHERE sidebarName = $deleteme";
  $res = mysql_query($deleteQuery);
 ?>
