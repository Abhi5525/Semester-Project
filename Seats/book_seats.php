<?php
session_start();
include('connection.php'); // Include your database connection file

// Ensure the user is logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    die("You must be logged in to book seats.");
}

// Ensure a movie is selected
if (!isset($_SESSION['movie_id'])) {
    die("No movie selected. Please go back and select a movie.");
}

// Retrieve the username from the session (assuming it is stored during login)
$username = $_SESSION['username'] ?? null;

if (!$username) {
    die("User not found in session.");
}

// Retrieve user ID from the database using the username
$query = "SELECT user_id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found.");
}

$userData = $result->fetch_assoc();
$userId = $userData['user_id']; // Retrieve user ID from the result
$movieId = $_SESSION['movie_id']; // Get movie ID from session

// Get date, time, and seats from the POST request
$date = $_POST['date'] ?? null;
$time = $_POST['time'] ?? null;
$seats = isset($_POST['seats']) ? json_decode($_POST['seats'], true) : [];

// Validate the booking data
if (!$date || !$time || empty($seats)) {
    die("Invalid booking data.");
}

// Begin transaction to ensure atomicity of the operation
try {
    $conn->begin_transaction();

    // Loop through each selected seat and insert into the database
    foreach ($seats as $seat) {
        // Insert the seat reservation into the seat_reservations table
        $query = "INSERT INTO seat_reservations (seat_number, reservation_date, showtime, reserved_by, movie_id) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $seat, $date, $time, $userId, $movieId);

        // If the query fails, throw an exception to rollback the transaction
        if (!$stmt->execute()) {
            throw new Exception("Database error: " . $stmt->error);
        }
    }

    // Commit the transaction if everything is successful
    $conn->commit();
    echo "success";  // Booking was successful
} catch (Exception $e) {
    // Rollback the transaction if there is an error
    $conn->rollback();
    echo "Booking failed: " . $e->getMessage();  // Output the error message
}

// Close the database connection
$conn->close();
?>
