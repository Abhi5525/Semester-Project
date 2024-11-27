<?php
// Include the connection file to use the database connection
include('connection.php');

// List of rows in the cinema
$rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G']; // Add more rows if necessary
$columns = 10; // Number of columns in each row

// Loop through each row
foreach ($rows as $row) {
    // Loop through each column in the row
    for ($col = 1; $col <= $columns; $col++) {
        $seat_number = $row . $col; // Generate seat number like A1, A2, B1, B2, etc.

        // SQL query to insert the seat into the seats table
        $sql = "INSERT INTO seats (seat_number) VALUES ('$seat_number')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Seat $seat_number inserted successfully.<br>";
        } else {
            echo "Error inserting seat $seat_number: " . $conn->error . "<br>";
        }
    }
}

// Close the connection
$conn->close();
?>
