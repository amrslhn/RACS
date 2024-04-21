<?php
// Start the session
session_start();

session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or any other appropriate page after logout
header("Location: index.php");
exit();
?>
