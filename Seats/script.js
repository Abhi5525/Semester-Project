let selectedSeats = [];

// Function to fetch and update reserved seats
function updateReservedSeats() {
    const date = document.getElementById("dateDropdown").value;
    const time = document.querySelector('input[name="time"]:checked').value;

    // Send an AJAX request to the server
    fetch("check_reserved_seats.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}`
    })
        .then(response => response.json())
        .then(reservedSeats => {
            // Reset all seats to default
            document.querySelectorAll(".seat").forEach(seat => {
                seat.classList.remove("disabled");
                seat.classList.remove("selected");
            });

            // Mark reserved seats as disabled
            reservedSeats.forEach(seatNumber => {
                const seatElement = document.querySelector(`.seat[data-seat='${seatNumber}']`);
                if (seatElement) {
                    seatElement.classList.add("disabled");
                }
            });
        })
        .catch(error => console.error("Error fetching reserved seats:", error));
}

// Add event listeners for date and time changes
document.getElementById("dateDropdown").addEventListener("change", updateReservedSeats);
document.querySelectorAll('input[name="time"]').forEach(radio =>
    radio.addEventListener("change", updateReservedSeats)
);

// Initial call to update reserved seats on page load
document.addEventListener("DOMContentLoaded", updateReservedSeats);

// Selecting required elements
const bookSeatsButton = document.getElementById("bookSeatsButton");
const modal = document.getElementById("confirmation-modal");
const modalMessage = document.getElementById("modal-message");
const closeModalButton = document.getElementById("close-modal");
const confirmButton = document.getElementById("confirm-button");
const cancelButton = document.getElementById("cancel-button");

// Toggle the modal visibility
function toggleModal(message = null) {
    if (message) {
        modalMessage.textContent = message;
        modal.style.display = "flex"; // Show modal
    } else {
        modal.style.display = "none"; // Hide modal
    }
}

// Open modal when "Book Selected Seats" button is clicked
bookSeatsButton.addEventListener("click", () => {
    toggleModal("Are you sure you want to book these seats?");
});

// Close modal when "Cancel" button is clicked
cancelButton.addEventListener("click", () => {
    toggleModal();
});

// Close modal when the close (x) button is clicked
closeModalButton.addEventListener("click", () => {
    toggleModal();
});

// Set the current date in the dropdown
function setDefaultDate() {
    const dateDropdown = document.getElementById("dateDropdown");
    if (dateDropdown) {
        const formattedDate = new Date().toISOString().split("T")[0];
        dateDropdown.value = formattedDate; // Set default date
    } else {
        console.error("Date dropdown not found.");
    }
}

// Set the first available showtime
function setDefaultTime() {
    const timeRadioButtons = document.querySelectorAll('input[name="time"]');
    if (timeRadioButtons.length > 0) {
        timeRadioButtons[0].checked = true; // Default to first time slot
    } else {
        console.error("No time radio buttons found.");
    }
}

// Toggle seat selection
function toggleSeat(seat) {
    if (!seat || !seat.dataset) {
        console.error("Invalid seat element.");
        return;
    }

    const seatNumber = seat.dataset.seat;

    if (seat.classList.contains("disabled")) {
        alert("This seat is already reserved.");
        return;
    }

    seat.classList.toggle("selected");
    if (seat.classList.contains("selected")) {
        selectedSeats.push(seatNumber);
    } else {
        selectedSeats = selectedSeats.filter(s => s !== seatNumber);
    }

    const selectedSeatsInput = document.getElementById("selectedSeats");
    if (selectedSeatsInput) {
        selectedSeatsInput.value = JSON.stringify(selectedSeats);
    } else {
        console.error("Selected seats input element not found.");
    }
}

// Set the selected date in the hidden input when the date dropdown changes
document.getElementById('dateDropdown').addEventListener('change', function() {
    const selectedDate = this.value;
    document.getElementById('selectedDate').value = selectedDate;
});

// Set initial value of the hidden date field when the page loads
document.getElementById('selectedDate').value = document.getElementById('dateDropdown').value;

// Store the selected movie in the session
function storeMovie(movieId) {
    return fetch("login_movieId.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `movie_id=${movieId}`,
    })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Log server response for debugging
            if (data.toLowerCase().includes("success")) {
                alert("Movie selected successfully!");
            } else {
                alert("Failed to select movie. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error storing movie ID:", error);
            alert("An error occurred. Please try again.");
        });
}

// Handle movie selection
function selectMovie(movieElement) {
    const movieId = movieElement.getAttribute("data-movie-id"); // Extract movie_id
    const movieTitle = movieElement.getAttribute("data-title");

    if (confirm(`Do you want to book tickets for "${movieTitle}"?`)) {
        storeMovie(movieId); // Store the movie ID in session
    }
}

// Attach event listeners to movies
document.querySelectorAll(".movie").forEach(movieElement => {
    movieElement.addEventListener("click", () => selectMovie(movieElement));
});
// Validate booking form inputs
function validateBooking() {
    const date = document.getElementById('dateDropdown')?.value;
    if (!date) {
        alert("Please select a valid date.");
        return false;
    }

    const time = document.querySelector('input[name="time"]:checked')?.value;
    if (!time) {
        alert("Please select a time slot.");
        return false;
    }

    const selectedSeatsValue = document.getElementById('selectedSeats')?.value || "[]";
    const selectedSeatsList = JSON.parse(selectedSeatsValue);
    if (selectedSeatsList.length === 0) {
        alert("Please select at least one seat.");
        return false;
    }

    // Set the time and selected seats in hidden inputs before submission
    document.getElementById('selectedTime').value = time;
    document.getElementById('selectedSeats').value = JSON.stringify(selectedSeatsList);

    return true; // Allow form submission if all validations pass
}

// Handle booking confirmation
function handleBookingConfirmation() {
    if (!validateBooking()) return;

    const date = document.getElementById("dateDropdown").value;
    const time = document.querySelector('input[name="time"]:checked').value;
    const seats = JSON.parse(document.getElementById("selectedSeats").value || "[]").join(", ");

    const message = `You have selected the following seats: ${seats}\nDate: ${date}\nTime: ${time}\nDo you want to proceed?`;
    toggleModal(message);
}

// Reset the booking form
function resetBooking() {
    selectedSeats = [];
    const selectedSeatsInput = document.getElementById("selectedSeats");
    if (selectedSeatsInput) selectedSeatsInput.value = "[]";

    document.querySelectorAll(".seat.selected").forEach(seat => seat.classList.remove("selected"));
}

// Initialization
function initializeBookingSystem() {
    setDefaultDate();
    setDefaultTime();

    document.querySelectorAll(".seat").forEach(seat =>
        seat.addEventListener("click", () => toggleSeat(seat))
    );

    document.getElementById("bookSeatsButton")?.addEventListener("click", handleBookingConfirmation);
    document.getElementById("confirm-button")?.addEventListener("click", submitBooking);
    document.getElementById("close-modal")?.addEventListener("click", () => toggleModal());
    document.getElementById("cancel-button")?.addEventListener("click", () => toggleModal());

    window.addEventListener("click", e => {
        if (e.target === modal) toggleModal();
    });
}

document.addEventListener("DOMContentLoaded", initializeBookingSystem);

function submitBooking() {
    const userName = sessionStorage.getItem("username");
    const userEmail = sessionStorage.getItem("userEmail");
    const userPhone = sessionStorage.getItem("phone");
    const currentMovieId = sessionStorage.getItem("movieId");

    if (!userName || !userEmail || !userPhone) {
        alert("User details are missing. Please log in again.");
        window.location.href = "../LoginFiles/login.php";
        return;
    }

    const date = document.getElementById("dateDropdown").value;
    const time = document.querySelector('input[name="time"]:checked')?.value;

    if (!date || !time || !selectedSeats || selectedSeats.length === 0) {
        alert("Please select a date, time, and seats.");
        return;
    }

    const formData = new FormData();
    formData.append("date", date);
    formData.append("time", time);
    formData.append("seats", JSON.stringify(selectedSeats));
    // formData.append("movie_id", currentMovieId); 

    fetch("book_seats.php", {
        method: "POST",
        body: formData,
    })
    .then(response => {
        // console.log("Response received:", response); // Log the raw response
        if (!response.ok) {
            throw new Error("Booking request failed");
        }
        return response.json();
    })
    .then(data => {
        console.log("Parsed JSON data:", data); // Log the parsed JSON
        if (data.success) {
            console.log("Booking successful. Calling generateTicket...");
            // Now call the function to generate the PDF ticket
            generateTicketPDF(data); // Pass the entire response data (including seats and movie details)
        } else {
            alert(`Booking failed: ${data.message}`);
        }
    })
    .catch(error => {
        console.error("Error during booking:", error);
        alert("An error occurred during booking. Please try again.");
    });

    toggleModal(); // Close the modal after submission
}


function generateTicketPDF(data) {
    // Retrieve the user's session information
    const userName = sessionStorage.getItem("username");
    const userEmail = sessionStorage.getItem("userEmail");
    const userPhone = sessionStorage.getItem("phone");
    
    // Prepare the ticket data
    const ticketData = {
        seats: JSON.stringify(data.data), // Reserved seats data (array of objects)
        movie: JSON.stringify(data.movie), // Movie details (object)
        userName: userName, // User's name
        userEmail: userEmail, // User's email
        userPhone: userPhone, // User's phone
        reservation_date: data.reservation_date, // Reservation date (string)
        showtime: data.showtime, // Showtime (string)
        movieId: data.movie_id // Movie ID (integer)
    };

    // Send POST request to generateTicket.php
    fetch('generate_ticket.php', {
        method: 'POST',
        body: new URLSearchParams(ticketData) // Send data as form data
    })
    .then(response => response.blob()) // Expect a PDF blob response
    .then(blob => {
        // Create a download link for the PDF
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'ticket.pdf'; // PDF file name
        link.click(); // Trigger the download
    })
    .catch(error => {
        console.error('Error generating PDF:', error);
    });
}
