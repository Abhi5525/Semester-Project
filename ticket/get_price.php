<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
// fetch_prices.php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database conn file
require '../Seats/connection.php';

// Get the input values from the AJAX request
$movieId = $_POST['movieId'];
$showDate = $_POST['date'];
$showTime = $_POST['time'];

// Validate input (basic validation)
if (empty($movieId) || empty($showDate) || empty($showTime)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
    exit;
}

// Query to join the `showtimes` and `ticket_rates` tables
$query = "
    SELECT tr.price
    FROM showtimes st
    JOIN ticket_rates tr
    ON st.day_type = tr.day_type AND st.show_time = tr.show_time
    WHERE st.movie_id = '$movieId'
    AND st.show_date = '$showDate'
    AND st.show_time = '$showTime'
";

// Execute the query
$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle database query error
    echo json_encode(['status' => 'error', 'message' => 'Database query failed: ' . mysqli_error($conn)]);
    exit;
}

// Fetch the price
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $price = $row['price'];

    // Return the price as a JSON response
    echo json_encode(['status' => 'success', 'price' => $price]);
} else {
    // No matching record found
    echo json_encode(['status' => 'error', 'message' => 'No price found for the selected showtime.']);
}

// Close the database conn
mysqli_close($conn);
?>