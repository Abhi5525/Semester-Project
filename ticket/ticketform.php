<?php
include('../Home/connection.php');

$message = ""; // Initialize message to display success/error feedback

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $day_type = trim($_POST['day_type']);
    $show_time = trim($_POST['show_time']);
    $price = trim($_POST['price']);

    // Validate input
    if (empty($day_type) || empty($show_time) || empty($price) || !is_numeric($price)) {
        $message = "Please fill all fields correctly.";
    } else {
        try {
            // Check if a record already exists
            $checkQuery = $conn->prepare("SELECT id FROM ticket_rates WHERE day_type = ? AND show_time = ?");
            $checkQuery->bind_param("ss", $day_type, $show_time);
            $checkQuery->execute();
            $checkResult = $checkQuery->get_result();

            if ($checkResult->num_rows > 0) {
                // Update existing record
                $updateQuery = $conn->prepare("UPDATE ticket_rates SET price = ? WHERE day_type = ? AND show_time = ?");
                $updateQuery->bind_param("dss", $price, $day_type, $show_time);
                if ($updateQuery->execute()) {
                    $message = "Ticket rate updated successfully!";
                } else {
                    throw new Exception("Error updating ticket rate: " . $updateQuery->error);
                }
                $updateQuery->close();
            } else {
                // Insert new record
                $insertQuery = $conn->prepare("INSERT INTO ticket_rates (day_type, show_time, price) VALUES (?, ?, ?)");
                $insertQuery->bind_param("ssd", $day_type, $show_time, $price);
                if ($insertQuery->execute()) {
                    $message = "Ticket rate added successfully!";
                } else {
                    throw new Exception("Error adding ticket rate: " . $insertQuery->error);
                }
                $insertQuery->close();
            }
            $checkQuery->close();
        } catch (Exception $e) {
            $message = $e->getMessage();
        } finally {
            $conn->close();
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
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        .form-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-bottom: 15px;
            text-align: center;
        }
        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }
        .form-container input, .form-container select, .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button{
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
        .error {
            color: red;
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
        <form action="" method="POST">
            <label for="day_type">Day Type</label>
            <select id="day_type" name="day_type" required>
                <option value="">Select Day Type</option>
                <option value="weekday">Weekday</option>
                <option value="weekend">Weekend</option>
                <option value="holiday">Holiday</option>
            </select>

            <label for="show_time">Showtime</label>
            <select id="show_time" name="show_time" required>
                <option value="">Select Showtime</option>
                <option value="morning">Morning</option>
                <option value="afternoon">Afternoon</option>
                <option value="evening">Evening</option>
            </select>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" min="0" required>

            <button type="submit">Add Rate</button>
            <button onclick="window.location.href='../Adminpage/index.php'"> Back to home page</button> 
        </form>
    </div>
</body>
</html>