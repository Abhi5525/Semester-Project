<?php
session_start();
include("../Seats/connection.php");

// Admin credentials
$adminemail = "MasterAdmin@gmail.com";
$adminpassword = "MasterAdmin";

// Get user input and sanitize it
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$pw = isset($_POST['password']) ? trim($_POST['password']) : '';

// Check if it's the admin
if ($email === $adminemail && $pw === $adminpassword) {
    $_SESSION['userRole'] = 'Admin'; // Set a role for the admin
    $_SESSION['userEmail'] = $adminemail;
    $_SESSION['isLoggedIn'] = true;

    // Redirect to the admin page
    header("Location: ../AdminPage/index.php"); // Corrected path
    exit();
}

// Prepare SQL query to check regular user credentials
$stmt = $conn->prepare("SELECT username, password, phone FROM users WHERE email = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    
    // Verify the password
    if (password_verify($pw, $row['password'])) {
        // Set session variables
        $_SESSION['username'] = $row['username'];
        $_SESSION['phone'] = $row['phone']; // Corrected to 'phone'
        $_SESSION['userEmail'] = $email;
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['userRole'] = 'User';

        // Redirect to user home page
        header("Location: ../Home/index.php");
        exit();
    } else {
        // Incorrect password
        echo "<script>
                alert('Incorrect password. Please try again.');
                window.location.href = '../LoginFiles/login.html';
              </script>";
    }
} else {
    // No user found
    echo "<script>
            alert('No user found with this email. Please register.');
            window.location.href = '../LoginFiles/register.html';
          </script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
