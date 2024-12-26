<?php
include('../Home/connection.php');

try {
    // Prepare SQL to fetch ticket rates
    $sql = "SELECT day_type, show_time, price FROM ticket_rates";
    $result = $conn->query($sql);

    $rates = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Map ENUM values to ensure correct capitalization
            $row['day_type'] = ucfirst($row['day_type']); // e.g., weekday -> Weekday
            $row['show_time'] = ucfirst($row['show_time']); // e.g., morning -> Morning
            $rates[] = $row;
        }
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($rates);
} catch (Exception $e) {
    // Handle potential errors
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => 'Failed to fetch rates. Please try again later.']);
} finally {
    $conn->close();
}
?>
