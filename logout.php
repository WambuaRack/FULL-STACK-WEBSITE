<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // If logged in, unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit();
} else {
    // If user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>
