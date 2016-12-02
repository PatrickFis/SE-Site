<?php
ob_start();
session_start();
require_once 'dbconnect.php';

// if session is not set this will redirect to login page
if( !isset($_SESSION['user']) ) {
  // do nothing
}
// select loggedin users detail
if(isset($_SESSION['user'])) {
  $res=mysql_query("SELECT * FROM Users WHERE idUsers=".$_SESSION['user']);
  $userRow=mysql_fetch_array($res);
  $adminRes=mysql_query("SELECT * FROM admin WHERE idadmin=".$userRow['idUsers']);
  $adminRow=mysql_fetch_array($adminRes); // Check to see if current user is an admin
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sponsors</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <?php include_once("analyticstracking.php") ?>

  <nav class="navbar navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Brentwood Leadership</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li><a href="Main.php">Home</a></li>
          <li><a href="calendar.php">Calendar</a></li>
          <li><a href="contact.php">Contact Us</a></li>
          <li><a href="donate.php">Donate</a></li>
          <li class="active"><a href="Sponsors.php">Sponsors</a></li>
          <?php if(!isset($_SESSION['user'])): ?> <!-- Hides these two buttons if logged in. -->
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
          <?php if($adminRow['isadmin'] == 1): ?>
            <li><a href="admin.php">Admin</a></li>
          <?php endif; ?>
        <?php endif; ?>
        </ul>
        <?php if(isset($_SESSION['user'])): ?>
          <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-user"></span>&nbsp;Hi <?php echo $userRow['email']; ?>&nbsp;<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="settings.php"><span class="glyphicon glyphicon-wrench"></span>&nbsp;Settings</a></li>
                  <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                </ul>
              </li>
            </ul>
          <?php endif; ?>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <!-- PHP code to create the nav-tabs -->
    <?php
      $selectQuery = "SELECT * FROM sponsors";
      $res = mysql_query($selectQuery);
      $flag = 1;
      $count = 0;
      // Create the sidebar
      echo "<ul class='nav nav-tabs-no-style nav-stacked col-md-3'>";
      while($row = mysql_fetch_array($res)) {
        if($flag == 1) {
          echo '<li class="active"><a data-toggle="tab" href=#'.$count.'>'.$row['sidebarName'].'</a></li>';
          $flag = 0;
          $count = $count + 1;
        }
        else {
          echo '<li><a data-toggle="tab" href=#'.$count.'>'.$row['sidebarName'].'</a></li>';
        }
      }
      echo "</ul>";
      // Create the tab content
      echo "<div class='col-md-9'>";
      echo "<div class='tab-content'>";
      // Go back to start of results
      mysql_data_seek($res, 0);
      $flag = 1;
      $count = 0;
      while($row = mysql_fetch_array($res)) {
        echo $row['imgpath'];
        if($flag == 1) {
          echo "<div id='$count' class='tab-pane fade in active'>";
          echo '<h3>'.$row['sidebarName'].'</h3>';
          echo '<h4>'.$row['sponsorName'].'</h4>';
          echo '<img class="img-responsive" src="adminScripts/'.$row['imgpath'].'">';
          echo "<br><br><br>";
          echo "</div>";
          $flag = 0;
          $count = $count + 1;
        }
        else {
          echo "<div id='$count' class='tab-pane fade'>";
          echo '<h3>'.$row['sidebarName'].'</h3>';
          echo '<h4>'.$row['sponsorName'].'</h4>';
          echo '<img class="img-responsive" src="adminScripts/'.$row['imgpath'].'">';
          echo "<br><br><br>";
          echo "</div>";
          $count = $count + 1;
        }
      }
      echo "</div></div>";
     ?>
  <!-- Footer here, can add this to other pages later. -->
  <div class="navbar navbar-default navbar-fixed-bottom">
      <div class="container">
        <p class="navbar-text pull-left">© 2016 - All rights reserved – Williamson County Chamber Foundation, an affiliate of the Williamson County Chamber of Commerce</p>
      </div>
  </div>
</div>



    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
  </html>
  <?php ob_end_flush(); ?>
