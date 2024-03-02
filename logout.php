<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or any other desired page
header("Location: index.php"); // Change "login.php" to the page you want to redirect to after logout
exit();
?>
