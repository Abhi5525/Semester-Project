<?php
session_start();

// if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
//     http_response_code(401); // Unauthorized
//     echo "User is not logged in.";
//     exit();
// }

// Check if movie_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id'])) {
    $movie_id = intval($_POST['movie_id']); // Ensure it's an integer

    if ($movie_id > 0) {
        $_SESSION['movie_id'] = $movie_id;
        echo "Movie ID stored successfully.";
    } else {
        http_response_code(400); // Bad Request
        echo "Invalid Movie ID.";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
?>
