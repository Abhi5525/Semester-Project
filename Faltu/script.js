// Define the seat map for different shifts
const seatMap = {
    shift1: { rows: generateRows() },
    shift2: { rows: generateRows() },
    shift3: { rows: generateRows() }
};

// Function to generate rows with seats
function generateRows() {
    return {
        A: Array(13).fill('available'),
        B: Array(13).fill('available'),
        C: Array(13).fill('available'),
        D: Array(13).fill('available'),
        E: Array(13).fill('available')
    };
}

// Global variables for selected seat and shift
let selectedSeat, selectedShift;

// Load default seat map when the page is ready
document.addEventListener('DOMContentLoaded', () => {
    loadSeats('shift1'); // Load the default shift (11:00 AM - 2:00 PM)
    document.getElementById('shift1').classList.add('active'); // Highlight the default button
    //Ensure the modal is hidden on  page load
    document.getElementById('confirmation-modal').style.display = 'none';
    // Set up modal close functionality
    document.getElementById('close-modal').onclick = closeModal; // Ensure this button exists in your HTML
    document.getElementById('cancel-button').onclick = closeModal;

    // Confirm button action
    document.getElementById('confirm-button').onclick = confirmReservation;

     // Set up shift button click events
    document.querySelectorAll('.shift-btn').forEach(button => {
        button.addEventListener('click', () => {
            const shift = button.id; // Get the ID of the clicked button (shift)
            loadSeats(shift); // Load the selected shift's seats
        });
    });
});

// Function to load seats based on selected shift
function loadSeats(shift) {
    const seatMapContainer = document.getElementById('seat-map');
    const selectedShiftMap = seatMap[shift];

    // Clear current seat map and display the screen label
    seatMapContainer.innerHTML = '<div class="seat-label">Screen</div>';

    // Update shift buttons to show active status
    document.querySelectorAll('.shift-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById(shift).classList.add('active');

    // Generate rows and seats based on the selected shift
    Object.keys(selectedShiftMap.rows).forEach(row => {
        const rowContainer = document.createElement('div');
        rowContainer.classList.add('row');

        // Create row label
        const rowLabel = document.createElement('span');
        rowLabel.classList.add('row-label');
        rowLabel.textContent = row;
        rowContainer.appendChild(rowLabel);

        // Create seats for the row
        selectedShiftMap.rows[row].forEach((status, index) => {
            const seat = document.createElement('div');
            seat.classList.add('seat', status);
            seat.setAttribute('data-seat', `${row}${index + 1}`);
            seat.setAttribute('title', `${row}${index + 1}`);
            seat.addEventListener('click', () => toggleSeatStatus(seat, shift));
            rowContainer.appendChild(seat);
        });

        seatMapContainer.appendChild(rowContainer);
    });
}

// Function to open modal for seat confirmation
function toggleSeatStatus(seat, shift) {
    selectedSeat = seat; // Store reference to the selected seat
    selectedShift = shift; // Store selected shift
    const seatNumber = seat.dataset.seat;
    const action = seat.classList.contains('booked') ? 'cancel' : 'reserve';

    // Set the message in the modal
    document.getElementById('modal-message').textContent = `Are you sure you want to ${action} seat ${seatNumber}?`;
    document.getElementById('confirmation-modal').style.display = 'flex'; // Show the modal as flex to center it
}

// Function to close the modal
function closeModal() {
    document.getElementById('confirmation-modal').style.display = 'none'; // Hide modal
}

// Function to confirm the reservation
function confirmReservation() {
    const seatNumber = selectedSeat.dataset.seat;
    const action = selectedSeat.classList.contains('booked') ? 'cancel' : 'reserve';

    // Update seat status based on action
    if (action === 'reserve') {
        selectedSeat.classList.add('booked');
        selectedSeat.classList.remove('available');
        selectedSeat.style.backgroundColor = '#f44336'; // Change color to red when booked
    } else {
        selectedSeat.classList.remove('booked');
        selectedSeat.classList.add('available');
        selectedSeat.style.backgroundColor = ''; // Reset to original color if cancelled
    }

    // Close the modal
    closeModal();

    // Optionally, make an AJAX request if you want to update the server-side status
    fetch('update_seat.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `shift=${selectedShift}&seat=${seatNumber}&action=${action}`
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message); // Handle any errors
            // Optionally revert seat status in case of an error
            if (action === 'reserve') {
                selectedSeat.classList.remove('booked');
                selectedSeat.classList.add('available');
                selectedSeat.style.backgroundColor = ''; // Reset to original color if error
            }
        }
    })
    .catch(error => {
        console.log('There was a problem with the fetch operation:', error);
        alert('An error occurred. Please try again later.');
    });
}
