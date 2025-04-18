<!-- forgot_password.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="send_otp.php">
        <select name="role">
                <option value="admin">Admin</option>
                <option value="vendor">Vendor</option>
                <option value="customer">Customer</option>
        </select><br>
        <label for="email">Enter your email:</label><br>
        <input type="email" name="email" required><br><br>
        <button type="submit">Send OTP</button>
    </form>
</body>
</html>
