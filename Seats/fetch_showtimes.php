<?php
session_start();
include('connection.php');

// Ensure movie_id exists in session and show_date is passed in POST
if (!isset($_POST['movie_id']) || !isset($_POST['show_date'])) {
    die(json_encode(["error" => "Movie ID or show date is missing."]));
}

$movie_id = $_POST['movie_id'];  // Get movie_id from session
$selected_date = $_POST['show_date'];  // Get selected date from POST

// Set timezone to Asia/Kathmandu
date_default_timezone_set('Asia/Kathmandu');
$current_datetime = new DateTime('now');

// Prepare and execute query to get available showtimes
$query = "SELECT DISTINCT show_time FROM showtimes WHERE movie_id = ? AND show_date = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt === false) {
    die(json_encode(["error" => "Query preparation failed: " . mysqli_error($conn)]));
}

mysqli_stmt_bind_param($stmt, "is", $movie_id, $selected_date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$available_showtimes = [];

while ($row = mysqli_fetch_assoc($result)) {
    $show_datetime = new DateTime("$selected_date {$row['show_time']}");

    // Calculate cutoff time (15 minutes before showtime)
    $cutoff_time = clone $show_datetime;
    $cutoff_time->modify('-15 minutes');

    // If the current datetime is less than the cutoff time, add the showtime to the available list
    if ($current_datetime < $cutoff_time) {
        $available_showtimes[] = $row['show_time'];
    }
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// Return the available showtimes as JSON
echo json_encode([$selected_date => $available_showtimes]);
?>
