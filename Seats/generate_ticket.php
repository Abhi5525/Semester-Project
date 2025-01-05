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

    // Check if data is valid
    if (empty($seats) || empty($movie) || empty($userName) || empty($userEmail) || empty($userPhone)) {
        echo json_encode(['error' => 'Invalid ticket data.']);
        exit;
    }

    try {
        // Create the PDF
        $pdf = new FPDF();
        
        // Add a page for the main title and movie details
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Title
        $pdf->Cell(200, 10, 'Ticket for ' . $movie['Title'], 0, 1, 'C');

        // Movie details
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(200, 10, 'Movie: ' . $movie['Title'], 0, 1);
        $pdf->Cell(200, 10, 'Duration: ' . $movie['Duration'] . ' mins', 0, 1);
        $pdf->Cell(200, 10, 'Genre: ' . $movie['Genre'], 0, 1);
        $pdf->Cell(200, 10, 'Reservation Date: ' . $reservationDate, 0, 1);
        $pdf->Cell(200, 10, 'Showtime: ' . $showtime, 0, 1);

        // User info
        $pdf->Cell(200, 10, 'User: ' . $userName, 0, 1);
        $pdf->Cell(200, 10, 'Email: ' . $userEmail, 0, 1);
        $pdf->Cell(200, 10, 'Phone: ' . $userPhone, 0, 1);

        // Now create individual tickets for each seat
        foreach ($seats as $seat) {
            // Each seat gets its own page
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(200, 10, 'Seat: ' . $seat['seat_number'], 0, 1);
            // Optionally, include additional seat details here
            $pdf->Cell(200, 10, 'Reservation Date: ' . $reservationDate, 0, 1);
            $pdf->Cell(200, 10, 'Showtime: ' . $showtime, 0, 1);
        }

        // Save PDF to a file on the server
        $pdfFilePath = 'tickets/ticket.pdf'; // You can set your own path here
        $pdf->Output('F', $pdfFilePath); // Save as a file

        // Return the path of the generated PDF to the frontend
        echo json_encode(['pdfUrl' => $pdfFilePath]);

    } catch (Exception $e) {
        // Handle any errors during PDF generation
        echo json_encode(['error' => 'Failed to generate PDF: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Required data is missing.']);
}
?>
