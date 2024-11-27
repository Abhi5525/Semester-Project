<?php
include 'connection.php';

$shift = $_GET['shift'];
$seatData = [];

// Fetch seat status for the selected shift
$sql = "SELECT row_letter, seat_number, status FROM seats WHERE shift = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $shift);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $rowLetter = $row['row_letter'];
    $seatNumber = $row['seat_number'];
    $status = $row['status'];

    if (!isset($seatData[$rowLetter])) {
        $seatData[$rowLetter] = [];
    }
    $seatData[$rowLetter][$seatNumber - 1] = $status; // Adjust for array index
}

echo json_encode($seatData);
$stmt->close();
$conn->close();
?>
