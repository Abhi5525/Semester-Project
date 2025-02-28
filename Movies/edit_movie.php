<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
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
    <link rel="stylesheet" href="movies.css">
    <script>
        function validation() {
            var title = document.getElementById("title").value;
            var description = document.getElementById("description").value;
            var duration = document.getElementById("duration").value;
            var url = document.getElementById("url").value;
            var genre = document.getElementById("genre").value;
            var thumbnail = document.getElementById("thumbnail").value;
            var status = document.getElementById("status").value;


            document.getElementById("titleError").textContent = "";
            document.getElementById("descriptionError").textContent = "";
            document.getElementById("durationError").textContent = "";
            document.getElementById("urlError").textContent = "";
            document.getElementById("genreError").textContent = "";
            document.getElementById("thumbnailError").textContent = "";
            document.getElementById("statusError").textContent = "";




            var valid = true;

            if (title == "") {
                document.getElementById("titleError").textContent = "Missing the movie title";
                valid = false;
            }

            if (description == "") {
                document.getElementById("descriptionError").textContent = "Missing the movie description";
                valid = false;
            }

            if (duration == "") {
                document.getElementById("durationError").textContent = "Missing the movie duration";
                valid = false;
            }

            if (url == "") {
                document.getElementById("urlError").textContent = "Missing the movie trailor's URL";
                valid = false;
            }

            if (genre == "") {
                document.getElementById("genreError").textContent = "Missing the movie genre";
                valid = false;
            }

            if (thumbnail == "") {
                document.getElementById("thumbnailError").textContent = "Please upload a movie thumbnail";
                valid = false;
            }
            if (status == "") {
                document.getElementById("statusError").textContent = "Please upload a movie thumbnail";
                valid = false;
            }

            return valid;
        }
    </script>
</head>


<body>
    <h2>Edit Movie</h2>
    <div class="container">

    <form action="update_movie.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
        <div class="input-field">
        
            <label for="title">Movie Title</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($movie['Title']); ?>" required>
            <span class="error" id="titleError"></span>
        
        </div>
        <div class="input-field">
        
            <label for="description">Description</label>
            <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($movie['Description']); ?>" required>
            <span class="error" id="descriptionError"></span>
       
        </div>
        <div class="input-field">
        
            <label for="duration">Duration (minutes)</label>
            <input type="text" name="duration" id="duration" value="<?php echo htmlspecialchars($movie['Duration']); ?>" required>
            <span class="error" id="durationError"></span>
        
        </div>
        <div class="input-field">
        
            <label for="url">Trailer URL</label>
            <input type="text" name="url" id="url" value="<?php echo htmlspecialchars($movie['URL']); ?>" required>
            <span class="error" id="urlError"></span>
        
        </div>
        <div class="input-field">
        
            <label for="genre">Genre</label>
            <select name="genre" id="genre" required>
                <option value="Action" <?php echo isset($movie['genre']) && $movie['genre'] == 'Action' ? 'selected' : ''; ?>>Action</option>
                <option value="Comedy" <?php echo isset($movie['genre']) && $movie['genre'] == 'Comedy' ? 'selected' : ''; ?>>Comedy</option>
                <option value="Drama" <?php echo isset($movie['genre']) && $movie['genre'] == 'Drama' ? 'selected' : ''; ?>>Drama</option>
                <option value="Horror" <?php echo isset($movie['genre']) && $movie['genre'] == 'Horror' ? 'selected' : ''; ?>>Horror</option>
                <option value="Sci-Fi" <?php echo isset($movie['genre']) && $movie['genre'] == 'Sci-Fi' ? 'selected' : ''; ?>>Sci-Fi</option>

            </select>
            <span class="error" id="genreError"></span>


        </div>
        <div class="input-field">
        
            <label for="thumbnail">Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail">
            <img src="<?php echo $movie['Thumbnail']; ?>" alt="Thumbnail" width="100">
            <span class="error" id="thumbnailError"></span>
        
        </div>
        <div class="input-field">
        
    <label for="status">Movie Status</label>
    <select name="status" id="status" required>
        <option value="Now Showing" <?php echo $movie['status'] == 'Now Showing' ? 'selected' : ''; ?>>Now Showing</option>
        <option value="Coming Soon" <?php echo $movie['status'] == 'Coming Soon' ? 'selected' : ''; ?>>Coming Soon</option>
        <option value="ended" <?php echo $movie['status'] == 'ended' ? 'selected' : ''; ?>>Ended</option>
    </select>
    <span class="error" id="statusError"></span>

</div>
        <button type="submit">Update Movie</button>
    </form>
</div>

</body>

</html>