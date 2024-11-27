<?php include("connection.php");?>

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
        <button class="sign-in" onclick="login()">Sign Up</button>
    </nav>

    <!-- Movie List Section -->
    <section class="available-movies">
        <h2>Now Showing</h2>
        
        <?php 
        $sql = "SELECT * from movies";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $title = $row['Title'];
                $description = $row['Description'];
                $duration = $row['Duration'];
                $genre = $row['Genre'];
                $thumbnailPath = $row['Thumbnail'];
                $url = $row['URL'];
            ?>
            
            <div class="movie-container">
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
                    <p class="movie-title"><?php echo $title;?></p>
                </div>
            </div>
            
        <?php
            }
        }
        ?>
    </section>

    <!-- Modal Structure for Movie Details -->
    <div id="movieModal" class="modal">
        <div class="modal-content">
            <a href="index.php"><span class="close">&times;</span></a> <!-- Close button within modal -->
            <div class="modal-left">
                <img id="modalImage" src="" alt="Movie Thumbnail">
            </div>
            <div class="modal-right">
                <h2 id="modalTitle"></h2>
                <p id="modalGenre"></p>
                <p id="modalDescription"></p>
                <p id="modalDuration"></p>
                <div class="buttons">
                    <button id="trailerButton" onclick="watchTrailer()">Watch Trailer</button>
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
