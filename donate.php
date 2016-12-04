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
  <title>Donate</title>
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
          <li class="active"><a href="donate.php">Donate</a></li>
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
    <!-- Credit for donation form: http://bootsnipp.com/snippets/featured/credit-card-form-bootstrap-3 ... Will probably replace this. -->
    <div class="container">
  <form class="form-horizontal" role="form">
    <fieldset>
      <legend>Donation</legend>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-holder-name">Name on Card</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="card-holder-name" id="card-holder-name" placeholder="Card Holder's Name">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-number">Card Number</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="card-number" id="card-number" placeholder="Debit/Credit Card Number">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="expiry-month">Expiration Date</label>
        <div class="col-sm-9">
          <div class="row">
            <div class="col-xs-3">
              <select class="form-control col-sm-2" name="expiry-month" id="expiry-month">
                <option>Month</option>
                <option value="01">Jan (01)</option>
                <option value="02">Feb (02)</option>
                <option value="03">Mar (03)</option>
                <option value="04">Apr (04)</option>
                <option value="05">May (05)</option>
                <option value="06">June (06)</option>
                <option value="07">July (07)</option>
                <option value="08">Aug (08)</option>
                <option value="09">Sep (09)</option>
                <option value="10">Oct (10)</option>
                <option value="11">Nov (11)</option>
                <option value="12">Dec (12)</option>
              </select>
            </div>
            <div class="col-xs-3">
              <select class="form-control" name="expiry-year">
                <option value="13">2016</option>
                <option value="14">2017</option>
                <option value="15">2018</option>
                <option value="16">2019</option>
                <option value="17">2020</option>
                <option value="18">2021</option>
                <option value="19">2022</option>
                <option value="20">2023</option>
                <option value="21">2024</option>
                <option value="22">2025</option>
                <option value="23">2026</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="cvv">Card CVV</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="cvv" id="cvv" placeholder="Security Code">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
          <button type="button" class="btn btn-success">Pay Now</button>
        </div>
      </div>
    </fieldset>
  </form>
</div>
<!-- Footer -->
<div class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
      <p class="navbar-text pull-left">© 2016 - All rights reserved – Williamson County Chamber Foundation, an affiliate of the Williamson County Chamber of Commerce</p>
    </div>
</div>
</body>
</html>
