<?php
include 'connection.php';

$shift = $_POST['shift'];
$seat = $_POST['seat'];
$action = $_POST['action'];
$status = ($action === 'reserve') ? 'booked' : 'available';

// Extract row letter and seat number
$row = substr($seat, 0, 1);
$seatNumber = intval(substr($seat, 1));

$sql = "UPDATE seats SET status = ? WHERE shift = ? AND row_letter = ? AND seat_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $status, $shift, $row, $seatNumber);

// Execute the statement
$stmt->execute();

// Prepare the response
$response = [];
if ($stmt->affected_rows > 0) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = "Failed to update seat status. Please try again.";
}

// Add error handling for SQL execution
if ($stmt->error) {
    $response['success'] = false;
    $response['message'] = "Database error: " . $stmt->error;
}

// Send the JSON response back to the client
echo json_encode($response);

// Close the statement and connection
$stmt->close();
$conn->close();
?>
