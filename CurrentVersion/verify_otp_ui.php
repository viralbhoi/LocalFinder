<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - LocalFinder</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<section class="reg_screen">
    <fieldset class="reg1">
        <legend><h2>Reset Password</h2></legend>
        <form method="POST" action="verify_otp.php">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">

            <label>Enter OTP:</label><br>
            <input type="text" name="otp" pattern="\d{6}" required><br><br>

            <input type="submit" value="Reset Password" id="sub1">
        </form>
    </fieldset>
</section>

</body>
</html>
