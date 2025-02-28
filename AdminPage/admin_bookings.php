<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("Location: ../LoginFiles/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Seat Bookings</title>
    <!-- Bootstrap CSS (Only for table and buttons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery for DOM manipulation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, rgb(39, 25, 25), rgb(57, 3, 3));
            /* Dark gradient background */
            color: #ffffff;
            /* White text */
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            color: whitesmoke;
            /* Light golden color for headings */
        }

        .container {
            margin-top: 20px;
            padding: 20px;
            background: #1b1717;
            /* Dark background for container */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
        }

        .table-container {
            /* overflow-x: auto; */
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
            border: 1px solid #df7676;
            /* Light red border */
            color: rgb(14, 13, 13);
            /* White text */
            font-size: 16px;
        }

        .table td {
            white-space: nowrap;
        }

        .table th {
            background-color: #7a0000;
            /* Dark red for header */
            color: whitesmoke;
            /* Light golden text */
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            text-align: center;
        }

        .table tbody tr {
            transition: background-color 0.3s ease;
            /* Smooth hover effect */
        }

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
            /* Light hover effect */
        }

        .btn-change-seat,
        .btn-cancel-seat {
            width: 100px;
            /* Slightly wider for better text fit */
            height: 35px;
            text-align: center;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 2px;
            /* Small margin between buttons */
        }

        .btn-change-seat {
            background-color: #007bff;
            /* Blue for change seat */
            color: white;
        }

        .btn-change-seat:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            color: white;
        }

        .btn-cancel-seat {
            background-color: #dc3545;
            /* Red for cancel seat */
            color: white;
        }

        .btn-cancel-seat:hover {
            background-color: #c82333;
            /* Darker red on hover */
            color: white;
        }

        .btn-sm {
            padding: 5px 10px !important;
            /* Override Bootstrap's default */
            font-size: 14px !important;
            height: auto !important;
        }

        .text-center {
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
            /* Light gray for striped rows */
        }

        .table-bordered {
            border: 1px solid #df7676;
            /* Light red border */
        }

        .table-dark {
            background-color: #7a0000;
            /* Dark red for table header */
        }

        .table-dark th {
            border-color: #df7676;
            /* Light red border for header */
        }

        .table-responsive {
            overflow-x: auto;
        }

        .btn-primary {
            background-color: #007bff;
            /* Blue for primary buttons */
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            border-color: #004085;
        }

        .btn-danger {
            background-color: #dc3545;
            /* Red for danger buttons */
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            /* Darker red on hover */
            border-color: #bd2130;
        }

        .btn {
            margin: 2px;
            /* Small margin between buttons */
        }

        /* Search Input Styling */
        #searchInput {
            background-color: rgb(10, 9, 10);
            /* Dark background for search input */
            color: #ffffff;
            /* White text */
            border-radius: 6px;
            padding: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        #searchInput:focus {
            border-color: #b30000;
            /* Darker red on focus */
            box-shadow: 0 0 8px rgba(223, 118, 118, 0.5);
            /* Glow effect */
        }

        #searchInput::placeholder {
            color: #ffffff;
            /* White color for placeholder text */
            opacity: 1;
            /* Ensure full visibility */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Manage Seat Bookings</h1>

        <!-- Search Input -->
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by username, movie name seat number or date......" />
        </div>

        <!-- Table to Display Results -->
        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Seat Number</th>
                        <th>Reservation Date</th>
                        <th>Showtime</th>
                        <th>User Id</th>
                        <th>Reserved By</th>
                        <th>Movie Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="searchResults">
                    <!-- Results will be populated here dynamically -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS (Only for table and buttons) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Client-Side Filtering -->
    <script>
        $(document).ready(function() {
            let allData = []; // To store all data fetched initially

            // Fetch all data when the page loads
            function fetchAllData() {
                $.ajax({
                    url: 'fetch_all_data.php', // Backend endpoint to fetch all data
                    type: 'GET',
                    success: function(data) {
                        allData = data; // Store all data
                        renderTable(data); // Render the table with all data
                    },
                    error: function() {
                        $('#searchResults').html('<tr><td colspan="8" class="text-center">An error occurred while fetching data.</td></tr>');
                    }
                });
            }

            // Render the table with data
            function renderTable(data) {
                let html = '';
                data.forEach(row => {
                    html += `<tr>
                                <td>${row.id}</td>
                                <td>${row.seat_number}</td>
                                <td>${row.reservation_date}</td>
                                <td>${row.showtime}</td>
                                <td>${row.reserved_by}</td>
                                <td>${row.user_name}</td>
                                <td>${row.movie_name}</td>
                                <td>${row.STATUS}</td>
                                <td>
                                    <a href='change_seat.php?id=${row.id}' class='btn btn-change-seat btn-sm'>Change Seat</a>
                                    <form action='cancel_seat.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='id' value='${row.id}'>
                                        <button type='submit' class='btn btn-cancel-seat btn-sm'>Cancel Seat</button>
                                    </form>
                                </td>
                             </tr>`;
                });
                $('#searchResults').html(html);
            }

            // Filter data based on search query
            function filterData(query) {
                const filteredData = allData.filter(row => {
                    return (
                        row.seat_number.toLowerCase().includes(query.toLowerCase()) ||
                        row.reservation_date.toLowerCase().includes(query.toLowerCase()) ||
                        row.movie_name.toLowerCase().includes(query.toLowerCase()) ||
                        row.user_name.toLowerCase().includes(query.toLowerCase()) 
                    );
                });
                renderTable(filteredData);
            }

            // Listen for keyup events on the search input
            $('#searchInput').on('keyup', function() {
                const query = $(this).val().trim(); // Get the search query
                filterData(query); // Filter the data
            });

            // Fetch all data when the page loads
            fetchAllData();
        });
    </script>
</body>

</html>