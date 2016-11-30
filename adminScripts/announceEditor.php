<?php
ob_start();
session_start();
if( !isset($_SESSION['user'])!="" ){
  header("Location: ../Main.php");
}
include_once '../dbconnect.php';
echo "Posted text: ";
echo $_POST['announce'];
$error = false;
$res=mysql_query("SELECT * FROM Users WHERE idUsers=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
$adminRes=mysql_query("SELECT * FROM admin WHERE idadmin=".$userRow['idUsers']);
$adminRow=mysql_fetch_array($adminRes); // Check to see if current user is an admin
if($adminRow['idadmin'] == "") {
  header("Location: ../Main.php");
}
?>
