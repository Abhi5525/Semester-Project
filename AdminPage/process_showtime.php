<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];

    // Check if the showtime already exists
    $check_query = "SELECT * FROM showtimes WHERE show_date = '$show_date' AND show_time = '$show_time'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "This showtime is already assigned to another movie!";
    } else {
        // Insert showtime into the table
        $query = "INSERT INTO showtimes (movie_id, show_date, show_time) VALUES ('$movie_id', '$show_date', '$show_time')";
        if (mysqli_query($conn, $query)) {
            echo "Showtime assigned successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
