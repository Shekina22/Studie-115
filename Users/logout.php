<?php
session_start();
$_SESSION = array();
session_destroy();

// Omdiriger til innloggingssiden
header('Location: login.php');
exit;
?>
