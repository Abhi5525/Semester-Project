<?php
// Start the session
session_start();

// Include database connection
require 'connection.php';

// Return available showtimes for the selected date
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];

    // Extract movie_id from session
    if (isset($_SESSION['movie_id'])) {
        $movieId = $_SESSION['movie_id'];

        // Query to fetch available showtimes for the selected date
        $stmt = $conn->prepare("SELECT DISTINCT showtime FROM seat_reservations WHERE reservation_date = ? AND movie_id = ?");
        $stmt->bind_param("ss", $date, $movieId);
        $stmt->execute();
        $result = $stmt->get_result();

        $availableTimes = [];
        while ($row = $result->fetch_assoc()) {
            $availableTimes[] = $row['showtime'];
        }

        // Return available times as JSON
        echo json_encode($availableTimes);
    } else {
        // Handle case where movie_id is not set in the session
        echo json_encode(['error' => 'Movie ID not found in session.']);
    }
}
?>
