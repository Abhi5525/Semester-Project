
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
    z-index: 1000; /* Ensure navbar stays on top */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
}

.navbar .logo img {
    height: 80px;
    width: auto;
    max-width: 100%; /* Responsive scaling */
}

.navbar .nav-links {
    display: flex;
    gap: 30px;
}

.navbar .nav-links li {
    list-style: none;
}

.navbar .nav-links a {
    color: #fff;
    text-decoration: none;
    font-size: larger;
    transition: color 0.3s ease;
    font-weight: 600;
}

.navbar .nav-links a:hover {
    color: #e50914;
}

.navbar .sign-in {
    padding: 10px 20px;
    background-color: #e50914;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 16px;
    font-weight: 700;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    text-decoration: none;
}

.navbar .sign-in:hover {
    background-color: #c12c17;
}
.welcome-text{
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    font-size: 25px;
    font-weight: bolder;
    /* color: #e64659; */
}
.logout{
    width: 65px;
    height: 30px;
    color: white;
    background-color: #651d24;
    border-radius: 5%;
    border: none;
    font-weight: bold;
    font-size: 15px;
    text-decoration: none;
    
}
.logout:hover{
    background-color: #de0f27;
    transform: scale(1.1); /* Slight enlargement */


}
/* Modal */
.navbar-modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent black */
    justify-content: center;
    align-items: center;
}

.navbar-modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    max-width: 600px;
    width: 90%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.navbar-close-btn {
    color: black;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}

.rates-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.rates-table th, .rates-table td {
    border: 1px solid #ddd;
    text-align: left;
    padding: 8px;
}

.rates-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

</style>
<nav class="navbar">
    <div class="logo">
        <img src="../images/logo.png" alt="Logo">
    </div>
    <ul class="nav-links">
        <li><a href="#">Location</a></li>
        <li><a href="#" id="viewRatesLink">Ticket Rate</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
    </ul>
    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
        <span class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
        <a href="../LoginFiles/logout.php" class="logout">Logout</a>
    <?php else: ?>
        <a href="../LoginFiles/register.html" class="sign-in">Sign Up</a>
    <?php endif; ?>
</nav>

<div id="ticketRatesModal" class="navbar-modal" role="dialog" aria-label="Ticket Rates Modal" style="display: none;">
    <div class="navbar-modal-content">
        <button class="navbar-close-btn" onclick="closeRatesModal()">&times;</button>
        <h2>Ticket Rates</h2>
        <table class="rates-table">
            <thead>
                <tr>
                    <th>Date Type</th>
                    <th>Showtime</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="ratesTableBody">
                <!-- Rates will be dynamically loaded here -->
            </tbody>
        </table>
    </div>
</div>
<script>
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
                    <td>$${rate.price}</td>
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

function closeRatesModal() {
    document.getElementById("ticketRatesModal").style.display = "none";
}

document.getElementById("viewRatesLink").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default link behavior
    openRatesModal();
});

window.addEventListener("click", function (event) {
    const modal = document.getElementById("ticketRatesModal");
    if (event.target === modal) {
        closeRatesModal();
    }
});

window.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        closeRatesModal();
    }
});

</script>