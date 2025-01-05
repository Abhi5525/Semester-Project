<?php
session_start();
header('Content-Type: Application/JSON');
include('connection.php'); // Include your database connection file

// Ensure the user is logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    die(json_encode(["success" => false, "message" => "You must be logged in to book seats."]));
}

// Ensure a movie is selected
if (!isset($_SESSION['movie_id'])) {
    die(json_encode(["success" => false, "message" => "No movie selected. Please go back and select a movie."]));
}

// Retrieve the username from the session (assuming it is stored during login)
$username = $_SESSION['username'] ?? null;

if (!$username) {
    die(json_encode(["success" => false, "message" => "User not found in session."]));
}

// Retrieve user ID from the database using the username
$query = "SELECT user_id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die(json_encode(["success" => false, "message" => "User not found."]));
}

$userData = $result->fetch_assoc();
$userId = $userData['user_id']; // Retrieve user ID from the result
$movieId = $_SESSION['movie_id']; // Get movie ID from session

// Get date, time, and seats from the POST request
$date = $_POST['date'] ?? null;
$time = $_POST['time'] ?? null;
$seats = isset($_POST['seats']) ? json_decode($_POST['seats'], true) : [];

// Validate the booking data
if (!$date || !$time || empty($seats) || !is_array($seats)) {
    die(json_encode(["success" => false, "message" => "Invalid booking data."]));
}

// Begin transaction to ensure atomicity of the operation
try {
    $conn->begin_transaction(); // Begin the transaction

    foreach ($seats as $seat) {
        // $checkQuery = "SELECT * FROM seat_reservations 
        //                WHERE seat_number = '$seat' 
        //                  AND reservation_date = '$date' 
        //                  AND showtime = '$time' 
        //                  AND movie_id = $movieId";
        // $result = mysqli_query($conn, $checkQuery);

        // if (mysqli_num_rows($result) > 0) {
        //     $conn->rollback(); // Rollback the transaction
        //     throw new Exception("Seat $seat is already reserved.");
        // }

        $query = "INSERT INTO seat_reservations (seat_number, reservation_date, showtime, reserved_by, movie_id) 
                  VALUES ('$seat', '$date', '$time', '$userId', $movieId)";
        if (!mysqli_query($conn, $query)) {
            $conn->rollback(); // Rollback the transaction
            throw new Exception("Database error: " . mysqli_error($conn));
        }
    }


    // Commit the transaction if everything is successful
    $conn->commit();

    // Fetch the movie details (name, genre, duration, thumbnail)
    $movieQuery = "SELECT Title, Duration, Genre, Thumbnail FROM movies WHERE movie_id = $movieId";
    $movieResult = mysqli_query($conn, $movieQuery);

    if (mysqli_num_rows($movieResult) > 0) {
        $movieDetails = mysqli_fetch_assoc($movieResult);
    } else {
        die("Movie not found.");
    }

    // Fetch the bookings in descending order of `created_at` for the same reservation date
    $query = "SELECT * FROM seat_reservations 
              WHERE reservation_date = '$date' 
              ORDER BY created_at DESC 
              LIMIT 10";
    $result = mysqli_query($conn, $query);

    $latestSeats = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $latestSeats[] = $row;
    }

    // Return success message with seat and movie details
    echo json_encode([
        "success" => true,
        "message" => "Booking successful.",
        "data" => $latestSeats,
        "movie" => $movieDetails // Include the movie details
    ]);
} catch (Exception $e) {
    // Rollback the transaction if there is an error
    $conn->rollback();

    // Return failure message as JSON
    echo json_encode(["success" => false, "message" => "Booking failed: " . $e->getMessage()]);
}

// Close the database connection
$conn->close();
