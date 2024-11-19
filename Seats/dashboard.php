<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket Booking</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <script src="script.js" defer></script> <!-- Link to your JS file -->
</head>
<body>
    <div id="dashboard" class="dashboard">
        <h1> Seat Reservation Section</h1>

         <h2>Show Days</h2>
         <input type="radio" name = "date" value = "today"> Today
         <input type="radio" name = "date" value = "tomorrow"> Tomorrow


        <h2> Our Available Showtimes</h2>

        <!-- Shift Buttons at the top -->
        <div id="shifts" class="shifts">
            <button id="shift1" class="shift-btn">11:00 AM - 2:00 PM</button>
            <button id="shift2" class="shift-btn">3:00 PM - 7:00 PM</button>
            <button id="shift3" class="shift-btn">8:00 PM - 11:00 PM</button>
        </div>
        
        <!-- Seat Map Section -->
        <div id="seat-map" class="seat-map"></div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close-button">&times;</span>
            <div id="modal-message"></div>
            <button id="confirm-button">Confirm</button>
            <button id="cancel-button">Cancel</button>
        </div>
    </div>
</body>
</html>
