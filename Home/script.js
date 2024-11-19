// Function to open the modal
function openModal(movieTitle, movieGenre, movieLikes) {
    document.getElementById("movieModal").style.display = "flex";
    document.getElementById("modalMovieTitle").innerText = movieTitle;
    document.getElementById("modalMovieGenre").innerText = movieGenre;
    document.getElementById("modalMovieLikes").innerText = movieLikes;
}


// Add event listeners to each movie thumbnail
window.onload = () => {
    document.querySelectorAll('.movie').forEach(movie => {
        movie.addEventListener('click', () => {
            const title = movie.querySelector('.movie-title').innerText;
            const genre = movie.querySelector('.movie-genre').innerText;
            const likes = movie.querySelector('.movie-details span').innerText;
            openModal(title, genre, likes);
        });
    });
};


function watchTrailer() {
    const trailerUrl = 'https://youtube.com/shorts/L8XZWXNniDc?si=WU8ZhPUczjqPpsfO'; 
    window.open(trailerUrl, '_blank');
}

function bookTicket() {
    window.location.href = '../Seats/logincheck.php';
}

// function login()
// {
//      window.location.href = '../LoginFiles/login.html';
// }