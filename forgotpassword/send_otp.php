<?php
session_start();
require '../Home/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $_SESSION['fpEmail'] = $email; // Fix: Change $_session to $_SESSION

    // Check email in voters only
    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $message = "Your password reset OTP is:";
        sendOtp($message, $email);
    } else {
        $_SESSION['error_message'] = "Email not registered";
        header('Location: ../forgotpassword/forgot_password.php');
        exit();
    }
} else {
    header("Location: ../forgotpassword/forgot_password.php");
    exit();
}

function sendOtp($body, $email)
    {
        // Generate OTP
        $otp = rand(100000, 999999);
        // Save email in session
        $_SESSION['fpEmail'] = $email;
        // Save OTP in a cookie for 5 minutes
        setcookie("otp", $otp, time() + 300, "/");


        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';
        require '../PHPMailer/src/Exception.php';

        // Create a new PHPMailer instance
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'thesachit1@gmail.com'; // Replace with your Gmail address
        $mail->Password = 'cgef oatc hkms xwqb';   // Replace with your generated app password
        $mail->SMTPSecure = 'tls';               // Enable TLS encryption
        $mail->Port = 587;                       // TLS port is 587

        // Email content
        $mail->setFrom('thesachit1@gmail.com', 'Bamel Ticket Booking');
        // $mail->addAddress($_POST['email'], $_POST['name']); // User's email and name
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reset Password';
        $mail->Body = 'Hello ' . htmlspecialchars($email) . ',<br><br>' . $body . ':<br><strong>' . $otp . '</strong><br><br> It is valid for 5 minutes only and dont share with others. Ignore if you did not requested. .<br><br>Best Regards,<br>Bamel Ticket Booking';

        // Send the email and check for errors
        if ($mail->send()) {
            header("Location: ../forgotpassword/enter_otp.php");
        } else {
            echo "However, email sending failed. Error: " . $mail->ErrorInfo;
        }
    }
?>
