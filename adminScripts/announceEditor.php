<?php
ob_start();
session_start();
if( !isset($_SESSION['user'])!="" ){
  header("Location: ../Main.php");
}
include_once '../dbconnect.php';
// Make sure the user is signed in and is an administrator
$error = false;
$res=mysql_query("SELECT * FROM Users WHERE idUsers=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
$adminRes=mysql_query("SELECT * FROM admin WHERE idadmin=".$userRow['idUsers']);
$adminRow=mysql_fetch_array($adminRes); // Check to see if current user is an admin
if($adminRow['idadmin'] == "") {
  header("Location: ../Main.php");
}

  $updateQuery=mysql_query("UPDATE announcements SET announce=".$_POST['announce']." WHERE idannouncements=0");
?>