<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Movie Booking System - Admin</title>
    <link rel="stylesheet" href="style.css">  <!-- Link to external CSS -->
    <script src="script.js"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo"><img src="../images/logo.png"></div>
        <ul class="nav-links">
            <li><a href="#">Location</a></li>
            <li><a href="#">Ticket Rate</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>

        <?php if (isset($_SESSION['userEmail']) && $_SESSION['userEmail'] === "MasterAdmin@gmail.com"): ?>
            <!-- Admin Welcome Message -->
            <span class="welcome-text">Welcome, MasterAdmin!</span>
            <a href="../LoginFiles/logout.php"><button class = "logout">Logout </button></a>
            <?php else: ?>
        <a href="../LoginFiles/register.html"><button class="sign-in">Sign Up</button></a>
        <?php endif; ?>
    </nav>

    <!-- Movie List Section -->
    <section class="available-movies">
        <h2>Now Showing</h2>
        <div class="movie-container">
            <?php 
            $sql = "SELECT * FROM movies";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row['Title'];
                    $description = $row['Description'];
                    $duration = $row['Duration'];
                    $genre = $row['Genre'];
                    $thumbnailPath = $row['Thumbnail'];
                    $url = $row['URL'];
            ?>
                    <div 
                        class="movie"
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
            <?php
                }
            } else {
                echo "<p>No movies available at the moment.</p>";
            }
            ?>
            <div class="managemovies">
                <div class="button1">
                    <a href="../Movies/UploadMovies.php"><button class="movie-button">Add New Movies</button></a>
                </div>
                <div class="button2">
                    <a href="../Movies/Availablemovies.php"><button class="movie-button">Manage Available Movies</button></a>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
