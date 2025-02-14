<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
include("connection.php");

// Handle search
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Seat Bookings</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background:rgb(214, 180, 180); /* Light gray background */
        margin: 0;
        padding: 0;
    }

    h1 {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
        color: #343a40; /* Dark gray for headings */
    }

    .container {
        margin-top: 20px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }

    .table-container {
        overflow-x: auto;
        margin-top: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        text-align: left;
        border: 1px solid #dee2e6; /* Light gray border */
        color: #495057; /* Dark gray for text */
        font-size: 16px;
    }
.table td{
    white-space: nowrap;
}
    .table th {
        background-color: #343a40; /* Dark gray for header */
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
    }

    .table tbody tr {
        transition: background-color 0.3s ease; /* Smooth hover effect */
    }

    .table tbody tr:hover {
        background-color: #f1f3f5; /* Light gray on hover */
    }

    .btn-change-seat,
    .btn-cancel-seat {
        width: 100px; /* Slightly wider for better text fit */
        height: 35px;
        text-align: center;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin: 2px; /* Small margin between buttons */
    }

    .btn-change-seat {
        background-color: #007bff; /* Blue for change seat */
        color: white;
    }

    .btn-change-seat:hover {
        background-color: #0056b3; /* Darker blue on hover */
        color: white;

    }

    .btn-cancel-seat {
        background-color: #dc3545; /* Red for cancel seat */
        color: white;
    }

    .btn-cancel-seat:hover {
        background-color: #c82333; /* Darker red on hover */
        color: white;
        
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
    }

    .text-center {
        text-align: center;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05); /* Light gray for striped rows */
    }

    .table-bordered {
        border: 1px solid #dee2e6; /* Light gray border */
    }

    .table-dark {
        background-color: #343a40; /* Dark gray for table header */
    }

    .table-dark th {
        border-color: #454d55; /* Slightly darker border for header */
    }

    .table-responsive {
        overflow-x: auto;
    }

    .btn-primary {
        background-color: #007bff; /* Blue for primary buttons */
        border-color: #007bff;
    }
    

    .btn-primary:hover {
        background-color: #0056b3; /* Darker blue on hover */
        border-color: #004085;
    }

    .btn-danger {
        background-color: #dc3545; /* Red for danger buttons */
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333; /* Darker red on hover */
        border-color: #bd2130;
    }

    .btn {
        margin: 2px; /* Small margin between buttons */
    }


     </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Manage Seat Bookings</h1>

        <!-- Search Form -->
        <form method="GET" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by seat number, date, or movie name" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Seat Number</th>
                    <th>Reservation Date</th>
                    <th>Showtime</th>
                    <th>Reserved By</th>
                    <th>Movie Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all seat reservations with movie name
                $query = "SELECT sr.*, m.Title AS movie_name 
                FROM seat_reservations sr 
                JOIN movies m ON sr.movie_id = m.movie_id";
      
      if (!empty($search)) {
        $query .= " WHERE sr.seat_number LIKE '%$search%' 
                    OR sr.reservation_date LIKE '%$search%' 
                    OR m.Title LIKE '%$search%'";
    }

                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['seat_number']}</td>
                                <td>{$row['reservation_date']}</td>
                                <td>{$row['showtime']}</td>
                                <td>{$row['reserved_by']}</td>
                                <td>{$row['movie_name']}</td>
                                <td>{$row['STATUS']}</td>
                                <td>
                                    <a href='change_seat.php?id={$row['id']}' class='btn btn-change-seat btn-sm'>Change Seat</a>
                                    <form action='cancel_seat.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' class='btn btn-cancel-seat btn-sm'>Cancel Seat</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No seat reservations found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>