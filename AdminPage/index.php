<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
include("connection.php");
include('../Home/navbar.php')
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Movie Booking System - Admin</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>

    <!-- Movie List Section -->
    <section class="available-movies">
        <h2>Now Showing</h2>
        <div class="movie-container">
            <?php
            $sql = "SELECT * from movies WHERE status = 'Now Showing'";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $movieId = $row['movie_id'];
                    $title = $row['Title'];
                    $description = $row['Description'];
                    $duration = $row['Duration'];
                    $genre = $row['Genre'];
                    $thumbnailPath = $row['Thumbnail'];
                    $url = $row['URL'];
            ?>
                    <div
                        class="movie"
                        data-movie-id="<?php echo $movieId; ?>"
                        data-title="<?php echo htmlspecialchars($title); ?>"
                        data-description="<?php echo htmlspecialchars($description); ?>"
                        data-duration="<?php echo htmlspecialchars($duration); ?>"
                        data-genre="<?php echo htmlspecialchars($genre); ?>"
                        data-url="<?php echo htmlspecialchars($url); ?>"
                        data-thumbnail="../Movies/<?php echo htmlspecialchars($thumbnailPath); ?>"
                        onclick="showModal(this)"> <!-- Open modal on click -->

                        <div class="thumbnail">
                            <img src="../Movies/<?php echo htmlspecialchars($thumbnailPath); ?>" alt="<?php echo htmlspecialchars($title); ?> Thumbnail">
                        </div>
                        <p class="movie-title"><?php echo htmlspecialchars($title); ?></p>
                    </div>
            <?php
                }
            } else {
                echo "<p>No movies available at the moment.</p>";
            }
            ?>
        </div>

    </section>
    <section class="Coming-soon">
        <h2>Coming Soon</h2>
        <div class="movie-container">
            <?php
            $sql = "SELECT * from movies WHERE status = 'Coming Soon'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $movieId = $row['movie_id'];
                    $title = $row['Title'];
                    $description = $row['Description'];
                    $duration = $row['Duration'];
                    $genre = $row['Genre'];
                    $thumbnailPath = $row['Thumbnail'];
                    $url = $row['URL'];
            ?>

                    <!-- <div class="movie-container"> -->
                    <div
                        class="movie"
                        data-movie-id="<?php echo $movieId; ?>"
                        data-title="<?php echo $title; ?>"
                        data-description="<?php echo $description; ?>"
                        data-duration="<?php echo $duration; ?>"
                        data-genre="<?php echo $genre; ?>"
                        data-url="<?php echo $url; ?>"
                        data-thumbnail="../Movies/<?php echo $thumbnailPath; ?>"
                        onclick="showModal(this)"> <!-- Added onclick for opening modal -->

                        <div class="thumbnail">
                            <img src="../Movies/<?php echo $thumbnailPath; ?>" alt="<?php echo $title; ?> Thumbnail">
                        </div>
                        <p class="movie-title"><?php echo $title; ?></p>
                    </div>
                    <!-- </div> -->

            <?php
                }
            }
            ?>
        </div>

    </section>
    

    <!-- Movie Details Modal -->
    <div id="movie-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

</body>

</html>