document.addEventListener("DOMContentLoaded", () => {
    // Get all the movie elements
    const movies = document.querySelectorAll(".movie");
    const modal = document.getElementById("movieModal");
    const modalImage = document.getElementById("modalImage");
    const modalIframe = document.getElementById("modalIframe");
    const modalLeft = document.getElementById("modalLeft");

    let currentTrailerUrl = ""; // To store the trailer URL dynamically

    // Add event listeners to all movie elements
    movies.forEach(movie => {
        movie.addEventListener("click", () => showModal(movie));
    });

    // Close the modal when the close button is clicked
    const closeButton = document.querySelector(".close");
    closeButton.addEventListener("click", closeModal);

    // Close the modal when clicking outside the modal content
    modal.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    // Mouse hover event for trailer preview
    modalLeft.addEventListener("mouseenter", function () {
        if (currentTrailerUrl) {
            const videoId = extractYouTubeId(currentTrailerUrl);
            if (videoId) {
                modalIframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
                modalImage.style.display = "none";
                modalIframe.style.display = "block";
            }
        }
    });

    // Mouse leave event to revert back to image
    modalLeft.addEventListener("mouseleave", function () {
        modalIframe.src = ""; // Stop video playback
        modalImage.style.display = "block";
        modalIframe.style.display = "none";
    });

    function showModal(movieElement) {
        const movieId = movieElement.getAttribute("data-movie-id"); // Retrieve movie_id

        // Store movieId in the session via an AJAX request
        fetch("login_movieId.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `movie_id=${encodeURIComponent(movieId)}`,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to store movie ID.");
                }
                return response.text();
            })
            .then(data => {
                console.log(data); // Optional: Log success message
                openModal(movieElement); // Proceed to open the modal
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Failed to store movie ID. Please try again.");
            });
    }

    // this function  is moved to navbar
    function openModal(movie) {
        const modal = document.getElementById("movieModal");
        const descriptionEl = document.getElementById("modalDescription");
        const seeMoreBtn = document.getElementById("seeMoreBtn");
        seeMoreBtn.innerText="See more";
    
        // Set movie details
        document.getElementById("modalTitle").innerText = movie.dataset.title;
        document.getElementById("modalGenre").innerText = `Genre: ${movie.dataset.genre}`;
        document.getElementById("modalDuration").innerText = `Duration: ${movie.dataset.duration}`;
        document.getElementById("modalImage").src = movie.dataset.thumbnail;
     // Set trailer URL dynamically
     currentTrailerUrl = movie.dataset.url || ""; // Store the trailer URL for later use
        // Get full description
        const fullDescription = movie.dataset.description;
        const shortDescription = fullDescription.length > 100 ? fullDescription.substring(0, 100) + "..." : fullDescription;
    
        // Set description and See More button visibility
        descriptionEl.innerText = shortDescription;
        seeMoreBtn.style.display = fullDescription.length > 100 ? "inline-block" : "none";
    
        // Store full description for toggling
        descriptionEl.dataset.full = fullDescription;
        descriptionEl.dataset.short = shortDescription;
        descriptionEl.dataset.expanded = "false";
    
        // Show the modal
        modal.style.display = "flex";
    }
    
    
    
    

    // Function to close the modal
    function closeModal() {
        const modal = document.getElementById("movieModal");
        modal.style.display = "none";
        modalIframe.src = ""; // Stop video when closing
    }

    // Function to extract YouTube video ID from different URL formats
    function extractYouTubeId(url) {
        const match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/);
        return match ? match[1] : null;
    }
});
