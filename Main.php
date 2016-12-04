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
          <li class="active"><a href="Main.php">Home</a></li>
          <li><a href="calendar.php">Calendar</a></li>
          <li><a href="contact.php">Contact Us</a></li>
          <li><a href="donate.php">Donate</a></li>
          <li><a href="sponsor.php">Sponsors</a></li>
          <?php if(!isset($_SESSION['user'])): ?> <!-- Hides these two buttons if logged in. -->
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php endif; ?>
        <?php if($adminRow['idadmin'] != ""): ?> <!-- Display an admin link if the user is an administrator -->
          <li><a href="admin.php">Admin</a></li>
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
    <div class="container">
      <div class="alert alert-info alert-dismissable fade in">
        <h3>Announcements</h3>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php
            $announcementQuery = "SELECT announce FROM announcements WHERE idannouncements=0";
            $result = mysql_query($announcementQuery);
            while($annRow = mysql_fetch_array($result)) {
              echo $annRow['announce'];
            }
         ?>
      </div>


<!-- This will display information about the objectives, program, and purpose of the program. -->
    <ul class="nav nav-tabs-no-style nav-stacked col-md-3">
      <li class="active"><a data-toggle="tab" href="#Objectives">Objectives</a></li>
      <li><a data-toggle="tab" href="#Program">Program</a></li>
      <li><a data-toggle="tab" href="#Purpose">Purpose</a></li>
    </ul>
    <div class="col-md-6">
      <div class="tab-content">
        <div id="Objectives" class="tab-pane fade in active">
          <h3>Objectives</h3>
          <ul>
            <li>Provide an educational format which allows leaders to enhance their leadership abilities through exposure to and understanding of all aspects of the  Brentwood community.</li>
            <li>Promote a free exchange of ideas and concerns among the various segments of Brentwood.</li>
            <li>Foster an attitude of increased participation and commitment within the community.</li>
            <li>Identify leaders from the civic, educational, government, religious and business communities who will use their leadership knowledge, skills and abilities for the long-term benefit of the  Brentwood community.</li>
          </ul>
          <br><br><br>
        </div>
        <div id="Program" class="tab-pane fade">
          <h3>Program</h3>
          <p>The Leadership Brentwood program is sponsored by the Williamson County Chamber Foundation, the non-profit arm of the  Williamson, Inc. Chamber of Commerce.

              The program consists of daylong seminars, group discussions, field trips and retreats that address different issues in the Brentwood and surrounding areas. The sessions create a forum to exchange ideas and discuss areas of interest. Each participant will be involved in a small group project outside of the program schedule to leave a legacy for the community.

              The program offers individuals the opportunity to become involved and to make a difference in Brentwood and in Williamson County.

              The daylong programs include a focus on history, education, business, economic development, media/entertainment, government and quality of life.

              Participants are also given the opportunity to network and develop relationships with other class members and community leaders.
          </p>
          <br><br><br>
        </div>
        <div id="Purpose" class="tab-pane fade">
          <h3>Purpose</h3>
          <p>To identify and educate present and future leaders and integrate them into the Brentwood community.</p>
        </div>
        <br><br><br><br><br>
      </div>
      <div class="col-md-3">
        <!--  Small agenda style calendar to the right of the nav-tabs. -->
        <iframe src="https://calendar.google.com/calendar/embed?src=brentwoodcalendar2016%40gmail.com&title=Brentwood%20Leadership&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;mode=AGENDA&amp;height=300&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;ctz=America%2FChicago" style="border-width:0" width="300" height="300" frameborder="0" scrolling="no"></iframe>
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
