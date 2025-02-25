<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'];

    // Check if OTP cookie exists
    if (isset($_COOKIE['otp'])) {
        $stored_otp = $_COOKIE['otp'];

        // Validate OTP
        if ($entered_otp == $stored_otp) {
            // OTP matches
            setcookie("otp", "", time() - 3600, "/"); // Clear OTP cookie
            // $_SESSION['success_message'] = "OTP verified successfully.";
            header("Location: ../forgotpassword/reset_password.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid OTP. Please try again.";
            header('Location: ../forgotpassword/enter_otp.php');
        }
    } else {
        $_SESSION['error_message'] = "OTP expired. Please try again by requesting new OTP";
        header('Location: ../forgotpassword/forgot_password.php');
    }
} else {
    $_SESSION['error_message'] = "Invalid request method";
    header("Location: ../forgotpassword/forgot_password.php");
    exit();
}
