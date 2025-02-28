<style>
    .footer {
        /* background-color: #2a0c2f;
     */
        background: linear-gradient(to bottom, rgba(139, 0, 0, 0.8), rgba(0, 0, 0, 0.8));
        color: white;
        padding: 20px 0;
        font-family: Arial, sans-serif;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        flex-wrap: wrap;
    }

    .footer-section {
        flex: 1;
        margin: 10px;
        padding: 10px;
    }

    .footer-section h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .footer-section p {
        font-size: 14px;
    }

    .footer-section ul {
        list-style-type: none;
        padding: 0;
    }

    .footer-section ul li {
        font-size: 14px;
        margin: 5px 0;
    }

    .footer-section ul li a {
        text-decoration: none;
        color: white;
        transition: color 0.3s;
    }

    .footer-section ul li a:hover {
        color: #ff6666;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-links li a {
        text-decoration: none;
        color: white;
        font-size: 16px;
        transition: color 0.3s;
    }

    .social-links li a:hover {
        color: #ff6666;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
    }

    .footer-bottom p {
        margin: 0;
    }
</style>

<footer class="footer" id = "footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>About Us</h3>
            <p>Your ultimate destination for movie bookings, from the latest releases to your favorite classics.</p>
        </div>
        <div class="footer-section">
            <h3>Contact Us</h3>
            <ul>
                <li><a href="mailto:info@moviebookingsystem.com">info@moviebookingsystem.com</a></li>
                <li><a href="tel:+1234567890">+1 234 567 890</a></li>
                <li>Pulbazzar Street, Banepa City, Nepal</li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Follow Us</h3>
            <ul class="social-links">
                <li><a href="https://www.facebook.com" target="_blank">Facebook</a></li>
                <li><a href="https://www.twitter.com" target="_blank">Twitter</a></li>
                <li><a href="https://www.instagram.com" target="_blank">Instagram</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Movie Booking System. All Rights Reserved.</p>
    </div>
</footer>