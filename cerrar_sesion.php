<?php
header('Content-Type: application/json');
session_start();
session_unset();
session_destroy();
header("Location: http://localhost/3.3/login.php");
exit();
?>
