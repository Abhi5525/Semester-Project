<style>
    /* Navbar styling */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 50px;
        background: linear-gradient(to bottom, rgba(139, 0, 0, 0.8), rgba(0, 0, 0, 0.8));
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }

    .navbar .logo img {
        height: 80px;
        max-width: 100%;
    }

    .navbar .nav-links {
        display: flex;
        gap: 30px;
        list-style: none;
        /* Moved from li */
        padding: 0;
        /* Ensure no extra spacing */
    }

    .navbar .nav-links a {
        color: #fff;
        text-decoration: none;
        font-size: larger;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .navbar .nav-links a:hover {
        color: #e50914;
        /* text-shadow: 0 0 5px rgba(255, 255, 255, 0.7); */
    }

    /* Welcome Text */
    .welcome-text {
        font-family: Cambria, Georgia, Times, 'Times New Roman', serif;
        font-size: 20px;
        font-weight: bold;
    }

    /* Logout Button */
    .logout {
        /* font-family: 'Times New Roman', serif; */
        padding: 7px 12px;
        color: white;
        background-color: transparent;
        border-radius: 5%;
        border: none;
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .sign-in {
        /* font-family: Cambria, Georgia, Times, 'Times New Roman', serif; */
        padding: 8px 14px;
        color: white;
        background-color: transparent;
        border-radius: 5%;
        border: none;
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .logout:hover {
        background-color: #de0f27;
        transform: scale(1.1);
    }

    .sign-in:hover {
        background-color: #de0f27;
        transform: scale(1.1);
    }

    /* Modal */
    .navbar-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    .navbar-modal-content {
        background: linear-gradient(90deg, rgb(18, 17, 17) 0%, rgb(104, 12, 12) 50%, rgb(120, 3, 3) 100%);
        padding: 20px;
        border-radius: 10px;
        max-width: 600px;
        width: 90%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
        max-height: 90vh;
        overflow-y: auto;
    }

    .navbar-close-btn {
        background-color: white;
        color: red;
        float: right;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
    }

    /* Rates Table */
    .rates-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        text-align: center;
        /* Centralized alignment */
    }

    .rates-table th,
    .rates-table td {
        color: white;
        font-size: 17px;
        font-weight: 600;
        padding: 8px;
    }

    /* Search Container */
    .search-container {
        position: relative;
        max-width: 350px;
        margin: 30px auto;
        flex-grow: 1;
        margin: 0 20px;
        border: none;
    }

    .search-bar {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
    }

    /* Search Results Container */
    .search-results {
        position: absolute;
        /* Position results relative to the container */
        top: 100%;
        /* Place below the search bar */
        left: 0;
        width: 100%;
        max-height: 200px;
        /* Set a max height for the results dropdown */
        overflow-y: auto;
        /* Enable scrolling if content exceeds max height */
        background-color: #fff;
        /* border: 1px solid #ccc; */
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 10;
        /* Ensure it appears on top */
        display: none;
        /* Hidden by default */
    }

    /* Visible State */
    .search-results.active {
        display: block;
        /* Display when there are results */
    }

    /* Individual Result Item */
    .result-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #eee;
        /* Separator between items */
        gap: 10px;
        /* Space between thumbnail and details */
        cursor: pointer;
        /* Indicate clickable item */
    }

    .result-item:hover {
        background: white;
        /* Light gray background on hover */
    }

    /* Thumbnail Image */
    .search-results img {
        width: 40px;
        height: 60px;
        object-fit: cover;
        /* Ensure the image fills the area without distortion */
        border-radius: 4px;
        /* Slight rounding on edges */
        margin-right: 10px;
        /* Space between thumbnail and text */
    }

    /* Movie Details (Title and Info) */
    .search-results h4 {
        margin: 0;
        font-size: 14px;
        font-weight: bold;
        color: #333;
        white-space: nowrap;
        /* Prevent text wrapping */
        overflow: hidden;
        text-overflow: ellipsis;
        /* Add ellipsis for long titles */
    }

    .result-item.no-results {
        text-align: center;
        font-size: 16px;
        color: black;
        padding: 0px;
        /* border: 1px solid #ccc; */
        background-color: white;
        margin: 5px;
        /* border-radius: 5px; */
    }

    /* Dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
        margin-right: 15px;
    }

    .dropbtn {
        background-color: transparent;
        color: white;
        padding: 10px;
        font-weight: bold;
        font-size: 20px;
        border: none;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: black;
        min-width: 240px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a,
    .dropdown-content form {
        /* color: black; */
        /* padding: 10px; */
        text-decoration: none;
        display: block;
        /* border-bottom: 1px solid #ddd; */


        background: none;
        border: none;
        color: black;
        /* width: 97%; */
        text-align: left;
        padding: 4px;
        cursor: pointer;
        font-size: 12px;

    }

    .dropdown-content a:hover {
        /* background-color: #f1f1f1; */
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-btns {
        /* background: none; */
        /* border: none; */
        /* color: black; */
        width: 100%;
        text-align: left;
        padding: 10px;
        cursor: pointer;
        font-size: 16px;
        background-color: #8b1109;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-weight: bold;
    }

    .dropdown-btns:hover {
        transform: scale(1.05);
    }
</style>


<nav class="navbar">
    <div class="logo">
        <img src="../images/logo.png" alt="Logo">
    </div>
    <ul class="nav-links">
        <?php
        if (isset($_SESSION['userRole'])) {
            if ($_SESSION['userRole'] == 'User') { ?>
                <li><a href="#">Location</a></li>
                <li><a href="#">About Us</a></li>
        <?php }
        } ?>
        <li><a href="#" id="viewRatesLink">Ticket Rate</a></li>
    </ul>

    <?php
    if (isset($_SESSION['userRole'])) {
        if ($_SESSION['userRole'] == 'User') { ?>
            <div class="search-container">
                <input type="text" class="search-bar" id="search-bar" placeholder="Search movies..." onkeyup="searchMovies()">
                <div class="search-results" id="search-results"></div>
            </div>
        <?php }
    } else { ?>
        <div class="search-container">
            <input type="text" class="search-bar" id="search-bar" placeholder="Search movies..." onkeyup="searchMovies()">
            <div class="search-results" id="search-results"></div>
        </div><?php
            } ?>

    <?php
    if (isset($_SESSION['userRole'])) { ?>
        <span class="welcome-text">Welcome,
            <?php echo htmlspecialchars($_SESSION['userRole'] == 'User' ? $_SESSION['username'] : 'Admin'); ?>!
        </span>
    <?php } ?>

    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
        <?php if ($_SESSION['userRole'] == 'Admin'): ?>
            <div class="dropdown">
                <button class="dropbtn">Admin Panel</button>
                <div class="dropdown-content">
                    <a href="../Movies/UploadMovies.php"><button class="dropdown-btns">Add New Movies</button></a>
                    <a href="../Movies/Availablemovies.php"><button class="dropdown-btns">Manage Available Movies</button></a>
                    <a href="../ticket/ticketform.php"><button class="dropdown-btns">Manage ticket rates</button></a>
                    <a href="assign_showtimes.php"><button class="dropdown-btns">Manage Showtimes </button></a>
                    <a href="admin_bookings.php"><button class="dropdown-btns">Manage Seat Bookings</button></a>

                    <form action="dbcleanup.php" method="post">
                        <button class="dropdown-btns" type="submit">Archive Data</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <a href="../LoginFiles/logout.php" class="logout">Logout</a>
    <?php else: ?>
        <a href="../LoginFiles/register.html" class="sign-in">Sign Up</a>
    <?php endif; ?>
</nav>


<div id="ticketRatesModal" class="navbar-modal" role="dialog" aria-label="Ticket Rates Modal" style="display: none;">
    <div class="navbar-modal-content">
        <!-- <button class="navbar-close-btn" onclick="closeRatesModal()">&times;</button> -->
        <h2>TICKET RATES</h2>
        <table class="rates-table">
            <thead>
                <tr>
                    <th>DAYS</th>
                    <th>SHOWTIME</th>
                    <th>PRICE</th>
                </tr>
            </thead>
            <tbody id="ratesTableBody">
                <!-- Rates will be dynamically loaded here -->
            </tbody>
        </table>
    </div>
</div>
<script>
    function searchMovies() {
        const query = document.getElementById('search-bar').value.trim(); // Fetch and trim the query
        const searchResults = document.getElementById('search-results'); // Target results container

        if (query.length > 0) {
            const xhttp = new XMLHttpRequest();

            xhttp.onload = function() {
                if (xhttp.status === 200) {
                    try {
                        const results = JSON.parse(xhttp.responseText); // Parse JSON response
                        searchResults.innerHTML = ''; // Clear previous results
                        console.log(results);

                        if (results.length === 0) {
                            // No results found, show the message
                            searchResults.style.display = 'block';
                            searchResults.innerHTML = `
                    <div class="result-item no-results">
                        No results found
                    </div>
                `;
                        } else {
                            // Display matching results
                            searchResults.style.display = 'block';
                            results.forEach(movie => {
                                const resultItem = document.createElement('div'); // Create container for each result
                                resultItem.classList.add('result-item'); // Add CSS class
                                // Add movie details as data-* attributes
                                resultItem.dataset.title = movie.Title;
                                resultItem.dataset.genre = movie.Genre;
                                resultItem.dataset.description = movie.Description;
                                resultItem.dataset.duration = movie.Duration;
                                resultItem.dataset.thumbnail = `../Movies/${movie.Thumbnail}`;
                                resultItem.innerHTML = `
                        <img src="../Movies/${movie.Thumbnail}" alt="${movie.Title}">
                        <h4>${movie.Title}</h4>
                        
                    `;
                                // Add click event listener to reuse the existing openModal function
                                resultItem.addEventListener('click', function() {
                                    openModal(this); // Pass the clicked result item to openModal
                                });

                                searchResults.appendChild(resultItem); // Append the result
                            });
                        }
                    } catch (error) {
                        console.error('Error parsing JSON response:', error);
                        searchResults.style.display = 'block';
                        searchResults.innerHTML = `
                <div class="result-item error-message">
                    Error loading results. Please try again.
                </div>
            `;
                    }
                } else {
                    console.error('Error fetching data:', xhttp.status);
                    searchResults.style.display = 'block';
                    searchResults.innerHTML = `
            <div class="result-item error-message">
                Error fetching data. Please try again.
            </div>
        `;
                }
            };

            // Properly encode query to avoid special character issues
            xhttp.open('GET', 'search.php?search=' + encodeURIComponent(query), true);
            xhttp.send();
        } else {
            searchResults.innerHTML = ''; // Clear results if query is empty
        }
    }



    function openRatesModal() {
        const ratesTableBody = document.getElementById("ratesTableBody");

        // Show loading indicator
        ratesTableBody.innerHTML = "<tr><td colspan='3'>Loading...</td></tr>";

        // Fetch rates from the server
        fetch("../ticket/get_ticket_rates.php")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(rates => {
                ratesTableBody.innerHTML = ""; // Clear existing rows

                // Populate table with rates
                rates.forEach(rate => {
                    const dayType = rate.day_type ? rate.day_type.charAt(0).toUpperCase() + rate.day_type.slice(1) : "Unknown";
                    const showTime = rate.show_time ? rate.show_time.charAt(0).toUpperCase() + rate.show_time.slice(1) : "Unknown";

                    const row = document.createElement("tr");
                    row.innerHTML = `
                    <td>${dayType}</td>
                    <td>${showTime}</td>
                    <td>Rs. ${rate.price}</td>
                `;
                    ratesTableBody.appendChild(row);
                });

                // Show the modal
                document.getElementById("ticketRatesModal").style.display = "flex";
            })
            .catch(error => {
                console.error("Error fetching rates:", error);
                ratesTableBody.innerHTML = "<tr><td colspan='3'>Unable to load rates.</td></tr>";
            });
    }
    window.onload = function(event) {
        var modal = document.getElementById('ticketRatesModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    function closeRatesModal() {
        document.getElementById("ticketRatesModal").style.display = "none";
    }

    document.getElementById("viewRatesLink").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default link behavior
        openRatesModal();
    });

    window.addEventListener("click", function(event) {
        const modal = document.getElementById("ticketRatesModal");
        if (event.target === modal) {
            closeRatesModal();
        }
    });

    window.addEventListener("keydown", function(event) {
        if (event.key === "Escape") {
            closeRatesModal();
        }
    });
</script>