<?php 
session_start();
if (!isset($_SESSION['fpEmail'])) {
    header("Location: ../forgotpassword/forgot_password.php");
    exit();
}

require '../Home/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch new password from the form
    $new_password = $_POST['password'];
    $email = $_SESSION['fpEmail'];

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update query with the hashed password
    $sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Notify the user of successful password reset
        $_SESSION['success_message'] = "Password has been reset successfully.";
        unset($_SESSION['fpEmail']); // Clear session
        header("Location: ../Loginfiles/login.html");
        exit();
    } else {
        // Handle update error
        $_SESSION['error_message'] = "Error updating password. Please try again.";
        header("Location: ../forgotpassword/reset_password.php");
        exit();
    }

    // Close the connection
    // mysqli_close($conn);
}
