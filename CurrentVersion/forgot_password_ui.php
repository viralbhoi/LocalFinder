<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password - LocalFinder</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<section class="reg_screen">
    <fieldset class="reg1">
        <legend><h2>Forgot Password</h2></legend>
        <form method="POST" action="send_otp.php">
        <select name="role">
                    <option value="admin">Admin</option>
                    <option value="vendor">Vendor</option>
                    <option value="customer">Customer</option>
                </select>
            <label for="email">Enter your registered email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <input type="submit" value="Send OTP" id="sub1">
        </form>
    </fieldset>
</section>

</body>
</html>
