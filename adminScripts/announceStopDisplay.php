<?php
include_once ('../dbconnect.php');
$qry = "UPDATE announcements SET announce = 'no announce' WHERE idannouncements=0";
$res = mysql_query($qry);
?>
