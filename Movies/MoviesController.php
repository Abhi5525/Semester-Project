<?php
include("connection.php");

$title = $_POST['title'];
$description = $_POST['description'];
$duration = $_POST['duration'];
$url = $_POST['url'];
$genre = $_POST['genre'];
$status = $_POST['status']; // Corrected typo from 'staus' to 'status'

if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
    $targetDir = "thumbnails/";

    // Check if the directory exists, if not create it
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory with appropriate permissions
    }

    // File type and size validation
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5 MB

    // Check if the file type is allowed
    if (!in_array($_FILES['thumbnail']['type'], $allowedTypes)) {
        die("Error: Invalid file type. Only JPG, PNG, and GIF are allowed.");
    }

    // Check if the file size exceeds the maximum limit
    if ($_FILES['thumbnail']['size'] > $maxSize) {
        die("Error: File size exceeds the limit of 5 MB.");
    }

    // Generate a unique file name and set the target file path
    $filename = uniqid() . "_" . basename($_FILES['thumbnail']['name']);
    $targetFilePath = $targetDir . $filename;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetFilePath)) {
        // Store the file path in the database
        $thumbnail = $targetFilePath;

        // Normal SQL query to insert movie details into the database
        $sql = "INSERT INTO movies (Title, Description, Duration, URL, Genre, Thumbnail, status) 
                VALUES ('$title', '$description', '$duration', '$url', '$genre', '$thumbnail', '$status')";

        // Execute the SQL query
        if ($conn->query($sql) === TRUE) {
            // Successfully uploaded and inserted
            echo "<script> alert('Uploaded Successfully!'); </script>";
            header("Location: ../Home/index.php");
            exit(); // Stop the script execution here after redirect
        } else {
            // Error in database insertion
            echo "Error: " . $conn->error;
        }
    } else {
        // Error moving the uploaded file
        die("File upload error: " . $_FILES['thumbnail']['error']);
    }
} else {
    // Error: no file uploaded or some other error
    die("No file uploaded or there was an error.");
}

mysqli_close($conn);
?>
