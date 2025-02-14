<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];

    // Check if the showtime already exists
    $checkQuery = "SELECT * FROM showtimes WHERE movie_id = ? AND show_date = ? AND show_time = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("iss", $movie_id, $show_date, $show_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "This showtime is already assigned for this movie.";
    } else {
        // Insert new showtime
        $insertQuery = "INSERT INTO showtimes (movie_id, show_date, show_time) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iss", $movie_id, $show_date, $show_time);

        if ($stmt->execute()) {
            echo "Showtime assigned successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}

mysqli_close($conn);
?>
