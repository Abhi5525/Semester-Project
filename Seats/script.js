// Select seat elements and modal elements
const seats = document.querySelectorAll(".seat");
const modal = document.getElementById("confirmation-modal");
const modalMessage = document.getElementById("modal-message");
const closeModal = document.getElementById("close-modal");
const confirmButton = document.getElementById("confirm-button");
const cancelButton = document.getElementById("cancel-button");

// State to track selected seat
let selectedSeat = null;

// Function to handle modal visibility
const showModal = (message) => {
    modalMessage.textContent = message;
    modal.style.display = "flex"; // Use flex for proper centering
};

const hideModal = () => {
    modal.style.display = "none"; // Hide modal
    selectedSeat = null; // Reset selected seat
};

// Event listener for seat clicks
seats.forEach((seat) => {
    seat.addEventListener("click", () => {
        // Prevent action on reserved seats
        if (seat.classList.contains("reserved")) {
            alert("This seat is already reserved!");
            return;
        }

        selectedSeat = seat.dataset.seat; // Get seat number
        console.log("Seat clicked: ", selectedSeat); // Debug
        console.log("Setting modal to display flex");
        modal.style.display = "flex"; // Make modal visible
        console.log("Modal style: ", modal.style.display); // Debug current modal style
        showModal(`Do you want to confirm the reservation for seat ${selectedSeat}?`);
    });
});

// Close modal logic
closeModal.addEventListener("click", hideModal);
cancelButton.addEventListener("click", hideModal);

// Close modal on outside click
window.addEventListener("click", (e) => {
    if (e.target === modal) hideModal();
});

// Confirm seat reservation
confirmButton.addEventListener("click", () => {
    if (selectedSeat) {
        const seatElement = document.querySelector(`[data-seat="${selectedSeat}"]`);
        if (seatElement) {
            seatElement.classList.add("reserved");
            alert(`Seat ${selectedSeat} has been successfully reserved.`);
        } else {
            alert("An error occurred while reserving the seat.");
        }
        hideModal();
    }
});
