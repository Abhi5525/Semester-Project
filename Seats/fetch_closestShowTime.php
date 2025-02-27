<?php

// Include the database conn file
require '../Seats/connection.php';

$movie_id = $_POST['movie_id'];
$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
$dayAfter = date('Y-m-d', strtotime('+2 days'));

$query = "SELECT show_date, show_time FROM showTimes 
          WHERE movie_id = '$movie_id' 
          AND show_date IN ('$today', '$tomorrow', '$dayAfter') 
          ORDER BY show_date ASC, show_time ASC";

$result = mysqli_query($conn, $query);

$showtimes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $showtimes[] = $row;
}

echo json_encode($showtimes);
mysqli_close($conn);
?>
