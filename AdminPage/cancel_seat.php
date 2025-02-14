<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Update the reservation status to "available"
    $query = "DELETE FROM seat_reservations WHERE id = $id";
    if ($conn->query($query)) {
        echo "Seat reservation cancelled successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Redirect back to the admin bookings page
header("Location: admin_bookings.php");
exit();
?>