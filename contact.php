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
<html lang="en">
<head>
  <title>Contact Us</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- fix image sizes -->
<style>
#myCarousel {
  margin-left: 30px;
  margin-right: 30px;
}
.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
    width: 450px;
    height: 300px;
    margin: auto;
    overflow: hidden;
}
.carousel-indicators li {
background-color: #999;
background-color: rgba(70,70,70,.25);
}
.carousel-control {
  /*top: 50%;*/
}
.carousel-control.left, .carousel-control.right {
  background: none;
  color: @red;
  border: none;
}
.carousel-control.left {
  color: black;
}
.carousel-control.right {
  color: black;
}
.carousel-indicators .active {
background-color: #000000;
}
.carousel-caption {
position: relative;
left: auto;
right: auto;
}
.carousel-caption h3 {
color: black;
}
</style>
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
          <li class="active"><a href="contact.php">Contact Us</a></li>
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
      <br>
      <div class="row">
        <div class="col-md-6">
          <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="10000">
            <!-- Indicators -->
            <ol class="carousel-indicators">
            <?php
              $qry = mysql_query("SELECT * FROM contact");
              $flag = 1;
              $count = 1;
              while($row = mysql_fetch_array($qry)) {
                if($flag == 1) {
                  echo '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
                  $flag = 0;
                }
                else {
                  echo "<li data-target='#myCarousel' data-slide-to='$count'></li>";
                  $count = $count + 1;
                }
              }
             ?>
             </ol>
            <!-- <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol> -->
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <?php
                // This code pulls a list of images for the img directory and then
                // generates code
                // $dirname = "img/";
                // $images = glob($dirname."*.jpg");
                // $flag = 1; // Make the first item active
                // foreach($images as $image) {
                //   echo '<div class="item' .($flag?' active':''). '">'.PHP_EOL."\t\t";
                //   echo '<img src="'.$image.'" alt=""></div>'.PHP_EOL."\t";
                //   $flag = 0;
                // }
                $qry = mysql_query("SELECT * FROM contact");
                $flag = 1;
                while($row = mysql_fetch_array($qry))
                {
                  $cap = $row['caption'];
                  $add = $row['address'];
                  $phn = $row['phoneNum'];
                  $eml = $row['email'];
                  if($flag == 1)
                  {
                    echo '<div class="item' .($flag?' active':''). ' ">';
                    echo '<img src="adminScripts/'.$row['imgpath'].' ">';
                    echo '<div class="carousel-caption">';
                    echo '<h3>'.$cap.'</h3>';
                    echo'<h3>'.$add.'</h3>';
                    echo'<h3>'.$phn.'</h3>';
                    echo'<h3>'.$eml.'</h3>';
                    echo '</div>';
                    echo '</div>';
                    $flag = 0;
                  }
                  else{
                    echo '<div class="item">';
                    echo '<img src="adminScripts/'.$row['imgpath'].' ">';
                    echo '<div class="carousel-caption">';
                    echo '<h3>'.$cap.'</h3>';
                    echo'<h3>'.$add.'</h3>';
                    echo'<h3>'.$phn.'</h3>';
                    echo'<h3>'.$eml.'</h3>';
                    echo "</div>";
                    echo '</div>';
                  }
                }
               ?>
              <!-- <div class="item active">
                <img src="img/swagger_duder.jpg" alt="dude" width="460" height="345">
              </div>

              <div class="item">
                <img src="img/true_manliness.jpg" alt="manliness" width="460" height="345">
              </div>

              <div class="item">
                <img src="img/leadership_shirt.jpg" alt="shirt" width="460" height="345">
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <h3>Business Information</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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
