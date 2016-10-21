<?php
 session_start();
 if (!isset($_SESSION['user'])) {
  header("Location: Main.php");
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
?>

<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>
