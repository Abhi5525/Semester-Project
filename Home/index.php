
<?php 
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}

include("connection.php");?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Movie Booking System</title>
    <link rel="stylesheet" href="style.css">  <!-- Link to external CSS -->
    <script src="script.js"></script>

</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo"><img src = "../images/logo.png"></div>
        <ul class="nav-links">
            <li><a href="#">Location</a></li>
            <li><a href="#">Ticket Rate</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
        <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
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
        $sql = "SELECT * from movies";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
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
                    <p class="movie-title"><?php echo $title;?></p>
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
    <img id="modalImage" src="thumbnail.jpg" alt="Movie Thumbnail">
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
                <p id="modalDescription">
                </p>
                <p id="modalDuration"></p>
                <div class="buttons">
                    <!-- <button id="trailerButton" onclick="watchTrailer()">Watch Trailer</button> -->
                    <button onclick="bookTicket()">Book Tickets</button>
                    <script>
                        function bookTicket() {
                            window.location.href = '../Seats/logincheck.php';
                            }
                   </script>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
