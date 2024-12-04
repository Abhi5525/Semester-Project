<?php
include("connection.php"); // Include the connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie_id = $_POST['movie_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $url = $_POST['url'];
    $genre = $_POST['genre'];
    $thumbnail = $_FILES['thumbnail']['name'];

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
        $sql = "SELECT Thumbnail FROM movies WHERE movie_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $movie = $result->fetch_assoc();
        $thumbnail_path = $movie['Thumbnail'];
    }

    // Update movie details in the database
    $update_sql = "UPDATE movies SET Title = ?, Description = ?, Duration = ?, URL = ?, Genre = ?, Thumbnail = ? WHERE movie_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssisssi", $title, $description, $duration, $url, $genre, $thumbnail_path, $movie_id);

    if ($stmt->execute()) {
        // Redirect after a successful update
        header("Location: Availablemovies.php");
        exit();
    } else {
        echo "Error updating movie: " . $conn->error;
    }
}
?>
