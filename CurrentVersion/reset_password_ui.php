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
        <form method="POST" action="reset_password.php">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <label>New Password:</label><br>
            <input type="password" name="password" required><br><br>

            <label>Confirm Password:</label><br>
            <input type="password" name="confirm_password" required><br><br>

            <input type="submit" value="Reset Password" id="sub1">
        </form>
    </fieldset>
</section>

</body>
</html>
