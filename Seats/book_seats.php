<?php

session_start();
header('Content-Type: Application/JSON');
include('connection.php');

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    die(json_encode(["success" => false, "message" => "You must be logged in to book seats."]));
}

if (!isset($_SESSION['movie_id'])) {
    die(json_encode(["success" => false, "message" => "No movie selected."]));
}

$username = $_SESSION['username'] ?? null;
if (!$username) {
    die(json_encode(["success" => false, "message" => "User not found in session."]));
}

$query = "SELECT user_id FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die(json_encode(["success" => false, "message" => "User not found."]));
}

$userData = mysqli_fetch_assoc($result);
$userId = $userData['user_id'];
$movieId = $_SESSION['movie_id'];

$date = $_POST['date'] ?? null;
$time = $_POST['time'] ?? null;
$seats = isset($_POST['seats']) ? json_decode($_POST['seats'], true) : [];

if (!$date || !$time || empty($seats) || !is_array($seats)) {
    die(json_encode(["success" => false, "message" => "Invalid booking data."]));
}

try {
    // Start a single transaction
    mysqli_begin_transaction($conn);

    foreach ($seats as $seat) {
        // Check if the seat is already reserved
        $checkQuery = "SELECT * FROM seat_reservations 
                       WHERE seat_number = '$seat' 
                       AND reservation_date = '$date' 
                       AND showtime = '$time' 
                       AND movie_id = $movieId";
        $checkResult = mysqli_query($conn, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            mysqli_rollback($conn);
            throw new Exception("Seat $seat is already reserved.");
        }

        // Insert the reservation
        $query = "INSERT INTO seat_reservations (seat_number, reservation_date, showtime, reserved_by, movie_id, status) 
                  VALUES ('$seat', '$date', '$time', $userId, $movieId ,'reserved')";
        if (!mysqli_query($conn, $query)) {
            mysqli_rollback($conn);
            throw new Exception("Database error: " . mysqli_error($conn));
        }
    }

    // Retrieve movie details
    $movieQuery = "SELECT Title, Duration, Genre, Thumbnail FROM movies WHERE movie_id = $movieId";
    $movieResult = mysqli_query($conn, $movieQuery);
    $movieDetails = mysqli_fetch_assoc($movieResult);

    if (!$movieDetails) {
        mysqli_rollback($conn);
        throw new Exception("Movie not found.");
    }

    $query = "SELECT * 
    FROM seat_reservations 
    WHERE created_at = (SELECT MAX(created_at) FROM seat_reservations)";
$result = mysqli_query($conn, $query);

$latestSeats = [];
if ($result) {
while ($row = mysqli_fetch_assoc($result)) {
  $latestSeats[] = $row; // Add the rows to the array
}
}


    // Commit the transaction
    mysqli_commit($conn);

    // Return a success response
    echo json_encode([
        "success" => true,
        "message" => "Booking successful.",
        "data" => $latestSeats,
        "movie" => $movieDetails
    ]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(["success" => false, "message" => "Booking failed: " . $e->getMessage()]);
}

mysqli_close($conn);
