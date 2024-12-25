<?php
// Include database connection
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Query to fetch reserved seats for the selected date and time
    $stmt = $conn->prepare("SELECT seat_number FROM seat_reservations WHERE reservation_date = ? AND showtime = ?");
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    $reservedSeats = [];
    while ($row = $result->fetch_assoc()) {
        $reservedSeats[] = $row['seat_number'];
    }

    // Return reserved seats as JSON
    echo json_encode($reservedSeats);
}
?>
