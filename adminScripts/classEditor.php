<?php
  ob_start();
  session_start();
  if( !isset($_SESSION['user'])!="" ){
    header("Location: ../Main.php");
  }
  include_once ('../dbconnect.php');
  // Make sure the user is signed in and is an administrator
  $error = false;
  $res=mysql_query("SELECT * FROM Users WHERE idUsers=".$_SESSION['user']);
  $userRow=mysql_fetch_array($res);
  $adminRes=mysql_query("SELECT * FROM admin WHERE idadmin=".$userRow['idUsers']);
  $adminRow=mysql_fetch_array($adminRes); // Check to see if current user is an admin
  if($adminRow['idadmin'] == "") {
    header("Location: ../Main.php");
  }
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name, ENT_QUOTES, "UTF-8");

  $company = trim($_POST['company']);
  $company = strip_tags($company);
  $company = htmlspecialchars($company, ENT_QUOTES, "UTF-8");

  $title = trim($_POST['title']);
  $title = strip_tags($title);
  $title = htmlspecialchars($title, ENT_QUOTES, "UTF-8");

  $year = trim($_POST['year']);
  $year = strip_tags($year);
  $year = htmlspecialchars($year, ENT_QUOTES, "UTF-8");

  $insertQuery = mysql_query("INSERT INTO classMembers (name, company, title, year) VALUES('$name', '$company', '$title', '$year')");
  // Redirect the user back to the admin page.
  header("Location: ../admin.php");
?>
