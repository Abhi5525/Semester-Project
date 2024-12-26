<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket Booking</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
<?php 
session_start();
include('../Home/navbar.php');?>
    <form action="book_seats.php" method="POST" onsubmit="return validateBooking()">
        <div id="dashboard" class="dashboard">
            <h1 class="section-title">Seat Reservation Section</h1>

            <div class="left-part">
                <!-- Date Dropdown -->
                <div class="dropdown-container">
                    <label for="dateDropdown" class="dropdown-label">Select Date:</label>
                    <select id="dateDropdown" name="date" class="dropdown-select">
                        <?php
                        for ($i = 0; $i < 3; $i++) {
                            $date = date('Y-m-d', strtotime("+$i days"));
                            $dayOfWeek = date('l', strtotime($date)); // Get the day of the week
                            echo "<option value='$date'>" . date('M d, Y', strtotime($date)) . " ($dayOfWeek)</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Time Buttons -->
                <div id="shifts" class="shifts">
                    <label>
                        <input type="radio" name="time" value="10:00 AM - 1:00 PM" checked> Morning Show
                    </label>
                    <label>
                        <input type="radio" name="time" value="2:00 PM - 6:00 PM"> Afternoon Show
                    </label>
                    <label>
                        <input type="radio" name="time" value="7:00 PM - 10:00 PM"> Evening Show
                    </label>
                </div>

            </div>
            <div class="right-part">
                <h2>SCREEN</h2>
                <div id="seat-map" class="container">
                    <img src="../images/Untitled_design-removebg-preview.png" alt="" class="screen">

                    <div class="column-numbers">
                        <div class="placeholder"></div>
                        <div class="row">
                            <div class="column-number">1</div>
                            <div class="column-number">2</div>
                            <div class="column-number">3</div>
                            <div class="column-number">4</div>
                            <div class="column-number">5</div>
                            <div class="column-number">6</div>
                            <div class="column-number">7</div>
                            <div class="column-number">8</div>
                            <div class="column-number">9</div>
                            <div class="column-number">10</div>
                        </div>
                    </div>
                    <!-- Seat rows -->
                    <div class="seat-row">
                        <div class="row-label">A</div>
                        <div class="row">
                            <div class="seat" data-seat="A1" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="A2" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="A3" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="A4" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="A5" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="A6" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="A7" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="A8" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="A9" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="A10" onclick="toggleSeatSelection(this)"></div>
                        </div>
                    </div>
                    <!-- Repeat for other rows as needed -->
                    <div class="seat-row">
                        <div class="row-label">B</div>
                        <div class="row">
                            <div class="seat" data-seat="B1" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="B2" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="B3" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="B4" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="B5" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="B6" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="B7" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="B8" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="B9" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="B10" onclick="toggleSeatSelection(this)"></div>
                        </div>
                    </div>
                    <div class="seat-row">
                        <div class="row-label">C</div>
                        <div class="row">
                            <div class="seat" data-seat="C1" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="C2" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="C3" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="C4" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="C5" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="C6" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="C7" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="C8" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="C9" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="C10" onclick="toggleSeatSelection(this)"></div>
                        </div>
                    </div>

                    <div class="seat-row">
                        <div class="row-label">D</div>
                        <div class="row">
                            <div class="seat" data-seat="D1" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="D2" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="D3" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="D4" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="D5" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="D6" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="D7" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="D8" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="D9" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="D10" onclick="toggleSeatSelection(this)"></div>
                        </div>
                    </div>

                    <div class="seat-row">
                        <div class="row-label">E</div>
                        <div class="row">
                            <div class="seat" data-seat="E1" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="E2" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="E3" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="E4" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="E5" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="E6" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="E7" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="E8" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="E9" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="E10" onclick="toggleSeatSelection(this)"></div>
                        </div>
                    </div>

                    <div class="seat-row">
                        <div class="row-label">F</div>
                        <div class="row">
                            <div class="seat" data-seat="F1" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="F2" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="F3" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="F4" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="F5" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="F6" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="F7" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="F8" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="F9" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="F10" onclick="toggleSeatSelection(this)"></div>
                        </div>
                    </div>

                    <div class="seat-row">
                        <div class="row-label">G</div>
                        <div class="row">
                            <div class="seat" data-seat="G1" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="G2" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="G3" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="G4" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="G5" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="G6" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="G7" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="G8" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="G9" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="G10" onclick="toggleSeatSelection(this)"></div>
                        </div>
                    </div>

                    <div class="seat-row">
                        <div class="row-label">H</div>
                        <div class="row">
                            <div class="seat" data-seat="H1" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="H2" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="H3" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="H4" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="H5" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="H6" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="H7" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="H8" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="H9" onclick="toggleSeatSelection(this)"></div>
                            <div class="seat" data-seat="H10" onclick="toggleSeatSelection(this)"></div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Modal for Reserved Seat Message -->
            <div id="reserved-seat-modal" class="modal" style="display:none;">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal()">&times;</span>
                    <p id="reserved-seat-message"></p>
                </div>
            </div>

            <input type="hidden" name="date" id="selectedDate" value="">
            <input type="hidden" name="time" id="selectedTime" value="">
            <input type="hidden" id="selectedSeats" name="seats" value="[]">

            <div class="confirm-booking">
                <!-- Changed the "Book Selected Seats" button to a normal button -->
                <button type="button" id="bookSeatsButton">Book Selected Seats</button>
            </div>

            <!-- Confirmation Modal -->
            <div id="confirmation-modal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span id="close-modal" class="close-button">&times;</span>
                    <div id="modal-message"></div>
                    <!-- Confirm and Cancel Buttons -->
                    <button id="confirm-button" type="submit">Confirm</button>
                    <button id="cancel-button" type="button">Cancel</button>
                </div>
            </div>


        </div>
    </form>
    <script src="script.js"></script>

</body>

</html>