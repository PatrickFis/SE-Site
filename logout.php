<?php
 session_start();
 if (!isset($_SESSION['user'])) {
  header("Location: Main.html");
 } else if(isset($_SESSION['user'])!="") {
  header("Location: Main.php");
 }
 
 if (isset($_GET['logout'])) {
  unset($_SESSION['user']);
  session_unset();
  session_destroy();
  header("Location: Main.php");
  exit;
 }