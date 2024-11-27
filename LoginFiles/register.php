<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_booking";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

// Retrieve form data
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$password = $_POST['password'];  // Use this as the raw password for hashing

// Check if email already exists
$sql1 = "SELECT email FROM users WHERE email = '$email'";
$result1 = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result1) > 0) {
    // Email already exists, return error
    echo "<script>alert('Email already used. Please try a different one.'); window.location.href='register.html';</script>";
} else {
    // Hash the password before inserting into the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $sql = "INSERT INTO users (username, email,phone, password) VALUES ('$username', '$email','$phone', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to login page upon successful registration
        echo "<script>alert('Registered Sucessfully.'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);

?>
