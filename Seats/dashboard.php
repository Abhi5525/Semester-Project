<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket Booking</title>
    <link rel="stylesheet" href="styles.css">
   
</head>
<body>
    <div id="dashboard" class="dashboard" >
        <h1>Seat Reservation Section</h1>

        <!-- Show Days Section -->
        <!-- <h2>Show Days</h2> -->
<div class="main-part" style="display:flex">
<div style="display: flex; align-items: start;flex-direction:column" class="left-part">
    <!-- Dropdown Container -->
            <div style="margin-right: auto; padding: 20px;">
                <label for="dateDropdown" style="color: #fff; font-size: 1.2em; font-weight: bold;">Select Date:</label>
                <select id="dateDropdown" onchange="fetchSeats(this.value)" style="padding: 8px; border-radius: 5px; border: 1px solid #6C63FF; background-color: #fff; color: #333;">
                    <!-- Dates will be populated dynamically using PHP -->
                    <?php
                    // Generate 7 days starting from today
                    for ($i = 0; $i < 3; $i++) {
                        $date = date('Y-m-d', strtotime("+$i days"));
                        echo "<option value='$date'>" . date('M d, Y', strtotime($date)) . "</option>";
                    }
                    ?>
                </select>
            </div>        <!-- Showtimes Section -->
        <!-- <h2>Our Available Showtimes</h2> -->
        <div id="shifts" class="shifts">
            <button id="shift1" class="shift-btn">11:00 AM - 2:00 PM</button><br>
            <button id="shift2" class="shift-btn">3:00 PM - 7:00 PM</button><br>
            <button id="shift3" class="shift-btn">8:00 PM - 11:00 PM</button><br>
        </div>

    <!-- Seat Container -->
    <!-- <div id="seatContainer" style="flex-grow: 1; text-align: center;"> -->
        <!-- Seats will be rendered here -->
        <!-- <h2 style="color: #fff;">Seat Reservation Section</h2> -->
        <!-- <div id="seats"></div> -->
    <!-- </div> -->
</div>
<div class="right-part">
<h2>SCREEN</h2>
        <div id="seat-map" class="container">
            <img src="../images/Untitled_design-removebg-preview.png" alt="" class="screen">

            <div class="column-numbers">
                <div class="placeholder"></div> <!-- Placeholder to align with row labels -->
                <div class="row">
                    <div class="column-number">1</div>
                    <div class="column-number">2</div>
                    <div class="column-number">3</div>
                    <!-- <div class="column-number"></div> -->
                    <div class="column-number">4</div>
                    <div class="column-number">5</div>
                    <div class="column-number">6</div>
                    <div class="column-number">7</div>
                    <!-- <div class="column-number"></div> -->
                    <div class="column-number">8</div>
                    <div class="column-number">9</div>
                    <div class="column-number">10</div>
                </div>
            </div>
            <div class="seat-row">
                <div class="row-label">A</div>
                <div class="row">
                    <div class="seat" data-seat="A1"></div>
                    <div class="seat" data-seat="A2"></div>
                    <div class="seat" data-seat="A3"></div>
                    <div class="seat" data-seat="A4"></div>
                    <div class="seat" data-seat="A5"></div>
                    <div class="seat" data-seat="A6"></div>
                    <div class="seat" data-seat="A7"></div>
                    <div class="seat" data-seat="A8"></div>
                    <div class="seat" data-seat="A9"></div>
                    <div class="seat" data-seat="A10"></div>
                </div>
            </div>

            <div class="seat-row">
                <div class="row-label">B</div>
                <div class="row">
                    <div class="seat" data-seat="B1"></div>
                    <div class="seat" data-seat="B2"></div>
                    <div class="seat" data-seat="B3"></div>
                    <div class="seat" data-seat="B4"></div>
                    <div class="seat" data-seat="B5"></div>
                    <div class="seat" data-seat="B6"></div>
                    <div class="seat" data-seat="B7"></div>
                    <div class="seat" data-seat="B8"></div>
                    <div class="seat" data-seat="B9"></div>
                    <div class="seat" data-seat="B10"></div>
                </div>
            </div>

            <div class="seat-row">
                <div class="row-label">C</div>
                <div class="row">
                    <div class="seat" data-seat="C1"></div>
                    <div class="seat" data-seat="C2"></div>
                    <div class="seat" data-seat="C3"></div>
                    <div class="seat" data-seat="C4"></div>
                    <div class="seat" data-seat="C5"></div>
                    <div class="seat" data-seat="C6"></div>
                    <div class="seat" data-seat="C7"></div>
                    <div class="seat" data-seat="C8"></div>
                    <div class="seat" data-seat="C9"></div>
                    <div class="seat" data-seat="C10"></div>
                </div>
            </div>

            <div class="seat-row">
                <div class="row-label">D</div>
                <div class="row">
                    <div class="seat" data-seat="D1"></div>
                    <div class="seat" data-seat="D2"></div>
                    <div class="seat" data-seat="D3"></div>
                    <div class="seat" data-seat="D4"></div>
                    <div class="seat" data-seat="D5"></div>
                    <div class="seat" data-seat="D6"></div>
                    <div class="seat" data-seat="D7"></div>
                    <div class="seat" data-seat="D8"></div>
                    <div class="seat" data-seat="D9"></div>
                    <div class="seat" data-seat="D10"></div>
                </div>
            </div>

            <div class="seat-row">
                <div class="row-label">E</div>
                <div class="row">
                    <div class="seat" data-seat="E1"></div>
                    <div class="seat" data-seat="E2"></div>
                    <div class="seat" data-seat="E3"></div>
                    <div class="seat" data-seat="E4"></div>
                    <div class="seat" data-seat="E5"></div>
                    <div class="seat" data-seat="E6"></div>
                    <div class="seat" data-seat="E7"></div>
                    <div class="seat" data-seat="E8"></div>
                    <div class="seat" data-seat="E9"></div>
                    <div class="seat" data-seat="E10"></div>
                </div>
            </div>

            <div class="seat-row">
                <div class="row-label">F</div>
                <div class="row">
                    <div class="seat" data-seat="F1"></div>
                    <div class="seat" data-seat="F2"></div>
                    <div class="seat" data-seat="F3"></div>
                    <div class="seat" data-seat="F4"></div>
                    <div class="seat" data-seat="F5"></div>
                    <div class="seat" data-seat="F6"></div>
                    <div class="seat" data-seat="F7"></div>
                    <div class="seat" data-seat="F8"></div>
                    <div class="seat" data-seat="F9"></div>
                    <div class="seat" data-seat="F10"></div>
                </div>
            </div>
            <div class="seat-row">
                <div class="row-label">G</div>
                <div class="row">
                    <div class="seat" data-seat="G1"></div>
                    <div class="seat" data-seat="G2"></div>
                    <div class="seat" data-seat="G3"></div>
                    <div class="seat" data-seat="G4"></div>
                    <div class="seat" data-seat="G5"></div>
                    <div class="seat" data-seat="G6"></div>
                    <div class="seat" data-seat="G7"></div>
                    <div class="seat" data-seat="G8"></div>
                    <div class="seat" data-seat="G9"></div>
                    <div class="seat" data-seat="G10"></div>
                </div>
            </div>


            <div class="seat-row">
                <div class="row-label">H</div>
                <div class="row">
                    <div class="seat" data-seat="H1"></div>
                    <div class="seat" data-seat="H2"></div>
                    <div class="seat" data-seat="H3"></div>
                    <div class="seat" data-seat="H4"></div>
                    <div class="seat" data-seat="H5"></div>
                    <div class="seat" data-seat="H6"></div>
                    <div class="seat" data-seat="H7"></div>
                    <div class="seat" data-seat="H8"></div>
                    <div class="seat" data-seat="H9"></div>
                    <div class="seat" data-seat="H10"></div>
                </div>
            </div>

        </div>
</div>
</div>


        <!-- Seat Map Section -->
        
        <div id="confirmation-modal" class="modal">
            <div class="modal-content">
                <span id="close-modal" class="close-button">&times;</span>
                <div id="modal-message"></div>
                <button id="confirm-button">Confirm</button>
                <button id="cancel-button">Cancel</button>
            </div>
        </div>

        

    </div>
    <script src="script.js"></script>

</body>
</html>
