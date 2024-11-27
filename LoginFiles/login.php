<?php
session_start(); // Start the session at the beginning

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
$adminemail = "MasterAdmin@gmail.com";
$adminpassword = "MasterAdmin";
$email = $_POST['email'];
$pw = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

if($email === $adminemail && $pw === $adminpassword){
    header("Location: ../Movies/UploadMovies.php"); 
    exit();
}
// Check if the user exists and verify the password
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($pw, $row['password'])) {
        // Set session variable to indicate the user is logged in
        $_SESSION['username'] = $row['username'];
        $_SESSION['phone']=$row['phone'];
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['userEmail'] = $email; // Optionally store email or other info

        // Redirect to the home page
        header("Location: ../Home/index.php");
        exit(); // Ensure script stops after redirection

    }
    else {
        // Incorrect password
        echo "<script>
                alert('Incorrect username or password. Please try again.');
                window.location.href = '../Home/login.php';
              </script>";
    }
} else {
    // No user found with the given email
    echo "<script>
            alert('Incorrect username or password. Please try again.');
            window.location.href = '../Home/login.php';
          </script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>