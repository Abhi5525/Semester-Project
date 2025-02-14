<?php
include 'connection.php';

// Fetch the current reservation details using GET
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $query = "SELECT * FROM seat_reservations WHERE id = $id";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $reservation = $result->fetch_assoc();
    } else {
        die("Reservation not found.");
    }
} else {
    die("No reservation ID provided.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $new_seat = $conn->real_escape_string($_POST['new_seat']); // basic sanitization

    // Prevent changing to the same seat
    if ($reservation['seat_number'] === $new_seat) {
        echo "<script>
                alert('New seat is the same as the current seat.');
                window.location.href='admin_bookings.php';
              </script>";
        exit;
    }

    $movie_id = (int) $reservation['movie_id'];

    // Retrieve showtime and date from the current reservation
    // (Adjust these field names if your table uses different names)
    $showtime = $conn->real_escape_string($reservation['showtime']);
    $date = $conn->real_escape_string($reservation['reservation_date']);

    // Check if the new seat is available for the specific showtime and date
    $check_query = "SELECT * FROM seat_reservations 
                    WHERE seat_number = '$new_seat' 
                      AND movie_id = $movie_id 
                      AND showtime = '$showtime'
                      AND reservation_date = '$date'
                      AND status = 'available'";
    $check_result = $conn->query($check_query);

    if ($check_result && $check_result->num_rows > 0) {
        // Update the seat number and mark it as booked
        $update_query = "UPDATE seat_reservations 
                         SET seat_number = '$new_seat', status = 'booked' 
                         WHERE id = $id";
        if ($conn->query($update_query)) {
            echo "<script>
                    alert('Seat changed successfully!');
                    window.location.href='admin_bookings.php';
                  </script>";
            exit;
        } else {
            echo "Error updating seat: " . $conn->error;
        }
    } else {
        echo "<script>
                alert('Seat is already booked or not available for the selected showtime and date!');
                window.location.href='admin_bookings.php';
              </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Seat</title>
  <style>
      body {
          background: linear-gradient(135deg, rgb(22, 14, 14), rgb(57, 3, 3));
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
  <h1>Change Reservation for Seat <?php echo htmlspecialchars($reservation['seat_number']); ?></h1>
  <form method="POST">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
      <label for="new_seat">New Seat Number:</label>
      <input type="text" id="new_seat" name="new_seat" required 
             pattern="[A-H](?:[1-9]|10)" 
             title="Seat number must be in the format A1 to H10 (e.g., A5, B7, H10)">
      <button type="submit">Change Seat</button>
  </form>
</body>
</html>
