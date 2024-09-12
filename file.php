<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $showtime = $_POST['showtime'];
    $num_tickets = $_POST['num_tickets'];

    $sql = "INSERT INTO bookings (movie_id, showtime, num_tickets) VALUES ('$movie_id', '$showtime', '$num_tickets')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New booking created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
