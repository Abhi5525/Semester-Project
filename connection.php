<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "movie_booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT title, genre, likes, rating, votes FROM movies";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<div class='movie'>";
    echo "<p class='movie-title'>" . $row["title"]. "</p>";
    echo "<p class='movie-genre'>" . $row["genre"]. "</p>";
    echo "<div class='movie-details'>👍 " . $row["likes"]. " Likes ⭐ " . $row["rating"]. "/10 • " . $row["votes"]. " Votes</div>";
    echo "</div>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>
