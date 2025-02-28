<?php
session_start();
// if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
//     header("Location: ../LoginFiles/login.html");
//     exit();
// }

if (isset($_SESSION['isLoggedIn'])) {
    // Use null coalescing operator to provide fallback values
    $username = $_SESSION['username'] ?? 'Guest';
    $userEmail = $_SESSION['userEmail'] ?? '';
    $phone = $_SESSION['phone'] ?? '';

    // Safely pass values to JavaScript using json_encode
    echo "<script>
        sessionStorage.setItem('username', " . json_encode($username) . ");
        sessionStorage.setItem('userEmail', " . json_encode($userEmail) . ");
        sessionStorage.setItem('phone', " . json_encode($phone) . ");
    </script>";
}




include("connection.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Movie Booking System</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS -->
    <script src="script.js"></script>

</head>

<body>
    <!-- Navigation Bar -->
    <?php include('navbar.php'); ?>
    <!-- Movie List Section -->
    <section class="available-movies">
        <h2  class = "heading">Now Showing</h2>
        <div class="movie-container">
            <?php
            $sql = "SELECT * from movies WHERE status = 'Now Showing'";
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
    <section class="Coming-soon">
        <h2 class = "heading">Coming Soon</h2>
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

    <!-- Modal Structure for Movie Details -->
    <div id="movieModal" class="modal">
        <div class="modal-content">
            <a href="index.php"><span class="close">&times;</span></a> <!-- Close button within modal -->
            <div class="modal-left" id="modalLeft">
                <!-- Image shown by default -->
                <img id="modalImage" src="../images/screen.png" alt="Movie Thumbnail">
                <!-- iFrame for the trailer -->
                <iframe id="modalIframe" width="300" height="300"
                    src=""
                    frameborder="0"
                    allow="autoplay; encrypted-media"
                    allowfullscreen
                    style="display: none;">
                </iframe>
            </div>

            <div class="modal-right">
                <h2 id="modalTitle"></h2>
                <p id="modalGenre"></p>
                <p id="modalDuration"></p>
                <p id="modalDescription">
                </p>
                <div class="buttons">
                    <!-- <button id="trailerButton" onclick="watchTrailer()">Watch Trailer</button> -->
                    <button onclick="bookTicket()">Book Tickets</button>
                    <script>
                        function bookTicket() {
                            window.location.href = '../Seats/Dashboard.php';
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <?php include('../Footer/footer.php'); ?>
</body>

</html>