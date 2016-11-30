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
  <title>Homepage</title>
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
          <li class="active"><a href="sponsers.php">Sponsers</a></li>
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


<!-- This will display information about the objectives, program, and purpose of the program. -->
    <ul class="nav nav-tabs-no-style nav-stacked col-md-3">
      <li class="active"><a data-toggle="tab" href="#Presenting">Presenting Sponser</a></li>
      <li><a data-toggle="tab" href="#Opening">Opening Reception</a></li>
      <li><a data-toggle="tab" href="#Education">Education Day</a></li>
      <li><a data-toggle="tab" href="#Business">Business Day</a></li>
      <li><a data-toggle="tab" href="#History">History Day</a></li>
      <li><a data-toggle="tab" href="#Quality">Quality of Life Day</a></li>
      <li><a data-toggle="tab" href="#Government">Government Day</a></li>
      <li><a data-toggle="tab" href="#Media">Media &amp; Entertainment Day</a></li>
      <li><a data-toggle="tab" href="#Retreat">Closing Retreat and Graduation</a></li>
      <li><a data-toggle="tab" href="#Support">Supporting Sponsers and In-Kind</a></li>
    </ul>
    <div class="col-md-9">
      <div class="tab-content">
        <div id="Presenting" class="tab-pane fade in active">
          <h3>Presenting Sponser</h3>
            <h4>Nissan North America</h4>
            <img src="sponserimg/nissan-logo.jpg" alt="Nissan Logo">
          <br><br><br>
        </div>
        <div id="Opening" class="tab-pane fade">
          <h3>Opening Reception</h3>
            <h4>BancorpSouth</h4>
            <img src="sponserimg/bancorpsouth-inc-logo.jpg" alt="BancorpSouth Logo">
          <br><br><br>
        </div>
        <div id="Education" class="tab-pane fade">
          <h3>Education Day</h3>
          <h4>LBMC</h4>
          <img src="sponserimg/LBMC.png" alt="LBMC Logo">
        </div>
        <div id="Business" class="tab-pane fade">
          <h3>Business Day</h3>
          <h4>SVN Commercial Realtors</h4>
        </div>
        <div id="History" class="tab-pane fade">
          <h3>History Day</h3>
          <h4>Pinnacle Financial Partners</h4>
          <img src="sponserimg/FinancialPartnersColor_calogo1499.jpg" alt="Pinnacle Financial Partners Logo">
        </div>
        <div id="Quality" class="tab-pane fade">
          <h3>Quality of Life Day</h3>
          <h4>None</h4>
        </div>
        <div id="Government" class="tab-pane fade">
          <h3>Government Day</h3>
          <h4>None</h4>
        </div>
        <div id="Media" class="tab-pane fade">
          <h3>Media &amp; Entertainment Day</h3>
          <h4>None</h4>
        </div>
        <div id="Retreat" class="tab-pane fade">
          <h3>Closing Retreat and Graduation</h3>
          <h4>Skanska</h4>
          <img src="sponserimg/Skanska-Logo.png" alt="Skanska Logo">
        </div>
        <div id="Support" class="tab-pane fade">
          <h3>Supporting Sponsers and In-Kind</h3>
          <h4>Brentwood Roesch-Patton Funeral Home</h4>
          <h4>Zeitlin &amp; Company, Realtors-Linda Hirsch</h4>
        </div>
        <br><br><br><br><br>
      </div>
    </div>
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
