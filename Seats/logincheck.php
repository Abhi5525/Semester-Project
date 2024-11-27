<?php
session_start();

// Check if the session variable 'isLoggedIn' is set and true
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true) {
    // Redirect to Dashboard if logged in
    header("Location: Dashboard.php");
    exit(); // Ensure no further code is executed after redirect
} else {
    // If not logged in, redirect to login page
    header("Location: ../LoginFiles/login.html");
    exit(); // Ensure no further code is executed after redirect
}
?>
