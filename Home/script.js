document.addEventListener("DOMContentLoaded", () => {
    // Get all the movie elements
    const movies = document.querySelectorAll(".movie");
    const modal = document.getElementById("movieModal");

    // Add event listeners to all movie elements
    movies.forEach(movie => {
        movie.addEventListener("click", () => openModal(movie));
    });

    // Close the modal when the close button is clicked
    const closeButton = document.querySelector(".close");
    closeButton.addEventListener("click", closeModal);

    // Close the modal when clicking outside the modal content
    modal.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });
});

// Function to open the modal and populate its content
function openModal(movie) {
    const modal = document.getElementById("movieModal");

    // Set modal content from the clicked movie's data attributes
    document.getElementById("modalTitle").innerText = movie.dataset.title;
    document.getElementById("modalGenre").innerText = `Genre: ${movie.dataset.genre}`;
    document.getElementById("modalDescription").innerText = movie.dataset.description;
    document.getElementById("modalDuration").innerText = `Duration: ${movie.dataset.duration}`;
    document.getElementById("modalImage").src = movie.dataset.thumbnail; // Changed id to match modalImage

    // Set the "Watch Trailer" button action
    // const trailerButton = document.getElementById("trailerButton");
    // trailerButton.onclick = () => window.open(movie.dataset.url, "_blank");
    
    // Show the modal
    modal.style.display = "flex";
}

// Function to close the modal
function closeModal() {
    const modal = document.getElementById("movieModal");
    modal.style.display = "none";
}
document.addEventListener("DOMContentLoaded", function () {
    const modalLeft = document.getElementById("modalLeft");
    const modalImage = document.getElementById("modalImage");
    const modalIframe = document.getElementById("modalIframe");
    
    const trailerURL = "https://www.youtube.com/embed/DLgcCTnMheg?si=5-gV7R2e2CG0-1nW"; // Replace YOUR_TRAILER_ID

    // modalLeft.addEventListener("mouseenter", function () {
        // Show iframe, hide image
        modalIframe.src = trailerURL; // Set trailer link dynamically
        modalImage.style.display = "none";
        modalIframe.style.display = "block";
    // });
});
