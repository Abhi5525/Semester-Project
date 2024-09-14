<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: Please try again later.");
}

// Get user input
$email = $_POST['email'];
$pw = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists and verify the password
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($pw, $row['password'])) {
        header("Location: dashboard.php");
        exit(); // Ensure script stops after redirection
    } else {
        echo "<script>alert('Incorrect username or password. Please try again.'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('Incorrect username or password. Please try again.'); window.location.href='login.php';</script>";
}

// Close the connection
$stmt->close();
$conn->close();
?>
