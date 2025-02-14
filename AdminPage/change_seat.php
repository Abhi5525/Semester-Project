<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $new_seat = $_POST['new_seat'];

    // Check if the new seat is available
    $check_query = "SELECT * FROM seat_reservations WHERE seat_number = '$new_seat' AND movie_id = (SELECT movie_id FROM seat_reservations WHERE id = $id) AND status = 'available'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows === 0) {
        // Update the seat number
        $update_query = "UPDATE seat_reservations SET seat_number = '$new_seat' WHERE id = $id";
        if ($conn->query($update_query)) {
            echo "Seat changed successfully!";
            header('Location: admin_bookings.php');
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Seat is already booked!";
    }
}

// Fetch the current reservation details
$id = $_GET['id'];
$query = "SELECT * FROM seat_reservations WHERE id = $id";
$result = $conn->query($query);
$reservation = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Seat</title>
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
        h1 {
            color: wheat;
            margin-bottom: 50px;
            text-align: center;

        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: wheat;
        }
        input[type="text"] {
            padding: 10px;
            padding-bottom: 0;
            border: 1px solid #df7676;
            border-radius: 6px;
            background-color: #1a1a1a;
            color: white;
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
    <h1>Change Seat for Reservation <?php echo $reservation['seat_number']; ?></h1>
    <form method="POST">
    <input type="hidden" name="id" value="<?php echo $reservation['id']; ?>">
    <label for="new_seat">New Seat Number:</label>
    <input type="text" id="new_seat" name="new_seat" required 
           pattern="[A-H][1-9]|[A-H]10" 
           title="Seat number must be in the format A1 to H10 (e.g., A5, B7, H10)">
    <button type="submit">Change Seat</button>
</form>

</body>
</html>