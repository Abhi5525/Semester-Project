<?php
// Start the session
session_start();

// Include database connection
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Extract movie_id from session
    if (isset($_SESSION['movie_id'])) {
        $movieId = $_SESSION['movie_id'];

        // Query to fetch reserved seats for the selected date, time, and movie
        $stmt = $conn->prepare("SELECT seat_number FROM seat_reservations WHERE reservation_date = ? AND showtime = ? AND movie_id = ?");
        $stmt->bind_param("sss", $date, $time, $movieId);
        $stmt->execute();
        $result = $stmt->get_result();

        $reservedSeats = [];
        while ($row = $result->fetch_assoc()) {
            $reservedSeats[] = $row['seat_number'];
        }

        // Return reserved seats as JSON
        echo json_encode($reservedSeats);
    } else {
        // Handle case where movie_id is not set in the session
        echo json_encode(['error' => 'Movie ID not found in session.']);
    }
}
?>
