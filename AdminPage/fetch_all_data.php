<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    die("Unauthorized access.");
}

include("connection.php");

// Fetch all seat reservations with movie name
$query = "SELECT sr.*, m.Title AS movie_name 
          FROM seat_reservations sr 
          JOIN movies m ON sr.movie_id = m.movie_id";

$result = $conn->query($query);
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Add each row to the data array
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>