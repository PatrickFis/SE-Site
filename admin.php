<?php
ob_start();
session_start();
if( !isset($_SESSION['user'])!="" ){
  header("Location: Main.php");
}
include_once 'dbconnect.php';
$error = false;
$res=mysql_query("SELECT * FROM Users WHERE idUsers=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
$adminRes=mysql_query("SELECT * FROM admin WHERE idadmin=".$userRow['idUsers']);
$adminRow=mysql_fetch_array($adminRes); // Check to see if current user is an admin
if($adminRow['idadmin'] == "") {
  header("Location: Main.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
          <li><a href="sponsor.php">Sponsors</a></li>
          <?php if(!isset($_SESSION['user'])): ?> <!-- Hides these two buttons if logged in. -->
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php endif; ?>
        <?php if($adminRow['idadmin'] != ""): ?> <!-- Display an admin link if the user is an administrator -->
          <li class="active"><a href="admin.php">Admin</a></li>
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

        <ul class="nav nav-tabs-no-style nav-stacked col-md-3">
          <li class="active"><a data-toggle="tab" href="#Contact">Contact Editor</a></li>
          <li><a data-toggle="tab" href="#Sponsor">Sponsor Editor</a></li>
          <li><a data-toggle="tab" href="#Announcements">Announcement Editor</a></li>
          <li><a data-toggle="tab" href="#Email">Newsletter</a></li>
          <li><a data-toggle="tab" href="#Analytics">Google Analytics</a></li>
          <li><a data-toggle="tab" href="#AdminChanger">Account Type Changer</a></li>
        </ul>
        <div class="col-md-9">
          <div class="tab-content">
            <div id="Contact" class="tab-pane fade in active">
              <h3>Contact Editor</h3>
              <form action="adminScripts/contactEditor.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <div class="form-group">
                  <input type="file" name="fileToUpload" id="fileToUpload">
                  <input class="form-control" id="cap" name="caption" placeholder="Image Caption"></textarea>
                  <input class="form-control" id="addr" name="address" placeholder = "Address"></textarea>
                  <input class="form-control" id="phn" name="phone" placeholder="Phone Number"></textarea>
                  <input class="form-control" id="eml" name="email" placeholder="Email"></textarea>
                  <button type="submit" class="btn btn-block btn-primary" name="submit">Upload Image</button>
                </div>
              </form>
              <br><br><br>
              <h3>Delete Contact</h3>
              <form action="adminScripts/contactDeleter.php" method="post">
                <p>Use this to delete a contact from the page.</p>
                <div class="form-group">
                  <label for="selectContact">Select Contact</label>
                  <select class="form-control" id="selectContact" name="selCon">
                    <?php
                      $populateQuery = "SELECT * FROM contact";
                      $res = mysql_query($populateQuery);
                      while($row = mysql_fetch_array($res)) {
                        echo '<option>'.$row['caption'].'</option>';
                      }
                     ?>
                  </select>
                  <button type="submit" class="btn btn-block btn-primary" name="submit">Delete Contact</button>
                </div>
              </form>
              <br><br><br>
            </div>
            <div id="Sponsor" class="tab-pane fade">
              <form action="adminScripts/sponsorEditor.php" method="post" enctype="multipart/form-data">
                <h3>Sponsor Editor</h3>
                <div class="form-group">
                  <input type="file" name="fileToUpload" id="fileToUpload">
                  <!-- <div class="input-group"> -->
                    <input class="form-control" type="text" id="spon" name="sponName" placeholder="Sponsor Name">
                  <!-- </div> -->
                  <!-- <div class="input-group"> -->
                    <input class="form-control" type="text" id="spon" name="sideName" placeholder="Sidebar Name">
                  <!-- </div> -->
                  <button type="submit" class="btn btn-block btn-primary" name="submit">Upload Image</button>
                </div>
              </form>
              <br><br><br>
              <h3>Delete Sponsor</h3>
              <form action="adminScripts/sponsorDeleter.php" method="post">
                <p>Use this to delete a sponsor from the page.</p>
                <div class="form-group">
                  <label for="selectImage">Select Sponsor</label>
                    <select class="form-control" id="selectImage" name="selImg">
                      <?php
                        $populateQuery = "SELECT * FROM sponsors";
                        $res = mysql_query($populateQuery);
                        while($row = mysql_fetch_array($res)) {
                          echo '<option>'.$row['sidebarName'].'</option>';
                        }
                      ?>
                    </select>
                    <button type="submit" class="btn btn-block btn-primary" name="submit">Delete Sponsor</button>
                </div>
              </form>
              <br><br><br>
            </div>
            <div id="Announcements" class="tab-pane fade">
              <h3>Announcement Editor</h3>
              <p>Use this editor to create dismissible announcements for the main page of your website.</p>
              <form action="adminScripts/announceEditor.php" method="post">
                <div class="form-group">
                  <label for="announce">Announcement:</label>
                  <textarea class="form-control" rows="5" id="ann" name="announce"></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-block btn-primary" name="btn-announce">Submit</button>
                </div>
            </form>
            <br><br><br>
          </div>
          <div id="Email" class="tab-pane fade">
            <h3>Newsletter</h3>
            <p>The newsletter is handled by Mail Chimp. Please go to their
            <a href="https://login.mailchimp.com/">website</a> to send the
            newsletter.</p>
          </div>
          <div id="Analytics" class="tab-pane fade">
            <h3>Google Analytics</h3>
            <p>Check Google's <a href="https://analytics.google.com/">website</a>
            for website traffic information.</p>
            <br><br><br>
          </div>
          <div id="AdminChanger" class="tab-pane fade">
            <h3>Modify Account</h3>
            <p>Use this tool to change account permissions.</p>
            <form action="adminScripts/permissionChanger.php" method="post">
              <div class="form-group">
                <label for="em">Email Address</label>
                <input class="form-control" type="email" id="em" name="acctEmail" placeholder="someone@somewhere.com">
                <label for="selectType">Select Type</label>
                  <select class="form-control" id="selectType" name="selType">
                    <option>Administrator</option>
                    <option>Normal User</option>
                  </select>
                  <button type="submit" class="btn btn-block btn-primary" name="submit">Modify Account</button>
              </div>
            </form>
            <br><br><br>
            <!-- Display current admins in a dropdown panel -->
            <div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1">Click to see current administrators</a>
                  </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                  <ul class="list-group">
                    <?php
                      $getAdminQuery = "SELECT email FROM Users, admin where Users.idUsers = admin.idadmin";
                      $admins = mysql_query($getAdminQuery);
                      // echo mysql_error();
                      while($adminRow = mysql_fetch_array($admins)) {
                        echo '<li class="list-group-item">'.$adminRow['email'].'</li>';
                      }
                     ?>
                  </ul>
                </div>
              </div>
            </div>
            <br><br><br>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <br><br><br>
      <div class="navbar navbar-default navbar-fixed-bottom">
          <div class="container">
            <p class="navbar-text pull-left">© 2016 - All rights reserved – Williamson County Chamber Foundation, an affiliate of the Williamson County Chamber of Commerce</p>
          </div>
      </div>
</body>
</html>
<?php ob_end_flush(); ?>
