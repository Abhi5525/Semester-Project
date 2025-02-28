<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
include("connection.php"); // Include the connection file

// Check if the movie ID is provided in the URL
if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];
    
    // Delete the movie from the database
    $delete_sql = "DELETE FROM movies WHERE movie_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();

    // Redirect to the movies list page after deletion
    header("Location: Availablemovies.php");
    exit();
} else {
    // If no movie ID is provided, redirect to the movies list page
    header("Location: Availablemovies.php");
    exit();
}
?>
