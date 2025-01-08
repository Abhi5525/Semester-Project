<?php
include('connection.php');

// Set the header to return JSON
header('Content-Type: application/json');

// Get the search query
$query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';


if ($query != '') {
    // Query to fetch Title, Duration, and Thumbnail from movies
    $sql = "SELECT Title,Description,Duration ,URL ,Genre, Thumbnail FROM movies WHERE Title LIKE '%$query%' LIMIT 5";
    $result = $conn->query($sql);

    $movies = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
        
    }

    // Return results as JSON
    echo json_encode($movies);
}
 else {
    echo json_encode([]); // Return an empty array if query is empty
}

$conn->close();
?>
