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

            // --- Header / Title section ---
            $pdf->SetFillColor(240, 240, 240); // Light gray background for the header
            $pdf->Rect(0, 0, $pdf->GetPageWidth(), 25, 'F'); // Draw a filled rectangle for the header
            $pdf->SetFont('Arial', 'B', 18);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(190, 15, 'A Ticket to Bamel Cinemas', 0, 1, 'C'); // Centered title
            $pdf->Ln(2); // Add some spacing

            // --- Movie Details Section ---
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(190, 10, 'Movie Details', 0, 1); // Section title
            $pdf->SetFont('Arial', '', 12);

            // Movie details (without reservation date and showtime)
            $pdf->Cell(40, 6, 'Title:', 0, 0);
            $pdf->Cell(60, 6, $movie['Title'], 0, 1);
            $pdf->Cell(40, 6, 'Genre:', 0, 0);
            $pdf->Cell(60, 6, $movie['Genre'], 0, 1);
            $pdf->Cell(40, 6, 'Duration:', 0, 0);
            $pdf->Cell(60, 6, $movie['Duration'] . ' mins', 0, 1);
            $pdf->Ln(10); // Add some spacing

            // --- Customer Details Section ---
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(190, 10, 'Customer Details', 0, 1); // Section title
            $pdf->SetFont('Arial', '', 12);

            // Customer details
            $pdf->Cell(40, 6, 'Name:', 0, 0);
            $pdf->Cell(60, 6, $userName, 0, 1);
            $pdf->Cell(40, 6, 'Email:', 0, 0);
            $pdf->Cell(60, 6, $userEmail, 0, 1);
            $pdf->Cell(40, 6, 'Phone:', 0, 0);
            $pdf->Cell(60, 6, $userPhone, 0, 1);
            $pdf->Ln(10); // Add some spacing

            // --- Reservation Details Section ---
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(190, 10, 'Reservation Details', 0, 1); // Changed section title
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(40, 6, 'Seat Number:', 0, 0);
            $pdf->Cell(60, 6, $seat['seat_number'], 0, 1);
            $pdf->Cell(40, 6, 'Date:', 0, 0);
            $pdf->Cell(60, 6, $reservationDate, 0, 1);
            $pdf->Cell(40, 6, 'Showtime:', 0, 0);
            $pdf->Cell(60, 6, $showtime, 0, 1);
            $pdf->Ln(10); // Add some spacing

            // --- Movie Poster (Thumbnail) ---
            if (!empty($thumbnail) && file_exists("../movies/$thumbnail")) {
                // Save current position
                $currentX = $pdf->GetX();
                $currentY = $pdf->GetY();

                // Place the image on the right side
                $pdf->SetXY(135, 40);
                $pdf->Image("../movies/$thumbnail", null, null, 50, 60, 'JPG' /* or PNG */);

                // Return to the left side for the next text
                $pdf->SetXY($currentX, $currentY + 40);
            } else {
                // If no valid thumbnail found, display a placeholder
                $pdf->Cell(190, 10, 'Poster not available.', 0, 1, 'R');
            }

            // --- Generate QR code ---
            $qrData = "Movie: " . $movie['Title'] . "\n" .
                      "Seat: " . $seat['seat_number'] . "\n" .
                      "Date: " . $reservationDate . "\n" .
                      "Showtime: " . $showtime . "\n" .
                      "User: " . $userName;

            // Temporary file for QR code
            $qrFile = tempnam(sys_get_temp_dir(), 'qr') . '.png';
            QRcode::png($qrData, $qrFile, 'L', 4, 2); // Generate QR code

            // Place the QR code near the bottom
            $pdf->SetXY(80, 160);
            $pdf->Image($qrFile, $pdf->GetX(), $pdf->GetY(), 50, 50);
            unlink($qrFile); // Remove the temporary file

            // Optional: a small note about scanning the QR code
            $pdf->SetXY(70, 220);
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Cell(70, 5, 'Scan this code at the Reception', 0, 1, 'C');

            // Footer with contact information
            $pdf->SetXY(0, 270);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(190, 5, 'Contact: support@BamelCinemas.com | Phone: 01-123223', 0, 1, 'R');
            $pdf->Ln(5);
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
