<?php
session_start();

// Check if 'role' is set in the session
if (!isset($_POST['role'])) {
    // Handle the case where 'role' is not set
    die("User  role is not defined. Please log in.");
}

//echo $_SESSION['role']; // This will now only run if 'role' is set

require_once 'pdo.php';
require_once './phpmailer/phpmailer/src/PHPMailer.php';
require_once './phpmailer/phpmailer/src/SMTP.php';
require_once './phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $sql = 'customer';
    $_SESSION['role']=$role;
    if ($role == 'admin') {
        $sql = 'admin_staff_login';
        $stmt = $pdo->prepare("SELECT * FROM $sql WHERE AEmail = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    } else if ($role == 'customer') {
        $sql = 'customer';
        $stmt = $pdo->prepare("SELECT * FROM $sql WHERE Email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    } else if ($role == 'vendor') {
        $sql = 'vendor';
        $stmt = $pdo->prepare("SELECT * FROM $sql WHERE Email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    }

    // Check if email exists in users table
    
    if (!$user) {
        die("No account found with that email.");
    }

    $otp = rand(100000, 999999);
    $generatedAt = gmdate('Y-m-d H:i:s');  // UTC time
    $stmt = $pdo->prepare("INSERT INTO password_reset (email, otp, generated_at) VALUES (?, ?, ?)");
    $stmt->execute([$email, $otp, $generatedAt]);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'aku975025@gmail.com'; // Your email
        $mail->Password = 'lcfb xudf gzsd kdzg'; // Your email app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('aku975025@gmail.com', 'LocalFinder');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP for password reset';
        $mail->Body = "Your OTP is: $otp";

        $mail->send();
        header("Location: verify_otp_ui.php?email=" . urlencode($email));
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>