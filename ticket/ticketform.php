<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
include('../Home/connection.php');

$message = ""; // Initialize message to display success/error feedback

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $day_type = trim($_POST['day_type']);
    $show_time = mysqli_real_escape_string($conn, trim($_POST['show_time']));
    $price = trim($_POST['price']);

    // Validate input
    if (empty($day_type) || empty($show_time) || empty($price) || !is_numeric($price)) {
        $message = "Please fill all fields correctly.";
    } else {
        // Check if a record already exists
        $checkQuery = "SELECT id FROM ticket_rates WHERE day_type = '$day_type' AND show_time = '$show_time'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Update existing record
            $updateQuery = "UPDATE ticket_rates SET price = '$price' WHERE day_type = '$day_type' AND show_time = '$show_time'";
            if (mysqli_query($conn, $updateQuery)) {
                $message = "Ticket rate updated successfully!";
            } else {
                $message = "Error updating ticket rate: " . mysqli_error($conn);
            }
        } else {
            // Insert new record
            $insertQuery = "INSERT INTO ticket_rates (day_type, show_time, price) VALUES ('$day_type', '$show_time', '$price')";
            if (mysqli_query($conn, $insertQuery)) {
                $message = "Ticket rate added successfully!";
            } else {
                $message = "Error adding ticket rate: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Ticket Rates</title>
    <style>
        body {
            background: linear-gradient(135deg,rgb(39, 25, 25),rgb(57, 3, 3));
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
        h2{
            color: wheat;
            margin-bottom: 10px;
            text-align: center;
        }
        .container {
            background-color: #1b1717;
            border-radius: 12px;
            padding: 25px;
            width:400px;
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
        input[type="number"], select {
            padding: 10px;
            border: 1px solid #df7676;
            border-radius: 6px;
            background-color: #1a1a1a;
            color: #fff;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="submit"], button {
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

        input[type="submit"]:hover {
            background: linear-gradient(135deg, #b30000, #590000);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Ticket Rate</h2>
        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, 'successfully') !== false ? '' : 'error'; ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <div class="container">
            <form action="" method="POST">
                <div class="input-field">
                    <label for="day_type">Day Type</label>
                    <select id="day_type" name="day_type" required>
                        <option value="">Select Day Type</option>
                        <option value="weekday">Weekday</option>
                        <option value="weekend">Weekend</option>
                        <option value="holiday">Holiday</option>
                    </select>
                </div>

                <div class="input-field">
                    <label for="show_time">Showtime</label>
                    <select id="show_time" name="show_time" required>
                        <option value="">Select Showtime</option>
                        <option value="10:00:00">Morning</option>
                        <option value="14:00:00">Afternoon</option>
                        <option value="18:00:00">Evening</option>
                    </select>
                </div>

                <div class="input-field">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required>
                </div>

                <button type="submit">Add Rate</button>
                <button type="button" onclick="window.location.href='../Adminpage/index.php'">Back to home page</button>
            </form>
        </div>
    </div>
</body>
</html>
