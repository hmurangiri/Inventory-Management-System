<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect user to login page
header("Location: login.php?message=You have been logged out!");
exit();
?>