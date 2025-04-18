<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 // Load Composer's autoloader
session_start();
if (isset($_POST['email'])) {
    require_once "pdo.php";
    $role=$_POST['role'];
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(8)); // Generate a secure token
    $sql;
    //$resetLink = "http://yourdomain.com/reset_password.php?token=" . $token;
    if($role=='admin')
    {
        $sql='UPDATE admin_staff_login set Apass="'.$token.' Where AEmail="'.$email.'"';
    }
    else if($role=='customer')
    {
        $sql='UPDATE customer set Pass="'.$token.'" Where Email="'.$email.'"';
    }
    else if($role=='vendor')
    {
        $sql='UPDATE vendor set Pass="'.$token.' Where Email="'.$email.'"';
    }
    // Insert the token into the database
    //$sql = 'INSERT INTO Forgot_pass (email, token, created_at) VALUES (:email, :token, NOW())';
    
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        // Send the reset link via email
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'aku975025@gmail.com'; // Replace with your SMTP username
            $mail->Password = 'Ak$73768'; // Replace with your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('aku975025@gmail.com', 'LocalFinder');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Hi,<br><br>You requested to reset your password. Here is your new password:$token<br><br>If you did not request a password reset, please ignore this email.";

            $mail->send();
            echo "Password reset link has been sent to your email.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Failed to process your request. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/forgotPassword.js" type="text/javascript"></script>
    <style>
        .forgot-password-form {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 400px;
        }

        .forgot-password-form label {
            display: block;
            margin-bottom: 5px;
        }

        .forgot-password-form input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        #sub1{
            width:200px;
        }
    </style>
</head>

<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a></div>
                <div><a href="user_reg.php"><i class="fas fa-user-plus"></i> Register</a></div>
                <div><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></div>
            </nav>
        </div>
    </header>
    <section class="forgot-password">
        <div class="forgot-password-form">
            <h2>Forgot Password</h2>
            <form id="forgotPasswordForm" method="post">
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="vendor">Vendor</option>
                    <option value="customer">Customer</option>
                </select>
                <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" id="email" name="email" required>
                <button id="sub1" type="submit">Reset Password</button>
            </form>
        </div>
    </section>
    <footer>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="copyright">
            &copy; 2025 LocalFinder. All rights reserved.
        </div>
    </footer>
</body>

</html>
