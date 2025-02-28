let selectedSeats = [];
let totalPrice = 0;
let totalPriceDiv = document.getElementById('total-price');
// Function to fetch and update reserved seats
function updateReservedSeats() {
    // Reset all seats to default
    document.querySelectorAll(".seat").forEach(seat => {
        seat.classList.remove("booked");
        totalPrice = 0;
        totalPriceDiv.innerText = totalPrice;
    });
    selectedSeats = [];
    const date = document.getElementById("dateDropdown").value;
    if (!document.querySelector('input[name="time"]:checked')) {
        // console.log("No time for this day is selected");
        return;
    }
    const time = document.querySelector('input[name="time"]:checked').value;
    console.log(time);
    
    // Send an AJAX request to the server
    fetch("check_reserved_seats.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}`
    })
        .then(response => response.text())  // Use .text() to get raw response
        .then(text => {
            console.log("Server Response:", text);  // Log the server's raw response

            try {
                const reservedSeats = JSON.parse(text);  // Try to parse JSON

                if (reservedSeats.error) {
                    console.error("Error:", reservedSeats.error);
                    alert("Error fetching reserved seats: " + reservedSeats.error);
                    return;
                }
                // Reset all seats to default
                document.querySelectorAll(".seat").forEach(seat => {
                    seat.classList.remove("disabled");
                    seat.classList.remove("booked");
                    // alert(seat);
                    seat.classList.remove("selected");
                });

                // Mark reserved seats as disabled
                reservedSeats.forEach(seatNumber => {
                    const seatElement = document.querySelector(`.seat[data-seat='${seatNumber}']`);
                    if (seatElement) {
                        seatElement.classList.add("disabled");
                        seatElement.classList.add("book");

                    }
                });
                
            } catch (e) {
                console.error("Error parsing JSON:", e);
                alert("Failed to parse reserved seats data. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error fetching reserved seats:", error);
            alert("Failed to load reserved seats. Please try again.");
        });
}

// Add event listeners for date and time changes
document.getElementById("dateDropdown").addEventListener("change", updateReservedSeats);
document.querySelectorAll('input[name="time"]').forEach(radio =>
    radio.addEventListener("change", updateReservedSeats)
);

// Initial call to update reserved seats on page load
// document.addEventListener("DOMContentLoaded", updateReservedSeats);

function toggleSeat(seat) {
    if (!seat || !seat.dataset) {
        console.error("Invalid seat element.");
        return;
    }

    const seatNumber = seat.dataset.seat;

    // If the seat is disabled (already reserved), alert the user
    if (seat.classList.contains("disabled")) {
        alert("This seat is already reserved.");
        return;
    }

    // Toggle the 'selected' class on the seat
    seat.classList.toggle("selected");

    // If the seat is now selected, mark it as booked
    if (seat.classList.contains("selected")) {
        selectedSeats.push(seatNumber);
        seat.classList.add("booked");  // Add the 'booked' class to display the seat number
        totalPrice = totalPrice + price;
        console.log(totalPrice);
        totalPriceDiv.innerText = totalPrice;
    } else {
        selectedSeats = selectedSeats.filter(s => s !== seatNumber);
        seat.classList.remove("booked");  // Remove the 'booked' class if unselected
        totalPrice = totalPrice - price;
        console.log(totalPrice);
        totalPriceDiv.innerText = totalPrice;

    }

    // Update the hidden input with the selected seats
    const selectedSeatsInput = document.getElementById("selectedSeats");
    if (selectedSeatsInput) {
        selectedSeatsInput.value = JSON.stringify(selectedSeats);
    } else {
        console.error("Selected seats input element not found.");
    }
}



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
// Close modal when "Cancel" button is clicked
cancelButton.addEventListener("click", () => {
    toggleModal();
});

// Close modal when the close (x) button is clicked
closeModalButton.addEventListener("click", () => {
    toggleModal();
});

// // Set the current date in the dropdown
// function setDefaultDate() {
//     const dateDropdown = document.getElementById("dateDropdown");
//     if (dateDropdown) {
//         const formattedDate = new Date().toISOString().split("T")[0];
//         dateDropdown.value = formattedDate; // Set default date
//     } else {
//         console.error("Date dropdown not found.");
//     }
// }

// // Set the first available showtime
// function setDefaultTime() {
//     const timeRadioButtons = document.querySelectorAll('input[name="time"]');
//     if (timeRadioButtons.length > 0) {
//         timeRadioButtons[0].checked = true; // Default to first time slot
//     } else {
//         console.error("No time radio buttons found.");
//     }
// }


// Set the selected date in the hidden input when the date dropdown changes
document.getElementById('dateDropdown').addEventListener('change', function () {
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
        // alert("Please select at least one seat.");
        return false;
    }

    // Set the time and selected seats in hidden inputs before submission
    document.getElementById('selectedTime').value = time;
    document.getElementById('selectedSeats').value = JSON.stringify(selectedSeatsList);

    return true; // Allow form submission if all validations pass
}

// Handle booking confirmation
function handleBookingConfirmation() {
    if (!validateBooking()) {
        return;
    } else {
        const date = document.getElementById("dateDropdown").value;
        const time = document.querySelector('input[name="time"]:checked').value;
        const seats = JSON.parse(document.getElementById("selectedSeats").value || "[]").join(", ");
        const message = `You have selected the following seats: ${seats}\nDate: ${date}\nTime: ${time}\nDo you want to proceed?`;
        toggleModal(message);
    }
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
    // setDefaultDate();
    // setDefaultTime();

    document.querySelectorAll(".seat").forEach(seat =>{
        
        seat.addEventListener("click", () =>{ if(!sessionStorage.username){
            window.location.href="../LoginFiles/login.html";   
           }else{ toggleSeat(seat);

    }});
});

    document.getElementById("bookSeatsButton")?.addEventListener("click", function () {
        alert(selectedSeats);
        handleBookingConfirmation();
    });
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

    if (!date) {
        alert("Please select a date.");
        return;
    }
    if (!time) {
        alert("Please select a time.");
        return;
    }
    if (!selectedSeats || selectedSeats.length === 0) {
        alert("Please select at least one seat.");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "book_seats.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    console.log("Parsed JSON data:", response);
                    if (response.success) {
                        console.log("Booking successful. Calling generateTicket...");
                        generateTicketPDF(response); // Pass the entire response data
                        // selectedSeats=[];
                        updateReservedSeats();
                        // setTimeout(function () {
                        //     window.location.href = "dashboard.php"; // Correct syntax to redirect
                        // }, 500);
                    } else {
                        alert(`Booking failed: ${response.message}`);
                    }
                } catch (error) {
                    console.error("Error parsing response JSON:", error);
                    alert("An error occurred during booking. Please try again.");
                }
            } else {
                console.error("Error during booking:", xhr.status, xhr.statusText);
                alert("An error occurred during booking. Please try again.");
            }
        }
    };

    const postData = `date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}&seats=${encodeURIComponent(JSON.stringify(selectedSeats))}`;
    console.log(postData);
    xhr.send(postData);

    toggleModal(); // Close the modal after submission
}

function generateTicketPDF(data) {
    alert("ENtered in generate ticket");
    // Retrieve the user's session information
    const userName = sessionStorage.getItem("username");
    const userEmail = sessionStorage.getItem("userEmail");
    const userPhone = sessionStorage.getItem("phone");

    // Prepare the ticket data
    const ticketData = `seats=${encodeURIComponent(JSON.stringify(data.data))}` +
        `&movie=${encodeURIComponent(JSON.stringify(data.movie))}` +
        `&userName=${encodeURIComponent(userName)}` +
        `&userEmail=${encodeURIComponent(userEmail)}` +
        `&userPhone=${encodeURIComponent(userPhone)}` +
        `&reservation_date=${encodeURIComponent(data.data[0].reservation_date)}` +
        `&showtime=${encodeURIComponent(data.data[0].showtime)}` +
        `&movieId=${encodeURIComponent(data.data[0].movie_id)}`;

    console.log(ticketData);
    // Create an XMLHttpRequest object
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "generate_ticket.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.responseType = "blob"; // Expect a blob response (PDF)

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Create a download link for the PDF
            const blob = xhr.response;
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.target = '_blank'; // Open in a new tab
            link.click();
            // Trigger the download
        } else {
            console.error('Error generating PDF:', xhr.status, xhr.statusText);
            alert("Failed to generate the ticket. Please try again.");
        }
    };

    xhr.onerror = function () {
        console.error('Error occurred while generating PDF');
    };

    // Send the POST request with ticket data
    xhr.send(ticketData);
}
