<?php
include("connection.php"); // Include the connection file

// Fetch movie data for editing
if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];
    $sql = "SELECT * FROM movies WHERE movie_id = $movie_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
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
            <select name="genre" id="genre" required>
                <option value="Action" <?php echo isset($movie['genre']) && $movie['genre'] == 'Action' ? 'selected' : ''; ?>>Action</option>
                <option value="Comedy" <?php echo isset($movie['genre']) && $movie['genre'] == 'Comedy' ? 'selected' : ''; ?>>Comedy</option>
                <option value="Drama" <?php echo isset($movie['genre']) && $movie['genre'] == 'Drama' ? 'selected' : ''; ?>>Drama</option>
                <option value="Horror" <?php echo isset($movie['genre']) && $movie['genre'] == 'Horror' ? 'selected' : ''; ?>>Horror</option>
                <option value="Sci-Fi" <?php echo isset($movie['genre']) && $movie['genre'] == 'Sci-Fi' ? 'selected' : ''; ?>>Sci-Fi</option>

            </select>

        </div>
        <div>
            <label for="thumbnail">Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail">
            <img src="<?php echo $movie['Thumbnail']; ?>" alt="Thumbnail" width="100">
        </div>
        <div>
    <label for="status">Movie Status</label>
    <select name="status" id="status" required>
        <option value="now_showing" <?php echo $movie['status'] == 'now_showing' ? 'selected' : ''; ?>>Now Showing</option>
        <option value="coming_soon" <?php echo $movie['status'] == 'coming_soon' ? 'selected' : ''; ?>>Coming Soon</option>
        <option value="ended" <?php echo $movie['status'] == 'ended' ? 'selected' : ''; ?>>Ended</option>
    </select>
</div>
        <button type="submit">Update Movie</button>
    </form>
</body>

</html>