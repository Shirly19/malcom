<?php
session_start();  // Start the session

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the main page (or login page if preferred)
header("Location: main.php");  // Replace with your main page or home page
exit();
?>

