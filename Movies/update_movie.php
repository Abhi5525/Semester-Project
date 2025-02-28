<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
include("connection.php"); // Include the connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie_id = $_POST['movie_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $url = $_POST['url'];
    $genre = $_POST['genre'];
    $thumbnail = $_FILES['thumbnail']['name'];
    $status = $_POST['status'];

    // Handle thumbnail upload or preserve old one
    if ($thumbnail) {
        $upload_dir = 'thumbnails/'; // Correct directory for thumbnails
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
        }

        $thumbnail_path = $upload_dir . basename($thumbnail);

        if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_path)) {
            die("Error uploading thumbnail. Please ensure the thumbnails directory exists and has the correct permissions.");
        }
    } else {
        // Fetch the old thumbnail if no new one is uploaded
        $sql = "SELECT Thumbnail FROM movies WHERE movie_id = $movie_id";
        $result = $conn->query($sql);
        $movie = $result->fetch_assoc();
        $thumbnail_path = $movie['Thumbnail'];
    }

    // Update movie details in the database without prepared statements
    $update_sql = "UPDATE movies SET Title = '$title', Description = '$description', Duration = '$duration', URL = '$url', Genre = '$genre', Thumbnail = '$thumbnail_path', status = '$status' WHERE movie_id = $movie_id";

    if ($conn->query($update_sql) === TRUE) {
        // Redirect after a successful update
        header("Location: ../AdminPage/index.php");
        exit();
    } else {
        echo "Error updating movie: " . $conn->error;
    }
}
?>
