<?php
require('../util/fpdf.php');

// Check if data is passed correctly
if (isset($_POST['seats']) && isset($_POST['movie']) && isset($_POST['reservation_date']) && isset($_POST['showtime'])) {
    // Retrieve the data sent via POST
    $seats = json_decode($_POST['seats'], true); // Array of selected seats
    $movie = json_decode($_POST['movie'], true); // Movie details
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPhone = $_POST['userPhone'];
    $reservationDate = $_POST['reservation_date'];
    $showtime = $_POST['showtime'];
    // $thumbnail = $_POST['thumbnail'];
    

    // Check if data is valid
    if (empty($seats) || empty($movie) || empty($userName) || empty($userEmail) || empty($userPhone)) {
        echo json_encode(['error' => 'Invalid ticket data.']);
        exit;
    }

    try {
        // Create the PDF
        $pdf = new FPDF();

        // Loop through each seat and generate a page for each ticket
        foreach ($seats as $seat) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);

            // Title
            $pdf->Cell(190, 10, 'Ticket for ' . $movie['Title'], 0, 1, 'C');

            // Embed the thumbnail image
            // Get the thumbnail path from the database
            // $thumbnailPath = $movie['Thumbnail']; // 'thumbnails/Pushpa.jpg'

            // // Define the base path to the directory where images are stored
            // $basePath = __DIR__ . '../Movies/';
            // echo json_encode($basePath."<br>");
            // // Create the full file path
            // $fullPath = $basePath . $thumbnailPath;

            // // Check if the file exists before trying to embed it
            // if (!empty($thumbnailPath) && file_exists($fullPath)) {
            //     $pdf->Image($fullPath, 10, 20, 30, 30); // Adjust position and size as needed
            // }


            // Movie details
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetY(60); // Adjust Y position after the image
            $pdf->Cell(190, 10, 'Movie: ' . $movie['Title'], 0, 1);
            $pdf->Cell(190, 10, 'Duration: ' . $movie['Duration'] . ' mins', 0, 1);
            $pdf->Cell(190, 10, 'Genre: ' . $movie['Genre'], 0, 1);
            $pdf->Cell(190, 10, 'Reservation Date: ' . $reservationDate, 0, 1);
            $pdf->Cell(190, 10, 'Showtime: ' . $showtime, 0, 1);

            // User info
            $pdf->Cell(190, 10, 'User: ' . $userName, 0, 1);
            $pdf->Cell(190, 10, 'Email: ' . $userEmail, 0, 1);
            $pdf->Cell(190, 10, 'Phone: ' . $userPhone, 0, 1);

            // Seat details
            $pdf->Cell(190, 10, 'Reserved Seat: ' . $seat['seat_number'], 0, 1);
        }

        // Output the PDF to the browser (inline display)
        $pdf->Output('I', 'ticket.pdf');
    } catch (Exception $e) {
        // Handle any errors during PDF generation
        echo json_encode(['error' => 'Failed to generate PDF: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Required data is missing.']);
}