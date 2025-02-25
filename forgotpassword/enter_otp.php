<?php
session_start();

if (!isset($_SESSION['fpEmail'])) {
  header("Location: ../forgotpassword/forgot_password.php");
  exit();
}
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']); // Clear the message

$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']); // Clear the message
?>

<!DOCTYPE html>
<html>

<head>
  <title>Enter OTP</title>
  <link rel="stylesheet" href="../forgotpassword/style1.css">
  <link rel="icon" href="../images/logo.png" type="image/x-icon">
  
  <script>

    function validateForm() {
      const otp = document.getElementById('otp').value.trim();

      const otpError = document.getElementById('otpError');

      let isValid = true;

      // Email validation
      if (otp === "") {
        otpError.textContent = "OTP should not be empty";
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

  <h2>Enter OTP</h2>
  <form action="../forgotpassword/verify_otp.php" method="post" onsubmit="return validateForm();">
    <label for="otp">Enter the OTP sent to <?php echo htmlspecialchars($_SESSION['fpEmail']); ?>:</label><br>
    <input type="number" name="otp" id="otp">
    <span class="error" id="otpError"></span>
    <br><br>
    <input type="submit" value="Verify">
  </form>
  <script>
    
        // Show error modal if there's an error message
        const errorMessage = <?= json_encode($errorMessage); ?>;
        const successMessage = <?= json_encode($successMessage); ?>;
        if (errorMessage) {
            alert(errorMessage);
        }else if(successMessage){
            alert(successMessage);
        }
        
  </script>
</body>

</html>