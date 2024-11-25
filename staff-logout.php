<?php
session_start();
 
$_SESSION = array();
 
session_destroy();

header("location: staff-login");
exit;
?>