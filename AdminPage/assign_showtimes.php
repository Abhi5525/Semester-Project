<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
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
            background: linear-gradient(135deg, rgb(39, 25, 25), rgb(57, 3, 3));
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        h2 {
            color: wheat;
            margin-bottom: 10px;
            text-align: center;
        }
        .container {
            background-color: #1b1717;
            border-radius: 12px;
            padding: 25px;
            width: 400px;
            box-shadow: 0 0 15px rgba(176, 173, 173, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .input-field {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: wheat;
        }
        select {
            padding: 10px;
            border: 1px solid #df7676;
            border-radius: 6px;
            background-color: #1a1a1a;
            color: #fff;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        button {
            padding: 12px;
            background: linear-gradient(135deg, #7a0000, #400000);
            color: wheat;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background: linear-gradient(135deg, #b30000, #590000);
            transform: scale(1.05);
        }
    </style>

</head>
<body>

    <h2>Assign Showtimes to Movies</h2>
<div class="container">

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
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
