<?php
include("connection.php");

// Fetch data from the database
$sql = "SELECT movie_id, Title, Description, Duration, URL, Genre, Thumbnail, status FROM movies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(29, 10, 10);

            margin: 0;
            padding: 0;
            color: rgb(249, 252, 254);
        }

        h2 {
            font-size: 40px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            color: rgb(249, 252, 254);
            
        }

        .container {
            margin-top: 20px;
            padding: 20px;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border: 4px solid rgb(69, 10, 10);
            color: rgb(235, 239, 242);
        }
        td:nth-child(3) { /* Description column */
    width: 30%; /* Adjust as per your requirement */
    white-space: nowrap; /* Ensures text does not wrap */
    overflow: hidden; /* Hides overflow */
    text-overflow: ellipsis; /* Adds ... for clipped text */
}
td:nth-child(5) { /* URL column */
    width: 20%;
}

        .table th {
            background-color: transparent;
            color: rgb(235, 239, 242);
            font-weight: 600;
        }

        .table tbody tr {
            height: 140px;
            /* Set a minimum height for all rows */
            height: auto;
            /* Allow rows to expand if needed */
            vertical-align: middle;
            /* Align content vertically in the middle */
        }

        .btn-edit,
        .btn-delete {
            width: 80px;
            height: 35px;
            text-align: center;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-edit {
            background-color: #28a745;
            color: white;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .see-more-btn {
            display: inline-block;
            color: #007bff;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Available Movies</h2>
        <div class="table-container">
            <table class="table table-bordered text-center ">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Movie Title</th>
                        <th>Description</th>
                        <th>Duration</th>
                        <th>Trailer URL</th>
                        <th>Genre</th>
                        <th>Thumbnail</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['movie_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['Title']); ?></td>
                                <td>
                                    <span class="short-desc">
                                        <?php echo substr(htmlspecialchars($row['Description']), 0, 100); ?>...
                                    </span>
                                    <span class="full-desc" style="display: none;">
                                        <?php echo htmlspecialchars($row['Description']); ?>
                                    </span>
                                    <button class="see-more-btn" onclick="toggleDescription(this)">See More</button>
                                </td>
                                <td><?php echo htmlspecialchars($row['Duration']); ?> mins</td>
                                <td>
                                    <?php echo htmlspecialchars($row['URL']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['Genre']); ?></td>
                                <td>
                                    <img src="<?php echo htmlspecialchars($row['Thumbnail']); ?>" alt="Thumbnail">
                                </td>
                                <td><?php echo htmlspecialchars($row['status']); ?> </td>
                                <td>
                                    <a href="edit_movie.php?id=<?php echo $row['movie_id']; ?>" class="btn btn-edit">Edit</a><br><br>
                                    <a href="delete_movie.php?id=<?php echo $row['movie_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this movie?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No movies found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Close the database connection -->
    <?php $conn->close(); ?>

    <!-- JavaScript for "See More" -->
    <script>
        // Toggle description visibility
        function toggleDescription(button) {
            const shortDesc = button.previousElementSibling.previousElementSibling;
            const fullDesc = button.previousElementSibling;

            // Check if the full description is currently displayed
            const isFullDescVisible = fullDesc.style.display === "inline";

            if (isFullDescVisible) {
                // Collapse to short description
                shortDesc.style.display = "inline";
                fullDesc.style.display = "none";
                button.textContent = "See More";
            } else {
                // Expand to full description
                shortDesc.style.display = "none";
                fullDesc.style.display = "inline";
                button.textContent = "See Less";

                // Set a data attribute to track the currently open description
                document.querySelectorAll(".see-more-btn").forEach(btn => {
                    btn.setAttribute("data-open", "false");
                });
                button.setAttribute("data-open", "true");
            }
        }

        // Close any expanded descriptions when clicking outside
        document.addEventListener("click", function(event) {
            // Find the button with an open description
            const openButton = document.querySelector(".see-more-btn[data-open='true']");
            if (openButton && !openButton.contains(event.target)) {
                const shortDesc = openButton.previousElementSibling.previousElementSibling;
                const fullDesc = openButton.previousElementSibling;

                // Collapse the description
                shortDesc.style.display = "inline";
                fullDesc.style.display = "none";
                openButton.textContent = "See More";
                openButton.setAttribute("data-open", "false");
            }
        });
    </script>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>