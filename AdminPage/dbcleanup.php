<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}

include("connection.php");

try {
    // Archival Query with Duplicate Handling
    $sql = "
        INSERT INTO archive_booking_table (id, seat_number, reservation_date, showtime, reserved_by, created_at, movie_id)
       SELECT r.id, r.seat_number, r.reservation_date, r.showtime, r.reserved_by, r.created_at, r.movie_id
        FROM seat_reservations r
        WHERE r.reservation_date < CURDATE() OR (r.reservation_date = CURDATE() AND r.showtime < CURTIME())
        ON DUPLICATE KEY UPDATE id = archive_booking_table.id";

    if ($conn->query($sql) === TRUE) {
        // Delete Old Records
        $deleteSql = "
            DELETE FROM seat_reservations
            WHERE reservation_date < CURDATE() OR (reservation_date = CURDATE() AND showtime < CURTIME())";
        $conn->query($deleteSql);

        echo "<script>
        alert('Archival process completed successfully.');
        window.location.href = 'index.php'; // Redirect to the admin page
    </script>";

    } else {
        echo "<script>
            alert('Error during archival: " . $conn->error . "');
            window.location.href = 'index.php'; // Redirect to the admin page
        </script>";
    }
    }
 catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
$conn->close();
?>
