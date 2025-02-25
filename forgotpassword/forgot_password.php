<?php
session_start();
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']); // Clear the message
?>
<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <link rel="icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../forgotpassword/style1.css">

    <script>
        function validateForm() {
            const email = document.getElementById('email').value.trim();

            const emailError = document.getElementById('emailError');

            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            let isValid = true;

            // Email validation
            if (email === "") {
                emailError.textContent = "Email should not be empty";
                isValid = false;
            } else if (!emailRegex.test(email)) {
                emailError.textContent = "Invalid email format";
                isValid = false;
            } else {
                emailError.textContent = "";
            }

            // Return whether the form is valid or not
            return isValid;
        }
    </script>
</head>

<body>

    <!-- Logo Section -->
    <div class="logo-container">
        <img src="../images/logo.png" alt="Logo">
    </div>

    <!-- Forgot Password Form -->
    <h2>Forgot Password</h2>
    <form action="../forgotpassword/send_otp.php" method="post" onsubmit="return validateForm();">
        <label for="email">Enter your email address:</label>
        <input type="text" name="email" id="email">
        <span class="error" id="emailError"></span>

        <input type="submit" value="Submit">
        <a href="../Loginfiles/login.html">Back to Login</a>
    </form>
    <script>
        const errorMessage = <?= json_encode($errorMessage); ?>;
        if (errorMessage) {
            alert(errorMessage);
        } // Pass PHP error to JS function
        // Close the modal when clicking outside of the modal content
        window.onclick = function(event) {
            var modals = document.getElementsByClassName('all-modals');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = 'none';
                }
            }
        }
    </script>
</body>

</html>