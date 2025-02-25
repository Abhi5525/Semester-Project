<?php
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Showtimes</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #e9ecef; /* Light gray background */
        color: #333;
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: #2c3e50; /* Dark blue-gray for headings */
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        background-color: #ffffff; /* White background for the form */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        max-width: 400px;
        margin: 0 auto;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #34495e; /* Slightly darker blue-gray for labels */
    }

    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #bdc3c7; /* Light gray border */
        border-radius: 4px;
        font-size: 16px;
        background-color: #ecf0f1; /* Light blue-gray background for select */
        color: #2c3e50; /* Dark blue-gray text */
    }

    button {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        background-color: #3498db; /* Bright blue for the button */
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #2980b9; /* Darker blue on hover */
    }

    option {
        padding: 10px;
        background-color: #ffffff; /* White background for options */
        color: #2c3e50; /* Dark blue-gray text for options */
    }
</style>
</head>
<body>

    <h2>Assign Showtimes to Movies</h2>

    <form action="process_showtime.php" method="POST">
        <label for="movie">Select Movie:</label>
        <select id="movie" name="movie_id" required>
            <option value="">Select a Movie</option>
            <?php
                // Use movie_id instead of id
                $query = "SELECT movie_id, Title FROM movies WHERE status='Now Showing'";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn)); // Debugging
                }
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['movie_id']}'>{$row['Title']}</option>";
                }
            ?>
        </select>

        <label for="date">Select Date:</label>
        <select id="date" name="show_date" required>
            <?php
                for ($i = 0; $i < 3; $i++) {
                    $date = date('Y-m-d', strtotime("+$i days"));
                    echo "<option value='$date'>$date</option>";
                }
            ?>
        </select>

        <label for="showtime">Select Showtime:</label>
        <select id="showtime" name="show_time" required>
            <option value="10:00:00">10:00 AM</option>
            <option value="14:00:00">2:00 PM</option>
            <option value="18:00:00">6:00 PM</option>
        </select>

        <label for="day_type">Select Day Type:</label>
        <select id="day_type" name="day_type" required>
            <option value="weekday">weekday</option>
            <option value="weekend">weekend</option>
            <option value="holiday">holiday</option>
        </select>

        <button type="submit">Assign Showtime</button>
    </form>

</body>
</html>

<?php
mysqli_close($conn);
?>
