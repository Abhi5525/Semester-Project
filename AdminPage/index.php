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
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo"><img src="../images/logo.png" alt="Logo"></div>
        <ul class="nav-links">
            <li><a href="location.php">Location</a></li>
            <li><a href="ticket_rates.php">Ticket Rate</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
        </ul>
        <?php if (isset($_SESSION['userEmail'])): ?>
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['userRole']); ?>!</span>
            <a href="../LoginFiles/logout.php"><button class="logout">Logout</button></a>
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
        <div class="managemovies">
            <div class="button1">
                <a href="../Movies/UploadMovies.php"><button class="movie-button">Add New Movies</button></a>
            </div>
            <div class="button2">
                <a href="../Movies/Availablemovies.php"><button class="movie-button">Manage Available Movies</button></a>
            </div>
            <div class="button3">
                <a href="../ticket/ticketform.php"><button class="ticket-button">Manage ticket rates</button></a>
            </div>
            <div class="cleanup">
                <form action="dbcleanup.php" method="post">
                    <button class="movie-button cleanup-button" type="submit">Archive Data</button>
                </form>
            </div>
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
