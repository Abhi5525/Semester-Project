<?php
require('../util/fpdf.php');
require('../util/phpqrcode/qrlib.php'); // Include the QR code library

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
    $thumbnail = $movie['Thumbnail']; // Movie thumbnail path

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

            // Ticket Title
            $pdf->Cell(190, 10, 'Movie Ticket', 0, 1, 'C');
            $pdf->Ln(10); // Add some space

            if (!empty($thumbnail) && file_exists("../movies/$thumbnail")) {
                $pdf->Image("../movies/$thumbnail", 10, 30, 50, 70);
            }
            

            // Movie details
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetXY(70, 30); // Position after the image
            $pdf->Cell(120, 10, 'Movie: ' . $movie['Title'], 0, 1);
            $pdf->SetX(70);
            $pdf->Cell(120, 10, 'Duration: ' . $movie['Duration'] . ' mins', 0, 1);
            $pdf->SetX(70);
            $pdf->Cell(120, 10, 'Genre: ' . $movie['Genre'], 0, 1);
            $pdf->SetX(70);
            $pdf->Cell(120, 10, 'Reservation Date: ' . $reservationDate, 0, 1);
            $pdf->SetX(70);
            $pdf->Cell(120, 10, 'Showtime: ' . $showtime, 0, 1);
            $pdf->Ln(10); // Add some space

            // User info
            $pdf->SetX(10);
            $pdf->Cell(190, 10, 'User: ' . $userName, 0, 1);
            $pdf->SetX(10);
            $pdf->Cell(190, 10, 'Email: ' . $userEmail, 0, 1);
            $pdf->SetX(10);
            $pdf->Cell(190, 10, 'Phone: ' . $userPhone, 0, 1);
            $pdf->Ln(10); // Add some space

            // Seat details
            $pdf->SetX(10);
            $pdf->Cell(190, 10, 'Reserved Seat: ' . $seat['seat_number'], 0, 1);
            $pdf->Ln(20); // Add some space

            // Generate QR code
            $qrData = "Movie: " . $movie['Title'] . "\n" .
                      "Seat: " . $seat['seat_number'] . "\n" .
                      "Date: " . $reservationDate . "\n" .
                      "Showtime: " . $showtime . "\n" .
                      "User: " . $userName;

            $qrFile = tempnam(sys_get_temp_dir(), 'qr') . '.png'; // Temporary file for QR code
            QRcode::png($qrData, $qrFile, 'L', 4, 2); // Generate QR code

            // Embed QR code in the PDF
            $pdf->Image($qrFile, 80, 150, 50, 50); // Adjust position and size as needed
            unlink($qrFile); // Delete the temporary QR code file
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