<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket Booking</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php
    session_start();
    include('../Home/navbar.php');
    // Assuming movie_id is stored in PHP session
    if (isset($_SESSION['movie_id'])) {
        $movie_id = $_SESSION['movie_id'];
        echo "<script>sessionStorage.setItem('movieId', '$movie_id');</script>";
    }
    ?>
    <form action="book_seats.php" method="POST" onsubmit="event.preventDefault();">
        <div id="dashboard" class="dashboard">
            <h1 class="section-title">Seat Reservation Section</h1>

            <div class="left-part">
                <!-- Date Dropdown -->
                <div class="dropdown-container">
                    <label for="dateDropdown" class="dropdown-label">Select Date:</label>
                    <select id="dateDropdown" name="date" class="dropdown-select">
                        <!-- <option value="">Choose a Date</option> -->
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
                    <div id="morningOption">
                        <label>
                            <input type="radio" id="morning" name="time" value="10:00:00"> Morning Show
                        </label>
                    </div>
                    <div id="afternoonOption">
                        <label>
                            <input type="radio" id="afternoon" name="time" value="14:00:00"> Afternoon Show
                        </label>
                    </div>
                    <div id="eveningOption">
                        <label>
                            <input type="radio" id="evening" name="time" value="18:00:00"> Evening Show
                        </label>
                    </div>
                    <div id="noShowsMessage" style="display: none; color: red; font-weight: bold; margin-left: 10px;">
                        (NO SHOWS AVAILABLE FOR THIS DATE)
                    </div>
                    <div id="messageShow" style="display: none; color: green; font-weight: bolder; margin-left: 10px;">(SELECT AMONG AVAILABLE SHOWTIMES)</div>
                </div>
            </div>



            <script>
                // Global variable to store prices
                let price = null;
                $(document).ready(function() {
                    fetchShowtimes();

                    $("#dateDropdown").on("change", function() {
                        fetchShowtimes();
                    });

                    function fetchShowtimes() {
                        var movie_id = sessionStorage.getItem('movieId');
                        var selectedDate = $("#dateDropdown").val();

                        if (!movie_id || !selectedDate) {
                            console.error("Movie ID or selected date is missing.");
                            return;
                        }

                        $.ajax({
                            url: "fetch_showtimes.php",
                            type: "POST",
                            data: {
                                movie_id: movie_id,
                                show_date: selectedDate
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response && !response.error) {
                                    updateShowtimes(response);
                                } else {
                                    console.error("Error in response:", response.error);
                                    alert("No available showtimes for this date.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error:", error);
                                alert("Error fetching showtimes. Please try again.");
                            }
                        });
                    }

                    function updateShowtimes(showtimesData) {
                        var selectedDate = $("#dateDropdown").val();
                        var availableShowtimes = showtimesData[selectedDate] || [];

                        $("#morning, #afternoon, #evening").prop('disabled', false).prop('checked', false);
                        $("#noShowsMessage").hide();

                        var firstAvailable = null;

                        if (!availableShowtimes.includes("10:00:00")) {
                            $("#morning").prop('disabled', true);
                        } else {
                            firstAvailable = firstAvailable || "#morning";
                        }

                        if (!availableShowtimes.includes("14:00:00")) {
                            $("#afternoon").prop('disabled', true);
                        } else {
                            firstAvailable = firstAvailable || "#afternoon";
                        }

                        if (!availableShowtimes.includes("18:00:00")) {
                            $("#evening").prop('disabled', true);
                        } else {
                            firstAvailable = firstAvailable || "#evening";
                        }

                        if (firstAvailable) {
                            $(firstAvailable).prop('checked', true);
                            $("#messageShow").show();
                        } else {
                            $("#noShowsMessage").show();
                            $("#messageShow").hide();

                        }
                    }

                    // Function to fetch prices
                    function fetchPrices(selectedDate, selectedTime) {
                        // Get the movie ID from the session (assuming it's stored in a variable)
                        var movieId = sessionStorage.getItem('movieId'); // Replace with your actual session storage key

                        // Make an AJAX request to fetch prices
                        $.ajax({
                            url: '../ticket/get_price.php', // Replace with your server-side script URL
                            type: 'POST',
                            data: {
                                date: selectedDate,
                                time: selectedTime,
                                movieId: movieId
                            },
                            success: function(response) {
                                // Store the fetched prices in the global variable
                                price = parseFloat(JSON.parse(response).price);

                                // Log the prices to the console (for debugging)
                                console.log('Prices fetched and stored:', price);
                                // alert(price);
                                // You can update the DOM with the fetched prices here
                                // Example: Display the prices in a div
                                $('#priceDisplay').html(`Prices: ${JSON.stringify(price)}`);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching prices:', error);
                            }
                        });
                    }

                    // Event listeners for date dropdown and time radio buttons
                    $('#dateDropdown').change(function() {
                        checkAndFetchPrices();
                    });

                    $('input[name="time"]').change(function() {
                        checkAndFetchPrices();
                    });

                    // Function to check if both date and time are selected
                    function checkAndFetchPrices() {
                        var selectedDate = $('#dateDropdown').val();
                        var selectedTime = $('input[name="time"]:checked').val();

                        if (selectedDate && selectedTime) {
                            // Both date and time are selected, call fetchPrices
                            fetchPrices(selectedDate, selectedTime);
                        }
                    }
                });
            </script>
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
                    <!-- Repeat for other rows as needed -->
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
            <div id="total-price">

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
    <?php

    include('../Footer/footer.php'); ?>

</body>

</html>