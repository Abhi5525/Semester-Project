<?php
include("connection.php"); // Include the connection file

// Fetch movie data for editing
if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];
    $sql = "SELECT * FROM movies WHERE movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();
    if (!$movie) {
        die("Movie not found!");
    }
} else {
    die("No movie ID provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <link rel="stylesheet" href="editmovies.css">
</head>
<body>
    <h2>Edit Movie</h2>
    <form action="update_movie.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
        <div>
            <label for="title">Movie Title</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($movie['Title']); ?>" required>
        </div>
        <div>
            <label for="description">Description</label>
            <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($movie['Description']); ?>" required>
        </div>
        <div>
            <label for="duration">Duration (minutes)</label>
            <input type="text" name="duration" id="duration" value="<?php echo htmlspecialchars($movie['Duration']); ?>" required>
        </div>
        <div>
            <label for="url">Trailer URL</label>
            <input type="text" name="url" id="url" value="<?php echo htmlspecialchars($movie['URL']); ?>" required>
        </div>
        <div>
            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre" value="<?php echo htmlspecialchars($movie['Genre']); ?>" required>
        </div>
        <div>
            <label for="thumbnail">Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail">
            <img src="<?php echo $movie['Thumbnail']; ?>" alt="Thumbnail" width="100">
        </div>
        <button type="submit">Update Movie</button>
    </form>
</body>
</html>
