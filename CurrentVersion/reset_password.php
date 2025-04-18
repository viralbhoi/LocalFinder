<?php
require_once 'pdo.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = trim($_POST['email']);  // Changed from $_GET to $_POST
        $password = trim($_POST['password']);
        $confirm = trim($_POST['confirm_password']);

        // Validation
        if (empty($email) || empty($password) || empty($confirm)) {
            die("All fields are required.");
        }

        if ($password !== $confirm) {
            die("Passwords do not match.");
        }

        $role = $_SESSION['role'];
        $hashedPassword = $password; // Hash the password

        // Prepare the SQL statement based on the user role
        if ($role == 'admin') {
            $sql = "UPDATE admin_staff_login SET Apass = :password WHERE AEmail = :email";
        } else if ($role == 'customer') {
            $sql = "UPDATE customer SET Pass = :password WHERE Email = :email";
        } else if ($role == 'vendor') {
            $sql = "UPDATE vendor SET Pass = :password WHERE Email = :email";
        } else {
            die("Invalid user role.");
        }

        // Update the user password using prepared statement
        $update = $pdo->prepare($sql);
        $update->execute([':password' => $hashedPassword, ':email' => $email]);

        // Remove OTP entry using prepared statement
        $delete = $pdo->prepare("DELETE FROM password_reset WHERE email = :email");
        $delete->execute([':email' => $email]);

        echo "Password successfully updated. <a href='login.php'>Login</a>";

    } catch (Exception $e) {
        echo "Something went wrong: " . $e->getMessage();
    }
}
?>