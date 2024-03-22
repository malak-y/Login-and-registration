<?php

session_start();// Start the session
$_SESSION = array();// Unset all session variables to effectively "logout" the user
session_destroy();// Destroy the session completely to remove all session data when the user logout  
header("Location: login.php");// Redirect the user back to the login page after logout
exit();
?>
