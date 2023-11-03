<?php
require("session.php");
$_SESSION = array();
setcookie(session_name(), '', time()-56000);
session_destroy();
header("location: login.php");
exit();
?>