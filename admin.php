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

    <!-- This will display information about the objectives, program, and purpose of the program. -->
        <ul class="nav nav-tabs-no-style nav-stacked col-md-3">
          <li class="active"><a data-toggle="tab" href="#Contact">Contact Editor</a></li>
          <li><a data-toggle="tab" href="#Sponsor">Sponsor Editor</a></li>
          <li><a data-toggle="tab" href="#Announcements">Announcement Editor</a></li>
          <li><a data-toggle="tab" href="#Email">Mass Email</a></li>
        </ul>
        <div class="col-md-9">
          <div class="tab-content">
            <div id="Contact" class="tab-pane fade in active">
              <h3>Contact Editor</h3>
              <form action="adminScripts/contactEditor.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <div class="form-group">
                  <input type="file" name="fileToUpload" id="fileToUpload">
                  <textarea class="form-control" rows="1" id="cap" name="caption"></textarea>
                  <textarea class="form-control" rows="1" id="addr" name="address"></textarea>
                  <textarea class="form-control" rows="1" id="phn" name="phone"></textarea>
                  <textarea class="form-control" rows="1" id="eml" name="email"></textarea>
                  <input type="submit" value="Upload Image" name="submit">
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
                  <input type="submit" value="Upload Image" name="submit">
                </div>
              </form>
              <br><br><br>
              <h3>Delete Sponsor</h3>
              <form action="adminScripts/sponsorDeleter.php" method="post">
                <p>Use this to delete a sponsor from the page.</p>
                <div class="form-group">
                  <label for="selectImage">Select Image</label>
                    <select class="form-control" id="selectImage" name="selImg">
                      <?php
                        $populateQuery = "SELECT * FROM sponsors";
                        $res = mysql_query($populateQuery);
                        while($row = mysql_fetch_array($res)) {
                          echo '<option>'.$row['sidebarName'].'</option>';
                        }
                      ?>
                    </select>
                    <input type="submit" value="Delete">
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
          </div>
          <div id="Email" class="tab-pane fade">
            <h3>Mass Emailer</h3>
            <p>Use this editor to create email announcements for subscribed users.</p>
            <form action="adminScripts/announceEditor.php" method="post">
              <div class="form-group">
                <label for="announce">Email:</label>
                <textarea class="form-control" rows="5" id="ema" name="email"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary" name="btn-announce">Submit</button>
              </div>
          </form>
        </div>
        </div>
      </div>


            <!--form to upload a picture into the database -->

</body>
</html>
<?php ob_end_flush(); ?>
