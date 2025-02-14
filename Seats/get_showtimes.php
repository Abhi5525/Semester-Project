<?php
include('connection.php');

// Get the movie ID and selected date from the AJAX request
$movie_id = $_POST['movie_id'];
$selected_date = $_POST['date'];

// Fetch showtimes for the selected date and movie
$query = "SELECT DISTINCT show_time FROM showtimes WHERE movie_id = $movie_id AND show_date = '$selected_date'";
$result = mysqli_query($conn, $query);

$available_showtimes = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $available_showtimes[] = $row['show_time'];
    }
} else {
    die("Query failed: " . mysqli_error($conn));
}

// Return the showtimes as JSON
echo json_encode($available_showtimes);
?>